"""
Tests for check_rubric_coverage.py: every live submittable item has a usable
rubric. stdlib unittest only.

    python -m unittest discover -s 02-authoring-system/tools/tests -v
"""

import io
import json
import sys
import tempfile
import unittest
from contextlib import redirect_stdout
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))
import check_rubric_coverage as crc  # noqa: E402

REPO_ROOT = Path(__file__).resolve().parents[3]
GOOD = "# Rubric\n\n- [ ] Runs without errors\n- [ ] Prints the right total\n"


def item(id, live=True, rubric="r.md", **kw):
    return {"id": id, "name": id.title(), "type": "coding_exercise", "live": live, "rubric": rubric, **kw}


class TestCriteriaCount(unittest.TestCase):
    def test_each_criterion_format_counts(self):
        self.assertEqual(crc.criteria_count("- [ ] a\n* [x] b\n- [X] c"), 3)
        self.assertEqual(crc.criteria_count("1. a\n2) b\n**3. c**"), 3)
        self.assertEqual(crc.criteria_count("## Item 1 (shortanswer)\n## Item 2\n### Criterion 3\n#### Question 4"), 4)

    def test_table_rows_count_but_header_and_rule_do_not(self):
        table = "| Criterion | Points |\n|---|---|\n| Runs | 5 |\n| Correct | 5 |\n"
        self.assertEqual(crc.criteria_count(table), 2)
        self.assertEqual(crc.criteria_count("| :--- | ---: |"), 0)

    def test_prose_and_plain_bullets_do_not_count(self):
        self.assertEqual(crc.criteria_count("Grade it fairly.\n- a plain bullet\n## Item notes"), 0)


class TestCheckRubric(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.addCleanup(self.tmp.cleanup)
        self.dir = Path(self.tmp.name)

    def write(self, text):
        path = self.dir / "r.md"
        path.write_text(text, encoding="utf-8")
        return path

    def test_good_rubric_passes(self):
        self.assertEqual(crc.check_rubric(self.write(GOOD)), [])

    def test_missing_empty_thin_and_placeholder(self):
        self.assertEqual(crc.check_rubric(self.dir / "nope.md"), ["rubric file is missing"])
        self.assertEqual(crc.check_rubric(self.write("  \n")), ["rubric file is empty"])
        self.assertEqual(crc.check_rubric(self.write("# R\n\n- [ ] only one")),
                         ["rubric has 1 criteria, needs at least 2 (checklist items, table rows, numbered criteria, or Item headings)"])
        self.assertEqual(crc.check_rubric(self.write(GOOD + "\nPoints: TBD, TODO\n")), ["rubric still has a placeholder: TBD, TODO"])

    def test_placeholder_needs_a_whole_word(self):
        self.assertEqual(crc.check_rubric(self.write(GOOD + "Mastodon todos\n")), [])


class TestManifest(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.addCleanup(self.tmp.cleanup)
        self.root = Path(self.tmp.name)
        (self.root / "r.md").write_text(GOOD, encoding="utf-8")

    def check(self, *items):
        return crc.check_manifest({"items": list(items)}, self.root)

    def test_all_good(self):
        self.assertEqual(self.check(item("a"), item("b", live=False)), ([], []))

    def test_live_problems_are_errors_and_others_are_warnings(self):
        errors, warnings = self.check(item("live-one", rubric="gone.md"), item("later", live=False, rubric="gone.md"))
        self.assertEqual(errors, ["live-one (Live-One): rubric file is missing (gone.md)"])
        self.assertEqual(warnings, ["later (Later): rubric file is missing (gone.md)"])

    def test_no_rubric_listed(self):
        errors, warnings = self.check(item("x", rubric=None), item("y", live=False, rubric=""))
        self.assertEqual(errors, ["x (X): no rubric listed"])
        self.assertEqual(warnings, ["y (Y): no rubric listed"])

    def test_exempt_needs_a_reason(self):
        ok = {"id": "f", "name": "F", "type": "self_assessment", "live": True, "exempt": "Ratings only, not graded."}
        bad = {"id": "g", "name": "G", "type": "self_assessment", "live": True, "exempt": "  "}
        self.assertEqual(self.check(ok, bad), (["g (G): exempt with no reason"], []))

    def test_duplicate_ids(self):
        self.assertEqual(self.check(item("a"), item("a"))[0], ["a (A): duplicate id"])


class TestCli(unittest.TestCase):
    def run_main(self, manifest):
        with tempfile.TemporaryDirectory() as tmp:
            path = Path(tmp) / "m.json"
            path.write_text(json.dumps(manifest), encoding="utf-8")
            with redirect_stdout(io.StringIO()) as out:
                code = crc.main([str(path)])
        return code, out.getvalue()

    def test_usage(self):
        with redirect_stdout(io.StringIO()) as out:
            self.assertEqual(crc.main([]), 2)
        self.assertIn("check_rubric_coverage.py", out.getvalue())

    def test_exit_1_names_every_gap(self):
        code, out = self.run_main({"items": [item("a", rubric="nowhere/r.md"), item("b", live=False, rubric="nowhere/r.md")]})
        self.assertEqual(code, 1)
        self.assertIn("MISSING RUBRIC: a (A)", out)
        self.assertIn("WARNING (not live yet): b (B)", out)
        self.assertIn("1 live item(s) without a usable rubric, out of 2.", out)

    def test_the_real_python_course_is_covered(self):
        """The live gate: every live Python item has a rubric right now."""
        manifest = json.loads((REPO_ROOT / "courses" / "python" / "submittables.json").read_text(encoding="utf-8"))
        errors, _ = crc.check_manifest(manifest)
        self.assertEqual(errors, [])
        self.assertTrue(all("exempt" in i or i.get("rubric") for i in manifest["items"]))


if __name__ == "__main__":
    unittest.main()
