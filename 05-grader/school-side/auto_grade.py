#!/usr/bin/env python3
"""
FoxCS school-side auto-grader.

Runs on the teacher machine (cmd or PowerShell), stdlib only — no pip installs,
no network access, no AI. Reads already codename-swapped submission folders
(see ../../01-privacy-and-governance/codename-policy.md) and produces two
reports:

1. A completion/attempt report for the content that is genuinely structural
   to auto-grade: the four HTML pages that save themselves with a
   "_completed" suffix and embed a hidden foxcs-telemetry JSON block or
   hidden timestamp spans (vocab quiz, practice, mastery check, feedback —
   see 02-authoring-system/mvp-unit-folder-structure.md). This script never
   judges quality, only structural facts already present in the file:
   whether it was saved, how many attempts a drill/quiz took, whether the
   first try was right, how long a mastery check was unlocked before being
   marked complete.
2. A "needs review" manifest listing every file in each submission that
   requires a human or AI judgment call (project code, application code,
   mastery-check written answers, journal/reflection text quality) — these
   are NOT graded here. Bring this manifest, plus the actual files, to
   Claude Code (which already has feedback-and-grading-spec.md as its
   grading-voice/rubric reference) to draft feedback, then release only
   after review per data-boundaries.md's Release Gate.

Usage:
    python auto_grade.py <submissions_root> [--out-dir DIR]

<submissions_root> should contain one folder per student-lesson submission,
named "<CODENAME>_<lesson_dirname>" (matches the sample fixture layout in
05-grader/sample-submissions/), e.g.:

    submissions/
      PY1-A-DELTA04_lesson_01_04_printing_output/
        00_table_of_contents.html
        04_vocab_quiz_completed.html
        05_practice_completed.html
        06_application.py
        ...

Writes auto_grade_report.csv and needs_review_manifest.csv into --out-dir
(default: the current directory).
"""

import argparse
import csv
import json
import re
import sys
from datetime import datetime
from pathlib import Path

# Files matching these suffixes carry a hidden foxcs-telemetry JSON block
# (see 02-authoring-system/telemetry-and-analytics.md) with quiz_check /
# drill_attempt events. Numeric filename prefixes vary by lesson, so match
# on suffix only.
TELEMETRY_SUFFIXES = {
    "vocab_quiz": "vocab_quiz_completed.html",
    "practice": "practice_completed.html",
}

# Mastery check doesn't carry a telemetry block — it carries two hidden
# timestamp spans instead (see the redesign note in that file's own header
# comment: unlock time and completion time, written automatically, nothing
# for the student to transcribe).
MASTERY_CHECK_SUFFIX = "mastery_check_completed.html"

# Feedback form — completion-only, never content-graded (it's the student's
# opinion of the lesson, not a rubric target).
FEEDBACK_SUFFIX = "feedback_completed.html"

TELEMETRY_BLOCK_RE = re.compile(
    r'<script type="application/json" id="foxcs-telemetry"[^>]*>(.*?)</script>',
    re.DOTALL,
)
UNLOCK_TIME_RE = re.compile(r'unlocked_at:([0-9T:.\-Z]+)')
COMPLETE_TIME_RE = re.compile(r'completed_at:([0-9T:.\-Z]+)')


def _parse_iso_timestamp(value):
    """Parses a JS `Date.toISOString()` value, with or without milliseconds.

    Real browser-generated timestamps always include milliseconds
    (e.g. "2026-08-20T22:41:36.123Z"); the original hand-typed sample
    fixture omitted them, which masked a real bug where this raised
    ValueError and silently produced an empty
    mastery_check_minutes_unlocked_to_complete for every real submission.
    """
    for fmt in ("%Y-%m-%dT%H:%M:%S.%fZ", "%Y-%m-%dT%H:%M:%SZ"):
        try:
            return datetime.strptime(value, fmt)
        except ValueError:
            continue
    raise ValueError(f"Unrecognized timestamp format: {value!r}")
REFLECTION_TEXTAREA_RE = re.compile(
    r'<textarea[^>]*id="memoryTrick"[^>]*>(.*?)</textarea>', re.DOTALL
)

