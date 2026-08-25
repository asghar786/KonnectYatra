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

<!-- code-review-graph MCP tools -->
## MCP Tools: code-review-graph

**This project has a knowledge graph. Start with the code-review-graph
MCP tools to narrow scope, then read the source.** The graph is cheaper than scanning files and
gives you structural context (callers, dependents, test coverage) that file search cannot.

### When to use graph tools FIRST

- **Exploring code**: `semantic_search_nodes_tool` or `query_graph_tool` instead of Grep
- **Understanding impact**: `get_impact_radius_tool` instead of manually tracing imports
- **Code review**: `detect_changes_tool` + `get_review_context_tool` instead of reading entire files
- **Finding relationships**: `query_graph_tool` with callers_of/callees_of/imports_of/tests_for
- **Architecture questions**: `get_architecture_overview_tool` + `list_communities_tool`

### Verify in the source

- Narrow scope with the graph, then read the source. Do not change code from graph output alone.
- For any non-trivial change, read the implementation and the relevant tests before concluding.
- Verify the exact source when touching behavior, database logic, migrations, retries, fallbacks,
  recovery, or compatibility code.
- When the graph and the source disagree, the source wins. The graph may be stale or may not
  model that relationship.
- An empty graph result can mean "not indexed" or "not statically visible", not "does not exist".

### Key Tools

| Tool | Use when |
| ------ | ---------- |
| `detect_changes_tool` | Reviewing code changes — gives risk-scored analysis |
| `get_review_context_tool` | Need source snippets for review — token-efficient |
| `get_impact_radius_tool` | Understanding blast radius of a change |
| `get_affected_flows_tool` | Finding which execution paths are impacted |
| `query_graph_tool` | Tracing callers, callees, imports, tests, dependencies |
| `semantic_search_nodes_tool` | Finding functions/classes by name or keyword |
| `get_architecture_overview_tool` | Understanding high-level codebase structure |
| `refactor_tool` | Planning renames, finding dead code |

### Workflow

1. The graph auto-updates on file changes (via hooks).
2. Use `detect_changes_tool` for code review.
3. Use `get_affected_flows_tool` to understand impact.
4. Use `query_graph_tool` pattern="tests_for" to check coverage.
<!-- /code-review-graph MCP tools -->
