"""
Tests for check_question_bank.py: each question's expected answer is what
Python actually does, and its wording is true. stdlib unittest only.

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
import check_question_bank as cqb  # noqa: E402

REPO_ROOT = Path(__file__).resolve().parents[3]
REAL_BANK = REPO_ROOT / "courses" / "python" / "question-checks" / "unit_01.json"


def script(*tasks):
    body = "\n".join("    '" + t.replace("'", "\\'") + "'," for t in tasks)
    return f"<?php\n$tasks = [\n{body}\n];\n"


class Fixture(unittest.TestCase):
    def setUp(self):
        self.tmp = tempfile.TemporaryDirectory()
        self.addCleanup(self.tmp.cleanup)
        self.root = Path(self.tmp.name)

    def write(self, name, text):
        (self.root / name).write_text(text, encoding="utf-8")

    def setup_fix(self, task, key="## Item 1\n\n`print(\"Continue\")`\n", **item):
        self.write("s.php", script(task))
        self.write("k.md", key)
        base = {"id": "x", "kind": "fix_line", "source": {"script": "s.php", "index": 1}, "key": "k.md",
                "broken": "Print(Continue", "fixed": 'print("Continue")', "expected_output": "Continue\n",
                "mistakes": ["wrong capitalization", "missing quotation marks", "missing closing parenthesis"],
                "broken_error": "SyntaxError"}
        base.update(item)
        return cqb.check_item(base, self.root)


class TestFixLine(Fixture):
    GOOD = "<p>This line has three mistakes at once. Fix all three. It should display: Continue</p><pre>Print(Continue</pre>"

    def test_a_true_task_passes(self):
        self.assertEqual(self.setup_fix(self.GOOD), [])

    def test_the_real_01_6_bug_is_caught(self):
        """The live task said "two mistakes" for a line with three."""
        problems = self.setup_fix(self.GOOD.replace("three", "two"))
        self.assertEqual(problems, ["the task says 'has two mistakes', but 3 are listed: wrong capitalization, missing quotation marks, missing closing parenthesis"])

    def test_several_mistakes_need_a_stated_count(self):
        problems = self.setup_fix("<p>Fix this line. It should display: Continue</p><pre>Print(Continue</pre>")
        self.assertIn("3 mistakes are listed, but the task doesn't say how many there are", problems)

    def test_broken_line_that_runs_is_caught(self):
        task = '<p>This line has one mistake. It should display: Continue</p><pre>print("Continue")</pre>'
        problems = self.setup_fix(task, broken='print("Continue")', mistakes=["none really"])
        self.assertIn("the broken line actually runs without an error", problems)

    def test_wrong_error_name_is_caught(self):
        task = "<p>This line has one mistake. It should display: Paused</p><pre>print(Paused)</pre>"
        problems = self.setup_fix(task, key='## Item 1\n`print("Paused")`', broken="print(Paused)", fixed='print("Paused")',
                                  expected_output="Paused\n", mistakes=["missing quotes"], broken_error="SyntaxError")
        self.assertEqual(problems, ["the broken line raises \"NameError: name 'Paused' is not defined\", not SyntaxError"])

    def test_fix_that_fails_or_prints_wrong(self):
        self.assertIn("the fix doesn't run: SyntaxError: '(' was never closed", self.setup_fix(self.GOOD, fixed='print("Continue"'))
        self.assertIn("the fix prints 'continue\\n', not 'Continue\\n'", self.setup_fix(self.GOOD, fixed='print("continue")'))

    def test_display_with_and_without_s_both_checked(self):
        """The live wording is "It should display: Continue" (no s): it must be checked too."""
        self.assertIn("the task says it displays 'Keep going', but the expected output is 'Continue\\n'",
                      self.setup_fix(self.GOOD.replace("display: Continue", "display: Keep going")))
        self.assertEqual(self.setup_fix(self.GOOD.replace("It should display: Continue", 'Make it display "Continue".')), [])

    def test_displays_claim_must_match(self):
        task = self.GOOD.replace("display: Continue", 'display "Keep going"')
        self.assertIn("the task says it displays 'Keep going', but the expected output is 'Continue\\n'", self.setup_fix(task))

    def test_drift_between_bank_and_live_task(self):
        task = self.GOOD.replace("<pre>Print(Continue</pre>", "<pre>Print(Continu</pre>")
        self.assertIn("the task's <pre> block doesn't match this item's code: the bank and the live task have drifted apart", self.setup_fix(task))

    def test_key_must_state_the_fix(self):
        self.assertEqual(self.setup_fix(self.GOOD, key="## Item 1\n\nAnything else.\n"), ["the key's Item 1 doesn't state: 'print(\"Continue\")'"])
        self.assertEqual(self.setup_fix(self.GOOD, key="## Item 2\n\n`print(\"Continue\")`\n"), ["the key has no '## Item 1' section"])

    def test_missing_task_index(self):
        problems = self.setup_fix(self.GOOD, source={"script": "s.php", "index": 2})
        self.assertEqual(problems, ["no task 2 in s.php (it has 1)"])


class TestPredict(Fixture):
    def check(self, code, expected, task_code=None, key=None):
        self.write("s.php", script(f"<p>Predict exactly what this displays:</p><pre>{task_code or code}</pre>"))
        self.write("k.md", key if key is not None else "## Item 1\n" + expected)
        return cqb.check_item({"id": "p", "kind": "predict_output", "source": {"script": "s.php", "index": 1},
                               "key": "k.md", "code": code, "expected_output": expected}, self.root)

    def test_correct_prediction_passes(self):
        self.assertEqual(self.check('print("A")\n# print("B")', "A\n"), [])

    def test_wrong_expected_output_is_caught(self):
        """The classic authoring slip: forgetting a commented-out line doesn't run."""
        problems = self.check('print("A")\n# print("B")', "A\nB\n")
        self.assertEqual(problems, ["expected output 'A\\nB\\n', but Python prints 'A\\n'"])

    def test_code_that_errors_is_caught(self):
        self.assertIn("the code doesn't run: SyntaxError: unterminated string literal (detected at line 1)", self.check('print("A)', "A\n"))

    def test_key_must_state_every_line(self):
        self.assertEqual(self.check('print("A")\nprint("B")', "A\nB\n", key="## Item 1\nA only\n"), ["the key's Item 1 doesn't state: 'B'"])


