#!/usr/bin/env python3
"""check_mastery_check_completeness.py

PURPOSE
  Static checker for content-authoring completeness of a lesson's mastery
  check, built in direct response to `authoring-flow-gaps-2026-08-11.md`'s
  gap #9 ("Mastery-check answer key existence is unverified" -- flagged as
  something nobody had actually checked, only assumed). Also enforces two
  other rules that already exist only in prose: `mastery-check-standards.md`'s
  "FoxCS default: 3-5 items per lesson mastery check," and
  `content-authoring-standards.md`'s misconception -> recovery pairing rule
  ("a code with no paired resource is a dead end, not a placeholder to fill
  in later"). Modeled on `python-app`'s own `content-qa.test.ts` (a full-course
  structural sweep over every question/hint/test-case) -- FoxCS has no
  structured per-question JSON to sweep the same way, so this checks the
  real static-file convention FoxCS actually uses instead (student-facing
  HTML/py in `courses/<course>/content/`, a teacher-only answer key in
  `courses/<course>/teacher-materials/`).

WHAT IT CHECKS
  For every lesson directory found under the content root (any directory
  whose name matches `lesson_\\d+_\\d+...`):

  1. ANSWER KEY EXISTS
     If the lesson has any `*mastery_check*.html` or `*mastery_check*.py`
     file, a matching `<unit>/<lesson prefix>_mastery_check_KEY.md` file
     must exist under the sibling `teacher-materials/` directory (the exact
     convention already used by Unit 01's six real KEY files). Missing is a
     hard ERROR -- this is the concrete gap #9 was named for.

  2. ANSWER KEY NEVER LEAKS INTO STUDENT CONTENT
     No file inside the lesson's own `content/` directory may have "KEY" in
     its name (case-insensitive) -- the KEY file's own header is explicit
     ("Never include this file in the folder distributed to students").
     Finding one is a hard ERROR, not a style note -- this is an academic-
     integrity leak, not a formatting issue.

  3. ITEM COUNT IN RANGE (soft check)
     If a KEY file exists, its numbered items (`**N. (DOK ...`, the exact
     convention every real KEY file in this repo uses) are counted. Fewer
     than 3 or more than 5 is a WARNING against `mastery-check-standards.md`'s
     stated default -- not an ERROR, since that doc itself allows deviation
     with reason.

  4. MISCONCEPTION CODES HAVE PAIRED RECOVERY TEXT
     Every `` `CODE-NN` `` token found in a KEY file must be followed by real
     explanatory text (not just a bare mention) before the next code or the
     end of the section -- `content-authoring-standards.md`'s "a code with
     no paired resource is a dead end" rule. A code with little or no
     trailing text is a hard ERROR.

LIMITATIONS
  Pattern-matching against this repo's own established KEY-file convention
  (Unit 01's six real files), not a formal schema. A lesson authored in a
  materially different shape may not be detected at all, or may be
  over/under-flagged -- treat findings as a worklist, same caveat as this
  repo's other static checkers.

USAGE
  python3 check_mastery_check_completeness.py [course_root]
  (course_root defaults to courses/python -- the only course with real
  content as of 2026-09.)

EXAMPLE
  python3 check_mastery_check_completeness.py
  python3 check_mastery_check_completeness.py /home/jay/FoxCS/courses/python

EXIT CODE
  0 if no ERRORs were found (WARNINGs don't fail the run).
  1 if at least one ERROR was found.
"""
import os
import re
import sys

DEFAULT_COURSE_ROOT = "/home/jay/FoxCS/courses/python"

LESSON_DIR_RE = re.compile(r'^lesson_(\d+)_(\d+)')
KEY_ITEM_RE = re.compile(r'^\*\*(\d+)\.\s*\(DOK', re.MULTILINE)
MISCONCEPTION_CODE_RE = re.compile(r'`(CODE-\d+)`')

MIN_ITEMS = 3
MAX_ITEMS = 5
MIN_RECOVERY_TEXT_CHARS = 15


def find_lesson_dirs(content_root: str):
    """Return a sorted list of (unit_dir_name, lesson_dir_name, full_path)
    for every directory under content_root whose name matches the
    lesson_NN_MM... convention."""
    results = []
    for dirpath, dirnames, _ in os.walk(content_root):
        for d in dirnames:
            if LESSON_DIR_RE.match(d):
                unit_dir = os.path.basename(dirpath)
                results.append((unit_dir, d, os.path.join(dirpath, d)))
    results.sort(key=lambda r: (r[0], r[1]))
    return results


def has_mastery_check(lesson_path: str) -> bool:
    for fn in os.listdir(lesson_path):
        low = fn.lower()
        if 'mastery_check' in low and (low.endswith('.html') or low.endswith('.py')):
            return True
    return False


