#!/usr/bin/env bash
# Exercises setup-droplet.sh end to end in a temp directory (needs root for chown,
# CI runs it with sudo). Fails on the first broken expectation.
set -euo pipefail
HERE="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
T="$(mktemp -d)"; trap 'rm -rf "$T"' EXIT
export FOXCS_OPT="$T/opt" FOXCS_ETC="$T/etc" FOXCS_CRON_DIR="$T/cron.d" FOXCS_LOG="$T/class-code.log"
S="$HERE/setup-droplet.sh"
fail() { echo "FAIL: $*"; exit 1; }

bash "$S" > /dev/null
[ -e "$T/opt" ] || [ -e "$T/etc" ] && fail "dry run created files"

bash "$S" --apply > /dev/null
[ -f "$T/opt/mastery-check-access/mca_lib.php" ] || fail "scripts not installed"
[ "$(stat -c %a "$T/etc/class-code.secret")" = 640 ] || fail "secret mode not 640"
[ "$(stat -c %G "$T/etc/class-code.secret")" = www-data ] || fail "secret group not www-data"
[ "$(head -1 "$T/etc/class-code.secret" | tr -d '\n' | wc -c)" -ge 32 ] || fail "secret too short"
[ -e "$T/cron.d/foxcs-class-code" ] && fail "cron enabled without --enable-cron"

before="$(cat "$T/etc/class-code.secret")"
bash "$S" --apply > /dev/null
[ "$(cat "$T/etc/class-code.secret")" = "$before" ] || fail "re-run replaced the secret"

bash "$S" --apply --enable-cron --courses=foxcs-python,sandbox-adaptive-demo > /dev/null
grep -q -- "--courses=foxcs-python,sandbox-adaptive-demo --notify" "$T/cron.d/foxcs-class-code" || fail "cron line wrong"

php "$T/opt/mastery-check-access/class-code.php" --course=foxcs-python --secret-file="$T/etc/class-code.secret" \
  | grep -Eq '[0-9]{4}-[0-9]{2}-[0-9]{2} +[A-Za-z]+ +[0-9]{6}$' || fail "installed class-code.php did not print a code"

if bash "$S" '--courses=x;rm -rf /' > /dev/null 2>&1; then fail "accepted a malicious --courses"; fi
if bash "$S" --bogus > /dev/null 2>&1; then fail "accepted an unknown option"; fi
if FOXCS_WEB_GROUP=nosuchgroup bash "$S" > /dev/null 2>&1; then fail "accepted a missing group"; fi

echo "OK: setup-droplet.sh checks passed"
