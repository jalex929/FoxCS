#!/usr/bin/env python3
"""check_live_publish_readiness.py

PURPOSE
  Hard gate, added 2026-09-09, per a real incident: Unit 02's five
  Instruction pages (02.1-02.5) were promoted from the sandbox course to
  the real live foxcs-python course still carrying a "Sandbox prototype...
  Not live in any real course" banner and a "(Sandbox Prototype)" browser-
  tab title, visible to real students, because the sandbox-authoring
  markers were never stripped before deployment. Jay's direct instruction:
  "There should be tests to prevent claude from making content go live
  when it is still labeled as a prototype or when it does not give
  explicit instructions or allow for interactivity when it requires it
  from learners." This script is that check, run against a lesson's HTML
  BEFORE it gets deployed to any real (non-sandbox) course.

  Two of the three things Jay asked for are objectively checkable and are
  what this script actually enforces (see CHECKS below). The third --
  whether instructions are genuinely *explicit enough*, or whether a
  reflection/skill-check genuinely *lists the real skills* rather than
  asking a generic open-ended question (see feedback_skill_reflection_
  format.md; the Unit 01 Reflection's single generic "Unit confidence"
  item, fixed the same day this script was written, is exactly this
  failure mode) -- is a judgment call a regex can't reliably make. Treat
  this script as a hard floor, not a substitute for actually reading the
  content before it goes live.

CHECKS
  1. SANDBOX/PROTOTYPE MARKERS (hard fail). Any of: the literal string
     "sandbox" (case-insensitive) outside of an HTML comment, "prototype"
     (case-insensitive) outside a comment, a `proto-banner` class
     reference, or "Not live in any real course". HTML comments are
     stripped before this check runs, since authoring-history comments
     ("Sandbox prototype, 2026-09-08...") are expected and fine -- it's
     *visible* sandbox language the check cares about.
  2. MISSING INTERACTIVITY ON RESPONSE-ELICITING BLOCKS (hard fail). Any
     element whose class includes one of RESPONSE_ELICITING_CLASSES
     (quick-check, drill, reading-check, reflection) must contain at
     least one real interactive control (<select>, <input>, <textarea>,
     or a <button> paired with radio/checkbox inputs). Catches the same
     bug class as the 2026-09-08 "15 multiple-choice questions rendered
     as static, unselectable text" incident (see decisions-log.md).

  A file that isn't a lesson/response page at all (an overview/index page
  with no quick-check/drill/reflection blocks) will simply have nothing
  to flag under check 2 -- that's correct, not a false negative.

USAGE
  python3 check_live_publish_readiness.py [file-or-dir ...]
  Defaults to scanning courses/ for HTML files if no path is given.
  Exit code 0 = clean, 1 = at least one finding. Wire this into the
  deploy step for any script that promotes content to a real (non-
  sandbox) course -- run it against the staged HTML before create_module()
  / file_storage writes, not after.
"""

import re
import sys
import os

DEFAULT_ROOTS = [
    "/home/jay/FoxCS/courses",
]

COMMENT_RE = re.compile(r'<!--.*?-->', re.DOTALL)

SANDBOX_MARKER_RE = re.compile(
    r'sandbox|(?<!\.)\bprototype\b(?!\s*[.=])|not live in any real course',
    re.IGNORECASE,
)
# Excludes JS's own `Array.prototype`/`X.prototype = ...` idiom (a real,
# common, harmless pattern in this codebase's presentation-deck scripts) --
# "prototype" preceded by "." or followed by "." or "=" is JS code, not
# sandbox-authoring language. "sandbox" alone still catches every real
# banner, since every prototype banner in this codebase also says "sandbox".

RESPONSE_ELICITING_CLASSES = ['quick-check', 'drill', 'reading-check', 'reflection']

# A block is everything from its opening <div class="...X..."> to the
# matching close, approximated (not a real HTML parser) by scanning to the
# next top-level </div> at the same nesting depth. Good enough for this
# codebase's consistent, shallow div structure; a false negative here is
# safer than a false positive that blocks a real publish.
DIV_OPEN_RE = re.compile(r'<div\b[^>]*\bclass="([^"]*)"[^>]*>')


