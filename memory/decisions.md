# Decisions

Narrative log of significant decisions and their context — the "why" behind choices
that aren't obvious from the code or git history.

For the **structured, reviewable** decision log (with 30-day review dates), see
[`decisions.csv`](./decisions.csv). This file is for richer prose, links, and follow-ups
that don't fit a CSV cell.

<!--
Format:
## YYYY-MM-DD — <short title>
- **Decision:** what we decided
- **Reasoning:** why
- **Alternatives considered:**
- **Expected outcome:**
- **Review:** see decisions.csv row dated YYYY-MM-DD
-->

## 2026-06-16 — Go live on cPanel with symlink layout + GitHub Actions auto-deploy
- **Decision:** Deployed KonnectYatra live at https://konnectyatra.org. Repo cloned to `/home/rashad/konnectyatra`; main-domain docroot `public_html` is a symlink → `~/konnectyatra/public`. Auto-deploy via GitHub Actions over SSH on every push to `main` (`git pull` + `composer install --no-dev` + cache rebuild). Local XAMPP DB exported and imported into new DB `rashad_konnectyatra`.
- **Reasoning:** Main-domain docroot is locked to `public_html`, so a symlink gives clean URLs while keeping app code/.env out of the web root. Host has SSH + Composer, enabling true push-to-deploy without committing `vendor/` or storing tokens in the repo.
- **Alternatives considered:** (B) repo physically inside `public_html` with root `index.php` forward + `ASSET_URL=/public` — rejected (exposes app files, uglier URLs). (C) cPanel Git "Deploy HEAD" — no native auto-pull on push. (D) commit `vendor/` — bloats repo.
- **Fixes made along the way:** scrubbed all `Co-Authored-By: Claude` from history (force-push); pinned `laravel-dompdf` to working `^0.9.0` (lock mismatch); fixed PSR-4 case bug on two Admin controllers (Linux). Redesigned the home "President's message" section.
- **Follow-ups:** rotate DB + Gmail app passwords (shared in chat); the cached GitHub "claude" contributor should clear on its own.
- **Review:** see decisions.csv row dated 2026-06-16.

## 2026-07-17 — Gurdwara ZIP search, master-list import, and the Address Book field tool
- **Decision:** Three related pieces shipped together:
  1. **`/gurdwaras` ZIP search** — enter a US ZIP, get gurdwaras ranked by real distance. Backed by a
     **bundled 42,741-row `zip_codes` table** (`database/data/us_zip_codes.csv` + `ZipCodesSeeder`)
     rather than a live API, so a public page has no third-party dependency.
  2. **Master-list import** — the client's 151-row Excel merged onto the existing rows via
     `database/data/gurdwaras.csv` + an idempotent `GurdwarasSeeder`. **Merge, keep extras**, never blank
     good data with empty sheet cells. Prod went 44 → **150** gurdwaras, all 17 photos and sangat intact.
  3. **Admin Address Book** (`/admin/address-book`, Quick Menu) — Rashad's field tool: GPS ranks gurdwaras
     by distance from where he's standing; Navigate / Update / one-tap Visited; missing gurdwaras found via
     a **keyless** Google Maps search button (Places API rejected — needs GCP billing).
- **Reasoning:** Rashad travels to gurdwaras to confirm details in person, and visitors want "which gurdwara
  is near me?" — neither was possible with a state-grouped list.
