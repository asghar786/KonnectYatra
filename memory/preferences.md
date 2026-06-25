# Preferences

How I should work on this project — conventions, tooling, and standing instructions.
Add an entry whenever the user corrects me or confirms a way of working, with the reason.

<!--
Format:
- **<topic>:** <the preference>. Why: <reason>.
-->

- **Commit attribution:** Do NOT add `Co-Authored-By: Claude` (or any Claude/AI attribution) to commits or PR bodies in this repo. Use Claude purely as a code assistant. Why: user wants no AI collaborator showing on GitHub (requested 2026-06-16; existing history was scrubbed and force-pushed).
- **Batch prod DB migrations:** When work introduces new DB migrations, run them locally as needed but DON'T tell the user to migrate prod after each change. Accumulate the pending prod migrations and give one consolidated `php artisan migrate ... --force` command set at the end of the work session. Why: user runs prod migrations manually one time, after all add/edit/delete changes are done (requested 2026-06-25). Track pending ones in [[konnectyatra-pending-prod-migrations]].
