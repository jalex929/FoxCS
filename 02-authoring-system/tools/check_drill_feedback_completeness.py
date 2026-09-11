#!/usr/bin/env python3
"""check_drill_feedback_completeness.py

PURPOSE
  Heuristic scanner for a documented-but-unenforced content-quality rule:
  every practice drill needs real feedback for BOTH a correct and an
  incorrect answer, not just a pass/fail state with no explanatory text.
  This is exactly what `python-app`'s own question schema makes structural
  (every question record carries separate `feedback_correct` /
  `feedback_incorrect` fields, confirmed in this repo's own
  `moodle-quick-pilot-workflow.md`) but FoxCS's static HTML drills only
  enforce in prose -- `05_practice.html`'s own intro text promises "quick
  practice with immediate feedback," and the drills that already exist
  (see that file's `checkDrill1`/`checkDrill2`/`checkTyped` functions) all
  follow this pattern by convention, with nothing checking that a newly
  authored drill actually does too. Built the same way as this repo's other
  gotcha checkers, in response to Jay's direct request (2026-09) to also
  cover content-authoring quality, not just the four bugs already named in
  `authoring-flow-gaps-2026-08-11.md`.

WHAT IT SCANS
  Every `<div class="feedback" id="...">` element (this repo's established
  per-drill feedback-target convention -- see `05_practice.html`). For each
  one, gathers every function in the same file whose body textually
  references that feedback element's id (covers all three shapes already
  in real use: an inline ternary like `checkDrill1`, an if/else-if chain
  like `checkDrill2`, and delegation to a shared helper with the actual
  message literals supplied at the call site like `checkDrill3`/`checkTyped`)
  and counts distinct, substantial (>=15 char) quoted string literals found
  in that combined code.

  Fewer than 2 such literals is flagged: not clear evidence of a distinct
  correct-answer message AND a distinct incorrect-answer message.

LIMITATIONS -- READ BEFORE TRUSTING A CLEAN RESULT
  Deliberately loose (any 2+ substantial string literals near a feedback
  id counts as a pass) rather than trying to parse each of the three real
  shapes exactly -- doing that precisely would mean re-deriving this file's
  entire bespoke JS per drill, which isn't worth the fragility. This is a
  heuristic worklist, not a pass/fail gate (like check_eliminable_distractors.py):
  it can miss a drill whose "two messages" are actually near-duplicates of
  each other (e.g. "Correct!" / "Incorrect!"), and it can't judge whether
  the feedback text is actually GOOD, only whether real text-shaped content
  exists at all. Always exits 0 -- read the findings, don't gate on them.

USAGE
  python3 check_drill_feedback_completeness.py [root_dir]
  (root_dir defaults to courses/python/content.)

EXAMPLE
  python3 check_drill_feedback_completeness.py
  python3 check_drill_feedback_completeness.py /home/jay/FoxCS/courses/python/content

EXIT CODE
  Always 0 (heuristic review worklist, not a gate -- see LIMITATIONS).
"""
import re
import sys
import os

DEFAULT_ROOT = "/home/jay/FoxCS/courses/python/content"

FEEDBACK_DIV_RE = re.compile(
    r'<div\s+class="feedback"\s+id="([\w-]+)"', re.IGNORECASE
)
STRING_LITERAL_RE = re.compile(r"""(['"])((?:(?!\1)[^\\]|\\.)*)\1""")
MIN_LITERAL_CHARS = 15


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


def find_feedback_ids(html: str) -> list:
    return FEEDBACK_DIV_RE.findall(html)


def related_code_for_feedback(feedback_id: str, functions: dict) -> str:
    """Every function in the file whose body textually references this
    feedback id, concatenated. Covers a function that reads/writes the
    element directly (getElementById) and a function that only passes the
    id as a string argument to a shared helper."""
    return '\n'.join(body for body in functions.values() if feedback_id in body)


def substantial_literals(code: str) -> set:
    literals = set()
    for m in STRING_LITERAL_RE.finditer(code):
        text = m.group(2)
        if len(text) >= MIN_LITERAL_CHARS:
            literals.add(text)
    return literals


def check_feedback_id(feedback_id: str, functions: dict) -> list:
    code = related_code_for_feedback(feedback_id, functions)
    literals = substantial_literals(code)
    if len(literals) < 2:
        return [
            f"feedback \"{feedback_id}\": found {len(literals)} substantial message string(s) in "
            f"the code that references it -- no clear evidence of a distinct correct-answer AND "
            f"incorrect-answer message. Verify this drill actually gives real feedback both ways."
        ]
    return []


def check_file(path: str) -> list:
    with open(path, 'r', encoding='utf-8') as f:
        html = f.read()

    feedback_ids = find_feedback_ids(html)
    if not feedback_ids:
        return []

    script = extract_scripts(html)
    functions = extract_functions(script)

    findings = []
    for feedback_id in feedback_ids:
        findings.extend(check_feedback_id(feedback_id, functions))
    return findings


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

    print(f"Scanning {len(html_files)} HTML file(s) under {root} for drill feedback "
          f"completeness...\n")
    print("NOTE: this is a heuristic review worklist, not a pass/fail gate -- read PURPOSE in "
          "this script's header before treating any single finding as a confirmed bug.\n")

    total_ids_found = 0
    total_findings = 0
    any_feedback_at_all = False

    for path in html_files:
        with open(path, 'r', encoding='utf-8') as f:
            html = f.read()
        feedback_ids = find_feedback_ids(html)
        if not feedback_ids:
            continue
        any_feedback_at_all = True
        total_ids_found += len(feedback_ids)
        findings = check_file(path)
        rel = os.path.relpath(path, root)
        if findings:
            total_findings += len(findings)
            print(f"[REVIEW] {rel} ({len(feedback_ids)} feedback target(s) found)")
            for f_ in findings:
                print(f"    - {f_}")
        else:
            print(f"[PASS] {rel} ({len(feedback_ids)} feedback target(s), all show 2+ distinct messages)")

    print()
    if not any_feedback_at_all:
        print("No per-drill feedback targets found anywhere under this root. Nothing to check.")
        sys.exit(0)

    print(f"Total: {total_ids_found} feedback target(s) across {len(html_files)} file(s), "
          f"{total_findings} finding(s).")
    sys.exit(0)


if __name__ == '__main__':
    main()
