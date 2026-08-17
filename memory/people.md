# People

People mentioned in our work — teammates, clients, stakeholders, contacts.
One entry per person. Update when roles, relationships, or context change.

<!--
Format:
## <Name>
- Role / relationship:
- Context: where they came up, what they care about
- Notes:
-->

## Rashad Mahmood
- Role / relationship: President / business owner of Konnect Yatra (the client). The cPanel hosting account is his (`rashad`, /home/rashad); he is also the admin user in the app.
- Context: Appears as `MAIL_FROM_NAME` in mail config; the homepage has an audio message "from the President" (the section redesigned 2026-06-16). He supplies source data himself (the airport pricing sheet, the gurdwara master list).
- Notes: Public contact — rm@konnectyatra.org, +1 (718) 908-9464. **Address (confirmed final by the user 2026-08-17): `148-36 Guy R Brewers Blvd. Suit #202A, Jamaica, NY 11434, USA`** — write it exactly like that, "Brewers" plural and "Suit #202A", because the site header, Contact page and `config/schema.php` must stay byte-identical for NAP/Google Business Profile matching. An earlier note here said 18502 Hillside Avenue, NY 11432; that is wrong, superseded.
- **Works in the field:** he drives to gurdwaras and updates their details in person (phones, office-bearers, photos). The admin Address Book was built for this — phone-first, GPS-ranked. Assume mobile use and one-handed taps for anything aimed at him. See [[konnectyatra-address-book]].
- **Wants to self-serve:** where a value is his to supply (office coordinates, opening hours, social
  profile links), he expects a field in the admin rather than asking a developer — see
  [[settings-belong-in-admin]]. Admin → SEO Settings → Business Details was built for this on
  2026-08-17.
- **Social presence (as of 2026-08-17):** Facebook and Instagram only —
  `https://www.facebook.com/share/15D6rJA1H5/` and `https://www.instagram.com/konnect.yatra/`,
  both set in Admin → Settings → Integrations and now published as `sameAs`. **No X/Twitter or
  LinkedIn account exists**, so don't treat those empty fields as an oversight. The Facebook value
  is a `/share/` link rather than the page's permanent vanity URL — weaker as a `sameAs` signal and
  worth swapping if he can supply the canonical one.
- **How he specifies changes:** sends a screenshot of the live page plus a typed list of the fields/labels he wants, in his own line grouping (e.g. `Telephone:   Email:` on one line = put them side by side). Treat the grouping as the layout spec. His lists are not always exhaustive — the 2026-08-10 popup list silently dropped an existing field — so check what's in the current form but missing from his list and raise it rather than deleting it.

## Asghar (AsgharSHAH)
- Role / relationship: Developer building/maintaining KonnectYatra. The person I work with directly.
- Context: git user `AsgharSHAH <asghar786@hotmail.com>`; contact asghar786@gmail.com.
- Notes: Works on Windows + XAMPP locally; deploys to Rashad's cPanel host.