class TestWording(unittest.TestCase):
    def test_clean_task(self):
        self.assertEqual(cqb.wording_problems("<p>Write a <code>print()</code> statement.</p>"), [])

    def test_unbalanced_tags_doubled_spaces_and_endings(self):
        self.assertIn("<pre> opened 1 times, closed 0", cqb.wording_problems("<p>Fix it.</p><pre>x"))
        self.assertIn("doubled space in the task text", cqb.wording_problems("<p>Fix  it.</p>"))
        self.assertIn("task text doesn't end in punctuation", cqb.wording_problems("<p>Fix it</p>"))
        self.assertEqual(cqb.wording_problems("<p>Predict:</p><pre>print(1)</pre>"), [])

    def test_code_spacing_is_not_a_wording_problem(self):
        self.assertEqual(cqb.wording_problems("<p>Fix it:</p><pre>print(  1)</pre>"), [])


class TestBank(Fixture):
    def test_uncovered_checkable_claims_are_flagged(self):
        self.write("s.php", script("<p>Predict exactly what this displays:</p><pre>print(1)</pre>",
                                   "<p>Explain what a string is.</p>",
                                   "<p>This line has two mistakes at once. Fix both.</p><pre>Print(x</pre>"))
        errors = cqb.check_bank({"items": [], "scripts": ["s.php"]}, self.root)
        self.assertEqual(errors, [
            "s.php task 1: makes a checkable claim (a prediction, a fix, or a count of mistakes) but has no item in the bank",
            "s.php task 3: makes a checkable claim (a prediction, a fix, or a count of mistakes) but has no item in the bank"])

    def test_a_script_with_no_task_list(self):
        self.write("s.php", "<?php\n// nothing here\n")
        self.assertEqual(cqb.load_tasks(self.root / "s.php"), [])

    def test_the_real_unit_01_bank_holds(self):
        bank = json.loads(REAL_BANK.read_text(encoding="utf-8"))
        self.assertEqual(cqb.check_bank(bank), [])
        self.assertGreaterEqual(len(bank["items"]), 13)


class TestCli(unittest.TestCase):
    def test_usage_and_real_run(self):
        with redirect_stdout(io.StringIO()):
            self.assertEqual(cqb.main([]), 2)
        with redirect_stdout(io.StringIO()) as out:
            self.assertEqual(cqb.main([str(REAL_BANK)]), 0)
        self.assertIn("items verified by running them", out.getvalue())

    def test_problems_exit_1(self):
        with tempfile.TemporaryDirectory() as tmp:
            Path(tmp, "s.php").write_text(script("<p>Predict exactly:</p><pre>print(1)</pre>"), encoding="utf-8")
            bank = Path(tmp, "b.json")
            bank.write_text(json.dumps({"items": [], "scripts": [str(Path(tmp, "s.php"))]}), encoding="utf-8")
            with redirect_stdout(io.StringIO()) as out:
                self.assertEqual(cqb.main([str(bank)]), 1)
        self.assertIn("1 problem(s)", out.getvalue())


if __name__ == "__main__":
    unittest.main()
