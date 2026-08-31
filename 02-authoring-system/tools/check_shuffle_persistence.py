#!/usr/bin/env python3
"""check_shuffle_persistence.py

PURPOSE
  Static checker for the "unshuffled block bank" bug class named in
  authoring-flow-gaps-2026-08-11.md (Drill 7 rendered unshuffled, solvable
  top-to-bottom; Drills 1/5 re-sorted back to unshuffled order on every
  placement -- same root cause, different symptom). Built per recommendation
  3 of pipeline-comparison-python-app-2026-08-31.md ("tie every new
  authoring rule to a real check, even a cheap one").

  Scans static HTML practice files under courses/<course>/content/ for the
  "block bank" / drag-drop-reorder pattern (a `class="block-bank"` container
  that a script populates with clickable/draggable pieces) and flags any
  bank whose rendering code doesn't show evidence of an actual shuffle.

WHAT IT CHECKS (per detected bank)
  1. Some form of randomization exists in the code path that builds the
     bank's piece order -- a call to a function/pattern matching `shuffle(`,
     a Fisher-Yates loop (`for (...i > 0...i--)` combined with
     `Math.random()`), or `.sort(() => Math.random() ...)`.
  2. The bank's rendering loop doesn't fall back to iterating the piece
     list's own natural/definition order directly (e.g.
     `target.forEach(...)` or `target.map((_, i) => i).forEach(...)` used
     to populate the bank with no shuffle involved) -- this is the exact
     shape of the original bug (bank rendered in "d7Pieces' own definition
     order").

LIMITATIONS -- READ BEFORE TRUSTING A CLEAN RESULT
  This is static-source pattern matching, not a runtime check. It cannot
  confirm the shuffle actually executes differently across page loads (that
  would require a real/headless browser -- out of scope for a lightweight
  repo script). It also only recognizes the "block-bank" naming convention
  and function-call shapes already used in this repo's own fixed files
  (05_practice.html, see its own header comment for the original bug and
  fix). A bank built with a materially different structure may not be
  detected at all -- an empty "no banks found" result means "found nothing
  matching the known pattern," not "verified no block-bank drills exist."
  Treat a FLAG as something to open the file and look at, and a PASS as
  "matches the known-good pattern," not a formal proof.

USAGE
  python3 check_shuffle_persistence.py [root_dir]
  (root_dir defaults to courses/python/content, the only course with static
  HTML content as of 2026-08-31 -- see the report footer for what's actually
  the long-term home of this content once that's decided.)

EXAMPLE
  python3 check_shuffle_persistence.py
  python3 check_shuffle_persistence.py /home/jay/FoxCS/courses/python/content

EXIT CODE
  0 if no FLAGs were raised (a FLAG is a strong signal, not a soft note --
    unlike the eliminable-distractor scanner, "not shuffled" is unambiguous
    once a bank is detected at all).
  1 if at least one bank was flagged.
"""
import re
import sys
import os

DEFAULT_ROOT = "/home/jay/FoxCS/courses/python/content"

BANK_TAG_RE = re.compile(
    r'<div\s+([^>]*class="[^"]*\bblock-bank\b[^"]*"[^>]*|[^>]*)>',
    re.IGNORECASE,
)
ID_ATTR_RE = re.compile(r'id="([\w-]+)"')
CLASS_ATTR_RE = re.compile(r'class="([^"]*)"')

SHUFFLE_CALL_RE = re.compile(r'\bshuffle\s*\(')
FISHER_YATES_RE = re.compile(r'for\s*\([^)]*;\s*[\w$]+\s*>\s*0\s*;\s*[\w$]+--\s*\)')
SORT_RANDOM_RE = re.compile(r'\.sort\(\s*\(\)\s*=>\s*Math\.random')
MATH_RANDOM_RE = re.compile(r'Math\.random\(\)')

# The literal shape of the original bug: iterating the raw target/piece list
# directly (its own definition order) to build the bank, no shuffled
# variable involved.
NATURAL_ORDER_RENDER_RE = re.compile(
    r'\b([A-Za-z_$][\w$]*)\.(?:forEach|map)\s*\(\s*(?:\([^)]*\)|[\w$]+)\s*=>'
)


def extract_scripts(html: str) -> str:
    return '\n'.join(re.findall(r'<script[^>]*>(.*?)</script>', html, re.DOTALL | re.IGNORECASE))


def extract_functions(script: str) -> dict:
    """Return {function_name: body_text} for every `function name(...) { ... }`
    (including `async function`) found via brace-balanced matching."""
    functions = {}
    for m in re.finditer(r'(?:async\s+)?function\s+([A-Za-z_$][\w$]*)\s*\([^)]*\)\s*\{', script):
        name = m.group(1)
        start = m.end() - 1  # position of the opening brace
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


def find_bank_ids(html: str) -> list:
    """Find every element with class containing block-bank, return its id
    (or None if it has no id, which is itself worth flagging separately)."""
    ids = []
    for m in re.finditer(r'<div\s+([^>]*)>', html, re.IGNORECASE):
        attrs = m.group(1)
        classm = CLASS_ATTR_RE.search(attrs)
        if not classm or 'block-bank' not in classm.group(1).split():
            continue
        idm = ID_ATTR_RE.search(attrs)
        ids.append(idm.group(1) if idm else None)
    return ids


