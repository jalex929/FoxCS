#!/usr/bin/env bash
# Contract test: an event written by the Moodle plugin's PHP is accepted and
# graded by the Python worker's parser, end to end through the real files.
#   bash 07-infrastructure/local-plugins/foxcsgradequeue/tests/contract_test.sh
set -euo pipefail
cd "$(dirname "$0")/../../../.."
work=$(mktemp -d)
trap 'rm -rf "$work"' EXIT

event=$(php -r '
  define("FOXCS_GRADEQUEUE_TEST", true);
  require "07-infrastructure/local-plugins/foxcsgradequeue/queue_lib.php";
  [$q, $fixture] = [$argv[1], $argv[2]];
  $dir = foxcs_gq_files_dir($q, 7);
  mkdir($dir, 0770, true);
  $name = foxcs_gq_safe_filename("exercise.py");
  copy($fixture, "$dir/$name");
  $e = foxcs_gq_build_event(7, "testfox", "lesson_02_06_coins_to_points", 1768226400, [$name => "$dir/$name"]);
  echo foxcs_gq_write_event($q, $e, "ci");
' "$work" portfolio-showcase/grader/tests/on_submission_fixtures/string_repetition.py)

python3 - "$event" "$work" <<'PY'
import json, sys
from pathlib import Path
sys.path.insert(0, "portfolio-showcase/grader")
import on_submission as osub

event_path, queue = Path(sys.argv[1]), Path(sys.argv[2])
data = json.loads(event_path.read_text(encoding="utf-8"))
osub.parse_event(data)  # raises on any shape mismatch
store = osub.ResultStore(queue / "drafts.jsonl")
draft = osub.handle_submission(data, osub.load_exercises(Path("portfolio-showcase/grader/exercises")), queue / "files", store)
assert draft["submission_id"] == "moodle-sub-7", draft
assert draft["student_id"] == "testfox", draft
assert draft["band"] == "runs_with_issues", draft
print(f"contract ok: {event_path.name} graded as {draft['band']}")
PY
