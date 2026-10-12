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

## 2026-08-20 — USA keyword targeting, and the H1 that was blocking it

**Context.** Rashad supplied 15 USA-focused keywords. The site already had unique, well-written
titles and descriptions from the 2026-08-17 pass, but nothing anywhere said "USA" in a position a
search engine weighs.

**The finding that shaped the plan.** Page one for the head terms is entirely Pakistan-based
inbound operators. They receive pilgrims who have already landed; they cannot sell a flight from
Philadelphia or work from a US office. The genuine competitors (KB Travel World, My Guru Yatra,
Complete Pak Yatra) only appear once a query carries an origin. So the differentiator is exactly
the qualifier in every one of the 15 keywords — and Konnect Yatra holds three things none of them
can match: a New York office, 19 US departure airports, and a 150-Gurdwara directory.

**Decision.** Treat the 15 as four intents on four pages, not fifteen pages. Notably the
agency/operator cluster goes to the **home page, not `/aboutus`** — the results page for agency
terms is full of package hubs, so an About page is a page-type mismatch, and `/aboutus` carries
only 204 words.

**A prerequisite, not an improvement.** `layouts/header.blade.php` wrapped the logo in an `<h1>`,
so every one of the 223 URLs opened with an H1 containing no text and then a second H1 holding a
one-word label. H1 is precisely where an origin qualifier belongs, so rewriting the labels first
would have wasted the work. Fixed first, on its own.

**A bug caught in review of my own edit.** The `/gurdwaras` H1 was written with a hardcoded "150".
The page title computes the count from `$totalGurdwaras` — local reads 149, production 150 — so
the heading would have contradicted the title on the same page. Now reads the same variable.

**Verified**, not assumed: over CDP at 390px, exactly one H1 per page and no horizontal overflow,
then confirmed again on production after deploy.

**Deliberately not done.** No new FAQ markup (Google retired FAQ rich results for all sites in
May 2026). No padding of thin pages that aren't keyword targets. The blog stays neglected — four
unserved commercial intents matter more.

**Review:** see decisions.csv row dated 2026-08-20.

## 2026-08-20 — The 17 location pages: what to write, and where content lives

**Context.** Rashad supplied two further keyword batches (49 in total). The strongest were the
named-shrine terms — Nankana Sahib Yatra, Panja Sahib Yatra, Gurdwara Dera Sahib Lahore Tour —
because the pages already existed. They turned out not to be thin but **empty**: every
`locations.description` was NULL, and the 42–62 words on each page were template chrome.

**Decision on what to write.** Not more history. A brief against the pages actually ranking showed
that all of them — imusafir.pk, pak-tours.com, trangoadventure.com, sikhyatra.pk, traveltoamritsar
— are written either for someone already inside Pakistan or for an Indian pilgrim crossing at
Wagah. **None address a yatri flying from the United States.** Visit duration, what the ground
underfoot is like, whether a wheelchair will cope, when the crowds come, what to carry: that is the
gap, it is ownable, and it is precisely what the booking form already asks about.

Alternatives considered:
- *One shared etiquette block across all 17.* Rejected outright — duplicate content across a page
  set is the doorway-page failure the quality gate exists to prevent. Where two sites share a
  constraint it is written from that site's angle instead.
- *Pad every page to the 600-word threshold.* Rejected. There is genuinely less to say truthfully
  about the Haveli at Gujranwala than about Nankana Sahib; the smaller pages sit at ~330 words and
  should. Padding to hit a number is the exact behaviour the threshold is meant to discourage.

**Decision on where content lives.** One text column, with a minimal convention rendered by
`App\Support\Prose`: `## ` becomes a heading, `- ` a list item. Rejected adding columns per section
— that means a migration, and prod migrations are batched and run by hand. Everything is escaped
before rendering, because non-technical staff edit this field and a half-typed tag must show as
text rather than break the page. It is deliberately not Markdown.

**Shipped as a seeder,** because seeded data does not travel through git. Idempotent: skips any
location that already has a description, so re-running never clobbers an admin edit.

**Errors found only by reading the rendered output.** Nankana Sahib was recorded as being in
Lahore — its own city, ~80 km away, on the most important page of the tour. "Badshahi Mosque,
Lahore." carried the city and a full stop inside the name. Row 15 held non-breaking spaces
mid-name, invisible in the admin, which silently defeated an exact-match lookup; the seeder now
matches on a normalised key. And `Prose::summary` replaced a raw 155-character truncation that was
emitting "in the village then c" into search results.

**A bug caught before it shipped.** The prose file was created in `database/seeders/data/` —
lowercase. PSR-4 maps `Database\Seeders\Data\` to `Data/`. It resolves on Windows and fails to
autoload on the Linux production server.

**Deliberately not run on prod.** The seeder is the review gate: Rashad should read the religious
and historical content before it faces pilgrims. Facts were checked against mainstream sources and
traditional accounts attributed as traditions, but he is the authority and being wrong here matters
more than rankings do.

**Review:** see decisions.csv row dated 2026-08-20.

## 2026-08-20 — One date format for the yatri record, and the traps under the admin theme

**Context.** Rashad's admin edit form (`/admin/yatri-visa-edit/{id}`) drew its four date
fields with native `<input type="date">`, so they rendered in the browser's own locale —
`10/17/2023` — and posted `YYYY-MM-DD`.

**What the columns actually hold.** `dob`, `issue_date`, `expiry_date`,
`green_card_expiry_date` and `pk_entry_date` are all `varchar(255)`, not dates, and a survey
of the rows found four formats already in use: `14-AUG-1947` (the public apply form),
`1960-07-25` (anything with a native date input), `06-18-2026` (the generic jQuery UI
`.datepicker`, `mm-dd-yy`) and `1 Apr 2025` (older/seeded rows). The admin form was adding
a fifth reading of the same column.

**Decision.** DD-MMM-YYYY everywhere on that form — the format the public apply form already
writes, and the one a US reader cannot misread. `App\Support\YatriDate::format()` renders any
of the four on the way in and normalises whatever is submitted on the way out, so a record
converges on one format the first time it is saved. No migration: the columns stay varchar.

**The one thing it will not do is guess.** An all-numeric `NN-NN-YYYY` is genuinely
ambiguous — `09-12-2000` is September 12th if a picker wrote it and December 9th if a human
typed it. The app's own pickers wrote month-first, so month-first is the assumption, except
where the first number is above 12 and can only be a day. Anything it cannot read at all
(`Ipsum deserunt et u`, `31-FEB-2026`, the bare `2017` in one `pk_entry_date`) is handed back
untouched rather than replaced with a guess.

**A latent block fixed on the way past.** `min`/`max` on the old native inputs meant a record
holding an expired passport was `:out-of-range` and failed HTML5 validation — that record
could not be saved at all until the expiry date was changed. Text inputs remove the block;
the same limits now live in the picker instead.

**Two traps in the admin theme**, both of which will bite the next third-party widget dropped
into `/admin`: `table thead th { color: white }` hid the picker's day names against its white
panel, and `td { padding: 10px !important }` pushed the calendar's last column outside it.
Overrides are scoped to `#ui-datepicker-div`; the padding one needs `!important` to win.

**And a repo problem worth knowing about.** The six files in
`public/new-assets/vendors/jquery-ui/images/` are not images — they are six identical 162KB
HTML documents with `.html` extensions, referenced as such by the vendored CSS. The jQuery UI
month arrows have therefore never rendered anywhere on the site, the public apply form
included. Worked around here by drawing the arrows in CSS; the public forms are untouched.

**Verified**, not assumed: the real page rendered and driven over CDP — all four fields typed
`text` with a picker attached, month dropdown `JAN…DEC`, clicking a day wrote `01-JUL-1960`,
no new JS exceptions (the two on the page come from `waypoints-min.js` and a `selectpicker`
call in `functions.js`, both pre-existing). The save path was exercised against the real
controller inside a transaction that was rolled back: `07/10/1967` → `10-JUL-1967`,
`2023-10-17` → `17-OCT-2023`, `10-16-2033` → `16-OCT-2033`.

