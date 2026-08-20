"""
Tests for auto_grade.py. stdlib unittest only — runs on the school machine
with nothing beyond a stock Python install, same constraint as the script
itself.

Run from anywhere with:
    python -m unittest discover -s 05-grader/school-side/tests -v

Two kinds of coverage on purpose:
- Unit tests build small synthetic HTML fixtures in a temp dir so each
  extraction rule (telemetry JSON, reflection textarea, hidden timestamps,
  needs-review classification) is checked in isolation, including edge
  cases (missing file, malformed JSON, missing telemetry block) real
  submissions will eventually hit.
- One end-to-end test runs the actual script against the real fixture in
  ../../sample-submissions/PY1-A-DELTA04_lesson_01_04_printing_output/ and
  asserts the exact values documented in that fixture's persona (see its
  README.md) — 2 vocab-quiz check attempts, first attempt NOT all correct,
  8 practice drills with 4 correct on the first try, a 14.6-minute mastery
  check window. If the real lesson content changes, this test — not just
  the fixture's own README — should catch drift.
"""

import json
import sys
import tempfile
import unittest
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))
import auto_grade  # noqa: E402


REPO_ROOT = Path(__file__).resolve().parents[3]
REAL_FIXTURE = REPO_ROOT / "05-grader" / "sample-submissions" / "PY1-A-DELTA04_lesson_01_04_printing_output"


def write(folder: Path, name: str, content: str) -> Path:
    path = folder / name
    path.write_text(content, encoding="utf-8")
    return path


class TestParseSubmissionDirname(unittest.TestCase):
    def test_normal_case(self):
        codename, lesson = auto_grade.parse_submission_dirname(
            "PY1-A-DELTA04_lesson_01_04_printing_output"
        )
        self.assertEqual(codename, "PY1-A-DELTA04")
        self.assertEqual(lesson, "lesson_01_04_printing_output")

    def test_no_underscore_does_not_crash(self):
        codename, lesson = auto_grade.parse_submission_dirname("nolessonhere")
        self.assertEqual(codename, "nolessonhere")
        self.assertEqual(lesson, "")