def related_code_for_bank(bank_id: str, script: str, functions: dict) -> str:
    """Gather the text of every function that directly references this
    bank's id (init/render functions), plus (one level deep) any function
    they call by bare name, e.g. renderBlockDrill(...) called from
    initBlockDrill(...). Mirrors the same one-level call-following approach
    used in check_save_serialization.py."""
    referencing = [body for body in functions.values() if bank_id in body]
    combined = '\n'.join(referencing)

    called_names = set(re.findall(r'\b([A-Za-z_$][\w$]*)\s*\(', combined))
    for name in called_names:
        if name in functions and functions[name] not in combined:
            combined += '\n' + functions[name]

    # Also fold in any top-level (non-function-wrapped) script code that
    # references this id directly, e.g. `initBlockDrill('d1-bank', ...)`
    # calls made at the top level right after function definitions.
    for line in script.splitlines():
        if bank_id in line and line.strip() not in combined:
            combined += '\n' + line

    # A bank's referencing functions often read a module-level `const`/`let`
    # variable computed OUTSIDE any function (e.g.
    # `const d7BankOrder = shuffle(d7Pieces.map(p => p.id));` followed by a
    # `d7Render()` function that reads `d7BankOrder`). Pull in the top-level
    # declaration line for every identifier the combined code references so
    # that pattern is visible to the shuffle check below.
    identifiers = set(re.findall(r'\b([A-Za-z_$][\w$]*)\b', combined))
    for name in identifiers:
        for m in re.finditer(
            rf'^\s*(?:const|let|var)\s+{re.escape(name)}\s*=.*?;\s*$',
            script, re.MULTILINE,
        ):
            line = m.group(0)
            if line not in combined:
                combined += '\n' + line

    return combined


def check_bank(bank_id: str, code: str) -> list:
    """Return a list of flag strings for one bank's related code."""
    flags = []
    has_shuffle = bool(
        SHUFFLE_CALL_RE.search(code)
        or SORT_RANDOM_RE.search(code)
        or (FISHER_YATES_RE.search(code) and MATH_RANDOM_RE.search(code))
    )
    if not has_shuffle:
        flags.append(
            f"bank \"{bank_id}\": no randomization found (no shuffle()/Fisher-Yates/"
            f".sort(random) pattern in the code that builds this bank) -- likely "
            f"renders in a fixed, exploitable order."
        )
        return flags  # no point checking the natural-order fallback separately

    # Even with a shuffle present somewhere, check whether the rendering loop
    # ALSO has a direct natural-order fallback that isn't gated behind the
    # shuffled variable (the "resets to unshuffled order on every render" bug).
    # Heuristic: look for `<name>.map((_, i) => i)` or `<name>.forEach(` where
    # <name> looks like a raw data array (commonly named *Target*, *Pieces*,
    # *pieces*, *options*) used OUTSIDE of a shuffle(...) call.
    for m in NATURAL_ORDER_RENDER_RE.finditer(code):
        source_var = m.group(1)
        # Ignore if this exact usage is itself wrapped in a shuffle(...) call
        # (i.e., `shuffle(target.map(...))` -- that's the correct pattern).
        window_start = max(0, m.start() - 20)
        preceding = code[window_start:m.start()]
        if 'shuffle(' in preceding:
            continue
        if re.search(r'(target|pieces|options)', source_var, re.IGNORECASE):
            flags.append(
                f"bank \"{bank_id}\": found `{source_var}.forEach/map(...)` iterating "
                f"the raw piece list directly (not the shuffled order variable) -- "
                f"verify this isn't a leftover unshuffled render path alongside the "
                f"shuffle found elsewhere in this bank's code."
            )
    return flags


def check_file(path: str) -> list:
    with open(path, 'r', encoding='utf-8') as f:
        html = f.read()

    bank_ids = find_bank_ids(html)
    if not bank_ids:
        return []

    script = extract_scripts(html)
    functions = extract_functions(script)

    flags = []
    for bank_id in bank_ids:
        if bank_id is None:
            flags.append("a block-bank element has no id -- cannot trace its rendering code at all.")
            continue
        code = related_code_for_bank(bank_id, script, functions)
        flags.extend(check_bank(bank_id, code))
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

    print(f"Scanning {len(html_files)} HTML file(s) under {root} for block-bank drills...\n")

    total_banks_found = 0
    total_flags = 0
    any_bank_at_all = False

    for path in html_files:
        with open(path, 'r', encoding='utf-8') as f:
            html = f.read()
        bank_ids = find_bank_ids(html)
        if not bank_ids:
            continue
        any_bank_at_all = True
        total_banks_found += len(bank_ids)
        flags = check_file(path)
        rel = os.path.relpath(path, root)
        if flags:
            total_flags += len(flags)
            print(f"[FLAG] {rel} ({len(bank_ids)} bank(s) found)")
            for f_ in flags:
                print(f"    - {f_}")
        else:
            print(f"[PASS] {rel} ({len(bank_ids)} bank(s) found, all show shuffle evidence)")

    print()
    if not any_bank_at_all:
        print("No block-bank drills found anywhere under this root. Nothing to check.")
        print("(Not a failure -- this course may not have any drag/click-to-build drills yet,")
        print(" or they may use a different pattern this scanner doesn't recognize -- see the")
        print(" LIMITATIONS section in this script's header.)")
        sys.exit(0)

    print(f"Total: {total_banks_found} bank(s) found across {len(html_files)} file(s), {total_flags} flag(s).")
    sys.exit(1 if total_flags else 0)


if __name__ == '__main__':
    main()