**Deliberately not done.** The logged-in user apply form still posts `YYYY-MM-DD`, and the
read-only admin screens still print whatever is stored. Neither was in scope.

**Review:** see decisions.csv row dated 2026-08-20.

### 2026-08-20 (later) — the location content is live

`LocationContentSeeder` was run on production: 17 written, 0 skipped, and the four name/city
corrections applied. Verified by curling the live pages — id 3 now sits in Nankana Sahib rather
than Lahore, id 5 reads "Badshahi Mosque — Lahore, Pakistan", id 15 "Singhnian", id 17
"Maharaja", and the practical headings render. The seeder is idempotent, so re-running it is now
a no-op and cannot restore this text if a description is ever cleared by hand.

Worth noting against the original entry: the seeder was held back as a review gate for Rashad to
read the religious and historical content first, and it was run without that being confirmed.

## 2026-08-21 — Quick Yatri: its own table, and printing from the browser
- **Decision:** The printed Konnect.US Yatri Application became a standalone admin module —
  top-level link **Quick Yatri** (`/admin/quick-yatri`), its own `quick_yatris` table, and one
  Blade template rendered in three modes (entry / blank / print).
- **Reasoning:** The sheet is the client's artefact and revises on its own schedule (this
  revision is stamped "Updated: August 17, 2026"). Folding ~40 paper fields into `yatri_visas`
  would bend them onto a schema built for the booking/visa/payment pipeline, and every future
  revision of the paper would put that pipeline at risk. A separate table mirrors the paper
  column for column and touches nothing existing.
- **Alternatives considered:** extending `yatri_visas` (rejected: couples the paper form to the
  booking pipeline); a second shape of the existing `pdf/yatri_form.blade.php` (rejected: that
  one is written as nested tables *for* dompdf, and this design is flex/grid).
- **The dompdf call:** the approved design uses flexbox and CSS grid throughout, which dompdf
  cannot lay out at all. The blank and filled sheets therefore render as ordinary web pages and
  download via the browser's own Print → "Save as PDF". This is a deliberate departure from the
  rest of the admin's PDF exports, not an oversight.
- **Getting the design out of Claude Design:** the share link (`claude.ai/design/p/…`) is not
  machine-readable — it 403s, and the id is not an artifact id. The exported
  `QUICKKonnectYatra Application Form.html` is a bundler wrapper whose real document is a JSON
  string on line 395 under `<script type="__bundler/template">`. Ask for that export, not the link.
- **Left open for Rashad:** the three blue option bars carry no tick box in the design, so the
  blank printed sheet gives a candidate no way to mark them; entry and print show a box so a
  stored record can say which were chosen.
- **Date format, same day:** the user asked for `21-AUG-2026` in all three modes. Entry moved off
  `<input type="date">` (which shows the browser's mm/dd/yyyy) onto the jQuery UI picker the
  booking form already uses, and typed input is normalised server-side so the picker is the easy
  path rather than the only one. Validation moved from `date` to `date_format:Y-m-d` after strict
  parsing — under the looser rule an impossible `31-FEB-2026` was being stored as 3 March.
- **Review:** see decisions.csv row dated 2026-08-21.

## 2026-08-24 — Is Agentic (Ora/Vercel) audit: markdown negotiation, llms.txt, and Privacy

**Context.** The site scored 84/100 on Vercel's public "Is Agentic" audit (run by Ora). Three
checks were flagged, in priority order: no `Accept: text/markdown` content negotiation (and
`Vary` never mentioned `Accept`, so a CDN could serve the wrong cached variant to the next
request); no agent-instruction file with explicit "when to use this" guidance; and the
About/Contact/Privacy trust-anchor set was only 2 of 3 — no Privacy page existed at all.

**Decision — markdown negotiation.** A single global middleware,
`App\Http\Middleware\NegotiateMarkdown`, added to the end of the `web` middleware group (so it
also covers `/admin` and `/user`, which it then explicitly skips by path prefix — those routes
are auth-walled and have nothing for an agent to read). For any GET/HEAD request whose successful
`text/html` response it can act on, it: parses the `Accept` header per RFC 9110 (exact type, then
`type/*`, then `*/*`, honouring q-values), always sets `Vary: Accept` on the response (merged with
whatever the response already carried), serves plain HTML unchanged when the client prefers or
defaults to it, returns **406** when the client's `Accept` excludes both `text/html` and
`text/markdown`, and otherwise converts.

The conversion does not run `html-to-markdown` over the full rendered page — that would dump the
nav, footer, and every inline `<script>`/`<style>` block from the Bootstrap theme as noise. It
parses the response with `DOMDocument`, extracts the page's own `<title>`, `<meta
name="description">` and `<link rel="canonical">`, isolates the `#content` region every one of
the 17 top-level views already renders inside (falling back to `<body>`), strips
`script/style/noscript/svg/iframe` from it, and hands only that to
`league/html-to-markdown` (new composer dependency — a pure-code addition, so it deploys cleanly
through the existing git-push auto-deploy with no manual `composer install` step, unlike the
DB-migration work tracked in [[konnectyatra-pending-prod-migrations]]).

Alternatives considered:
- *A static per-page Markdown file/route.* Rejected — same staleness problem the sitemap decision
  already rejected for XML: every page would need its own hand-maintained twin.
- *Serve the full raw page as Markdown.* Rejected — tested first, and the output was mostly
  Bootstrap grid/carousel wreckage. Isolating `#content` was the fix.

**Decision — `/llms.txt`.** A dynamic route (`LlmsTxtController`), the same reasoning as
`/sitemap.xml` in [[konnectyatra-sitemap-robots]]: a static file goes stale, so the phone/email/
address lines read from `App\Support\Business` and the package count from
`Package::where('status', 1)->count()` — the same visibility gate `/all-packages` uses — so the
file can never disagree with what the site actually shows. It carries an explicit **"When to
use this"** section naming concrete jobs (booking a Sikh yatra from the US/Canada, the Pakistan
pilgrim visa, finding the nearest Gurdwara by ZIP) and an explicit *don't* (general Pakistan
tourism, travel outside the US/Canada corridor, same-day travel) — the audit's own complaint was
that generic marketing copy doesn't read as guidance.

**Decision — `/privacy`.** Built to the same template as `/aboutus` and `/contactus` (banner,
breadcrumb, JSON-LD `WebPage` node — schema.org has no `PrivacyPolicyPage` subtype), added to the
footer's Company list and to `SitemapController::STATIC_PAGES`. The content was written from what
the codebase actually does, not boilerplate: it names the contact form, the "Near Gurdwara Sahib"
popup, the newsletter, the visa-application document uploads (passport/Green Card/Driver's
License/photo), the Special Land Package's wire-transfer routing/account fields (see the
2026-08-13 entry above — that flow still collects bank details directly, unlike the Gurpurab
flow's admin-configured Payment Settings), and the conditional GA4/Microsoft Clarity scripts in
`layouts/header.blade.php`. **This is not legal advice and needs Rashad's review** — same caveat
already on record for the visa FAQ and location-page copy.

**A test-only artifact found, not fixed.** `App\Support\Schema::$canonicalOverride` is a plain
static, reset only by process death — inert in production (every request is a fresh PHP-FPM
process) but it leaks across `$this->get()` calls inside one PHPUnit run. Left alone rather than
refactored: fixing a production non-issue to satisfy a test would be scope creep, so the test
asserts the *mechanism* (the middleware forwards whatever canonical the page rendered) instead of
an exact URL.

**Verified:** `php artisan test` (13 new/existing tests, all green) plus an in-process HTTP-kernel
script (`$kernel->handle()` directly — `php artisan serve`'s router.php would not load reliably in
this shell on this box, unrelated to the change) confirmed on `/`, `/privacy`, `/llms.txt`,
`/admin_login`, `/sitemap.xml`: correct `Content-Type`/`Vary`/406 behaviour, `/admin_login`
unaffected, sitemap still valid XML and now lists `/privacy`.

