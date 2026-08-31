#!/usr/bin/env python3
"""check_save_serialization.py

PURPOSE
  Static checker for the save-serialization data-loss bug named in
  authoring-flow-gaps-2026-08-11.md: a "save in place" page (one that
  serializes `document.documentElement.outerHTML` and writes it out via
  `showSaveFilePicker`/download) silently drops a student's actual answer,
  because `outerHTML` only reflects DOM *attributes*, not the live IDL
  properties `<textarea>`.value, `<select>`.value (the chosen <option>), or
  a checkbox's `.checked` state. Without an explicit "sync live state back
  into attributes" step before serializing, a student's real input reverts
  to whatever the page loaded with (usually blank) the moment the saved
  file is reopened -- described in that audit as "worse than the others:
  it's not a rigor gap, it's data loss." Built per recommendation 3 of
  pipeline-comparison-python-app-2026-08-31.md; this is the highest-priority
  of the three VS Code-side checks that recommendation calls for.

  This script has already been run against the real, currently-fixed files
  in courses/python/content/ (05_practice.html's own header comment
  documents the original bug and its fix, `syncFormStateToDom()`) -- see
  this script's own test run output for confirmation it recognizes that
  fix as clean.

WHAT IT CHECKS
  For every HTML file that looks like a "save in place" page (contains
  `showSaveFilePicker` and/or serializes `documentElement.outerHTML`):
    1. Which form-control types actually appear in the page markup:
       <textarea>, <select>, and checkbox <input type="checkbox">.
    2. Whether the code path that runs BEFORE the outerHTML capture (the
       save function's own body up to that line, plus one level of
       functions it calls by name -- e.g. a separate `syncFormStateToDom()`
       helper, which is exactly this repo's own fixed pattern) contains a
       sync statement for each control type actually present:
         - textarea  -> `<var>.textContent = <var>.value` (or equivalent
           assignment sourced from `.value` into `.textContent`/an
           attribute)
         - select    -> `toggleAttribute('selected', ...)` or
           `setAttribute('selected', ...)` scoped to `<option>`s
         - checkbox  -> `toggleAttribute('checked', ...)` or
           `setAttribute('checked', ...)` scoped to the checkbox
    3. Whether a matching sync statement, if present anywhere in the file,
       actually occurs BEFORE the outerHTML line in execution order (a
       sync call written only after serialization is too late and is
       flagged the same as a missing one).

  A control type present in the markup with no matching sync evidence
  found in the reachable pre-serialize code is a hard FLAG -- this is
  exactly the shape of the original bug, so this checker treats it as a
  correctness issue, not a soft style note.

LIMITATIONS
  Static source pattern-matching again, not a real browser. It cannot
  execute the JS to confirm the sync function is actually reachable/wired
  correctly at runtime (e.g. if it's defined but never called at all from
  the right place -- this script does check call-order textually, but a
  sufficiently indirect call chain, e.g. through an event-bound anonymous
  function two levels removed, could evade detection). It also doesn't
  understand custom/non-native form widgets (e.g. a div styled to look like
  a dropdown) -- only the three real control types named in the original
  bug report. Treat a FLAG as "go look at this file"; treat a clean run as
  "matches the known-good pattern," not a formal proof.

USAGE
  python3 check_save_serialization.py [root_dir]
  (root_dir defaults to courses/python/content.)

EXAMPLE
  python3 check_save_serialization.py
  python3 check_save_serialization.py /home/jay/FoxCS/courses/python/content

EXIT CODE
  0 if no FLAGs were raised.
  1 if at least one save-in-place page is missing sync coverage for a
    control type it actually contains.
"""
import re
import sys
import os

DEFAULT_ROOT = "/home/jay/FoxCS/courses/python/content"

SAVE_MARKER_RE = re.compile(r'showSaveFilePicker|documentElement\.outerHTML')
OUTER_HTML_RE = re.compile(r'\.outerHTML\b')

TEXTAREA_TAG_RE = re.compile(r'<textarea\b', re.IGNORECASE)
SELECT_TAG_RE = re.compile(r'<select\b', re.IGNORECASE)
CHECKBOX_TAG_RE = re.compile(r'<input\b[^>]*type=["\']checkbox["\']', re.IGNORECASE)

# Sync-evidence patterns. Deliberately a little loose (not tied to exact
# variable names) since the point is "is there code shaped like a fix,"
# not "is it byte-identical to 05_practice.html's implementation."
TEXTAREA_SYNC_RE = re.compile(
    r"querySelectorAll\(['\"]textarea['\"]\)[\s\S]{0,200}?\.textContent\s*=\s*[\w.$]*\.value"
)
SELECT_SYNC_RE = re.compile(
    r"querySelectorAll\(['\"]select['\"]\)[\s\S]{0,300}?(?:toggleAttribute|setAttribute)\(\s*['\"]selected['\"]"
)
CHECKBOX_SYNC_RE = re.compile(
    r"querySelectorAll\(['\"]input\[type=[\\\"']checkbox[\\\"']\]['\"]\)[\s\S]{0,200}?"
    r"(?:toggleAttribute|setAttribute)\(\s*['\"]checked['\"]"
)


def extract_scripts(html: str) -> str:
    return '\n'.join(re.findall(r'<script[^>]*>(.*?)</script>', html, re.DOTALL | re.IGNORECASE))