- **Alternatives considered:** live ZIP API (rejected: prod dependency); Places API auto-discovery (rejected:
  key + billing); OpenStreetMap discovery (rejected: thinner coverage); replacing the gurdwara table outright
  (rejected: would have destroyed 17 photos and published typo'd names).
- **What the data cost us:** the sheet and the existing table are both dirty, and every safeguard below came
  from a bug caught in review, not foresight — **re-read before touching this data**: 16/43 stored ZIPs were
  wrong (Glen Rock NJ held an *Oregon* ZIP); deriving a ZIP from a city centroid *fabricates* data and
  overwrote a correct one; 5-digit street numbers parse as ZIPs; street names parse as cities; fuzzy city
  matching put "Pine Hill" in "Mine Hill" 80 miles away; name+state matching alone overwrote the wrong
  gurdwara (NJ has two "Singh Sabha"). Matching now needs the city to agree, with a 15-mile check to tell a
  real city correction from a different gurdwara.
- **Fixed along the way:** `update_gurdwara` never saved `zip` (create did, edit didn't) — exactly the field
  workflow this feature depends on. Public pages used FA6 icon names (`fa-location-dot`) under Font Awesome 5,
  so every address pin was an empty box; admin loads FA6 from a CDN and keeps those names.
- **Follow-ups:** 4 duplicate pairs remain in the DB (user chose to leave them: #11/#41, #8/#40, #14/#47,
  #18/#44); 14 sheet rows skipped (no address / shifted columns / unresolvable towns); distances are
  ZIP-centroid, so same-ZIP gurdwaras tie at "<1 mi".
- **Review:** see decisions.csv rows dated 2026-07-17.

## 2026-07-23 — Package form dropdowns driven by Departure Origins (+ the state_code bug)
- **Decision:** The admin package form's **State** dropdown now comes from the `departure_origins`
  table, and a second **Departure Airport** dropdown was added that writes `package.state_code`.
- **Reasoning:** Rashad reported Austria and Belgium showing under Departure Origins but missing from
  the package form. The dropdown was **26 hand-typed `<option>` tags** copy-pasted from the `$origins`
  array in `PdfPackagesSeeder`, frozen since 2026-06-19 — no link to the table at all.
- **The bigger bug found underneath it:** the form had **no `state_code` field**, and neither
  `create()` nor `edit()` ever wrote it — yet `/all-packages` filters purely on `state_code`
  (`data-code="{{ $val->state_code }}"`), never on `state`. `state` is only a card label. So **every
  package ever created through the admin UI had an empty `state_code` and could never appear on the
  public page**, whichever state was picked. Only the 19 seeded packages had codes. Fixing the
  dropdown alone would have left that intact.
- **Alternatives considered:** a single "Departure Origin" dropdown keyed on airport code, filling
  both fields (rejected by user — wanted the two-field layout kept).
- **The trap when editing:** `departure_origins.state` holds *selector labels*
  (`"New York (NY · NJ · CT)"`, `"Ontario"`) while `package.state` holds *card labels*
  (`"New York"`, `"Ontario, Canada"`) — the two vocabularies genuinely differ. A stored value not in
  the origins table is therefore preserved as a `"(current)"` option, so editing a package never
  silently rewrites its public label. Don't "clean this up" by forcing one vocabulary without
  checking what the public cards read like.
- **Deploy:** pure code — `state_code` already exists on the `package` table, so **no migration and
  no seeder**; GitHub Actions auto-deploy covers it.
- **Follow-ups:** the two fields can still be set to a mismatched pair (state Texas + code VIE) by
  design of the chosen layout; 8 legacy packages left untouched (already `status=0`).
- **Review:** see decisions.csv row dated 2026-07-23.

## 2026-07-23 — Package Status control (and the two gates for public visibility)
- **Decision:** Added an **Active / Hidden** `status` select to the package create/edit form, saved in
  both controller paths, plus a red **Hidden** badge + dimmed banner on the package list card.
- **What it fixed:** Rashad's Netherlands/Amsterdam package existed, had the right airport and package
  type, and still showed "Coming Soon" publicly. It had been built with **Copy** from a disabled
  package and inherited `status = 0` — and nothing in the admin displayed or set `status`, so it was
  invisible with no way to see why or fix it.
- **The two gates a package must pass to appear on `/all-packages`** (both are easy to miss):
  1. `status = 1` — `PackagesController@all_package` queries
     `Package::where('package_type', …)->where('status', 1)`.
  2. `state_code` must equal a `departure_origins.airport_code` — the page matches cards purely on
     `data-code="{{ $val->state_code }}"`. **`package.state` is only a display label and is never
     matched on.**
- **A package has no country field, deliberately.** Country is resolved through `departure_origins`
  (country → state → airport code), so the airport code already implies the country. Adding a country
  column would just create a second source of truth that can disagree with the airport.
- **Debugging trick worth reusing:** view-source on `/all-packages` and search for
  `data-code="XXX"`. Absent ⇒ the row failed the `status`/`package_type` query and the card was never
  rendered; present ⇒ the JS origin filter is at fault. It splits the problem in one step.
- **Review:** see decisions.csv row dated 2026-07-23.

## 2026-07-23 — Copy Package
- **Decision:** A **Copy** button on each package card (`POST /admin/apply_packages/copy/{id}`)
  duplicates the package plus its `package_details` and `price_details` rows, then redirects to the
  copy's edit form. Name gets " (Copy)" appended.
- **Reasoning:** Rashad builds most new packages from an existing one — ~80% is identical and only
  the departure, fares and brochure change.
- **Two traps that shaped the implementation:**
  1. **The copy gets its own duplicated flyer file**, not the original's filename. `edit()` unlinks
     the previous image whenever the brochure changes, so a shared filename would mean replacing the
     copy's brochure **silently deletes the original package's image**. `duplicateFlyer()` copies the
     file under a fresh `uniqid()` name and returns null if the stored file is missing on disk.
  2. **The copy inherits `status`** rather than being created hidden — at the time there was no status
     control in the form, so a copy created with `status=0` could never be enabled. Consequence: a copy
     is publicly visible from the moment it is created. **This inheritance bit within hours** — see the
     Status entry below. Status control was added the same day.
- **Also:** `.pkg-card-actions` gained `flex-wrap:wrap` — a 4th button squeezed the row.
- **Review:** see decisions.csv row dated 2026-07-23.

## 2026-06-19 — Rebuild the Yatri booking flow (packages, payment, PDF forms)
- **Decision:** Major build-out of the package/booking/payment flow:
  1. **Packages** — disabled the 8 old packages (added a `status` column) and seeded **19 Gurpurab packages** (one per departure airport) from the "AIRPORT TO TRAVEL" pricing sheet via `database/seeders/PdfPackagesSeeder.php`. `state_code` now holds the airport code.
  2. **/all-packages** — replaced the single state dropdown with a cascading **Country → State → Airport** origin selector that filters package cards by `state_code` (no cards shown until a country is chosen).
  3. **Apply form** — added Traveller Nationality (`yatri_visas.nationality` column), 4 passport types, DOB datepicker with year/month dropdowns, "Add More Documents" (images converted to **WebP**, stored in `yatri_documents` table), and a "Proceed to Payment" button gated on full form validity.
  4. **Payment** — payment page now **displays admin-configured payment instructions** (new Admin → Settings → **Payment Settings**, stored in `site_settings`) instead of collecting the customer's bank details; amount auto-filled from the package price; Cash shows an embedded Google map. **Pay Later** emails the booking + instructions to the primary email (`PayLaterMail`) and shows a 30-day-validity confirmation.
  5. **Yatri ID** — unique date/time IDs (`KYymd-Hi###`) generated at booking creation (replacing the per-payment `RT-N`/`L/P-N` scheme); existing rows backfilled.
  6. **Yatri Booking Form PDF** — booking-detail page now has Print Yatri Form (browser), Download PDF (form + each document on a titled page with smart header/footer + page numbers), and "Print Form C" (form + raw documents appended). Built with dompdf + **`setasign/fpdi` + `setasign/fpdf`** (new composer deps) for merging uploaded PDFs/images.
- **Reasoning:** Client (Rashad) provided the airport pricing sheet and the Yatri Booking Form design; needed accurate per-origin packages, a complete applicant record, configurable payment instructions, and printable/exportable booking forms that bundle the uploaded documents.
- **Critical deploy caveat:** all of the above includes **DB schema + data + composer dependency changes that do NOT travel via git auto-deploy** — on production you must run the new migrations (`--path ... --force`; only the new ones, since 8 legacy migrations are intentionally left pending), run `PdfPackagesSeeder`, `composer install`, and set the Payment Settings. See [[konnectyatra-yatri-booking-flow]].
- **Review:** see decisions.csv row dated 2026-06-19.

## 2026-07-31 — Homepage "Near Gurdwara Sahib" lead-capture popup
- **Decision:** A modal popup on the **homepage only** collects First Name, Last Name,
  Telephone Number, City, State, Zip Code, Name of Near Gurdwara Sahib, and (added mid-session)
  a "How did you know about Konnect Yatra USA?" pill choice (Facebook / Friends / Gurdwara Sahib).
  Submissions save to a new `gurdwara_leads` table, email `rm@konnectyatra.org`
  (`App\Mail\GurdwaraLeadMail`), and are reviewable at `/admin/gurdwara-leads` (new sidebar
  entry under Packages & Travel, styled to match the existing card-table admin pages).
- **Trigger/dismiss behaviour (explicitly specified by the user):** shows ~1.4s after the
  homepage loads. The **X** close button only dismisses that page view — it reappears on the
  *next* page reload. Only an actual **submit** sets a `localStorage` flag (`ky_gwp_submitted`)
  that stops it from ever showing again on that browser. No server-side "seen" tracking, since
  visitors aren't authenticated.
- **Reasoning:** Rashad wants to grow the same kind of gurdwara/contact data that feeds the
  Address Book and gurdwara master-list work (see [[konnectyatra-gurdwaras-zip-search]],
  [[konnectyatra-address-book]]) — but sourced from site visitors instead of his own field visits.
- **The `rm@konnectyatra.com` vs `.org` mix-up:** the user's request said `.com`; the codebase's
  established admin address (`BookingMailer::ADMIN_EMAIL`, and the homepage's own President's
  Message contact block) is `rm@konnectyatra.org`. Used `.org` and flagged the discrepancy rather
  than silently guessing or shipping to an address that may not exist.
- **Verified locally before shipping:** ran the new migration, POSTed a real test submission
  through the live local endpoint (curl + CSRF), confirmed the row saved with all fields
  including `heard_from`, then truncated the test row. **Caveat:** local `MAIL_MAILER` is real
  Gmail SMTP (not a log driver), so that test send actually delivered a "Test User" dummy-data
  email to `rm@konnectyatra.org`'s real inbox — told the user so they/Rashad can disregard it.
- **Deploy:** new migration `2026_07_31_000000_create_gurdwara_leads_table` is pending on prod —
  tracked in [[konnectyatra-pending-prod-migrations]] per the batch-migration preference.
- **Review:** see decisions.csv row dated 2026-07-31.

## 2026-08-04 — XML sitemap + robots.txt hardening
- **Decision:** `/sitemap.xml` is a **dynamic Laravel route**
  (`App\Http\Controllers\SitemapController`, registered near the top of `routes/web.php`),
  not a generated static file. It emits static public pages plus DB-driven URLs:
  packages (`status = 1`, the same gate `/all-packages` uses), the full gurdwara directory,
  published blog posts, hotels, locations, events and news — each with `lastmod` from
  `updated_at`, plus `changefreq`/`priority`. 221 URLs against the local DB; prod will differ
  because the local DB has drifted (see [[konnectyatra-prod-local-drift]]).
- **Deliberately excluded:** `admin/*` and `user/*` (auth-walled), login/register/logout, and the
  transactional booking steps (apply, payment, agreement, thank-you) — per-booking, not content.
- **Reasoning:** a static file goes stale every time Rashad adds a package, gurdwara or blog post.
  A route regenerates per request and reuses the real visibility gates, so a hidden package
  (see [[konnectyatra-package-visibility]]) can never leak into the index.
- **robots.txt was wide open** — a bare `Disallow:` with no rules — so the uploaded-document
  folders (`passport_uploads`, `greencard_uploads`, `drivinglicense_uploads`, `photo_uploads`,
  `document_uploads`, `bank_receipt`) were crawlable. Now disallowed along with the admin/user
  and auth paths, plus a `Sitemap: https://konnectyatra.org/sitemap.xml` line.
- **Known gap, left undone (flagged to the user, not in scope):** no page on the site has a
  `rel="canonical"` tag, and `/home` and `/our-info` are duplicate routes for `/` and `/our-info`.
  The sitemap lists only the canonical form, but without canonical tags the duplicates can still
  be indexed.
- **No DB or dependency changes** — this deploys cleanly over git auto-deploy, unlike the booking
  work in [[konnectyatra-pending-prod-migrations]].
- **Verified before shipping:** booted the app and rendered the route through the real HTTP kernel
  — HTTP 200, `application/xml`, `simplexml_load_string` parsed it, 221 `<url>` entries, deep
  links spot-checked for each content type.
- **Review:** see decisions.csv row dated 2026-08-04.

## 2026-08-10 — Expand the homepage Gurdwara Sahib popup to a fuller lead record

The client sent a marked-up screenshot of the live popup with the field list he wants. The
popup shipped 2026-07-31 (see the entry for that date and [[gurdwara-leads-popup]]) collected
8 fields; it now collects 12.

- **Added:** middle name (the only optional field), father's name, email alongside telephone,
  number of Yatris interested, and an **Others** pill on "How did you know about Konnect Yatra
  USA?" — previously anyone who found the site another way had to pick a wrong answer.
- **Layout follows the client's own line grouping:** First/Middle/Last on one row (new
  `.gwp-trio` 3-column grid), Father's Name full width, Telephone + Email, City/State/Zip on a
  trio row, then Yatri count + nearest Gurdwara Sahib. All trios collapse to one column under
  576px.
- **Kept, though the client's list did not mention it:** "Name of Near Gurdwara Sahib". It is
  the point of the popup — the heading is "Find Your Nearest Gurdwara Sahib" and the whole
  feature exists to route people to a gurdwara. Removing it is a one-line change if he
  confirms he wants it gone; flagged to the user rather than dropped silently.
- **New columns are nullable** (`middle_name`, `father_name`, `email`, `yatri_count`) so the
  submissions captured since 2026-07-31 stay valid; validation still requires all but the
  middle name. Custom validation attribute names were added because the messages surface in
  the popup's own error banner ("The father's name field is required", not "father name").
- **`heard_from` values unchanged** (Facebook / Friends / Gurdwara Sahib) with Others appended,
  so existing rows keep matching the `in:` rule.
- **Admin list restructured rather than widened:** father's name sits under the name as a
  `S/o` sub-line and email under the phone, so the table grew by one column (Yatris), not four.
- **Verified before shipping:** ran the controller with `Mail::fake()` — valid submit returns
  200 and saves all 12 fields, the rendered notification email contains the new rows, and
  missing father's name / bad email / `yatri_count` 0 / an unknown source are each rejected
  while a blank middle name passes. Test rows deleted afterwards. Mail was faked deliberately:
  local SMTP is real Gmail and would have emailed Rashad (see [[gurdwara-leads-popup]]).
  Layout checked by screenshotting the popup at 800px and 430px.
- **Needs a prod migration** — the auto-deploy ships the code but not the schema; see
  [[konnectyatra-pending-prod-migrations]].
- **Review:** see decisions.csv row dated 2026-08-10.

## 2026-08-13 — Rebuild the Special Land Package configurator and its apply step

Both pages of the land-package flow (`/special-package` and `/special-package/{id}/apply`) were
redesigned against a shared token stylesheet, **`public/new-assets/css/special-land-package.css`**
(primitive → semantic → component layers, all scoped under `.slp` so the legacy theme is untouched).

- **The design idea:** the six included days are a real route with direction (Wagah → Islamabad →
  Lahore → Nankana → Kartarpur → Wagah), so the day list became an **itinerary spine** — one
  continuous line with numbered station markers, solid kesari through the included days and a
  dashed saffron continuation into the optional ones. **Adding an optional day solidifies its
  marker and card**, so extending the trip visibly extends the road. Numbered markers are used
  because the content genuinely is a sequence, not as decoration.
- **What was actually broken (not just ugly):** the six included days were styled `.pkg-days.disabled`,
  so the itinerary you are paying for read as unavailable; the optional days never showed their
  surcharge ($125 on 4★, $150 on 5★) so the total changed with no stated cause; and the price and
  the only CTA sat at the very bottom of a 3400px page. The apply step asked ~40 fields per
  traveller with **no recap of what had been configured** — that recap now leads the page and links
  back with "Change journey".
- **Typography stayed on Raleway + Open Sans**, already loaded sitewide. A third display face would
  have cost a render-blocking request and broken consistency with the other ~20 pages, so the
  distinctiveness went into treatment (0.18em uppercase eyebrows as the only labelling device,
  tabular numerals on the spine markers) rather than new families.
- **Mobile** (explicitly asked for): the summary rail is `position: sticky` ≥992px and becomes a
  fixed bottom action bar below it, with `#whatsappFloat` and `#backTotop` lifted above it via
  `--slp-bar-h` on `:root`. Verified 0 overflowing elements at 390px on both pages.
- **Bugs fixed along the way:** the tier radios were toggled with `.attr("checked", …)` on
  `display:none` inputs, which only worked because the radios were never clicked directly — now
  native inputs; five element IDs (`first_name`, `last_name`, `place_birth`, `issuing_authority`,
  `selected_package_type`) were **duplicated once per traveller**, so every label pointed at
  traveller 1 — now suffixed and verified 0 duplicates across 5 travellers; and the
  `.green_card_area` toggle applied to *every* applicant at once instead of the one being edited.
  Roughly 200 lines of dead script were removed (`#package_1/2/3`, `first_visit`, `us_passport`,
  `.ticket_type`, `#gurdwara`, `.next`) — none of those elements exist on either page.
- **Two CSS specificity traps worth remembering**, both self-inflicted and both caught only by
  screenshotting: `.slp p` (0,1,1) silently beat every component class like `.slp-lede` (0,1,0) and
  killed their margins, so the lede never centred — the resets are now wrapped in `:where()` to
  carry zero specificity. But `list-style: none` then lost to the theme's `ul {}` and the disc
  bullets came back, so list-style is deliberately kept at normal weight while margin/padding sit
  in `:where()`.
- **FA5, not FA6:** `fa-shield-halved`, `fa-circle-info` and `fa-mobile-screen-button` rendered as
  nothing — the same trap logged on 2026-07-17. Public pages are Font Awesome 5.
- **Deliberately not changed:** the payment section still collects routing/account numbers rather
  than following the admin-configured Payment Settings model used by the Gurpurab booking flow, and
  the wire-transfer fields are still not `required` on load despite showing `*`. Both are
  pre-existing behaviour; changing what the form accepts is the client's call. Flagged, not touched.
- **No DB or dependency changes** — deploys cleanly over git auto-deploy.
- **Verified:** drove the real page over CDP — (950 + 150×2) × 3 = $3,750 with the exact posted
  strings the controller expects (`5 Star Package`, `Day 7`/`Day 8`), submitted end to end to
  `/special-package/9/apply`, confirmed the recap read back, then deleted the test row. Two console
  errors on these pages come from theme `custom.min.js` / `iternary.js` and also fire on the
  untouched homepage.
- **Review:** see decisions.csv row dated 2026-08-13.

## 2026-08-17 — Sitewide Schema.org / JSON-LD

**Context.** An audit of konnectyatra.org found zero structured data on every page, one shared
`<title>` ("KONNECT YATRA") and one shared meta description across all 224 sitemap URLs, and no
`rel="canonical"` anywhere. Machine readers had no way to tell a package page from a gurdwara
page, and nothing tied the 224 URLs to a single business.

**Decision.** Emit one `@graph` per page from a central builder (`app/Support/Schema.php`), with
the business facts in `config/schema.php` rather than a settings table.

Alternatives considered:
- *Hand-written JSON-LD per view.* Rejected — the Organization block would drift between pages,
  which is the exact failure mode that stops Google collapsing them into one entity.
- *A `schema_settings` DB table with an admin screen.* Rejected for now — it needs a migration
  and prod migrations are batched (see preferences), and these facts change roughly never. A
  config file is a `config:clear` away from being editable.
- *Separate `Organization` and `LocalBusiness` nodes.* Rejected — that publishes two entities for
  one business. `TravelAgency` is a subtype of both, so one node carries both sets of signals.
- *`Product` as the package type.* Rejected as primary; a tour is a `TouristTrip`. The node
  carries `additionalType: schema.org/Product` so Product-consuming parsers still read it,
  without a second competing entity.

**Left undone on purpose.** Office lat/lng and opening hours are null in config — a wrong map pin
or a wrong "Open now" badge is worse than none. No `SearchAction`, because the header search form
has no action and no results route. No `geo` on gurdwaras; the table has no coordinates.

**Follow-ups for Rashad.** (1) The NAP conflict — the site says 148-36 Guy R Brewer Blvd, our
notes say 18502 Hillside Avenue; the schema uses the published one. (2) The four social URLs in
Admin > Settings are empty, so `sameAs` is omitted; filling them is the single cheapest entity
signal left. (3) The `/visa` FAQ copy was drafted from existing site content and needs his
sign-off.

## 2026-08-17 — Business Details moved from config into the admin

**Context.** The structured-data work deliberately left several facts blank because inventing them
does active harm: office coordinates (a guessed pin puts the business on the wrong part of the
map), opening hours (a wrong "Open now" badge in front of a pilgrim about to call), and the
`sameAs` profile URLs. Those sat in `config/schema.php`, i.e. developer-only. The user asked for
them to be editable from the back end.

**Decision.** A Business Details card under Admin → SEO Settings, backed by `biz_*` keys in the
existing `site_settings` table, resolved through a new `App\Support\Business` helper as
*saved setting → config default*.

The larger part of the decision was scope: rather than exposing only the two blank fields, the
address, phone and email moved in too — because they had been hard-coded in **five separate
views**, which meant NAP consistency depended on remembering to edit all five. Inconsistent NAP is
the most common reason a site fails to match its Google Business Profile, so this was a
correctness fix, not convenience. Six consumers now read one source.

Alternatives considered:
- *Leave them in config.* Rejected — the user has to be able to fill these in without a deploy.
- *A dedicated `business_settings` table.* Rejected — `site_settings` already exists and is already
  cached per request, so this needed no migration (which matters: prod migrations are run manually
  and in batches).
- *Expose only lat/lng and hours.* Rejected — it would have left the address duplicated across five
  views, which is the risk actually worth closing.

**Guards written into the controller, not just documented.** A latitude without a longitude saves
neither; a week marked entirely closed publishes no hours rather than asserting the business never
opens. Both were tested against the real controller action.

**Incidental finds while wiring it up.** The Contact page carried an injected outbound link to
`blooketjoin.org` from a free map-embed generator — live and followed. The footer's `tel:` href was
`+43 660 100 7999`, Austrian theme boilerplate, while displaying the New York number.

## 2026-08-17 — Review of two overdue decisions

- **Production deploy (2026-06-16): HELD.** Verified directly — five pushes to `main` during this
  session each reached konnectyatra.org within roughly 30 seconds with no manual step, and the
  deploy's `optimize:clear` + `config:cache` picked up a brand-new config file correctly. Next
  review 2026-11-15.
- **Yatri booking flow (2026-06-19): AWAITING USER.** The build shipped and is live, but the
  expected outcome was about *booking data quality* — whether staff get complete records and usable
  exports. That can't be verified from the code, so it needs the user's answer. Re-flagged for
  2026-09-16.

## 2026-08-17 — Unset social profiles are omitted, not shown as placeholders

Reported by the user: two profiles configured (Facebook, Instagram) but four icons rendering. The
theme hard-coded all four with a `?: '#'` fallback, and the Integrations help text described that
as intentional ("Leave a field empty to keep that icon as a placeholder").

**Decision:** omit the icon entirely rather than render a disabled or placeholder one. A dead link
is a broken promise to whoever taps it, and four per page is four wasted crawl targets. Rejected
the alternatives of greying the icon out (still a link, still confusing) and of hiding it in CSS
(the `href="#"` stays in the HTML for crawlers).

Implemented as `Business::socialLinks()`, consumed by four views. Side effect worth having: the
same URLs now populate `sameAs` in the JSON-LD, which closes the P9 finding from the schema audit —
the cheapest entity-confirmation signal, previously publishing nothing.

Not logged in `decisions.csv`: this is a defect fix with an obvious right answer, not a bet that
needs revisiting in 30 days.

## 2026-08-20 — Travel options and surcharges from the printed application form

**Context.** Rashad shared the Konnect.US Yatri Application (paper form, updated 2026-08-17).
Roughly 85% of it was already collected by the web apply form, but four items were missing and
three of them carry money: wheelchair at the airport (free), wheelchair throughout the trip
(+$300), the two-suitcase Wagah declaration (+$25), and the vegetarian-meal acknowledgement. Two
further fees apply without anyone ticking anything — Indian passport processing (+$25) and a late
application fee (+$100 between 11 Sep and 15 Oct 2026).

**Decision.** A new "Travel Options & Assistance" accordion section on the apply form, with all
six fees resolved server-side by `App\Support\TravelFees`. Rates live in `site_settings` under
`fee_*` keys (no migration, admin-editable, config-style constants as fallback); the amounts
actually charged are written to `fee_*` columns on `yatri_visas`.

Alternatives considered:
- *Hard-code the rates.* Rejected — the standing preference is that anything only the client can
  supply gets a back-end field. These are prices; they will change.
- *Recompute the surcharges whenever a booking is displayed.* Rejected, and this is the load-bearing
  part of the decision. It reads as the tidier option, but it means editing a rate silently rewrites
  the total on every past booking, including ones already quoted, invoiced and paid. Rates and
  charged amounts are different facts with different lifetimes.
- *Reuse the existing `amount` column.* Rejected — it already carries the wire-transfer amount only,
  and overloading it would make the land-package $0 bug worse rather than better.

**A judgment call that needs Rashad's confirmation.** The wheelchair and baggage fees are charged
**once**, not multiplied by the companion count, on the reading that a wheelchair and a set of
suitcases belong to one person — and the printed form says a separate application is required per
traveller. But this app puts companions on a single booking and does not offer them their own
options. If a companion needs a wheelchair, the form cannot currently say so. Flagged, not guessed
at further.

**Superseded copy found while wiring it up.** The Terms & Conditions modal was still quoting
**$35** luggage handling and "3 months in advance"; the new form says $25 and 10 weeks. It has been
replaced with the instructions page in full. A commented-out block below it held the wrong office
address (185-02 Hillside Avenue — see people.md) and "valid till October 31, 2023"; the signature
field had been commented out along with it and is now restored.

**A defect fixed in passing.** The two acceptance checkboxes were both `name="terms"` with the same
value, so only one value ever reached the server — the declaration that the information is true and
the agreement to the terms were indistinguishable in the record. They are now separate fields.

**Deploy ordering matters here.** `store_yatri_visa` assigns the new columns, so pushing before the
migration runs on prod breaks every booking submission — the same failure as the gurdwara_leads
window in July. The commit was deliberately held back from `main` until the migration is run.

**Verified**, not assumed: drove the real page over CDP at a true 390px mobile viewport —
$3,050 + $300 + $25 + $25 = $3,400, the automatic-fee notice appears when passport country is set to
India, the option bars respond, and the document does not scroll horizontally. Also caught by
screenshotting: `fa-cutlery` is a Font Awesome 4 name and rendered nothing on these FA 5.12 pages;
it is `fa-utensils`.

**Still open for Rashad.** (1) The form's prices ($3,150 / $2,650) do not match the database
($3,050 / $2,350); Land Package $1,650 does match. (2) What SR#/RT#/OW#/LP# are, and whether the
system should generate them. (3) Whether `konnectus.inc@gmail.com` replaces `rm@konnectyatra.org`.

**Review:** see decisions.csv row dated 2026-08-20.
