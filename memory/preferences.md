# Preferences

How I should work on this project — conventions, tooling, and standing instructions.
Add an entry whenever the user corrects me or confirms a way of working, with the reason.

<!--
Format:
- **<topic>:** <the preference>. Why: <reason>.
-->

- **Commit attribution:** Do NOT add `Co-Authored-By: Claude` (or any Claude/AI attribution) to commits or PR bodies in this repo. Use Claude purely as a code assistant. Why: user wants no AI collaborator showing on GitHub (requested 2026-06-16; existing history was scrubbed and force-pushed).
- **Settings belong in the admin, not in config files:** when work needs a value only the client can
  supply (business coordinates, opening hours, profile URLs, API keys), build an admin screen for it
  rather than leaving it in `config/` or a constant. Why: the user asked for exactly this on
  2026-08-17 ("plz provide me option at backend so I fill it accordingly") — they fill these in
  themselves and shouldn't need a developer or a deploy. Prefer `site_settings` (key/value, already
  cached per request) so it needs no migration; keep the `config/` value as the fallback default.
- **Batch prod DB migrations:** When work introduces new DB migrations, run them locally as needed but DON'T tell the user to migrate prod after each change. Accumulate the pending prod migrations and give one consolidated `php artisan migrate ... --force` command set at the end of the work session. Why: user runs prod migrations manually one time, after all add/edit/delete changes are done (requested 2026-06-25). Track pending ones in [[konnectyatra-pending-prod-migrations]].
- **One date format, upper-cased: `21-AUG-2026`.** Every date the user sees — on screen, in a
  list, typed into a form, and printed on a PDF or sheet — reads DD-MMM-YYYY with the month in
  capitals. Never `21-Aug-2026`, never `2026-08-21`, and never a bare `<input type="date">`
  (it shows the browser's own mm/dd/yyyy and ignores the house format). Use
  `App\Support\YatriDate::format()` for varchar date columns, or a `stamp()` helper on the model
  for real `date` columns; for entry, the jQuery UI picker configured `dd-M-yy` with upper-case
  `monthNamesShort`. Why: the user asked for exactly this on 2026-08-21 for Quick Yatri, and it is
  the same stamp the public apply form has always written — DD-MMM-YYYY is unambiguous where
  NN-NN-YYYY is not. See `memory/decisions.md` 2026-08-21 and the `konnectyatra-yatri-dates` note.
- **List corrections before editing, when the source is a marked-up photo/screenshot.** When the
  user sends a hand-annotated image (strikethroughs, carets, circled words, arrows) rather than a
  typed list, read back the corrections as plain sentences — including how each ambiguous mark was
  resolved — and wait for a yes before touching any file. Why: asked for explicitly on 2026-08-24
  ("before proceed, list down the correction, so I can check if anything you missed") when marking
  up the Quick Yatri page-2 terms. Handwriting is lossier than a typed list (a strikethrough can
  mean several things, an arrow can point at the wrong line by accident), so confirming first here
  matters more than it does for his usual typed-list change requests.
