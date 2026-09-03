"""
Tests for check_mastery_check_completeness.py. stdlib unittest only,
matching the convention in 05-grader/school-side/tests/test_auto_grade.py.

Builds a synthetic course_root/content + teacher-materials tree per test
so each rule (answer key existence, no leaked KEY files in student
content, item-count range, misconception-code pairing) is exercised in
isolation, plus one end-to-end pass against the real Unit 01 content this
repo already has.

Run from anywhere with:
    python -m unittest discover -s 02-authoring-system/tools/tests -v
"""

import sys
import tempfile
import unittest
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))
import check_mastery_check_completeness as cmc  # noqa: E402

REPO_ROOT = Path(__file__).resolve().parents[3]
REAL_COURSE_ROOT = REPO_ROOT / "courses" / "python"

GOOD_KEY_TEXT = """# 01.1 Mastery Check: Teacher Key

**Never include this file in the folder distributed to students.**

**1. (DOK 1-2. Direct prediction)** Exactly: `Hello!`

**2. (DOK 2. Debug)** Correct: `print("Hi")`.

**3. (DOK 3. Apply)** Any syntactically correct print() with a clear message.

**Common misconceptions to watch for:** `CODE-01`. Treating a working program as automatically a good one, without checking the actual output quality. `CODE-02`. Fixing a syntax error by trial and error without being able to name the mistake.
"""


def make_lesson(root: Path, unit: str, lesson: str, files: dict):
    lesson_dir = root / "content" / unit / lesson
    lesson_dir.mkdir(parents=True, exist_ok=True)
    for name, content in files.items():
        (lesson_dir / name).write_text(content, encoding="utf-8")
    return lesson_dir


def make_key(root: Path, unit: str, key_filename: str, text: str):
    key_dir = root / "teacher-materials" / unit
    key_dir.mkdir(parents=True, exist_ok=True)
    (key_dir / key_filename).write_text(text, encoding="utf-8")


class TestKeyFilenamePrefix(unittest.TestCase):
    def test_extracts_lesson_number_prefix(self):
        self.assertEqual(
            cmc.key_filename_prefix("lesson_01_04_printing_output"), "lesson_01_04"
        )

    def test_non_matching_name_returns_none(self):
        self.assertIsNone(cmc.key_filename_prefix("unit_01_overview"))


class TestAnswerKeyExists(unittest.TestCase):
    def test_missing_key_is_an_error(self):
        with tempfile.TemporaryDirectory() as tmp:
            root = Path(tmp)
            make_lesson(
                root, "unit_01_x", "lesson_01_01_foo",
                {"09_mastery_check.html": "<html></html>"},
            )
            result = cmc.check_lesson(
                str(root), "unit_01_x", "lesson_01_01_foo",
                str(root / "content" / "unit_01_x" / "lesson_01_01_foo"),
            )
            self.assertEqual(len(result["errors"]), 1)
            self.assertIn("no answer key found", result["errors"][0])

    def test_present_key_produces_no_error(self):
        with tempfile.TemporaryDirectory() as tmp:
            root = Path(tmp)
            make_lesson(
                root, "unit_01_x", "lesson_01_01_foo",
                {"09_mastery_check.html": "<html></html>"},
            )
            make_key(root, "unit_01_x", "lesson_01_01_mastery_check_KEY.md", GOOD_KEY_TEXT)
            result = cmc.check_lesson(
                str(root), "unit_01_x", "lesson_01_01_foo",
                str(root / "content" / "unit_01_x" / "lesson_01_01_foo"),
            )
            self.assertEqual(result["errors"], [])

    def test_lesson_with_no_mastery_check_at_all_is_skipped(self):
        with tempfile.TemporaryDirectory() as tmp:
            root = Path(tmp)
            make_lesson(
                root, "unit_01_x", "lesson_01_01_foo",
                {"01_instruction.html": "<html></html>"},
            )
            result = cmc.check_lesson(
                str(root), "unit_01_x", "lesson_01_01_foo",
                str(root / "content" / "unit_01_x" / "lesson_01_01_foo"),
            )
            self.assertEqual(result["errors"], [])
            self.assertEqual(result["warnings"], [])