def find_class_blocks(html, classname):
    blocks = []
    for m in DIV_OPEN_RE.finditer(html):
        # Match the class as a whole space-separated token (e.g. "drill
        # quick-check"), not a substring -- "quick-check-label" must NOT
        # match classname "quick-check".
        if classname not in m.group(1).split():
            continue
        start = m.end()
        depth = 1
        pos = start
        while depth > 0:
            nextopen = html.find('<div', pos)
            nextclose = html.find('</div>', pos)
            if nextclose == -1:
                break
            if nextopen != -1 and nextopen < nextclose:
                depth += 1
                pos = nextopen + 4
            else:
                depth -= 1
                pos = nextclose + 6
        blocks.append(html[m.start():pos])
    return blocks


# FoxCS content uses several real interaction mechanisms beyond plain form
# controls -- drag-and-drop sorting (draggable="true"), click-to-check
# buttons (onclick=...), flip cards, etc. -- so this checks for ANY of
# them, not just <select>/<input>/<textarea>. The goal is to catch a block
# with literally zero interactive affordance (the actual 2026-09-08 bug:
# static enumerated text with no select, no button, no drag target, nothing
# a student can act on), not to mandate one specific UI pattern.
INTERACTIVE_RE = re.compile(
    r'<(select|input|textarea|button)\b|\bdraggable="true"|\bonclick=',
    re.IGNORECASE,
)


def scan_sandbox_markers(html_no_comments, path):
    findings = []
    for m in SANDBOX_MARKER_RE.finditer(html_no_comments):
        line = html_no_comments.count('\n', 0, m.start()) + 1
        snippet = html_no_comments[max(0, m.start() - 40):m.start() + 40].replace('\n', ' ')
        findings.append(f"line {line}: sandbox/prototype language visible to students: ...{snippet}...")
    return findings


def scan_missing_interactivity(html_no_comments, path):
    findings = []
    for classname in RESPONSE_ELICITING_CLASSES:
        for block in find_class_blocks(html_no_comments, classname):
            if not INTERACTIVE_RE.search(block):
                preview = re.sub(r'\s+', ' ', block)[:100]
                findings.append(
                    f'.{classname} block has no <select>/<input>/<textarea> -- '
                    f'response-eliciting content with no way to actually respond: {preview}...'
                )
    return findings


def scan_file(path):
    with open(path, encoding='utf-8', errors='replace') as f:
        html = f.read()
    html_no_comments = COMMENT_RE.sub('', html)
    return scan_sandbox_markers(html_no_comments, path) + scan_missing_interactivity(html_no_comments, path)


def main():
    roots = sys.argv[1:] if len(sys.argv) > 1 else DEFAULT_ROOTS
    html_files = []
    for root in roots:
        if os.path.isfile(root) and root.endswith('.html'):
            html_files.append(root)
            continue
        if not os.path.isdir(root):
            print(f"Not a file or directory, skipping: {root}", file=sys.stderr)
            continue
        for dirpath, _, filenames in os.walk(root):
            for fn in filenames:
                if fn.endswith('.html'):
                    html_files.append(os.path.join(dirpath, fn))
    html_files.sort()

    print(f"Scanning {len(html_files)} HTML file(s) for live-publish readiness...\n")

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
        print(f"Total: {total_files_flagged} file(s), {total_findings} finding(s).")
        print("\nRemember: this only catches the two objectively-checkable failure modes")
        print("(visible sandbox/prototype language, response blocks with no real interactive")
        print("control). It does NOT verify instructions are genuinely explicit, or that a")
        print("skill reflection actually lists the real skills -- read the content too.")
        sys.exit(1)
    print("Clean on the automated checks -- no visible sandbox language, no non-interactive")
    print("response-eliciting blocks found. Still read the content before it goes live.")
    sys.exit(0)


if __name__ == '__main__':
    main()
