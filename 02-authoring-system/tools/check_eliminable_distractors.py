#!/usr/bin/env python3
"""check_eliminable_distractors.py

PURPOSE
  Heuristic scanner for the "eliminable distractor" bug class named in
  authoring-flow-gaps-2026-08-11.md: "Drill 8's prompt wording let a student
  eliminate 3 of 4 options without reading the code" -- a multiple-choice
  question where an option's own wording (or its relationship to the other
  options) gives away whether it can be ruled in or out, independent of
  whether the student understood the actual question content. Built per
  recommendation 3 of pipeline-comparison-python-app-2026-08-31.md, which
  names this exact rule ("distractors must not be eliminable from the
  prompt") as one that existed only in prose (content-authoring-standards.md,
  added after the bug) with nothing automated checking for it.

  UNLIKE the shuffle-persistence and save-serialization checks, this is
  explicitly a heuristic, pattern-based scanner, not a pass/fail gate --
  the task that requested it is explicit this one is "flagged for human
  review rather than a hard pass/fail," because judging whether wording
  actually gives away an answer is a reading-comprehension call a script
  can't make reliably. Expect real, currently-fine questions to get flagged
  sometimes (e.g. a well-designed "which combination is correct" question
  legitimately uses words like "both"); expect it to also miss real
  problems it has no pattern for. Use it as a worklist to read, not a gate
  to pass.

WHAT IT SCANS
  Every `<select class="drill-select">...</select>` multiple-choice/dropdown
  question block in the target HTML files (this repo's established MC
  pattern -- see e.g. 05_practice.html's Drills 2/6/8), paired with its
  nearest preceding `.drill-prompt` text. For each question, its non-
  placeholder `<option>` texts are checked for:

  1. SIGNAL WORDS -- wording that itself narrows the field regardless of
     content: "only", "always", "never", "none of the above/these", "all
     of the above/these", "both", "neither", "nothing is wrong" and
     similar absolute/scope-defining phrases.
  2. LENGTH OUTLIER -- one option far longer or shorter (>=2x word count)
     than the others; test-writers unintentionally make the correct answer
     the most fully-hedged/detailed option more often than chance, and
     students learn to exploit that pattern across many questions even
     when it isn't scored against them here.
  3. COMPOSITE-OPTION PATTERN -- an option whose wording combines the
     distinguishing content of two OTHER sibling options (e.g. options are
     "missing the quote", "missing the parenthesis", and "missing both" --
     once a student notices two singular options exist, "both" is
     guessable as likely-correct without needing to verify either half
     against the actual code/content).

USAGE
  python3 check_eliminable_distractors.py [root_dir]
  (root_dir defaults to courses/python/content.)

EXAMPLE
  python3 check_eliminable_distractors.py
  python3 check_eliminable_distractors.py /home/jay/FoxCS/courses/python/content

EXIT CODE
  Always 0 (this is a review worklist, not a gate -- see PURPOSE above).
  The finding count is still printed so it can be tracked over time.
"""
import re
import sys
import os

DEFAULT_ROOT = "/home/jay/FoxCS/courses/python/content"

SELECT_BLOCK_RE = re.compile(
    r'<select\s+class="drill-select"[^>]*id="([\w-]+)"[^>]*>(.*?)</select>',
    re.DOTALL | re.IGNORECASE,
)
OPTION_RE = re.compile(r'<option\s+value="([^"]*)"[^>]*>([^<]*)</option>', re.IGNORECASE)
PROMPT_RE = re.compile(r'<div\s+class="drill-prompt">(.*?)</div>', re.DOTALL | re.IGNORECASE)
TAG_STRIP_RE = re.compile(r'<[^>]+>')

SIGNAL_WORD_RE = re.compile(
    r'\b(only|always|never|none of the (above|these)|all of the (above|these)|both|neither|'
    r'nothing is wrong)\b',
    re.IGNORECASE,
)

STOPWORDS = {
    'the', 'and', 'that', 'this', 'with', 'from', 'have', 'what', 'which',
    'does', 'both', 'only', 'either', 'over', 'into', 'than', 'when',
    'also', 'each', 'these', 'those', 'because', 'about', 'would', 'could',
    'closing', 'missing',
}


def strip_tags(text: str) -> str:
    return TAG_STRIP_RE.sub('', text).strip()


