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
