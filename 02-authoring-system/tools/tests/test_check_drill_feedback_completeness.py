"""
Tests for check_drill_feedback_completeness.py. stdlib unittest only,
matching the convention in 05-grader/school-side/tests/test_auto_grade.py.

Covers the three real feedback shapes already in use in this repo's own
content (05_practice.html): an inline ternary (checkDrill1), an if/else-if
chain (checkDrill2), and delegation to a shared helper with the real
message literals supplied at the call site (checkDrill3/checkTyped) -- plus
the "not enough distinct messages" case this checker exists to catch.

Run from anywhere with:
    python -m unittest discover -s 02-authoring-system/tools/tests -v
"""

import sys
import tempfile
import unittest
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))
import check_drill_feedback_completeness as cdf  # noqa: E402


def write_html(folder: Path, content: str) -> Path:
    path = folder / "page.html"
    path.write_text(content, encoding="utf-8")
    return path


class TestNoFeedbackTargets(unittest.TestCase):
    def test_page_with_no_feedback_div_is_clean(self):
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), "<html><body><p>nothing here</p></body></html>")
            self.assertEqual(cdf.check_file(str(path)), [])


class TestInlineTernaryShape(unittest.TestCase):
    def test_ternary_with_two_real_messages_passes(self):
        html = """
        <html><body>
        <div class="feedback" id="d1-feedback"></div>
        <script>
        function checkDrill1() {
            const fb = document.getElementById('d1-feedback');
            const correct = true;
            fb.textContent = correct
                ? 'Right! print("Ready to play!") displays exactly that text.'
                : 'Not quite. Check the order of the pieces you placed.';
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(cdf.check_file(str(path)), [])

    def test_bare_correct_incorrect_toggle_with_no_real_messages_is_flagged(self):
        html = """
        <html><body>
        <div class="feedback" id="d9-feedback"></div>
        <script>
        function checkDrill9() {
            const fb = document.getElementById('d9-feedback');
            const correct = true;
            fb.className = 'feedback ' + (correct ? 'correct' : 'incorrect');
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            findings = cdf.check_file(str(path))
            self.assertEqual(len(findings), 1)
            self.assertIn("d9-feedback", findings[0])


class TestIfElseChainShape(unittest.TestCase):
    def test_if_else_chain_with_distinct_messages_passes(self):
        html = """
        <html><body>
        <div class="feedback" id="d2-feedback"></div>
        <script>
        function checkDrill2() {
            const val = document.getElementById('d2-select').value;
            const fb = document.getElementById('d2-feedback');
            if (val === 'a') {
                fb.textContent = 'Right! Matching double quotes around the full text.';
            } else if (val === 'b') {
                fb.textContent = 'Close. That quote never gets closed, raising a SyntaxError.';
            }
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(cdf.check_file(str(path)), [])


class TestHelperDelegationShape(unittest.TestCase):
    def test_shared_helper_with_literals_at_call_site_passes(self):
        # The exact real shape: checkTyped's own body uses variables, but the
        # calling function (which also mentions the feedback id) supplies
        # the real literal messages as call arguments.
        html = """
        <html><body>
        <div class="feedback" id="d3-feedback"></div>
        <script>
        function checkTyped(inputId, feedbackId, acceptable, correctMsg, incorrectMsg) {
            const fb = document.getElementById(feedbackId);
            fb.textContent = acceptable ? correctMsg : incorrectMsg;
        }
        function checkDrill3() {
            checkTyped('d3-input', 'd3-feedback', ['argument'],
                'Right! "Hello" is the argument passed into print().',
                'Not quite. Think about what you hand a function to work with.');
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(cdf.check_file(str(path)), [])


class TestMultipleFeedbackTargetsInOneFile(unittest.TestCase):
    def test_only_the_incomplete_one_is_flagged(self):
        html = """
        <html><body>
        <div class="feedback" id="d1-feedback"></div>
        <div class="feedback" id="d2-feedback"></div>
        <script>
        function checkDrill1() {
            const fb = document.getElementById('d1-feedback');
            fb.textContent = true
                ? 'Right! This is a solid, specific correct-answer message.'
                : 'Not quite. This is a solid, specific incorrect-answer message.';
        }
        function checkDrill2() {
            document.getElementById('d2-feedback').className = 'feedback correct';
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            findings = cdf.check_file(str(path))
            self.assertEqual(len(findings), 1)
            self.assertIn("d2-feedback", findings[0])


class TestFindFeedbackIds(unittest.TestCase):
    def test_finds_every_feedback_div_id(self):
        html = """
        <div class="feedback" id="a-feedback"></div>
        <div class="feedback" id="b-feedback"></div>
        <div class="something-else" id="c-feedback"></div>
        """
        self.assertEqual(cdf.find_feedback_ids(html), ["a-feedback", "b-feedback"])


if __name__ == "__main__":
    unittest.main()