# Anything with one of these suffixes is a real submission artifact but is
# NOT auto-gradable here — it needs a human or Claude Code judgment call.
# Labeled so the manifest tells Jay *why*, not just *that*.
NEEDS_REVIEW_PATTERNS = [
    (re.compile(r'project\.py$'), "project code — holistic rubric grading"),
    (re.compile(r'application\.py$'), "application code — holistic rubric grading"),
    (re.compile(r'mastery_check(_completed)?\.py$'), "mastery check written answers — grade against the lesson's mastery_check_KEY.md"),
    (re.compile(r'example.*\.py$'), "view-only reference file — not a submission, skip"),
    (re.compile(r'project\.html$'), "project instructions/checklist — spot-check tier claims against the code"),
]


def parse_submission_dirname(dirname):
    """'PY1-A-DELTA04_lesson_01_04_printing_output' -> ('PY1-A-DELTA04', 'lesson_01_04_printing_output')."""
    if "_" not in dirname:
        return dirname, ""
    codename, _, lesson = dirname.partition("_")
    return codename, lesson


def find_file(folder: Path, suffix: str):
    matches = sorted(folder.glob(f"*{suffix}"))
    return matches[0] if matches else None


def score_telemetry_file(path: Path, event_type: str):
    """Returns (saved, attempt_count, first_try_all_correct, last_attempt_all_correct)."""
    text = path.read_text(encoding="utf-8", errors="replace")
    m = TELEMETRY_BLOCK_RE.search(text)
    if not m:
        return True, 0, None, None
    try:
        telemetry = json.loads(m.group(1))
    except json.JSONDecodeError:
        return True, 0, None, None
    events = [e for e in telemetry.get("events", []) if e.get("type") == event_type]
    if not events:
        return True, 0, None, None
    first_attempt = events[0]
    last_attempt = events[-1]

    def all_correct(evt):
        attempted = evt.get("attempted", [])
        if not attempted:
            return None
        return all(a.get("correct") for a in attempted)

    return True, len(events), all_correct(first_attempt), all_correct(last_attempt)


def grade_vocab_quiz(folder: Path, row: dict):
    path = find_file(folder, TELEMETRY_SUFFIXES["vocab_quiz"])
    if not path:
        row["vocab_quiz_saved"] = "N"
        return
    saved, attempts, first_ok, last_ok = score_telemetry_file(path, "quiz_check")
    text = path.read_text(encoding="utf-8", errors="replace")
    reflection_m = REFLECTION_TEXTAREA_RE.search(text)
    reflection_text = re.sub(r"<[^>]+>", "", reflection_m.group(1)).strip() if reflection_m else ""
    row["vocab_quiz_saved"] = "Y" if saved else "N"
    row["vocab_quiz_check_attempts"] = attempts
    row["vocab_quiz_first_attempt_all_correct"] = "" if first_ok is None else ("Y" if first_ok else "N")
    row["vocab_quiz_all_correct_by_save"] = "" if last_ok is None else ("Y" if last_ok else "N")
    row["vocab_quiz_reflection_word_count"] = len(reflection_text.split())
    row["vocab_quiz_reflection_text"] = reflection_text


def grade_practice(folder: Path, row: dict):
    path = find_file(folder, TELEMETRY_SUFFIXES["practice"])
    if not path:
        row["practice_saved"] = "N"
        return
    text = path.read_text(encoding="utf-8", errors="replace")
    m = TELEMETRY_BLOCK_RE.search(text)
    row["practice_saved"] = "Y"
    if not m:
        row["practice_check_events"] = 0
        return
    try:
        telemetry = json.loads(m.group(1))
    except json.JSONDecodeError:
        row["practice_check_events"] = 0
        return
    events = telemetry.get("events", [])
    row["practice_check_events"] = len(events)
    # Attempts are keyed per-drill; a drill "passes first try" if its
    # earliest recorded check for that drill id was fully correct.
    first_seen = {}
    for evt in events:
        drill_id = evt.get("drill_id") or evt.get("drill") or evt.get("id")
        if drill_id is None:
            continue
        first_seen.setdefault(drill_id, evt)
    drills_seen = len(first_seen)
    first_try_correct = sum(
        1 for evt in first_seen.values() if evt.get("correct") is True
    )
    row["practice_drills_attempted"] = drills_seen
    row["practice_first_try_correct_count"] = first_try_correct


