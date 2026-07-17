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