def key_filename_prefix(lesson_dir_name: str):
    """'lesson_01_04_printing_output' -> 'lesson_01_04', matching the real
    convention used by every existing KEY file. Returns None if the lesson
    dir name doesn't match the expected numbering convention at all."""
    m = LESSON_DIR_RE.match(lesson_dir_name)
    if not m:
        return None
    return f"lesson_{m.group(1)}_{m.group(2)}"


def expected_key_path(course_root: str, unit_dir: str, lesson_dir_name: str):
    prefix = key_filename_prefix(lesson_dir_name)
    if prefix is None:
        return None
    return os.path.join(
        course_root, 'teacher-materials', unit_dir, f'{prefix}_mastery_check_KEY.md'
    )


def find_leaked_key_files(lesson_path: str):
    return [fn for fn in os.listdir(lesson_path) if 'key' in fn.lower()]


def check_item_count(key_text: str):
    """Return (count, warning_or_None)."""
    count = len(KEY_ITEM_RE.findall(key_text))
    if count == 0:
        return count, None  # doesn't match the numbered convention at all -- not this check's job to flag
    if count < MIN_ITEMS or count > MAX_ITEMS:
        return count, (
            f"has {count} numbered item(s), outside the {MIN_ITEMS}-{MAX_ITEMS} default range "
            f"in mastery-check-standards.md -- fine if intentional, otherwise reconsider scope."
        )
    return count, None


def check_misconception_pairing(key_text: str):
    """Return a list of error strings, one per CODE-NN token with no real
    trailing explanation before the next code or end of text."""
    errors = []
    matches = list(MISCONCEPTION_CODE_RE.finditer(key_text))
    for i, m in enumerate(matches):
        start = m.end()
        end = matches[i + 1].start() if i + 1 < len(matches) else len(key_text)
        trailing = key_text[start:end].strip(" .\n\t")
        if len(trailing) < MIN_RECOVERY_TEXT_CHARS:
            errors.append(
                f"misconception code {m.group(1)} has no real paired explanation/recovery text "
                f"(found {len(trailing)} char(s) before the next code or end of section) -- "
                f"content-authoring-standards.md: 'a code with no paired resource is a dead end.'"
            )
    return errors


def check_lesson(course_root: str, unit_dir: str, lesson_dir_name: str, lesson_path: str):
    """Return {'errors': [...], 'warnings': [...]} for one lesson."""
    errors = []
    warnings = []

    leaked = find_leaked_key_files(lesson_path)
    if leaked:
        errors.append(
            f"{unit_dir}/{lesson_dir_name}: answer-key-looking file(s) found inside the "
            f"student-facing content folder: {', '.join(leaked)} -- must live only under "
            f"teacher-materials/, never in the distributed student folder."
        )

    if not has_mastery_check(lesson_path):
        return {'errors': errors, 'warnings': warnings}

    key_path = expected_key_path(course_root, unit_dir, lesson_dir_name)
    if key_path is None:
        errors.append(
            f"{unit_dir}/{lesson_dir_name}: has a mastery check but its directory name doesn't "
            f"match the lesson_NN_MM naming convention, so the expected KEY path can't be derived."
        )
        return {'errors': errors, 'warnings': warnings}

    if not os.path.isfile(key_path):
        errors.append(
            f"{unit_dir}/{lesson_dir_name}: has a mastery check but no answer key found at "
            f"expected path {key_path} (authoring-flow-gaps-2026-08-11.md gap #9)."
        )
        return {'errors': errors, 'warnings': warnings}

    with open(key_path, 'r', encoding='utf-8') as f:
        key_text = f.read()

    _, warning = check_item_count(key_text)
    if warning:
        warnings.append(f"{unit_dir}/{lesson_dir_name}: {warning}")

    for err in check_misconception_pairing(key_text):
        errors.append(f"{unit_dir}/{lesson_dir_name}: {err}")

    return {'errors': errors, 'warnings': warnings}


def main():
    course_root = sys.argv[1] if len(sys.argv) > 1 else DEFAULT_COURSE_ROOT
    content_root = os.path.join(course_root, 'content')
    if not os.path.isdir(content_root):
        print(f"Not a directory: {content_root}", file=sys.stderr)
        sys.exit(1)

    lessons = find_lesson_dirs(content_root)
    print(f"Checking {len(lessons)} lesson director(y/ies) under {content_root}...\n")

    total_errors = 0
    total_warnings = 0
    for unit_dir, lesson_dir_name, lesson_path in lessons:
        result = check_lesson(course_root, unit_dir, lesson_dir_name, lesson_path)
        if not result['errors'] and not result['warnings']:
            print(f"[PASS] {unit_dir}/{lesson_dir_name}")
            continue
        for e in result['errors']:
            total_errors += 1
            print(f"[ERROR] {e}")
        for w in result['warnings']:
            total_warnings += 1
            print(f"[WARN]  {w}")

    print(f"\nTotal: {len(lessons)} lesson(s) checked, {total_errors} error(s), "
          f"{total_warnings} warning(s).")
    sys.exit(1 if total_errors else 0)


if __name__ == '__main__':
    main()
