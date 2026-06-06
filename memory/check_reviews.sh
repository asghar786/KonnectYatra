#!/usr/bin/env bash
#
# check_reviews.sh — daily job.
# Scans decisions.csv and stamps any row whose review_date is on/before today
# with the "REVIEW DUE" flag (idempotent — already-flagged rows are left alone).
#
# Schedule this once a day. On Windows it is registered as a Scheduled Task
# (see CLAUDE.md / install_schedule.ps1); on Linux/macOS add to crontab:
#   0 9 * * *  /path/to/memory/check_reviews.sh
#
set -euo pipefail

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CSV="$DIR/decisions.csv"
TODAY="$(date +%Y-%m-%d)"

[ -f "$CSV" ] || { echo "No decisions.csv at $CSV"; exit 0; }

TMP="$(mktemp)"

awk -v today="$TODAY" '
# Parse one CSV line into global array F[1..NF_], handling double-quoted
# fields, escaped "" quotes, and commas inside quotes.
function parse_csv(line,   i, ch, nxt, field, inq) {
  delete F; NF_ = 0; field = ""; inq = 0
  for (i = 1; i <= length(line); i++) {
    ch = substr(line, i, 1)
    if (inq) {
      if (ch == "\"") {
        nxt = substr(line, i + 1, 1)
        if (nxt == "\"") { field = field "\""; i++ } else { inq = 0 }
      } else { field = field ch }
    } else {
      if (ch == "\"")      { inq = 1 }
      else if (ch == ",")  { F[++NF_] = field; field = "" }
      else                 { field = field ch }
    }
  }
  F[++NF_] = field
}
# Quote a field for output (always quote so embedded commas are safe).
function q(s) { gsub(/"/, "\"\"", s); return "\"" s "\"" }

NR == 1 { print; next }              # header passthrough
/^[[:space:]]*$/ { next }            # skip blank lines
{
  parse_csv($0)
  review_date = (NF_ >= 5 ? F[5] : "")
  status      = (NF_ >= 6 ? F[6] : "")
  if (review_date != "" && review_date <= today && status != "REVIEW DUE") {
    status = "REVIEW DUE"
    flagged++
  }
  printf "%s,%s,%s,%s,%s,%s\n", q(F[1]), q(F[2]), q(F[3]), q(F[4]), q(review_date), q(status)
}
END { if (flagged) printf "" > "/dev/stderr" }
' "$CSV" > "$TMP"

mv "$TMP" "$CSV"
echo "[$(date '+%Y-%m-%d %H:%M:%S')] check_reviews: scanned $CSV (today=$TODAY)"
