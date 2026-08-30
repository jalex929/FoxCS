#!/usr/bin/env python3
"""Stage a copy of each Unit 01 lesson folder for Moodle upload, stripping
cross-lesson nav-menu entries (which silently resolve to the wrong content
when each lesson becomes its own isolated Moodle resource) while keeping
the current lesson's own file-to-file navigation intact."""
import re
import os
import shutil

SRC_ROOT = "/home/jay/FoxCS/courses/python/content/unit_01_what_is_programming"
DST_ROOT = "/tmp/python-src-moodle"

LESSON_FOLDERS = [
    "lesson_01_01_what_programs_do",
    "lesson_01_02_input_process_output",
    "lesson_01_03_writing_your_first_program",
    "lesson_01_04_printing_output",
    "lesson_01_05_comments_and_documentation",
    "lesson_01_06_common_syntax_mistakes",
]

MENU_BLOCK_RE = re.compile(r'<div class="unit-menu-wrap">.*?</details>\s*</div>', re.DOTALL)
LESSON_ENTRY_RE = re.compile(r'      <details class="lesson-entry"[^>]*>.*?</details>\n', re.DOTALL)
UNIT_PROJECT_LINK_RE = re.compile(r'      <a href="\.\./project/unit_01_project_instructions\.html">Unit Project</a>\n')


def strip_cross_lesson_entries(text, current_folder):
    m = MENU_BLOCK_RE.search(text)
    if not m:
        return text, False
    block = m.group(0)

    def keep_only_current(entry_match):
        entry = entry_match.group(0)
        if f'data-lesson="{current_folder}"' in entry or (
            current_folder not in entry and 'href="00_' in entry
        ):
            return entry
        return ""

    # Simpler: find each lesson-entry, keep it only if its internal hrefs are
    # same-folder (start with a numbered file, not "../").
    def entry_filter(match):
        entry = match.group(0)
        if 'href="../' in entry:
            return ""  # cross-lesson entry, drop it
        return entry

    new_block = LESSON_ENTRY_RE.sub(entry_filter, block)
    new_block = UNIT_PROJECT_LINK_RE.sub(
        '      <a href="../project/unit_01_project_instructions.html">Unit Project (see Moodle course page)</a>\n',
        new_block,
    )
    new_text = text[:m.start()] + new_block + text[m.end():]
    return new_text, True


def main():
    if os.path.exists(DST_ROOT):
        shutil.rmtree(DST_ROOT)
    os.makedirs(DST_ROOT)

    for folder in LESSON_FOLDERS:
        src = os.path.join(SRC_ROOT, folder)
        dst = os.path.join(DST_ROOT, folder)
        shutil.copytree(src, dst)
        for fn in os.listdir(dst):
            if not fn.endswith(".html"):
                continue
            path = os.path.join(dst, fn)
            with open(path, "r", encoding="utf-8") as f:
                text = f.read()
            new_text, changed = strip_cross_lesson_entries(text, folder)
            if changed:
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_text)
        print(f"Staged {folder}")

    print(f"\nDone. Staged at {DST_ROOT}")


if __name__ == "__main__":
    main()