def keywords(text: str) -> set:
    words = re.findall(r"[a-zA-Z']+", text.lower())
    return {w for w in words if len(w) >= 4 and w not in STOPWORDS}


def find_preceding_prompt(html: str, select_start: int) -> str:
    best = None
    for m in PROMPT_RE.finditer(html, 0, select_start):
        best = m
    return strip_tags(best.group(1)) if best else "(no .drill-prompt found before this question)"


def check_question(prompt: str, options: list) -> list:
    """options: list of (value, text). Returns list of finding strings."""
    findings = []
    real_options = [(v, strip_tags(t)) for v, t in options if v.strip() != '']
    if len(real_options) < 2:
        return findings
    texts = [t for _, t in real_options]

    # 1. Signal words
    for _, text in real_options:
        m = SIGNAL_WORD_RE.search(text)
        if m:
            findings.append(
                f"option \"{text}\" contains scope/absolute word \"{m.group(0)}\" -- "
                f"check it isn't guessable from wording alone."
            )

    # 2. Length outlier
    wordcounts = [len(t.split()) for t in texts]
    if min(wordcounts) > 0:
        ratio = max(wordcounts) / min(wordcounts)
        if ratio >= 2.0 and max(wordcounts) - min(wordcounts) >= 3:
            longest = texts[wordcounts.index(max(wordcounts))]
            shortest = texts[wordcounts.index(min(wordcounts))]
            findings.append(
                f"option lengths are uneven (\"{shortest}\" vs \"{longest}\", "
                f"{ratio:.1f}x word-count ratio) -- length alone can hint at the answer."
            )

    # 3. Composite-option pattern: an option's keyword set is a superset that
    # covers two OTHER options' distinguishing keywords. Require the
    # "combining" option to carry at least 2 distinct keywords itself --
    # otherwise near-duplicate options that merely share one common word
    # (e.g. four options that are all variations on the same short phrase)
    # trivially "cover" each other and produce noise unrelated to the real
    # composite-distractor pattern (option D = "both A and B").
    kw = [keywords(t) for t in texts]
    for i, text_i in enumerate(texts):
        if len(kw[i]) < 2:
            continue
        others = [j for j in range(len(texts)) if j != i and kw[j]]
        covering = [j for j in others if kw[j] and kw[j] <= kw[i]]
        if len(covering) >= 2:
            covered_texts = ', '.join(f'"{texts[j]}"' for j in covering[:2])
            findings.append(
                f"option \"{text_i}\" appears to combine the distinguishing wording of "
                f"{covered_texts} -- a student can guess this is the 'combination' answer "
                f"without verifying either half against the actual content."
            )

    return findings


def scan_file(path: str) -> list:
    """Returns list of (select_id, prompt, findings)."""
    with open(path, 'r', encoding='utf-8') as f:
        html = f.read()

    results = []
    for m in SELECT_BLOCK_RE.finditer(html):
        select_id, body = m.group(1), m.group(2)
        options = OPTION_RE.findall(body)
        prompt = find_preceding_prompt(html, m.start())
        findings = check_question(prompt, options)
        if findings:
            results.append((select_id, prompt, findings))
    return results


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

    print(f"Scanning {len(html_files)} HTML file(s) under {root} for eliminable-distractor "
          f"patterns in <select class=\"drill-select\"> questions...\n")
    print("NOTE: this is a heuristic review worklist, not a pass/fail gate -- read PURPOSE in "
          "this script's header before treating any single finding as a confirmed bug.\n")

    total_questions_flagged = 0
    total_files_with_mc = 0
    total_findings = 0

    for path in html_files:
        with open(path, 'r', encoding='utf-8') as f:
            html = f.read()
        if not SELECT_BLOCK_RE.search(html):
            continue
        total_files_with_mc += 1
        results = scan_file(path)
        if not results:
            continue
        rel = os.path.relpath(path, root)
        print(f"[REVIEW] {rel}")
        for select_id, prompt, findings in results:
            total_questions_flagged += 1
            print(f"  Question \"{select_id}\": {prompt}")
            for f_ in findings:
                total_findings += 1
                print(f"    - {f_}")
        print()

    print(f"Total: {total_files_with_mc} file(s) with multiple-choice/dropdown questions, "
          f"{total_questions_flagged} question(s) flagged for review, {total_findings} finding(s).")
    sys.exit(0)


if __name__ == '__main__':
    main()
