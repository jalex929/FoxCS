"""
Tests for check_save_serialization.py. stdlib unittest only, matching the
convention in 05-grader/school-side/tests/test_auto_grade.py.

Each test builds a small synthetic "save in place" HTML fixture in a temp
dir and asserts the checker's verdict, covering the real bug this script
was written to catch (per authoring-flow-gaps-2026-08-11.md: a textarea/
select/checkbox's live value never gets synced into the DOM before
`.outerHTML` is captured, so it silently reverts to blank on reopen) and
the fixed pattern (05_practice.html's own `syncFormStateToDom()`).

Run from anywhere with:
    python -m unittest discover -s 02-authoring-system/tools/tests -v
"""

import sys
import tempfile
import unittest
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))
import check_save_serialization as css  # noqa: E402


def write_html(folder: Path, content: str) -> Path:
    path = folder / "page.html"
    path.write_text(content, encoding="utf-8")
    return path


class TestNotSaveInPlace(unittest.TestCase):
    def test_page_without_save_markers_is_ignored(self):
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), "<html><body><p>hello</p></body></html>")
            self.assertIsNone(css.check_file(str(path)))


class TestNoStatefulControls(unittest.TestCase):
    def test_save_in_place_with_no_controls_is_clean(self):
        html = """
        <html><body>
        <button onclick="save()">Save</button>
        <script>
        async function save() {
            const html = document.documentElement.outerHTML;
            const handle = await window.showSaveFilePicker();
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(css.check_file(str(path)), [])


class TestTextareaSync(unittest.TestCase):
    MISSING_SYNC_HTML = """
    <html><body>
    <textarea id="answer"></textarea>
    <button onclick="save()">Save</button>
    <script>
    async function save() {
        const html = document.documentElement.outerHTML;
        const handle = await window.showSaveFilePicker();
    }
    </script>
    </body></html>
    """

    FIXED_INLINE_HTML = """
    <html><body>
    <textarea id="answer"></textarea>
    <button onclick="save()">Save</button>
    <script>
    async function save() {
        document.querySelectorAll('textarea').forEach(t => t.textContent = t.value);
        const html = document.documentElement.outerHTML;
        const handle = await window.showSaveFilePicker();
    }
    </script>
    </body></html>
    """

    FIXED_VIA_HELPER_HTML = """
    <html><body>
    <textarea id="answer"></textarea>
    <button onclick="save()">Save</button>
    <script>
    function syncFormStateToDom() {
        document.querySelectorAll('textarea').forEach(t => t.textContent = t.value);
    }
    async function save() {
        syncFormStateToDom();
        const html = document.documentElement.outerHTML;
        const handle = await window.showSaveFilePicker();
    }
    </script>
    </body></html>
    """

    SYNC_TOO_LATE_HTML = """
    <html><body>
    <textarea id="answer"></textarea>
    <button onclick="save()">Save</button>
    <script>
    async function save() {
        const html = document.documentElement.outerHTML;
        document.querySelectorAll('textarea').forEach(t => t.textContent = t.value);
        const handle = await window.showSaveFilePicker();
    }
    </script>
    </body></html>
    """

    def test_missing_sync_is_flagged(self):
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), self.MISSING_SYNC_HTML)
            flags = css.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("textarea", flags[0])

    def test_inline_sync_before_outerhtml_passes(self):
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), self.FIXED_INLINE_HTML)
            self.assertEqual(css.check_file(str(path)), [])

    def test_sync_via_named_helper_one_level_deep_passes(self):
        # This is the repo's own real fix pattern (syncFormStateToDom()).
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), self.FIXED_VIA_HELPER_HTML)
            self.assertEqual(css.check_file(str(path)), [])

    def test_sync_written_after_outerhtml_capture_is_still_flagged(self):
        # Order matters: a sync call after serialization is too late.
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), self.SYNC_TOO_LATE_HTML)
            flags = css.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("textarea", flags[0])


class TestSelectAndCheckboxSync(unittest.TestCase):
    def test_select_missing_sync_is_flagged(self):
        html = """
        <html><body>
        <select id="choice"><option value="a">A</option></select>
        <script>
        async function save() {
            const html = document.documentElement.outerHTML;
            const handle = await window.showSaveFilePicker();
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            flags = css.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("<select>", flags[0])

    def test_select_with_sync_passes(self):
        html = """
        <html><body>
        <select id="choice"><option value="a">A</option></select>
        <script>
        async function save() {
            document.querySelectorAll('select').forEach(s => {
                Array.from(s.options).forEach(o => o.toggleAttribute('selected', o.selected));
            });
            const html = document.documentElement.outerHTML;
            const handle = await window.showSaveFilePicker();
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(css.check_file(str(path)), [])

    def test_checkbox_missing_sync_is_flagged(self):
        html = """
        <html><body>
        <input type="checkbox" id="agree">
        <script>
        async function save() {
            const html = document.documentElement.outerHTML;
            const handle = await window.showSaveFilePicker();
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            flags = css.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("checkbox", flags[0])

    def test_checkbox_with_sync_passes(self):
        html = """
        <html><body>
        <input type="checkbox" id="agree">
        <script>
        async function save() {
            document.querySelectorAll('input[type="checkbox"]').forEach(
                c => c.toggleAttribute('checked', c.checked)
            );
            const html = document.documentElement.outerHTML;
            const handle = await window.showSaveFilePicker();
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            self.assertEqual(css.check_file(str(path)), [])


class TestMixedControls(unittest.TestCase):
    def test_only_the_unsynced_control_type_is_flagged(self):
        html = """
        <html><body>
        <textarea id="answer"></textarea>
        <input type="checkbox" id="agree">
        <script>
        async function save() {
            document.querySelectorAll('textarea').forEach(t => t.textContent = t.value);
            const html = document.documentElement.outerHTML;
            const handle = await window.showSaveFilePicker();
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            flags = css.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("checkbox", flags[0])


class TestNoOuterHtmlFound(unittest.TestCase):
    def test_save_picker_without_outerhtml_is_flagged_for_manual_review(self):
        html = """
        <html><body>
        <textarea id="answer"></textarea>
        <script>
        async function save() {
            const blob = new Blob([JSON.stringify({a: 1})]);
            const handle = await window.showSaveFilePicker();
        }
        </script>
        </body></html>
        """
        with tempfile.TemporaryDirectory() as tmp:
            path = write_html(Path(tmp), html)
            flags = css.check_file(str(path))
            self.assertEqual(len(flags), 1)
            self.assertIn("no `.outerHTML`", flags[0])


class TestExtractFunctions(unittest.TestCase):
    def test_nested_braces_are_balanced_correctly(self):
        script = """
        function outer() {
            if (true) {
                for (let i = 0; i < 3; i++) { doThing(i); }
            }
        }
        function other() { return 1; }
        """
        functions = css.extract_functions(script)
        self.assertIn("outer", functions)
        self.assertIn("other", functions)
        # extract_functions captures from the opening brace onward, not the
        # `function name(...)` prefix.
        self.assertEqual(functions["other"], "{ return 1; }")
        self.assertIn("doThing(i)", functions["outer"])


if __name__ == "__main__":
    unittest.main()