class TestScoreTelemetryFile(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.folder = Path(self.tmp.name)

    def tearDown(self):
        self.tmp.cleanup()

    def _telemetry_html(self, events):
        block = json.dumps({"events": events})
        return (
            '<html><head><script type="application/json" id="foxcs-telemetry">'
            f"{block}</script></head><body></body></html>"
        )

    def test_first_and_last_attempt_correctness(self):
        events = [
            {"type": "quiz_check", "attempted": [{"correct": True}, {"correct": False}]},
            {"type": "quiz_check", "attempted": [{"correct": True}, {"correct": True}]},
        ]
        path = write(self.folder, "x.html", self._telemetry_html(events))
        saved, attempts, first_ok, last_ok = auto_grade.score_telemetry_file(path, "quiz_check")
        self.assertTrue(saved)
        self.assertEqual(attempts, 2)
        self.assertFalse(first_ok)
        self.assertTrue(last_ok)

    def test_missing_telemetry_block(self):
        path = write(self.folder, "x.html", "<html><body>no telemetry here</body></html>")
        saved, attempts, first_ok, last_ok = auto_grade.score_telemetry_file(path, "quiz_check")
        self.assertTrue(saved)
        self.assertEqual(attempts, 0)
        self.assertIsNone(first_ok)
        self.assertIsNone(last_ok)

    def test_malformed_json_does_not_crash(self):
        html = '<script type="application/json" id="foxcs-telemetry">{not valid json</script>'
        path = write(self.folder, "x.html", html)
        saved, attempts, first_ok, last_ok = auto_grade.score_telemetry_file(path, "quiz_check")
        self.assertTrue(saved)
        self.assertEqual(attempts, 0)

    def test_no_matching_event_type(self):
        events = [{"type": "drill_attempt", "attempted": [{"correct": True}]}]
        path = write(self.folder, "x.html", self._telemetry_html(events))
        saved, attempts, first_ok, last_ok = auto_grade.score_telemetry_file(path, "quiz_check")
        self.assertEqual(attempts, 0)
        self.assertIsNone(first_ok)


class TestGradeVocabQuiz(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.folder = Path(self.tmp.name)

    def tearDown(self):
        self.tmp.cleanup()

    def test_not_saved(self):
        row = {}
        auto_grade.grade_vocab_quiz(self.folder, row)
        self.assertEqual(row["vocab_quiz_saved"], "N")

    def test_saved_with_reflection(self):
        events = [{"type": "quiz_check", "attempted": [{"correct": True}] * 5}]
        html = (
            '<html><head><script type="application/json" id="foxcs-telemetry">'
            f'{json.dumps({"events": events})}</script></head><body>'
            '<textarea id="memoryTrick">I used a rhyme to remember it</textarea>'
            "</body></html>"
        )
        write(self.folder, "04_vocab_quiz_completed.html", html)
        row = {}
        auto_grade.grade_vocab_quiz(self.folder, row)
        self.assertEqual(row["vocab_quiz_saved"], "Y")
        self.assertEqual(row["vocab_quiz_check_attempts"], 1)
        self.assertEqual(row["vocab_quiz_first_attempt_all_correct"], "Y")
        self.assertEqual(row["vocab_quiz_reflection_word_count"], 7)
        self.assertIn("rhyme", row["vocab_quiz_reflection_text"])

    def test_empty_reflection_counts_zero_words(self):
        html = (
            '<html><body><textarea id="memoryTrick">   </textarea></body></html>'
        )
        write(self.folder, "04_vocab_quiz_completed.html", html)
        row = {}
        auto_grade.grade_vocab_quiz(self.folder, row)
        self.assertEqual(row["vocab_quiz_reflection_word_count"], 0)


class TestGradePractice(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.folder = Path(self.tmp.name)

    def tearDown(self):
        self.tmp.cleanup()

    def test_first_try_correct_count(self):
        events = [
            {"type": "drill_attempt", "drill_id": "drill1", "correct": True},
            {"type": "drill_attempt", "drill_id": "drill2", "correct": False},
            {"type": "drill_attempt", "drill_id": "drill2", "correct": True},
            {"type": "drill_attempt", "drill_id": "drill3", "correct": True},
        ]
        html = (
            '<html><head><script type="application/json" id="foxcs-telemetry">'
            f'{json.dumps({"events": events})}</script></head><body></body></html>'
        )
        write(self.folder, "05_practice_completed.html", html)
        row = {}
        auto_grade.grade_practice(self.folder, row)
        self.assertEqual(row["practice_saved"], "Y")
        self.assertEqual(row["practice_drills_attempted"], 3)
        # drill1 and drill3 correct on their first recorded attempt; drill2 was not.
        self.assertEqual(row["practice_first_try_correct_count"], 2)

    def test_not_saved(self):
        row = {}
        auto_grade.grade_practice(self.folder, row)
        self.assertEqual(row["practice_saved"], "N")


class TestGradeMasteryCheck(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.folder = Path(self.tmp.name)

    def tearDown(self):
        self.tmp.cleanup()

    def test_minutes_computed(self):
        html = (
            '<span id="unlockTime">unlocked_at:2026-08-11T15:10:03Z</span>'
            '<span id="completeTime">completed_at:2026-08-11T15:24:41Z</span>'
        )
        write(self.folder, "09_mastery_check_completed.html", html)
        row = {}
        auto_grade.grade_mastery_check(self.folder, row)
        self.assertEqual(row["mastery_check_saved"], "Y")
        self.assertEqual(row["mastery_check_minutes_unlocked_to_complete"], 14.6)

    def test_unlocked_but_not_completed(self):
        html = '<span id="unlockTime">unlocked_at:2026-08-11T15:10:03Z</span>'
        write(self.folder, "09_mastery_check_completed.html", html)
        row = {}
        auto_grade.grade_mastery_check(self.folder, row)
        self.assertEqual(row["mastery_check_completed_at"], "")
        self.assertNotIn("mastery_check_minutes_unlocked_to_complete", row)

    def test_not_saved(self):
        row = {}
        auto_grade.grade_mastery_check(self.folder, row)
        self.assertEqual(row["mastery_check_saved"], "N")


class TestGradeFeedback(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.folder = Path(self.tmp.name)

    def tearDown(self):
        self.tmp.cleanup()

    def test_saved_and_not_saved(self):
        row = {}
        auto_grade.grade_feedback(self.folder, row)
        self.assertEqual(row["feedback_saved"], "N")

        write(self.folder, "11_feedback_completed.html", "<html></html>")
        row2 = {}
        auto_grade.grade_feedback(self.folder, row2)
        self.assertEqual(row2["feedback_saved"], "Y")


class TestCollectNeedsReview(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.folder = Path(self.tmp.name)

    def tearDown(self):
        self.tmp.cleanup()

    def test_flags_only_judgment_required_files(self):
        for name in [
            "00_table_of_contents.html",
            "01_instruction.html",
            "02_example_01.py",
            "04_vocab_quiz_completed.html",
            "06_application.py",
            "07_project.html",
            "08_project.py",
            "10_mastery_check.py",
        ]:
            write(self.folder, name, "x")
        rows = []
        auto_grade.collect_needs_review(self.folder, "PY1-A-DELTA04", "lesson_01_04_printing_output", rows)
        flagged = {r["file"] for r in rows}
        self.assertIn("06_application.py", flagged)
        self.assertIn("07_project.html", flagged)
        self.assertIn("08_project.py", flagged)
        self.assertIn("10_mastery_check.py", flagged)
        self.assertIn("02_example_01.py", flagged)
        # Read-only/completed files with no judgment-required pattern should
        # not appear — the manifest should only list what genuinely needs review.
        self.assertNotIn("00_table_of_contents.html", flagged)
        self.assertNotIn("01_instruction.html", flagged)
        self.assertNotIn("04_vocab_quiz_completed.html", flagged)


@unittest.skipUnless(REAL_FIXTURE.is_dir(), "real sample-submissions fixture not found")
class TestRealFixtureEndToEnd(unittest.TestCase):
    """Grounds every rule above against the actual checked-in fixture, not
    just synthetic examples. Expected values come from this session's own
    manual run of the script against sample-submissions/README.md's
    documented persona — see that file for why each of these is correct,
    not just what it is."""

    @classmethod
    def setUpClass(cls):
        row = {"codename": "PY1-A-DELTA04", "lesson": "lesson_01_04_printing_output"}
        auto_grade.grade_vocab_quiz(REAL_FIXTURE, row)
        auto_grade.grade_practice(REAL_FIXTURE, row)
        auto_grade.grade_mastery_check(REAL_FIXTURE, row)
        auto_grade.grade_feedback(REAL_FIXTURE, row)
        cls.row = row
        cls.manifest = []
        auto_grade.collect_needs_review(REAL_FIXTURE, "PY1-A-DELTA04", "lesson_01_04_printing_output", cls.manifest)

    def test_vocab_quiz(self):
        self.assertEqual(self.row["vocab_quiz_saved"], "Y")
        self.assertEqual(self.row["vocab_quiz_check_attempts"], 2)
        self.assertEqual(self.row["vocab_quiz_first_attempt_all_correct"], "N")
        self.assertEqual(self.row["vocab_quiz_all_correct_by_save"], "Y")
        self.assertGreater(self.row["vocab_quiz_reflection_word_count"], 0)

    def test_practice(self):
        self.assertEqual(self.row["practice_saved"], "Y")
        self.assertEqual(self.row["practice_drills_attempted"], 8)
        self.assertEqual(self.row["practice_first_try_correct_count"], 4)

    def test_mastery_check(self):
        self.assertEqual(self.row["mastery_check_saved"], "Y")
        self.assertEqual(self.row["mastery_check_minutes_unlocked_to_complete"], 14.6)

    def test_feedback(self):
        self.assertEqual(self.row["feedback_saved"], "Y")

    def test_needs_review_manifest_has_five_files(self):
        flagged = {r["file"] for r in self.manifest}
        self.assertEqual(
            flagged,
            {
                "02_example_01.py",
                "06_application.py",
                "07_project.html",
                "08_project.py",
                "10_mastery_check.py",
            },
        )


if __name__ == "__main__":
    unittest.main()
