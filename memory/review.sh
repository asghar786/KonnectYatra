#!/usr/bin/env bash
#
# review.sh — surface only the decisions flagged "REVIEW DUE".
# Run any time:  bash memory/review.sh
#
set -euo pipefail

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CSV="$DIR/decisions.csv"

[ -f "$CSV" ] || { echo "No decisions.csv at $CSV"; exit 0; }

awk '
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
      if (ch == "\"")     { inq = 1 }
      else if (ch == ",") { F[++NF_] = field; field = "" }
      else                { field = field ch }
    }
  }
  F[++NF_] = field
}
NR == 1 { next }
/^[[:space:]]*$/ { next }
{
  parse_csv($0)
  if ((NF_ >= 6 ? F[6] : "") == "REVIEW DUE") {
    n++
    printf "\n#%d  (decided %s, review due %s)\n", n, F[1], F[5]
    printf "  Decision: %s\n", F[2]
    printf "  Reasoning: %s\n", F[3]
    printf "  Expected: %s\n", F[4]
  }
}
END {
  if (n) printf "\n%d decision(s) due for review.\n", n
  else   print "No decisions are due for review. \xe2\x9c\x93"
}
' "$CSV"
