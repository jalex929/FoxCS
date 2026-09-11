"""
Tests for check_eliminable_distractors.py. stdlib unittest only, matching
the convention in 05-grader/school-side/tests/test_auto_grade.py.

This checker is an explicit heuristic worklist, not a pass/fail gate (see
its own header), so these tests assert on `check_question`/`scan_file`
findings directly rather than a process exit code.

Run from anywhere with:
    python -m unittest discover -s 02-authoring-system/tools/tests -v
"""

import sys
import tempfile
import unittest
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))
import check_eliminable_distractors as ced  # noqa: E402


def write_html(folder: Path, content: str) -> Path:
    path = folder / "page.html"
    path.write_text(content, encoding="utf-8")
    return path


def select_block(select_id, options_html, prompt="What does this code do?"):
    return f"""
    <div class="drill-prompt">{prompt}</div>
    <select class="drill-select" id="{select_id}">
        <option value="">Choose...</option>
        {options_html}
    </select>
    """


class TestSignalWords(unittest.TestCase):
    def test_absolute_word_is_flagged(self):
        findings = ced.check_question(
            "prompt",
            [
                ("a", "It always prints twice"),
                ("b", "It prints once"),
                ("c", "It raises an error"),
            ],
        )
        self.assertTrue(any("always" in f for f in findings))

    def test_both_and_none_of_the_above_are_flagged(self):
        findings = ced.check_question(
            "prompt",
            [
                ("a", "Missing the quote"),
                ("b", "Missing the parenthesis"),
                ("c", "None of the above"),
            ],
        )
        joined = " ".join(findings)
        self.assertIn("none of the above", joined.lower())

    def test_clean_options_produce_no_signal_word_finding(self):
        findings = ced.check_question(
            "prompt",
            [
                ("a", "Missing the closing quote"),
                ("b", "Missing the closing parenthesis"),
                ("c", "The variable is undefined"),
            ],
        )
        self.assertEqual(findings, [])


class TestLengthOutlier(unittest.TestCase):
    def test_large_length_disparity_is_flagged(self):
        findings = ced.check_question(
            "prompt",
            [
                ("a", "Error"),
                ("b", "It prints the value stored in the variable to the console output"),
                ("c", "Nothing happens"),
            ],
        )
        self.assertTrue(any("length" in f for f in findings))

    def test_similar_lengths_are_not_flagged(self):
        findings = ced.check_question(
            "prompt",
            [
                ("a", "Prints the number"),
                ("b", "Raises an error"),
                ("c", "Returns the string"),
            ],
        )
        self.assertFalse(any("length" in f for f in findings))


class TestCompositeOptionPattern(unittest.TestCase):
    def test_option_combining_two_others_keywords_is_flagged(self):
        findings = ced.check_question(
            "prompt",
            [
                ("a", "Missing the closing quote"),
                ("b", "Missing the closing parenthesis"),
                ("c", "Missing both the quote and the parenthesis"),
            ],
        )
        self.assertTrue(any("combine the distinguishing wording" in f for f in findings))

    def test_unrelated_options_are_not_flagged_as_composite(self):
        findings = ced.check_question(
            "prompt",
            [
                ("a", "Raises a syntax error"),
                ("b", "Prints the number twice"),
                ("c", "Returns an empty string"),
            ],
        )
        self.assertFalse(any("combine the distinguishing wording" in f for f in findings))


class TestFewerThanTwoOptions(unittest.TestCase):
    def test_single_real_option_produces_no_findings(self):
        findings = ced.check_question("prompt", [("a", "Only choice")])
        self.assertEqual(findings, [])

    def test_placeholder_only_options_produce_no_findings(self):
        findings = ced.check_question("prompt", [("", "Choose..."), ("a", "Only real choice")])
        self.assertEqual(findings, [])


class TestScanFile(unittest.TestCase):
    def test_finds_question_with_findings_and_reports_prompt(self):
        html = "<html><body>" + select_block(
            "q1",
            '<option value="a">It always fails</option>'
            '<option value="b">It succeeds</option>',
            prompt="What happens when you run this?",
        ) + "</body></html>"
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            results = ced.scan_file(str(path))
            self.assertEqual(len(results), 1)
            select_id, prompt, findings = results[0]
            self.assertEqual(select_id, "q1")
            self.assertEqual(prompt, "What happens when you run this?")
            self.assertTrue(findings)

    def test_clean_question_is_not_in_results(self):
        html = "<html><body>" + select_block(
            "q2",
            '<option value="a">Raises a syntax error</option>'
            '<option value="b">Prints the number twice</option>'
            '<option value="c">Returns an empty string</option>',
        ) + "</body></html>"
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(ced.scan_file(str(path)), [])

    def test_no_drill_select_at_all_returns_empty(self):
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), "<html><body><p>no questions</p></body></html>")
            self.assertEqual(ced.scan_file(str(path)), [])


if __name__ == "__main__":
    unittest.main()
