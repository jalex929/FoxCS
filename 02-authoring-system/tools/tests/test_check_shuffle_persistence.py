"""
Tests for check_shuffle_persistence.py. stdlib unittest only, matching the
convention in 05-grader/school-side/tests/test_auto_grade.py.

Covers the two real bug shapes named in authoring-flow-gaps-2026-08-11.md:
Drill 7 (no shuffle at all -- solvable top to bottom) and Drills 1/5 (a
shuffle exists somewhere, but a separate render path iterates the raw
piece list directly, re-sorting back to unshuffled order on every
placement).

Run from anywhere with:
    python -m unittest discover -s 02-authoring-system/tools/tests -v
"""

import sys
import tempfile
import unittest
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))
import check_shuffle_persistence as csp  # noqa: E402


def write_html(folder: Path, content: str) -> Path:
    path = folder / "page.html"
    path.write_text(content, encoding="utf-8")
    return path


class TestNoBanks(unittest.TestCase):
    def test_page_with_no_block_bank_is_clean(self):
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), "<html><body><p>no drills here</p></body></html>")
            self.assertEqual(csp.check_file(str(path)), [])


class TestNoRandomization(unittest.TestCase):
    def test_bank_with_no_shuffle_is_flagged(self):
        # The exact original Drill 7 bug: rendered in definition order, no
        # randomization anywhere in the code that touches this bank.
        html = """
        <html><body>
        <div id="d7-bank" class="block-bank"></div>
        <script>
        const d7Pieces = ['a', 'b', 'c'];
        function renderD7() {
            d7Pieces.forEach(p => addToBank('d7-bank', p));
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            flags = csp.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("no randomization found", flags[0])


class TestProperShuffle(unittest.TestCase):
    def test_bank_with_shuffle_call_passes(self):
        html = """
        <html><body>
        <div id="d2-bank" class="block-bank"></div>
        <script>
        const d2Pieces = ['a', 'b', 'c'];
        const d2Order = shuffle(d2Pieces.map(p => p));
        function renderD2() {
            d2Order.forEach(p => addToBank('d2-bank', p));
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(csp.check_file(str(path)), [])

    def test_bank_with_fisher_yates_and_math_random_passes(self):
        html = """
        <html><body>
        <div id="d3-bank" class="block-bank"></div>
        <script>
        const d3Pieces = ['a', 'b', 'c'];
        function fisherYates(arr) {
            for (let i = arr.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [arr[i], arr[j]] = [arr[j], arr[i]];
            }
            return arr;
        }
        function renderD3() {
            fisherYates(d3Pieces).forEach(p => addToBank('d3-bank', p));
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(csp.check_file(str(path)), [])

    def test_bank_with_sort_random_passes(self):
        html = """
        <html><body>
        <div id="d4-bank" class="block-bank"></div>
        <script>
        const d4Pieces = ['a', 'b', 'c'];
        function renderD4() {
            d4Pieces.sort(() => Math.random() - 0.5).forEach(p => addToBank('d4-bank', p));
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(csp.check_file(str(path)), [])


class TestUnshuffledFallbackAlongsideShuffle(unittest.TestCase):
    def test_bank_that_resorts_to_raw_order_on_render_is_flagged(self):
        # The exact original Drills 1/5 bug: a shuffle exists in scope (so
        # the simpler "no randomization" check alone would miss this), but
        # the actual render loop iterates the raw target/piece list
        # directly, not the shuffled order variable, resetting on every
        # placement.
        html = """
        <html><body>
        <div id="d1-bank" class="block-bank"></div>
        <script>
        const d1Target = ['a', 'b', 'c'];
        function initBlockDrill() {
            const d1Order = shuffle(d1Target.map(p => p));
            d1Target.forEach(p => addToBank('d1-bank', p));
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            flags = csp.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("d1-bank", flags[0])
            self.assertIn("raw piece list", flags[0])

    def test_shuffled_variable_used_for_render_is_not_flagged(self):
        # Same shape, but the render loop correctly reads the shuffled
        # variable rather than the raw source array -- must not be flagged.
        html = """
        <html><body>
        <div id="d5-bank" class="block-bank"></div>
        <script>
        const d5Target = ['a', 'b', 'c'];
        function initBlockDrill() {
            const d5Order = shuffle(d5Target.map(p => p));
            d5Order.forEach(p => addToBank('d5-bank', p));
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(csp.check_file(str(path)), [])


class TestBankWithNoId(unittest.TestCase):
    def test_bank_without_id_is_flagged_as_untraceable(self):
        html = """
        <html><body>
        <div class="block-bank"></div>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            flags = csp.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("no id", flags[0])


class TestFindBankIds(unittest.TestCase):
    def test_multiple_banks_in_one_file_are_all_found(self):
        html = """
        <div id="a-bank" class="block-bank"></div>
        <div id="b-bank" class="foo block-bank bar"></div>
        <div id="not-a-bank" class="something-else"></div>
        """
        ids = csp.find_bank_ids(html)
        self.assertEqual(sorted(ids), ["a-bank", "b-bank"])


if __name__ == "__main__":
    unittest.main()