def extract_functions(script: str) -> dict:
    """Return {function_name: body_text} via brace-balanced matching."""
    functions = {}
    for m in re.finditer(r'(?:async\s+)?function\s+([A-Za-z_$][\w$]*)\s*\([^)]*\)\s*\{', script):
        name = m.group(1)
        start = m.end() - 1
        depth = 0
        i = start
        while i < len(script):
            if script[i] == '{':
                depth += 1
            elif script[i] == '}':
                depth -= 1
                if depth == 0:
                    functions[name] = script[start:i + 1]
                    break
            i += 1
    return functions


def find_save_function_preamble(script: str, functions: dict):
    """Locate the function containing the first `.outerHTML` reference and
    return (preamble_text, rest_of_code_available) where preamble_text is
    everything in that function's body BEFORE the outerHTML line, plus the
    bodies of any bare-named functions it calls (one level), which is where
    this repo's real fix (`syncFormStateToDom()`) lives.
    Returns (None, None) if no outerHTML usage is found at all."""
    m = OUTER_HTML_RE.search(script)
    if not m:
        return None, None

    # Find the enclosing function for this occurrence: the nearest function
    # whose body span contains m.start().
    enclosing_name, enclosing_body, enclosing_start = None, None, None
    for name, body in functions.items():
        idx = script.find(body)
        if idx != -1 and idx <= m.start() <= idx + len(body):
            enclosing_name, enclosing_body, enclosing_start = name, body, idx
            break

    if enclosing_body is None:
        # outerHTML used outside any named function (e.g. inline in an
        # anonymous handler) -- fall back to "everything before it" as the
        # preamble, which is conservative (more likely to find sync
        # evidence, so we don't over-flag a working page written slightly
        # differently than the reference implementation).
        preamble = script[:m.start()]
    else:
        rel_pos = m.start() - enclosing_start
        preamble = enclosing_body[:rel_pos]

    # Fold in one level of bare-called function bodies (e.g. a separate
    # `syncFormStateToDom()` helper called from inside the save function).
    called_names = set(re.findall(r'\b([A-Za-z_$][\w$]*)\s*\(\s*\)', preamble))
    for name in called_names:
        if name in functions:
            preamble += '\n' + functions[name]

    return preamble, enclosing_name


def check_file(path: str):
    with open(path, 'r', encoding='utf-8') as f:
        html = f.read()

    if not SAVE_MARKER_RE.search(html):
        return None  # not a save-in-place page at all

    has_textarea = bool(TEXTAREA_TAG_RE.search(html))
    has_select = bool(SELECT_TAG_RE.search(html))
    has_checkbox = bool(CHECKBOX_TAG_RE.search(html))

    if not (has_textarea or has_select or has_checkbox):
        return []  # save-in-place page, but no stateful controls to lose -- nothing to check

    script = extract_scripts(html)
    functions = extract_functions(script)
    preamble, fn_name = find_save_function_preamble(script, functions)

    flags = []
    if preamble is None:
        flags.append(
            "page matches the save-in-place pattern (showSaveFilePicker present) but no "
            "`.outerHTML` serialization was found -- verify how this page actually saves."
        )
        return flags

    if has_textarea and not TEXTAREA_SYNC_RE.search(preamble):
        flags.append(
            "<textarea> present but no evidence of a pre-save sync "
            "(`textarea.textContent = textarea.value`-style) in the reachable save-path code "
            "-- a typed answer will likely revert to blank when the saved file is reopened."
        )
    if has_select and not SELECT_SYNC_RE.search(preamble):
        flags.append(
            "<select> present but no evidence of a pre-save sync (marking the chosen "
            "<option> with the `selected` attribute) in the reachable save-path code -- a "
            "dropdown choice will likely revert to its default when reopened."
        )
    if has_checkbox and not CHECKBOX_SYNC_RE.search(preamble):
        flags.append(
            "checkbox <input> present but no evidence of a pre-save sync (mirroring "
            "`.checked` onto the `checked` attribute) in the reachable save-path code -- a "
            "checked box will likely revert to unchecked when reopened."
        )

    return flags


def main():
    root = sys.argv[1] if len(sys.argv) > 1 else DEFAULT_ROOT
    if not os.path.isdir(root):
        print(f"Not a directory: {root}", file=sys.stderr)
        sys.exit(1)

    html_files = []
    for dirpath, _, filenames in os.walk(root):
        for fn in filenames:
            if fn.endswith('.html'):
                html_files.append(os.path.join(dirpath, fn))
    html_files.sort()

    print(f"Scanning {len(html_files)} HTML file(s) under {root} for save-in-place pages...\n")

    checked = 0
    total_flags = 0
    for path in html_files:
        flags = check_file(path)
        if flags is None:
            continue
        checked += 1
        rel = os.path.relpath(path, root)
        if flags:
            total_flags += len(flags)
            print(f"[FLAG] {rel}")
            for f_ in flags:
                print(f"    - {f_}")
        else:
            print(f"[PASS] {rel}")

    print()
    if checked == 0:
        print("No save-in-place pages found (no showSaveFilePicker/outerHTML serialization) "
              "under this root. Nothing to check.")
        sys.exit(0)

    print(f"Total: {checked} save-in-place page(s) checked, {total_flags} flag(s).")
    sys.exit(1 if total_flags else 0)


if __name__ == '__main__':
    main()