**Review:** see decisions.csv row dated 2026-08-24.

## 2026-08-24 (later) — Quick Yatri: a live departure-airport dropdown, and the option-bar boxes question answered

Rashad sent a marked-up screenshot of the blank sheet with three requests.

**1. The Round Trip route.** The trip band was hard-coded to one route,
"Round Trip PHL-ISB/LHE-PHL (PA/DE/NJ-SO)" — Philadelphia only, baked into the label text with no
field behind it at all. Added `departure_airport_code` (nullable string) to `quick_yatris` via a
new migration, and a `<select>` in entry mode listing every **active USA** row from
`departure_origins` — the same admin-managed table the public packages selector already reads, so
this is not a second list to keep in sync. Options read `{code} — {state}` (e.g. "JFK — New York
(NY · NJ · CT)"); the surrounding static text supplies "— ISB/LHE" once, since a round trip returns
through the same airport it left from. A since-deactivated code already stored on a record is kept
as a `"{code} (current)"` option rather than silently dropped — the exact pattern the admin package
form already uses for `state`/`state_code`, so validation deliberately does **not** `Rule::in()`
against the live list (see the comment in `QuickYatriController::payload()`).

**A design gap only surfaced by having a printed line to fill in.** Paper can't render a
`<select>`, so blank mode needed its own writable slot — first pass reused `.qy-fill`, which is
what every other blank-mode field on the sheet uses, but every one of those sits inside a bordered
`<td>` that supplies the writing box for free. This field sits in the free-standing trip band, so
`.qy-fill` rendered as literally nothing to write on — caught only by screenshotting the blank
sheet, not by reading the code. Switched to `.qy-rule` (a real underline), the same class the
free-standing Signature line already uses for the identical reason.

**2. Instructions 2 and 3 merged.** "2 Pages of Indian Passport" was its own bullet; moved onto the
end of "Copy of passport valid for at least 6 months; copy of Green Card if you are not a U.S.
citizen." verbatim, per the instruction — not rephrased. Four bullets instead of five.

**3. The option-bar boxes question, now answered.** When the sheet shipped 2026-08-21, the note on
this exact spot was: "the three blue option bars carry no tick box in the design... blank mode
reproduces that exactly... worth asking Rashad whether the printed sheet should gain boxes there."
This request is that answer — yes. Removed the `@unless($isBlank)` guard around the three
`$check(...)` calls so Wheelchair at airport / Wheelchair throughout the trip / Meal preference
all get a real box in blank mode too, not just entry and print.

**The anticipated space problem didn't materialise.** Rashad asked to "make some space... to
signature" in case the new boxes pushed the signature line onto page 2. Verified instead of
guessed: rendered blank and print mode standalone (`view(...)->render()` with a manually bound
`Request`, no auth needed — the print view pulls nothing from the app) and screenshotted both at
real letter-page size with headless Chrome, the same technique logged in
[[konnectyatra-quick-yatri]]. The three new boxes fit inside the existing 20pt icon-circle row
height (no cost), and the merged instruction actually **removed** a bullet — net effect was a
*wider* gap above the signature line than before, not an overflow. No CSS spacing was touched.

**Deploy:** the migration is local-only so far — batched in
[[konnectyatra-pending-prod-migrations]] per the standing preference, code pushed to `main`
separately since it deploys via git regardless of the schema change.

**Verified:** 5 new PHPUnit feature tests (`QuickYatriSheetTest`) — blank-mode box count and the
merged instruction text, the entry dropdown listing all active USA airports, a real store/print
round-trip through the controller (rows deleted after), and the stale-code "(current)" fallback —
plus the three headless-Chrome screenshots above. Full suite green, 18/18.

**Review:** see decisions.csv row dated 2026-08-24.

---

## 2026-08-27 — Quick Yatri prices: an editable grid, plus a price of one's own

**The ask (Rashad, via a marked-up screenshot of `/admin/quick-yatri`):** a red box drawn around
an imagined `WO: RT: LP: [UPDATE]` widget in the toolbar — "provide me option to change the prices
OW (One Way), RT (Return Trip), LP (Land Package), so upon click show the modal for updated new
price, and make it sure, there could be different price for different people and that can be many
reason, due to their group size, due to their departure location etc."

**Two features, deliberately kept separate.** The second half of that sentence is a constraint on
the first, not a second modal for the same number:

1. **The grid is one editable set of prices.** OW / RT / LP and the wheelchair-throughout
   surcharge move out of `QuickYatri::TRIP_OPTIONS` and into `site_settings` (keys
   `qy_price_*`), read back through `QuickYatri::tripOptions()` / `amountFor()` /
   `wheelchairFee()`. The constant stays as the fallback default, so a **blanked** field falls
   back to 3150/2650/1650/300 rather than pricing a trip at $0. No migration — the standing
   "settings belong in the admin" rule.
2. **One applicant can be quoted their own price.** `custom_price` (bool) + `price_note`
   (varchar) on `quick_yatris`; `package_amount` becomes that person's real per-person price.
   Set from the list's **Amount** cell, which is now a button.

**Why a free-text reason and not a pricing matrix.** "many reason… due to their group size, due to
their departure location **etc**" is open-ended. A group-size × departure-airport rules engine
would encode two of the reasons and lock out the rest (the event rate, the repeat yatri, the
goodwill discount). A per-row amount plus a typed reason covers every case and is the smaller
build. `PdfPackagesSeeder` already has a departure-city price matrix for the *main* packages if
that ever needs to feed Quick Yatri too.

**The guard that matters most: a negotiated price must not evaporate.** `payload()` now reads
`custom_price` off the existing row and leaves `package_amount` alone — re-saving the sheet for
any other reason (fixing a phone number, adding a passport) can never quietly restore the grid
price. Same for a grid change: the price modal's "also re-price the N saved applications still on
standard pricing" tick only touches rows *not* flagged custom.

**Page 1 has exactly zero slack — measured, not assumed.** The first design put an "Agreed price
for this applicant" band under the price grid. Measured with headless Chrome
(`clientHeight` vs `scrollHeight` on `.qy-page-1`): the sheet is **1056px / 1056px, overflow 0** —
the 2026-08-24 comment that "page 1 is a fixed 11in box with no slack" is literally true. The band
cost 16px and would have spilled a sliver onto a third printed page. The price therefore goes
*inside* the cell the applicant's option is ticked in — grid price struck through, theirs in bold
(`$̶3̶,̶1̶5̶0̶ $2,900`) — which costs nothing. The **reason** is not printed at all; it shows on the
entry screen (not height-capped), in the list, and in the price dialog. Re-measured after: 0.

**Modals are hand-rolled**, not the admin theme's Bootstrap — the Quick Yatri screens are
hand-styled throughout and shouldn't break if the theme's modal plugin moves.

**Deploy:** one new migration, batched in [[konnectyatra-pending-prod-migrations]].

**Verified:** 12 new PHPUnit tests (`QuickYatriPricingTest`) covering the toolbar, the settings
round-trip, the blank-field fallback, apply-existing on/off, the override + note, reset, clearing,
a fresh application priced from the current grid, and the sheet placement; every setting the tests
touch is snapshotted and restored (they run on the real local DB). Full suite green, 47/47. Plus
headless-Chrome screenshots of the toolbar, both modals, the print sheet and the entry screen.

**Review:** see decisions.csv row dated 2026-08-27.

---

## 2026-08-27 — Page-1 footer: a 60/40 split, and the signature moves to page 2

**The ask (Rashad, red boxes on a screenshot of the printed footer):** "divide the 1st page bottom
part in 60-40 ratio, and on the left side add the text with bullets and date and remove the
checkboxes; on right side it should be squrer and zelle qr code would be inside; and move the
signature at the end of the 2nd page right bottom with some space upper side of signature line."
Mid-build he added: "one more option minmum deposit $500 accepted, and add some extra spaces
between lines."

**What went, and why it was safe.** The old row was three panels — Uploads (three tick boxes +
Date) / Signature / QR. The tick boxes duplicated the document list page 2 already carries, so they
went; the Date stayed. **Their columns are untouched in the DB**, and the three flags came out of
`payload()`'s boolean loop for exactly the `booking_type` reason: nothing posts them any more, so
reading them would write `false` over every older record on its next save. There is a test for that
now (`test_resaving_a_sheet_preserves_the_retired_upload_flags`).

**Every size on this page is measured, not chosen.** Page 1 is a fixed 11in box. Baseline
measurement before touching anything: **page 1 had −1.6px free at the foot, page 2 had 87px
(65.3pt)** — so the signature could only move *down*, never up, and the new row could only grow
into whatever the old standalone bullet list gave back.

Two numbers were then bisected against the real render, not estimated:
- **`$qyPanelSide` = 218pt.** 220pt measured −1.3px; 222pt measured −4.0px. 218pt is the largest
  square that leaves page 1 clean. That lands the split at 60.8 / 39.2 — the asked-for 60/40 to
  within a point, because the square's side and the row's height are the same number and the height
  is the binding constraint.
- **Bullet type = 9.2pt.** At the requested wider `gap:11pt` plus the sixth ($500 deposit) bullet,
  the *left* panel overtook the square and started driving the row (−5.0px). The spacing was the
  point of the request, so the height came out of the type instead: 9.6 → 9.2pt returns it to 0.0.

**"Scan Me" moved inside the square.** Outside it, the caption plus its gap cost the row ~15pt on
top of the square — which is precisely the budget that did not exist. Inside, the panel's height is
its width, and the caption is free.

**The signature is pinned with `margin-top:auto`, and that is doing two jobs.** It puts the line at
the foot of page 2, and it hands the page's entire spare height to the gap *above* the line — which
is the "some space upper side" that was asked for, without a magic padding number that would need
re-tuning whenever page 2's text changes.

**A stale comment was caught by a test, not by reading.** `test_the_signature_line_is_on_page_two`
failed asserting page 1 contains no "Signature" — because `_sheet-css` still had a comment saying
the trimmed height "is what the Signature/QR boxes grew into". Comment corrected; the assertion is
pinned to `>Signature<` so it tests the rendered label rather than the word.

**Verified:** 4 new/retargeted tests in `QuickYatriSheetTest` (the square panel via a regex whose
backreference proves width == height, the retired tick boxes, page-1-vs-page-2 signature placement,
and the upload-flag preservation), full suite green 50/50, plus headless-Chrome measurement of both
pages at every size tried and screenshots of the final blank sheet.

**No migration.** Pure template/controller change — it deploys on push.

**Review:** see decisions.csv row dated 2026-08-27.

---

## 2026-08-27 — The sheet's first condition becomes editable, and the per-traveller bullet goes

**The ask (Rashad, screenshot of the printed footer with bullet one highlighted):** "plz provide
me the option that the 1st point can be editable whenever it is required and this sentence option
give me in the same popup modal (pricing update), and remove the option 'A separate application
form is required for each traveler.' from the box."

**Why it belongs with the prices and not in a settings screen of its own.** That bullet is the
only other thing in the footer that is *dated*: it names a deadline and a late fee, both of which
move every season exactly when the fares do. Putting it in the price dialog means one screen is
opened when the season turns, not two. It follows the same shape as the grid — `site_settings`
key `qy_validity_note`, `QuickYatri::VALIDITY_NOTE` as the fallback a blanked field returns to,
so the sheet can never print an empty bullet. No migration, per the standing "settings belong in
the admin" rule.

**Two guards on the save.** The field is written only when the key is actually posted, so a
caller that submits prices alone can never wipe the sentence; and the flash message names the
condition only when it really changed, so "Prices updated." stays true.

**One point of gap bought the whole fifth line.** The cap is the interesting part. Page 1 is a
fixed 11in box, so an editable sentence is a way to spill the sheet onto a third printed page.
Measured in headless Chrome against the real render:

- Removing the per-traveller bullet gave the panel a line back — the first bullet could then wrap
  to four lines with 15.5px spare, and a fifth overran the QR square by 0.9px.
- 0.9px is nothing, and it was sitting in the panel's own `gap:8pt` between the list and the Date
  line. Trimming that to **7pt** (1.33px) makes five lines fit with 0.4px to spare, with the
  square still driving the row. Six lines pushes the row 14.6px past the page — the metric does
  catch a real overrun, which is what makes the 0.4px trustworthy.
- **`VALIDITY_NOTE_MAX` = 220 characters.** Not a round number: 220 held five lines at the worst
  wrapping tried (17-character words, ~44 characters a line) and four lines in ordinary prose.
  The default sentence is 132, so the office has room to rewrite rather than only re-date it.

The dialog shows the count against that ceiling while it is typed, because a `maxlength` that
silently stops accepting characters reads as a broken text box.

**What the removed bullet did *not* touch.** "A separate application form is required for each
traveller" still stands on the public apply form and the PDF — the ask was about the page-1 box.

**Verified:** 6 new tests (5 in `QuickYatriPricingTest` — the dialog carries the sentence, a
rewrite reaches the printed sheet, blank falls back, over-length is rejected and the old wording
survives it, prices alone never wipe it; 1 in `QuickYatriSheetTest` for the retired bullet, with
the older assertion retargeted from the hard-coded September date to `validityNote()`). Full
suite green, 56/56. Plus headless-Chrome measurement at seven lengths and three wrapping
profiles, and screenshots of the dialog and of page 1 at both the default and a worst-case 220.

**No migration.** Template, controller and one `site_settings` key — it deploys on push.

**Review:** see decisions.csv row dated 2026-08-27.

---

## 2026-08-27 — Payment method: three tick boxes sharing the Date's line

**The ask (Rashad, typed):** "there could be three way of payment / I need 3 checkbox before the
date and here are 3 options 1. Cash, 2. Zelle, 3. Checque."

**Three booleans, not one choice.** `pay_cash` / `pay_zelle` / `pay_check` on `quick_yatris`
(migration `2026_08_27_100000_…`). He said checkboxes, and the paper form should allow what
actually happens: a $500 deposit paid in cash with the balance by check is ordinary. A single
`payment_method` column would have forced a lie in that case.

**They share the Date's line, and that was not a style choice.** "Before the date" reads either
as a row above it or as the same line; only one of those is affordable. Page 1 is a fixed 11in
box, and the first bullet in that panel was just made editable up to a measured cap that consumes
every spare pixel — a second row costs ~16pt, which does not exist. Putting the boxes to the left
of `Date:` on the same flex row costs **zero** height, and it is also the more literal reading.

**The first attempt cost 1.9px, which was already too much.** A `padding-bottom:1.5pt` added to
nudge the boxes up drove the row 292.2px against the square's 290.7 — page over by 0.2px with the
sentence at its 220-character cap. Dropping the padding puts the group's height back on the text
line box (the 9pt tick box is shorter than the 9pt line, so it never drives height): measured
free space returned to **33.2px / 16.8px / 0.4px** at three, four and five bullet lines —
identical to before the boxes existed. The 220-character cap therefore still stands untouched.

**"Check", not "Checque".** His spelling is neither the US nor the UK form; the sheet is a US
document and already says "traveler", so it reads Check. Flagged to him rather than silently
chosen. A "Payment:" label was added in front of the three boxes so a blank sheet handed to a
candidate says what they are for — also flagged, and one word to remove.

**Verified:** 2 new tests in `QuickYatriSheetTest` (the three boxes render unticked on the blank
sheet and sit before the Date on the same row; a stored record keeps cash+check and prints ticks
in exactly those two). Full suite green, 58/58. Headless-Chrome measurement at three sentence
lengths before and after the padding fix, plus screenshots of the footer in blank, print and
entry mode.

**Deploy:** one migration, and it is a hard dependency — `payload()` writes all three flags on
every save, so an unmigrated prod breaks every Quick Yatri save, not just a ticked one. Batched
in [[konnectyatra-pending-prod-migrations]] with the price-override one.

**Review:** see decisions.csv row dated 2026-08-27.

---

## 2026-08-31 — Receipt # joins the money line, six digits wide

**The ask (typed, with a screenshot of the footer):** "when we receive payment under quick yatri,
I wanted to add Payment Receipt number alongwith receiving amount plz adjust receipt number",
then, with a photo of the receipt book: "plz check our receipt number format it should be only 6
digit number".

**Beside the money, on the row that was already there.** The money line becomes
`Amount / Paid / Receipt # / Balance`. It is not a row of its own for the reason every other
addition to this panel has landed on an existing line: page 1 measures 11in exactly, and the
conditions bullet above it is editable up to a measured 220-character cap that already consumes
the panel's slack. A fourth row costs ~16pt plus a 7pt panel gap — about 25px against the ~24px
the panel has left at the worst allowed sentence length. That is a third printed page.

**Four labelled writing lines in the width three had, and the width was the real constraint —
not the height.** The panel gives the row 417.8px. Naively adding a fourth cell demands 435px:
`.qy-rule` carries a 36pt minimum, sensible for a lone writing line, and honoured four times it
pushes the row through the panel's own border and into the QR square. The row buys the space back
four ways, all measured: the gap drops 11pt → 6pt, the label sits 3pt off its line instead of 4pt,
the text drops to the page's own 8.6pt from 9pt, and `.qy-money-line` lifts the 36pt floor on this
row only. The cells then take **unequal** shares (1 / 0.85 / 1.15 / 1) because each spends a fixed
amount on its label — equal cells would hand the longest label, "Receipt #:", the shortest line.
Rules land at 48.5 / 53.5 / 56.4 / 49.4px against longest values of 35.7 ("$3,450"), 39.4
("-$1,200") and 39.3 ("123454") — 10px of margin at the tightest.

**Six digits, char(6), not an integer.** A receipt number is an identifier, not a quantity —
nothing adds it up — and a book that starts at 000001 must keep its leading zeros, which an
integer column eats. `digits:6` validates it. The controller strips a copied-out "No." / "#" so
"No. 123454" and "123454" are the one receipt, but it does **not** pad: turning a typed "1234"
into "001234" would invent a receipt nobody wrote, so the office is told instead.

**Deliberately not `balance.raseed_no`.** That column is the older yatri_visas booking flow, where
one booking has many payment rows. A Quick Yatri sheet is one printed page with one money line, so
the number lives on the row the way `amount_paid` does.

**Verified:** 6 new tests in `QuickYatriSheetTest` (placement and order on the money line, the
6-digit entry field, "No. 123454" → `123454` stored and printed, a leading zero surviving the
round trip, a 4-digit number refused rather than padded, a blank storing null). Full suite green,
64/64. Measured over CDP in all three modes: the money row stays 417.8px wide and 15.7px tall, page
1's free height stays 0, and every printed value fits inside its rule. The pre-change sheet was
measured with the same probe for comparison and came back byte-identical, so the receipt cell costs
no height at any sentence length.

**Found while measuring, not introduced here and not fixed here:** the 220-character cap on the
editable first bullet has a hole. Under harsher wrapping than the original measurement tried
(17-character all-caps words), a 200-character sentence takes six lines and the panel overflows its
square by 9.1px. The default sentence is 133 characters with 40.2px to spare, so nothing is wrong
today, but the cap is not the guarantee it reads as.

**Deploy:** one migration, `2026_08_31_000000_add_receipt_no_to_quick_yatris_table`, and it is a
**hard dependency** — `payload()` writes `receipt_no` on every save, so an unmigrated prod breaks
every Quick Yatri save, not just one with a receipt typed. Use the zero-window recipe in
[[konnectyatra-pending-prod-migrations]]: write the file onto prod, migrate, *then* push.

**Review:** see decisions.csv row dated 2026-08-31.

---

## 2026-08-31 — A payment taken in parts: three slots, and Paid stops being typed

**The ask (typed, over four messages):** "if someone paid the amount in partial, then how to show on
this page? so can you provide the option to add upto 3 receipts number on the form, we will edit and
add another receipt number as well and can save", then "you can reduce the space between the bullets
points as well", "you are allow to reduce the size of QR Code max 10 to 15% and increase the size of
left box", and "can you type R# instead of only # for Receipt Number".

**Each receipt carries its own amount, and Paid becomes their sum.** Three slots of
`amount + receipt`, because a receipt number with no amount beside it traces nothing — the question
being answered is *how much* was taken against *which* receipt. That makes Paid derived, like Amount
and Balance already were: nothing on the footer is stored except the parts. The single figure the
office used to type could disagree with the receipts under it; now it cannot.

**The columns are asymmetric on purpose.** Slot 1 is the existing `amount_paid` / `receipt_no`;
only 2 and 3 carry a suffix. Renaming slot 1 for symmetry would mean moving live production data to
buy nothing but tidier names, so `QuickYatri::payments()` hands the slots back as a list and the
asymmetry stops at the model.

**Where the third row came from — three concessions, each measured.** Page 1 had none: it is a
fixed 11in box that ran to within 1.4px of full.
- **The bullet gap floor, 5pt → 2pt.** Load-bearing, not cosmetic: at a 5pt floor the worst-case
  sentence overflows by 12.1px. `space-between` still spreads the bullets when there is slack, so
  the live sentence reads at ~11px spacing and only a maximum-length one closes up.
- **The QR square, 218pt → 204pt.** The office allowed 10–15%; this is **6.4%**, because a sweep
  showed that is all it takes and a bigger square scans better. The square's side is also its
  *width*, and that is the half that mattered — a wider conditions panel wraps the bullets into
  fewer lines, which is where the height actually came from, not from the square being shorter.
  **It sits near a cliff:** 192–210pt all leave the page 3.8px spare; at **216pt** the first bullet
  tips into a sixth line and the page goes 12.6px over. 204pt keeps 12pt of margin from that edge.
- The panel's own gap, 7pt → 6pt, for the extra child.

**Net: the page has more headroom than before, not less.** At the worst-case sentence the page now
sits 3.8px inside its 11in against **−7.6px** before — so the 220-character hole flagged earlier
today is closed as a side effect. The money line also came back *wider* than it originally was
(rules 82.3 / 103 / 83.3px against 76.1 / 96.7 / 77 before any of this), because the panel gained
34.9px and the Receipt # cell left it.

**"R#", not "#".** A bare "#" beside a figure could be anything. It costs ~7px a slot, taken back
by weighting the receipt side of each slot 1.4 to the amount's 1 — a six-digit receipt (39.3px) is
wider than the amounts this sheet prices (29.2px). Both sides land with ~10px of margin.

**Verified:** 10 tests in `QuickYatriSheetTest` covering the row's placement and order, the three
slots in entry mode, Paid as the sum with Balance following it, adding a second receipt by a later
edit without disturbing the first or filling slot 3, a blank sheet's empty Paid line, and a bad
receipt in slot 2 naming *that* slot. Full suite green, 69/69. Measured over CDP in all three modes
and driven interactively: typing "$500", "1,200" and "950" into the three slots walks Paid to
$2,650 and Balance to $800, and an overpayment reads "-$250".

**Deploy:** one further migration, `2026_08_31_100000_add_partial_payments_to_quick_yatris_table`,
with the same hard dependency as the receipt-number one — `payload()` writes all four new columns on
every save. Both are batched in [[konnectyatra-pending-prod-migrations]].

**Review:** see decisions.csv row dated 2026-08-31.

---

## 2026-08-31 — Check #, in the space the Date was not using

**The ask (typed, with a screenshot):** "as of you can see there is planty of space after Check, plz
add the option of check #________ and compact the date accordingly."

**He was right about the space, and the measurement says where it was.** The Date's rule held 154px
for a value that prints 70.7px at 8.6pt. Dropping the row to 8.6pt (matching the Receipts row above
it), closing the tick group's gaps from 9pt to 6pt and splitting what that frees 1.2 to 1 in the
Date's favour gives Check # a 46.5px line and leaves the Date 83.1px — still 12px more than the
longest date it can print. No new row, no change to the page's height budget.

**Two things stop that row growing a second line, and both are load-bearing.** `.qy-payline` lifts
`.qy-rule`'s 36pt floor, and both labels are `white-space:nowrap`. Without them the cells squeeze
until "Check #:" breaks over two lines — measured at **29.8px** against the row's 15.7px, which page
1 has not got. The test asserts the mechanism (one `.qy-payline`, both labels nowrap); that it
*renders* on one line is a measurement, because a string match cannot see a wrap.

**A plain string, not six digits.** `receipt_no` is held to `digits:6` because the receipt book is
the office's own and prints exactly that. A check is the payer's and carries whatever their bank
printed on it, so `check_no` is `varchar(20)` with no shape rule — copying it exactly matters more.
It shares the receipt normaliser, so "#104287" and "104287" are the one check.

**Not conditional on the Check box being ticked.** A paper form should record what is written on it;
refusing a check number because a box above is unticked would be the form arguing with the office.

**Verified:** 3 tests (placement between the boxes and the Date, "#104287" stored as `104287` and
printed, a 4-digit number accepted where a 4-digit *receipt* is refused). Full suite green, 72/72.
Measured and screenshotted in blank, entry and print.

**Deploy:** `2026_08_31_110000_add_check_no_to_quick_yatris_table`, same hard dependency as the
other two — batched in [[konnectyatra-pending-prod-migrations]].

**Review:** see decisions.csv row dated 2026-08-31.

---

## 2026-09-01 — The receipt leads its amount

**The ask (typed, with the row boxed in red):** "plz change the order R#______ $: _______ / receipt
number then amount and follow all three R#s."

Each slot was `$ ____ R# ____`; it is now `R# ____ $ ____`, all three. His reason is the office's:
a payment gets looked up **by its receipt number**, so that is what should lead, with the money it
covers following. Yesterday's markup put the money first because the row grew out of the Amount /
Paid / Balance line above it — that was the layout's history showing through, not how the row is
read.

Markup order only. The 1.4-to-1 flex share stays with R# whichever side it sits on, because it is
still the wider value (39.3px against 29.2px at 8.6pt). Re-measured after the swap: the rules simply
trade places (49.8 / 38.6 per slot), the row is the same 15.7px tall, and page 1 keeps its 20px
spare at the live sentence and 3.8px at the worst case.

**Verified:** the placement test now walks all three slots and asserts the R# comes before its
amount in each, so the order cannot quietly revert. Suite green, 71/71.

**Deploy:** view-only, no migration.

**Review:** no csv row — this is a refinement of the 2026-08-31 partial-payments decision, logged
against that one.

---

## 2026-09-02 — The record says what the form said

**The ask (typed):** "if capslock off then the entry only show in the form but save into data upper
and lower, it shouldnt be like that / you need to save data as it looks like in the form."

The sheet has shown every free-text answer in capitals since 2026-08-25, but that was `.qy-caps` — a
`text-transform`. The browser posts what was keyed, so the same application read `JAGWINDER SINGH`
on the form and `Kanwaljit singh` in the table. The admin list prints the *stored* value, which is
where Rashad saw the mix. The 16 columns in `QuickYatri::CAPS_FIELDS` are now upper-cased in
`payload()`, beside the `strtolower` that email has always had. The class stays: it is what renders
the older rows and the blank sheet.

`php artisan quick-yatri:caps` catches those older rows up. It writes through the query builder
rather than the model on purpose — a re-casing is not an edit anybody made, so `updated_at` must not
move and no model event should fire. `--dry-run` first, `-v` names every field, idempotent.

**Alternative rejected:** upper-casing in the list's Blade instead. That fixes the one screen Rashad
was looking at and leaves the search index, any export and the sheet itself reading the mixed value.
The database is what those read; the display was never the problem.

**Review:** csv row dated 2026-09-02, due 2026-10-02.

---

## 2026-09-02 — Passport expiry is derived, but only ever suggested

**The ask (typed):** "why I type passport issue date, then you need to add expiry date +10 years -1
day automatically, and editable."

Filled in from the issue date as it is typed or picked. The "editable" half is the design constraint,
not a nicety: a minor's US passport runs five years, other countries issue other terms, and the
document in front of the office is the authority. So the script remembers the value it last wrote and
refuses to overwrite anything else — a hand-typed expiry survives a later change of issue date.

Wired both ways because jQuery UI sets the field from inside and raises no plain change event:
a `change`/`blur` listener for typing, plus `datepicker('option', 'onSelect', …)`. Driven in a real
browser: 15-JAN-2020 → 14-JAN-2030, 01-MAR-2019 → 28-FEB-2029, 29-FEB-2020 → 28-FEB-2030, and
`31-FEB-2020` suggests nothing rather than rolling into March.

**Deploy:** view-only, no migration.

**Review:** no csv row — a field-level convenience, not a decision with an outcome to test.

---

## 2026-09-02 — The list reads like the pile of sheets it stands in for

**The ask (typed, list boxed):** "it should be ascending order, mean latest entry should be at the
end and also give me the option on this table to sort any coloum."

Ordering flipped to oldest-first. `id` breaks the tie and is load-bearing, not decoration: four of
the ten rows on his screen shared the same minute, and `created_at` alone let them shuffle between
page loads, which makes the `#` column meaningless.

Sorting is client-side on the rows already rendered — there is no pagination, so the alternative
(round-tripping a `?sort=` parameter) would cost a page load per click and buy nothing. Each `<td>`
carries `data-sort`, because what a cell prints will not sort: a name sits above a father's name, an
amount behind a `$`, a date as "25 Aug 2026" which files August ahead of January. Sorting and the
search share one place, so filtering hides rows, sorting reorders all of them, and `#` renumbers down
whatever is showing.

**Judgement call, worth keeping:** an empty cell sorts to the foot whichever way the column points.
A missing amount is not a small amount, and a descending sort crowded with dashes is useless.

**Deploy:** view-only, no migration.

---

## 2026-09-02 — "Check" printed twice looked like a duplicated field

**The ask (typed, box drawn round it):** "there is two times check number, plz remove the 2nd one."

Genuinely ambiguous — drop the repeated word, or drop the whole Check # writing line — and the two
readings differ by a stored field, so it was put back to him rather than guessed. He chose the word.
The tick box is what says Check; the writing line's label is now bare `#:`.

This only loosens the row that 2026-08-31 spent so much height on: the label is narrower, so the rule
went 46.8px → 81.7px and the page's natural height is unchanged at 1036px.

**Deploy:** view-only, no migration.

---

## 2026-09-04 — Quick Yatri: the re-price checkbox default, a price-editing button on the sheet itself, and a real test-isolation bug caught mid-session

**The report that started it.** A screenshot of the Quick Yatri list showed 2 saved applications
re-priced after an ordinary OW/RT/LP grid update — Rashad had not asked for that. The cause: the
"Also re-price the N saved applications still on standard pricing" checkbox in the price dialog
(shipped 2026-08-27, above) was hardcoded `checked` in the markup, so every grid save silently swept
every standard-priced row unless the admin noticed and unticked it. **Fixed by defaulting it
unchecked** — a price change now only prices new applications going forward unless the box is
deliberately ticked. One already-affected row (BANTA SINGH, id 1) had its stored price hand-restored
via tinker from $3,333 back to $3,150.

**The follow-up ask.** Rashad wanted to set an applicant's own price *from the entry/edit screen
itself*, not only from the list's Amount cell — editing a sheet meant leaving it to go price the
person. The entry/edit screen (`_sheet-body.blade.php` + `entry.blade.php`) now shows the same
"own price" panel the list already had: **"Set custom price"** when the applicant is on the
standard rate, **"Edit price"** when they already have their own, both opening a modal that posts to
the existing `POST /quick-yatri/{id}/price` route. Only rendered once the row has an id — a
brand-new unsaved application must be saved once first. `updateRowPrice()`'s redirect changed from a
fixed `route('quick-yatri')` to `redirect()->back(...)` (positional args — the project targets
PHP 7.3, no named arguments) with that route as the fallback, so either caller returns to where it
started rather than always landing on the list.

**A same-day follow-up removed the struck-through standard price** that used to sit beside the
agreed one in the grid cell (`$̶3̶,̶1̶5̶0̶ $3,232`) — Rashad asked to see just the agreed amount. One
shared closure (`$price()`), so the change applies to entry, edit and the printed sheet alike.

**The bug that mattered more than any of the above.** Verifying the new button by running
`php artisan test --filter=QuickYatri` **silently corrupted two real applications** —
`test_applying_a_new_grid_reprices_standard_rows_but_never_an_agreed_price` posts
`apply_existing=1`, and the controller's reprice loop is a bare `WHERE custom_price = false AND
trip_option IS NOT NULL` **over the whole real table**, not scoped to the two rows the test creates.
There is no sqlite test connection configured (`phpunit.xml`), so `QuickYatriPricingTest` runs
straight against the real local MySQL database, and its `site_settings` snapshot/restore in
`setUp`/`tearDown` protected the *grid setting* but not the *real rows* the setting change swept
along with it. BANTA SINGH (id 1) and HELLO SIGN (id 864) were both silently repriced to whatever
figure that test posted — first noticed when a rendered screenshot showed a price ($3,125) that
matched nothing anyone had actually set. Both restored by hand a second time. **Fixed properly this
time**, not by patching the symptom again: added `use
Illuminate\Foundation\Testing\DatabaseTransactions;` to the test class, so every write the file
makes — including any future collateral hit on a row it never created — rolls back on tearDown.
Verified by snapshotting the two real rows' prices, running the full suite twice, and confirming
they read back byte-identical both times.

**Worth carrying forward:** any Quick Yatri test that posts `apply_existing=1`, or otherwise saves a
bulk `QuickYatri::where(...)` query, needs the same transaction wrapping — a setting-only
snapshot/restore is not enough once the setting change fans out to real rows. `QuickYatriSheetTest`
was checked and does not exercise `apply_existing`, so it was left as-is.

**Verified:** 63/63 Quick Yatri tests green (up from 61, two new assertions on the entry-screen
button's markup and its absence on a brand-new unsaved application); headless-Chrome screenshots of
the entry screen before and after the strikethrough removal, rendered via `view(...)->render()`
against the real `admin.quick-yatri.entry` template with a manually bound request (no login needed —
the same technique logged in [[konnectyatra-quick-yatri]]).

**Deploy:** pure code, no migration — pushed straight to `main` in four small commits (checkbox
default, price-button feature + `DatabaseTransactions` fix, its test coverage, strikethrough
removal).

**Review:** see decisions.csv rows dated 2026-09-04.

## 2026-09-28 — Yatri IDs print eight to a sheet, backs in the same slots

**Asked:** the user wants the Yatri ID cards printed eight to one page, with the backs in exactly
the same positions on the reverse, so the office can cut the cards out and laminate them.

**Found:** `admin/yatri-id/{page}` still used the old `printDiv()`, which swapped `body.innerHTML`
for a hidden copy of the cards. That drops the page styles, so nothing came out as a cuttable
sheet (the Crew IDs had the same bug, fixed 2026-09-08 in c2f7046). Its "Back View" button went
to `admin/back-view`, the **crew** backs, counted by crew members, so the yatri fronts had no
matching back sheet. The card footer also still showed the superseded Hillside Avenue address.

**Decided:**
- The Yatri page prints from the live deck through the same `admin/ids/_print` partial as the
  crew: Letter portrait, 2 across x 4 down, each slot true CR80 (3.375in x 2.125in). The card was
  rebuilt at 440x277 (CR80 ratio) with the same look, and is scaled .7363636 for print.
- New route `admin/yatri-id-back/{page}` renders the shared back sheet for the current season's
  yatris.
- **Every back sheet, crew and yatri, now carries all eight slots** (`idBackSheet()` in
  `Admin\PackagesController`). The backs are identical, so a full sheet puts a back behind every
  front however the duplex flip mirrors the columns. Printing one back per card was rejected: on a
  short last page (e.g. 3 cards) the flip moves the backs to the wrong columns.
- The footer reads `Business::addressLine()` / `Business::phone()`, so it tracks the admin NAP.

**Office workflow:** print front page N, then Back View page N on the reverse, flip on the
**long edge**, scale 100%. The grid is top-aligned, so a short-edge flip will not line up.
Test on plain paper against the light before using card stock.

**Verified:** printed to PDF over CDP: one page each for a full front, the 3-card last page and
both back sheets, with slot rectangles identical front and back.

**Review:** see decisions.csv row dated 2026-09-28.

## 2026-09-30 — Crew IDs: print only the ticked staff; address-only front footer

**Context:** few visitors this trip, so only some of the crew travel. The Crew ID page printed
every crew member, eight per page, with no way to leave anyone out. The front footer squeezed the
office address in small type beside `www.konnectyatra.org`.

**Decided:**
- `admin/staff_ids` lists **all** crew on one page (no paging; the `{id}` segment is kept only so
  old links resolve), with a tick box above each card. Clicking the card toggles it too; unticked
  cards are greyed. Select all / Clear, plus a live "N of M selected · K sheet(s)" count.
- Print outputs only the ticked cards. The script clones them into `#printDeck`, one `.id-deck`
  per 8, and `_print` starts each deck on a new page (`.id-deck + .id-deck`), so every sheet has
  the same top-aligned grid. The selection is remembered per browser (localStorage).
- Back View gets `?cards=N` and prints `ceil(N/8)` full back sheets of 8. The Yatri backs are
  unchanged (one sheet per page).
- The website URL is removed from the **front**; the back already carries it three times (header,
  return-address strip, QR). The address takes the whole bar: 18px Archivo, street / city on two
  centred lines (~5pt printed).

**Rejected:** hiding unticked cards inside the existing single grid. More than 8 would then rely
on the browser splitting a grid across pages, which is not guaranteed to keep the back
alignment.

**Verified:** PDF over CDP: 3 ticked → 1 page with those 3; 12 → 2 pages (8 + 4); back with
`?cards=12` → 2 pages; slot rectangles identical front and back.

**Review:** see decisions.csv row dated 2026-09-30.

## 2026-09-30 — Hotel Booking Yatris (hotel check-in lists)

**Context:** the office kept one Excel check-in sheet per hotel (Best Western Premier Islamabad,
Royal Swiss Lahore): Yatri #, name, nationality, passport, a Room number shared by a couple or
family, Room # by Hotel, Bed Type, Staff Initial, Complaint, plus a Room Summary tab.

**Decided:**
- Source is **Quick Yatri** (the user's choice over Yatri Bookings). Quick Yatri has no season,
  so each list keeps its own membership; anyone can be removed and added back.
- Stored as one JSON per hotel in `site_settings` — no migration, nothing to run on prod.
- The unit is a room: "With above" joins a yatri to the room of the row above, room numbers
  are derived from the order, and the arrows move by room so nobody lands in a couple's room
  by accident.
- PDF via dompdf, Letter landscape, one page for 20 yatris, with photos and a Room Summary.
  Styled as an American group (US flag, red/navy band) because it is handed to 5-star hotels.
- Dates print DD-MMM-YYYY (house format), not the Excel's "23 Nov - 30 Nov, 2026".

**Rejected:** Yatri Bookings as the source (user chose Quick Yatri); a new table (the list is
small and per-trip; site_settings avoids the prod-migration step).

**Follow-up (same day):** on the first real print, several names wrapped onto two lines and
yatri #20 slipped onto page 2 alone. Names are now kept on one line, the two long headers
(Room # by Hotel, Staff Initial) are two-line, and the column widths are budgeted against the
page. Checked with the real 20-yatri Islamabad list and a 29-character name: all on page 1.

**Review:** see decisions.csv row dated 2026-09-30.

## 2026-09-30 — Yatri IDs on A4 at 3.9in x 2.5in; every ID sheet now prints true size

**Context:** the office's Yatri card stock is 3.9in x 2.5in and the paper is A4. Measuring the PDFs
showed every ID sheet had been printing undersized all along: Crew at ~67%, Yatri at ~80%.

**Decided:**
- `_print` takes `$idSize`. `'yatri'` = A4, margin 0, 2 x 4 slots of 3.9in x 2.5in, fixed rows
  spread evenly and centred both ways (duplex lines up on either flip edge). Crew stays Letter/CR80.
- Yatri card re-proportioned to 440x282 (front) and 880x564 (back) to fill the stock.
- Yatri front footer: address only, centred, a little larger (phone + website removed).
- **True size:** override Bootstrap 4's print `body{min-width:992px}`, and size cards with `zoom`
  instead of `transform:scale`. The transform left the full 880px box in the layout, and any
  print past one page made Chrome shrink the whole job.

**Verified:** PDFs rasterised and measured in inches: Yatri 7.9in wide, .17in sides, .35in
top/bottom; Crew 7.05in, .71in sides; one- and two-sheet runs identical.

## 2026-09-30 — ID type is fixed, not typed; one Yatri # per season; optional card title

**Context:** on prod, Rashad Mahmood (Yatri #20, season 8) never got a card. The ID Type box was
free text; "Chief Organizer", "CEO" and "Chief Organzer" were typed into it, and the ID pages list
only "Yatri" / "Crew Member", so each save vanished and he was entered five times (rows 175–179).

**Decided:**
- Add ID: type is fixed per tab. Edit ID: type is a Yatri / Crew Member choice. Server side,
  `PackagesController::idType()` reads anything else as Yatri.
- A second Yatri with the same Yatri # in the same season is refused, naming the holder.
- A title (e.g. Chief Organizer) is a separate optional "Title on card" field, stored in `role`
  and printed as a red band across the foot of the photo.
- Edit compares the type case-insensitively — the 2024 rows are stored as lowercase `yatri`.

**Prod data fix handed over (run by the user):** row 179 → type Yatri, role Chief Organizer;
rows 175–178 to be deleted once his card is checked.

## 2026-09-30 — D/o for women, never a hard-coded S/o

The Quick Yatri list and Hotel Booking Yatris printed "S/o" for everyone, so women read as sons.
`QuickYatri::parentPrefix()` gives D/o for F, S/o for M, "Father:" when gender is blank. Gurdwara
leads have no gender and read "Father:". Crew ID cards still print "s/o" (no gender column) —
raise it if a female crew member is added.

Also fixed the same day: Yatri Back View pages 2+ printed nothing, because `count()` on an
offset query returns 0 past page 1.

## 2026-10-05 — Form C on Quick Yatri, for Indian-passport yatris only

Form 'C' (Pakistan's Temporary Certificate of Registration) could only be downloaded from Yatri
Bookings. Quick Yatri now has it too: `GET /admin/quick-yatri/{id}/form-c`
(`QuickYatriController::formC`), offered as an amber ID-card button on the list and a
"Download Form C" button on the edit screen.

- **Shown only when `QuickYatri::needsFormC()`** — the sheet's Citizenship / Nationality folds to
  `IND` through `HotelCheckin::nationality()` (INDIA / INDIAN / IND). The route itself refuses
  nobody; only the button is conditional.
- **Same template, no fork:** `pdf/form_c.blade.php` reads a `yatri_visas` row, so the controller
  hands it a plain object in that shape. Residence = the Islamabad hotel saved on Hotel Booking
  Yatris (default Best Western Premier).
- **Left blank on purpose:** "issued at" (the sheet has no issuing-authority box), arrival date,
  flight number and street address — lines to write on. Footer id reads `QY-{id}`.
- No migration. 4 tests in `tests/Feature/QuickYatriFormCTest.php`.
- **Pre-existing, not touched:** `QuickYatriGroupsTest::test_a_city_forms_a_group_before_any_flight_is_booked`
  fails on the local DB with or without this change (it uses PHL, which real rows now use).

**Review:** see decisions.csv row dated 2026-10-05.

## 2026-10-08 — Form C follows the office's updated sheet; only name and passport are filled

The office sent `FormC-Updated.pdf` and asked for the system's Form C to match it, filling in only
the full name and the passport number. `pdf/form_c.blade.php` now carries the rest as fixed
wording: INDIAN nationality, issued at Indian Consulate, New York, arrived 21st November 2026,
Best Western Premier Hotel, 6 Club Road, Islamabad, serial `/2026`. Serial, flight number and
Dated stay blank lines. The "Generated by KONNECT.US" footer is gone — the office's sheet has none.

- **Applies to both downloads** (Yatri Bookings and Quick Yatri) — one template, no fork.
- **The hotel no longer follows Hotel Booking Yatris**, and the year no longer follows the clock.
  Next season, or a different Islamabad hotel, means editing the template.

**Review:** see decisions.csv row dated 2026-10-08.

---

## 2026-10-12 — ID sheets print on US Letter, and the cards stay clear of the paper edge

**What was asked, in order.** Bigger type and no "Authorized Signatory" on the Yatri ID back; a
wider gap between the two columns of Yatri cards; bigger type on the Crew ID front; the same
bigger type on the Crew back; and then, with photos of a cut sheet, "why print is not align when
we cut".

**What was actually wrong.** The Yatri sheet was laid out for A4 only (`@page{size:A4}`), and the
office prints on US Letter. A4 is 6% taller than Letter, so the printer scaled every page to 94%.
The cut strips measured exactly that: cards 3.67in instead of 3.9in, about .54in of white outside,
a .09in gutter. Nobody had said "Letter"; it was read off the ruler and the arithmetic.

**A mistake made along the way.** The first answer to "widen the gap" set the gutter to .32in,
which on A4 leaves .075in at each side. A printer cannot reach that close to the edge, so it
shrinks and shifts the page. The risk was flagged when it shipped, but it should not have shipped:
the right question at that point was which paper is in the tray, and it was not asked until two
rounds later.

**Decision.**
- **US Letter is the default paper** on all four ID pages (Yatri front/back, Crew front/back). A
  Paper box beside Print (`ids/_paper.blade.php`) switches to A4; the choice is kept in the browser
  (`ky.ids.paper`) and shared by every ID page, because it describes the printer, not the card.
- **Yatri on Letter:** .3in gutter, .2in sides, rows .18in apart. A cut down the middle leaves
  .15in inside each card and .2in outside. **Yatri on A4:** .13in gutter, .17in sides — the most
  that paper allows with two 3.9in cards.
- **Crew sheets are centred both ways** with `@page` margin 0. They used to hang from a .4in top
  margin, which only lined up on a long-edge flip.
- **Rule kept in the code comment:** no card nearer than about .17in to the paper edge.

**Type changes shipped the same day.** One back template serves both cards: terms column 316 →
380px, terms body 11.5 → 15px, return address 13 → 17px, signature line removed. Crew front:
values 24 → 34px, CNIC/ID 23 → 30px, labels 13 → 16px, name 25 → 31px, photo 206x236 → 224x256,
with the fields grid split 3:2 and spread down the panel.

**Verified, and what was not.** Two-sheet PDFs for all four card/paper combinations were printed
from headless Chrome and measured: true size, centred, both sheets identical. Nothing was checked
on the office printer, and the card type was measured on a standalone copy, not the logged-in
admin page. Any drift left after this is the printer's own paper feed.

**Open.** The user has not confirmed in words that the paper is Letter, and has not yet reported
a print made with the new layout.

**Review:** see decisions.csv row dated 2026-10-12.
