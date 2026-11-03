#!/usr/bin/env bash
# Export portfolio-showcase/ into a brand-new git repository with fresh history.
#
#   bash 00-project-overview/portfolio-prep/export_showcase.sh [target_dir]
#
# Default target: ../foxcs-showcase (next to this repo). The new repo shares
# NO history with FoxCS, so nothing from this repo's past commits (licensed
# workbooks, passwords, real pseudonym formats) can be recovered from it.
# The leak scanner and all test suites must pass before the first commit is made.
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
SRC="$REPO_ROOT/portfolio-showcase"
TARGET="${1:-$REPO_ROOT/../foxcs-showcase}"

if [ -e "$TARGET" ] && [ -n "$(ls -A "$TARGET" 2>/dev/null)" ]; then
  echo "Refusing to export: $TARGET already exists and is not empty." >&2
  exit 1
fi

mkdir -p "$TARGET"
cp -R "$SRC"/. "$TARGET"/
find "$TARGET" -name __pycache__ -type d -prune -exec rm -rf {} +

cd "$TARGET"
echo "== Leak scan"
python3 tools/check_showcase_clean.py
echo "== Tests"
python3 -m unittest discover -s grader/tests
python3 -m unittest discover -s evals/tests
python3 -m unittest discover -s tools/tests
python3 evals/run_evals.py > /dev/null
find . -name __pycache__ -type d -prune -exec rm -rf {} +

git init -q -b main
git add -A
git -c user.name="${GIT_AUTHOR_NAME:-Jay Fox}" -c user.email="${GIT_AUTHOR_EMAIL:-jay@jayfox.design}" \
  commit -q -m "FoxCS engineering showcase: grader, eval harness, docs"

cat <<MSG

Exported to: $TARGET  (fresh history, 1 commit)

Next steps:
  1. Create an EMPTY repository on GitHub named foxcs-showcase (no README, no license).
     If you pick a different name, update the CI badge URL in README.md.
  2. cd "$TARGET"
     git remote add origin https://github.com/jalex929/foxcs-showcase.git
     git push -u origin main
  3. In the GitHub About panel add the description, website, and topics from
     00-project-overview/portfolio-prep/README.md.
MSG