class TestKeyLeakIntoStudentContent(unittest.TestCase):
    def test_key_file_inside_content_folder_is_flagged(self):
        with tempfile.TemporaryDirectory() as tmp:
            root = Path(tmp)
            make_lesson(
                root, "unit_01_x", "lesson_01_01_foo",
                {
                    "09_mastery_check.html": "<html></html>",
                    "lesson_01_01_mastery_check_KEY.md": "leaked answer key",
                },
            )
            make_key(root, "unit_01_x", "lesson_01_01_mastery_check_KEY.md", GOOD_KEY_TEXT)
            result = cmc.check_lesson(
                str(root), "unit_01_x", "lesson_01_01_foo",
                str(root / "content" / "unit_01_x" / "lesson_01_01_foo"),
            )
            self.assertTrue(any("student-facing content folder" in e for e in result["errors"]))

    def test_no_key_like_filename_is_clean(self):
        with tempfile.TemporaryDirectory() as tmp:
            root = Path(tmp)
            make_lesson(
                root, "unit_01_x", "lesson_01_01_foo",
                {"09_mastery_check.html": "<html></html>"},
            )
            make_key(root, "unit_01_x", "lesson_01_01_mastery_check_KEY.md", GOOD_KEY_TEXT)
            result = cmc.check_lesson(
                str(root), "unit_01_x", "lesson_01_01_foo",
                str(root / "content" / "unit_01_x" / "lesson_01_01_foo"),
            )
            self.assertFalse(any("student-facing content folder" in e for e in result["errors"]))


class TestItemCountRange(unittest.TestCase):
    def test_count_within_range_has_no_warning(self):
        count, warning = cmc.check_item_count(GOOD_KEY_TEXT)
        self.assertEqual(count, 3)
        self.assertIsNone(warning)

    def test_too_few_items_warns(self):
        text = "**1. (DOK 1)** Only one item here.\n"
        count, warning = cmc.check_item_count(text)
        self.assertEqual(count, 1)
        self.assertIsNotNone(warning)
        self.assertIn("outside the 3-5", warning)

    def test_too_many_items_warns(self):
        text = "\n".join(f"**{i}. (DOK 2)** Item {i}." for i in range(1, 8))
        count, warning = cmc.check_item_count(text)
        self.assertEqual(count, 7)
        self.assertIsNotNone(warning)

    def test_no_numbered_items_at_all_produces_no_warning(self):
        # Doesn't match the numbered convention -- not this check's job to flag.
        count, warning = cmc.check_item_count("Just some free-text notes, no numbered items.")
        self.assertEqual(count, 0)
        self.assertIsNone(warning)


class TestMisconceptionPairing(unittest.TestCase):
    def test_code_with_real_explanation_passes(self):
        text = "`CODE-01`. Treating a working program as automatically a good one."
        errors = cmc.check_misconception_pairing(text)
        self.assertEqual(errors, [])

    def test_bare_code_with_no_explanation_is_an_error(self):
        text = "`CODE-01`. `CODE-02`. Has a real explanation here, finally."
        errors = cmc.check_misconception_pairing(text)
        self.assertEqual(len(errors), 1)
        self.assertIn("CODE-01", errors[0])

    def test_last_code_with_no_trailing_text_is_an_error(self):
        text = "Some intro. `CODE-01`."
        errors = cmc.check_misconception_pairing(text)
        self.assertEqual(len(errors), 1)
        self.assertIn("CODE-01", errors[0])

    def test_no_codes_at_all_produces_no_errors(self):
        self.assertEqual(cmc.check_misconception_pairing("No misconception codes here."), [])


class TestRealUnit01Content(unittest.TestCase):
    """End-to-end: run against this repo's actual Unit 01 content. If real
    content ever regresses (a KEY file gets deleted/moved, a misconception
    code loses its explanation), this test should catch it, not just a
    human skim."""

    def setUp(self):
        if not REAL_COURSE_ROOT.is_dir():
            self.skipTest(f"real course root not found at {REAL_COURSE_ROOT}")

    def test_all_real_unit_01_lessons_pass_clean(self):
        content_root = REAL_COURSE_ROOT / "content"
        lessons = cmc.find_lesson_dirs(str(content_root))
        self.assertGreaterEqual(len(lessons), 6, "expected at least Unit 01's 6 lessons")
        for unit_dir, lesson_dir_name, lesson_path in lessons:
            result = cmc.check_lesson(str(REAL_COURSE_ROOT), unit_dir, lesson_dir_name, lesson_path)
            self.assertEqual(
                result["errors"], [],
                f"{unit_dir}/{lesson_dir_name} has unexpected error(s): {result['errors']}",
            )


if __name__ == "__main__":
    unittest.main()
