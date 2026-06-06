#!/usr/bin/env bash
#
# log_decision.sh — append one decision to decisions.csv.
# Review date is auto-set to 30 days after the decision date.
#
# Usage:
#   bash memory/log_decision.sh "<decision>" "<reasoning>" "<expected outcome>" [decision_date]
#
# decision_date is optional and defaults to today (YYYY-MM-DD).
#
set -euo pipefail

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CSV="$DIR/decisions.csv"

if [ "$#" -lt 3 ]; then
  echo "Usage: $0 \"<decision>\" \"<reasoning>\" \"<expected outcome>\" [decision_date]" >&2
  exit 1
fi

DECISION="$1"
REASONING="$2"
EXPECTED="$3"
DDATE="${4:-$(date +%Y-%m-%d)}"
RDATE="$(date -d "$DDATE +30 days" +%Y-%m-%d)"

# Create header if the file is missing.
[ -f "$CSV" ] || echo "date,decision,reasoning,expected_outcome,review_date,status" > "$CSV"

# CSV-quote a field: double internal quotes, wrap in quotes.
q() { printf '"%s"' "${1//\"/\"\"}"; }

printf '%s,%s,%s,%s,%s,%s\n' \
  "$(q "$DDATE")" "$(q "$DECISION")" "$(q "$REASONING")" \
  "$(q "$EXPECTED")" "$(q "$RDATE")" "$(q "")" >> "$CSV"

echo "Logged decision (review due $RDATE)."
