#!/usr/bin/env bash
# setup-droplet.sh -- one-time server setup for the daily class code.
# Covers README steps 0, 1 and 4: install a copy www-data can read, create the
# secret, and install the cron job. It does NOT touch any course or quiz:
# that is apply-mastery-check-access.php, run separately after the sandbox test.
#
#   sudo bash setup-droplet.sh                      # show what would happen
#   sudo bash setup-droplet.sh --apply              # do it, cron left OFF
#   sudo bash setup-droplet.sh --apply --enable-cron --courses=foxcs-python
#
# Safe to re-run: never overwrites an existing secret (that would change every
# future code), re-copies the scripts, rewrites the cron file to match.
#
# Paths can be overridden for testing: FOXCS_OPT, FOXCS_ETC, FOXCS_CRON_DIR,
# FOXCS_LOG, FOXCS_WEB_GROUP.
set -euo pipefail

SRC="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
OPT="${FOXCS_OPT:-/opt/foxcs}"
ETC="${FOXCS_ETC:-/etc/foxcs}"
CRON_DIR="${FOXCS_CRON_DIR:-/etc/cron.d}"
LOG="${FOXCS_LOG:-/var/log/foxcs-class-code.log}"
WEB_GROUP="${FOXCS_WEB_GROUP:-www-data}"
SECRET="$ETC/class-code.secret"
CRON_FILE="$CRON_DIR/foxcs-class-code"

APPLY=0; ENABLE_CRON=0; COURSES="foxcs-python"
for arg in "$@"; do
  case "$arg" in
    --apply) APPLY=1 ;;
    --enable-cron) ENABLE_CRON=1 ;;
    --courses=*) COURSES="${arg#--courses=}" ;;
    -h|--help) sed -n '2,17p' "$0"; exit 0 ;;
    *) echo "Unknown option: $arg" >&2; exit 2 ;;
  esac
done

if ! [[ "$COURSES" =~ ^[a-z0-9_-]+(,[a-z0-9_-]+)*$ ]]; then
  echo "--courses must be comma-separated course shortnames, got: $COURSES" >&2; exit 2
fi
if ! getent group "$WEB_GROUP" > /dev/null; then
  echo "Group '$WEB_GROUP' does not exist on this machine." >&2; exit 1
fi

run() { if [ "$APPLY" = 1 ]; then "$@"; else echo "  would run: $*"; fi; }

echo "== 1. Install scripts to $OPT/mastery-check-access"
run mkdir -p "$OPT"
run rm -rf "$OPT/mastery-check-access"
run cp -r "$SRC" "$OPT/mastery-check-access"
run chown -R "root:$WEB_GROUP" "$OPT/mastery-check-access"
run chmod -R u=rwX,g=rX,o= "$OPT/mastery-check-access"

echo "== 2. Class-code secret at $SECRET"
if [ -s "$SECRET" ]; then
  echo "  exists, keeping it (replacing it would change every future code)"
else
  run mkdir -p "$ETC"
  if [ "$APPLY" = 1 ]; then
    umask 027
    head -c 48 /dev/urandom | base64 | tr -d '\n' > "$SECRET"
    echo >> "$SECRET"
  else
    echo "  would create a new random 64-character secret"
  fi
fi
run chown "root:$WEB_GROUP" "$SECRET"
run chmod 640 "$SECRET"

echo "== 3. Cron job ($CRON_FILE)"
CRON_LINE="*/10 * * * * $WEB_GROUP php $OPT/mastery-check-access/rotate-daily-class-code.php --courses=$COURSES --notify >> $LOG 2>&1"
if [ "$ENABLE_CRON" = 1 ]; then
  if [ "$APPLY" = 1 ]; then
    mkdir -p "$CRON_DIR"
    touch "$LOG" && chown "$WEB_GROUP" "$LOG" && chmod 640 "$LOG"
    printf '# Daily class code rotation. Managed by setup-droplet.sh.\n%s\n' "$CRON_LINE" > "$CRON_FILE"
    chmod 644 "$CRON_FILE"
  else
    echo "  would write: $CRON_LINE"
  fi
else
  echo "  left OFF (pass --enable-cron after the sandbox test passes)"
  [ -e "$CRON_FILE" ] && echo "  note: $CRON_FILE already exists and was not changed"
fi

if [ "$APPLY" = 1 ]; then
  echo "Done. Check with: sudo -u $WEB_GROUP php $OPT/mastery-check-access/class-code.php --course=${COURSES%%,*}"
else
  echo "Nothing changed. Re-run with --apply."
fi
