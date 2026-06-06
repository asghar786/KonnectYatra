# KonnectYatra — Project Guide for Claude

## Persistent memory (read at start, update at end)

This project keeps a local memory under [`memory/`](./memory/). **At the start of every
session, read all four files** so I carry context forward:

- [`memory/user.md`](./memory/user.md) — who I'm working with.
- [`memory/people.md`](./memory/people.md) — teammates, clients, stakeholders, contacts.
- [`memory/preferences.md`](./memory/preferences.md) — how the user wants me to work.
- [`memory/decisions.md`](./memory/decisions.md) — narrative log of significant decisions.

**At the end of every session (or whenever I learn something durable), update them.**
Only record stable, reusable facts — not transient conversation details. Prefer editing an
existing entry over adding a duplicate; delete entries that turn out to be wrong.

## Decision logging

Whenever the user describes a decision they're making, append it to
[`memory/decisions.csv`](./memory/decisions.csv) with these columns:

`date, decision, reasoning, expected_outcome, review_date, status`

- `date` = the date the decision was made (YYYY-MM-DD).
- `review_date` = **`date` + 30 days** (revisit the decision then).
- `status` = left empty until the daily check flags it `REVIEW DUE`.
- All free-text fields are double-quoted; literal `"` is doubled (`""`).

The easy way to add a row (auto-computes the 30-day review date and quoting):

```bash
bash memory/log_decision.sh "<decision>" "<reasoning>" "<expected outcome>" [decision_date]
```

For richer context (alternatives considered, links, follow-ups) also add a prose entry to
[`memory/decisions.md`](./memory/decisions.md).

## Review workflow

- A **daily** job runs [`memory/check_reviews.sh`](./memory/check_reviews.sh), which stamps any
  row whose `review_date` is on/before today with `REVIEW DUE` (idempotent).
  - Windows: registered as Scheduled Task **"KonnectYatra Decision Reviews"**
    (install/remove with `memory/install_schedule.ps1` / `-Uninstall`).
  - Linux/macOS: `0 9 * * * /full/path/memory/check_reviews.sh`
- To see only what's due, run:

```bash
bash memory/review.sh
```

When `review.sh` surfaces a due decision, walk the user through it: did the expected outcome
hold? Update `decisions.md`, and either clear the `status`/bump the `review_date`, or retire it.