def grade_mastery_check(folder: Path, row: dict):
    path = find_file(folder, MASTERY_CHECK_SUFFIX)
    if not path:
        row["mastery_check_saved"] = "N"
        return
    text = path.read_text(encoding="utf-8", errors="replace")
    unlock_m = UNLOCK_TIME_RE.search(text)
    complete_m = COMPLETE_TIME_RE.search(text)
    row["mastery_check_saved"] = "Y"
    row["mastery_check_unlocked_at"] = unlock_m.group(1) if unlock_m else ""
    row["mastery_check_completed_at"] = complete_m.group(1) if complete_m else ""
    if unlock_m and complete_m:
        try:
            delta = _parse_iso_timestamp(complete_m.group(1)) - _parse_iso_timestamp(unlock_m.group(1))
            row["mastery_check_minutes_unlocked_to_complete"] = round(delta.total_seconds() / 60, 1)
        except ValueError:
            row["mastery_check_minutes_unlocked_to_complete"] = ""


def grade_feedback(folder: Path, row: dict):
    path = find_file(folder, FEEDBACK_SUFFIX)
    row["feedback_saved"] = "Y" if path else "N"


def collect_needs_review(folder: Path, codename: str, lesson: str, manifest_rows: list):
    for path in sorted(folder.iterdir()):
        if not path.is_file():
            continue
        for pattern, reason in NEEDS_REVIEW_PATTERNS:
            if pattern.search(path.name):
                manifest_rows.append({
                    "codename": codename,
                    "lesson": lesson,
                    "file": path.name,
                    "reason": reason,
                })
                break


def main():
    parser = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    parser.add_argument("submissions_root", help="Folder containing one subfolder per <CODENAME>_<lesson_dirname> submission")
    parser.add_argument("--out-dir", default=".", help="Where to write the two CSV reports (default: current directory)")
    args = parser.parse_args()

    root = Path(args.submissions_root)
    if not root.is_dir():
        print(f"Not a folder: {root}", file=sys.stderr)
        sys.exit(1)

    out_dir = Path(args.out_dir)
    out_dir.mkdir(parents=True, exist_ok=True)

    report_rows = []
    manifest_rows = []

    submission_dirs = sorted(p for p in root.iterdir() if p.is_dir())
    if not submission_dirs:
        print(f"No submission folders found directly inside {root}.", file=sys.stderr)
        sys.exit(1)

    for folder in submission_dirs:
        codename, lesson = parse_submission_dirname(folder.name)
        row = {"codename": codename, "lesson": lesson}
        grade_vocab_quiz(folder, row)
        grade_practice(folder, row)
        grade_mastery_check(folder, row)
        grade_feedback(folder, row)
        report_rows.append(row)
        collect_needs_review(folder, codename, lesson, manifest_rows)

    report_fields = [
        "codename", "lesson",
        "vocab_quiz_saved", "vocab_quiz_check_attempts",
        "vocab_quiz_first_attempt_all_correct", "vocab_quiz_all_correct_by_save",
        "vocab_quiz_reflection_word_count", "vocab_quiz_reflection_text",
        "practice_saved", "practice_check_events",
        "practice_drills_attempted", "practice_first_try_correct_count",
        "mastery_check_saved", "mastery_check_unlocked_at",
        "mastery_check_completed_at", "mastery_check_minutes_unlocked_to_complete",
        "feedback_saved",
    ]
    report_path = out_dir / "auto_grade_report.csv"
    with report_path.open("w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=report_fields, extrasaction="ignore")
        writer.writeheader()
        for row in report_rows:
            writer.writerow(row)

    manifest_path = out_dir / "needs_review_manifest.csv"
    with manifest_path.open("w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=["codename", "lesson", "file", "reason"])
        writer.writeheader()
        for row in manifest_rows:
            writer.writerow(row)

    print(f"Graded {len(report_rows)} submission(s).")
    print(f"  Auto-grade report: {report_path}")
    print(f"  Needs-review manifest ({len(manifest_rows)} file(s)): {manifest_path}")
    print("  Needs-review files were NOT graded — bring them (and this manifest) to")
    print("  Claude Code, using feedback-and-grading-spec.md as the grading-voice/rubric")
    print("  reference. Nothing generated by AI reaches a student without your approval")
    print("  (see 01-privacy-and-governance/data-boundaries.md's Release Gate).")


if __name__ == "__main__":
    main()
