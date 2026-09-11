#!/usr/bin/env python3
"""check_scaffold_answer_leak.py

PURPOSE
  Hard gate for a real bug class found 2026-09-04, in the same family as
  patch_disable_show_solution.py's "never let a student reveal a correct
  answer" rule and patch_remove_answer_leak.py's "don't name the correct
  category in feedback" fix -- but for a pattern neither of those checks:
  a Run & Check scaffolded fill-in-the-blank (see
  ../browser-python-execution.md, component-library #20/#21) whose
  <input> placeholder or nearby prompt text literally contains the exact
  line of code the blank is graded against. The whole point of a
  scaffolded blank is that the Learner has to work out what code goes
  there from the stated goal/expected output -- printing (or
  placeholdering) the literal answer defeats that, whether it's framed as
  a placeholder, a "for example" aside, or an "e.g." aside.

  Per Jay, directly, 2026-09-04: "we never want to deliberately give
  students the exact answer... make sure we have checks in place to make
  sure this is not happening." This script is that check.

CONVENTION THIS RELIES ON
  A scaffolded-blank <input> should carry data-expected="<exact graded
  string>" so this script (and the grading JS itself, ideally) has one
  real source of truth instead of a hand-typed duplicate that can drift.
  New Run & Check items should adopt this attribute. Where it's missing,
  this script still runs its "for example"/"e.g." heuristic against the
  prompt text alone (see HEURISTIC CHECK below), so authors don't get a
  false pass just by omitting the attribute.

WHAT IT SCANS, PER HTML FILE
  1. HARD CHECK (data-expected present): every
     <input ... class="...scaffold-blank..." data-expected="X"
     placeholder="Y">. Flags if Y (case/whitespace-normalized) equals X,
     or if X's core normalized form is a substring of Y -- catches both
     "placeholder is literally the answer" and "placeholder is the answer
     plus a little decoration."
  2. HEURISTIC CHECK (runs regardless of data-expected): any
     .drill-prompt/.ide-... prompt text containing "for example" or "e.g."
     immediately followed by a <code>...</code> span that itself looks
     like a real assignment statement (identifier = literal). This is the
     exact shape of the bug found in component-library #20 ("for example,
     `score = 10`") -- flagged even when the file doesn't use the
     data-expected convention at all, so this check can't be silently
     bypassed by not adopting it.

USAGE
  python3 check_scaffold_answer_leak.py [root_dir ...]
  (root_dir defaults to the repo's courses/ and 02-authoring-system/
  component-library/, since both real lesson content and the reference
  component library need to be clean.)

EXIT CODE
  1 if any finding, 0 if clean. Unlike check_eliminable_distractors.py,
  this IS a hard gate, not a review worklist -- both checks it runs are
  precise enough (exact/substring string comparison, or a narrow
  "for example/e.g. + code" phrase pattern) to not need human judgment
  the way distractor-wording calls do.
"""
import re
import sys
import os

DEFAULT_ROOTS = [
    "/home/jay/FoxCS/courses",
    "/home/jay/FoxCS/02-authoring-system/component-library",
]

INPUT_RE = re.compile(r'<input\b([^>]*)>', re.IGNORECASE)
ATTR_RE = re.compile(r'(\w[\w-]*)\s*=\s*"([^"]*)"')
CODE_RE = re.compile(r'<code>([^<]*)</code>', re.IGNORECASE)
FOR_EXAMPLE_RE = re.compile(
    r'(for example|e\.g\.)[^<]{0,40}<code>([^<]*)</code>',
    re.IGNORECASE,
)
ASSIGNMENT_LIKE_RE = re.compile(
    r'^[A-Za-z_][A-Za-z0-9_]*\s*=\s*\S'  # identifier = <something>
)


def normalize(s: str) -> str:
    return re.sub(r'\s+', ' ', s.strip())


def core_of(expected: str) -> str:
    """Strip a trailing/leading identifier= wrapper down to nothing extra --
    for now this is just normalize(); kept as its own function so a future
    author can extend the normalization (e.g. ignoring quote style) in one
    place without touching the two call sites below."""
    return normalize(expected)


def scan_hard_check(html: str) -> list:
    findings = []
    for m in INPUT_RE.finditer(html):
        attrs = dict(ATTR_RE.findall(m.group(1)))
        cls = attrs.get('class', '')
        if 'scaffold-blank' not in cls:
            continue
        expected = attrs.get('data-expected')
        placeholder = attrs.get('placeholder')
        if not expected or not placeholder:
            continue
        exp_norm = core_of(expected)
        ph_norm = normalize(placeholder)
        if ph_norm == exp_norm or exp_norm in ph_norm:
            findings.append(
                f'<input> placeholder="{placeholder}" leaks the graded answer '
                f'(data-expected="{expected}") -- replace the placeholder with '
                f'neutral guidance text, not the answer itself.'
            )
    return findings


def scan_heuristic_check(html: str) -> list:
    findings = []
    for m in FOR_EXAMPLE_RE.finditer(html):
        lead, code = m.group(1), m.group(2).strip()
        if ASSIGNMENT_LIKE_RE.match(code):
            findings.append(
                f'prompt text uses "{lead}" immediately before <code>{code}</code>, '
                f'which looks like a real, working assignment statement -- this reads '
                f'as literally telling the Learner the answer, not just the shape of one.'
            )
    return findings


def scan_file(path: str) -> list:
    with open(path, 'r', encoding='utf-8') as f:
        html = f.read()
    return scan_hard_check(html) + scan_heuristic_check(html)


def main():
    roots = sys.argv[1:] if len(sys.argv) > 1 else DEFAULT_ROOTS
    html_files = []
    for root in roots:
        if not os.path.isdir(root):
            print(f"Not a directory, skipping: {root}", file=sys.stderr)
            continue
        for dirpath, _, filenames in os.walk(root):
            for fn in filenames:
                if fn.endswith('.html'):
                    html_files.append(os.path.join(dirpath, fn))
    html_files.sort()

    print(f"Scanning {len(html_files)} HTML file(s) for scaffold answer-leak patterns...\n")

    total_findings = 0
    total_files_flagged = 0
    for path in html_files:
        findings = scan_file(path)
        if not findings:
            continue
        total_files_flagged += 1
        print(f"[FAIL] {path}")
        for f_ in findings:
            total_findings += 1
            print(f"  - {f_}")
        print()

    if total_findings:
        print(f"Total: {total_files_flagged} file(s), {total_findings} answer-leak finding(s).")
        sys.exit(1)
    print("Clean -- no scaffold answer-leak patterns found.")
    sys.exit(0)


if __name__ == '__main__':
    main()
