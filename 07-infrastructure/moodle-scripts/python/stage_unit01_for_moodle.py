#!/usr/bin/env python3
"""Stage a copy of each Unit 01 lesson folder for Moodle upload, replacing the
full unit-wide nested menu (Unit 01 toggle -> 6 collapsible lesson entries)
with a simple flat list of just the current lesson's own files. Two reasons:
1. Cross-lesson links silently resolve to the wrong content once each lesson
   is its own isolated Moodle resource (no real shared folder tree there).
2. Once each lesson is its own Moodle "tab" in the section list, the outer
   Unit-01-with-6-collapsible-lessons wrapper is redundant -- Moodle's own
   course navigation already provides that level. Per Jay's 2026-08-30
   request: a lesson's Moodle copy should show menu items for its own
   sub-items only, not the whole unit structure."""
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
CURRENT_ENTRY_RE = re.compile(
    r'<details class="lesson-entry"[^>]*>\s*<summary>([^<]*)</summary>\s*<div class="lesson-steps">(.*?)</div>\s*</details>',
    re.DOTALL,
)
CSS_BLOCK_RE = re.compile(
    r'  \.unit-menu-wrap \{.*?\.done-chip\.shown \{ display: inline-block; \}',
    re.DOTALL,
)

SIMPLE_CSS = """  .lesson-menu-wrap { position: sticky; top: 0; z-index: 20; background: #fff; border: 1px solid #dde3ea; border-radius: 0 0 8px 8px; margin-bottom: 1.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.08); padding: 0.6rem 1.3rem; font-family: Verdana, Arial, sans-serif; }
  .lesson-menu-title { font-size: 0.72rem; letter-spacing: 0.07em; text-transform: uppercase; font-weight: bold; color: #1a5aa8; margin-bottom: 0.4rem; }
  .lesson-menu-links { display: flex; flex-wrap: wrap; gap: 0.3rem 0.8rem; }
  .lesson-menu-links a { display: flex; align-items: center; gap: 0.4rem; color: #1a1a1a; text-decoration: none; font-size: 0.85rem; padding: 0.2rem 0.4rem; border-radius: 4px; }
  .lesson-menu-links a:hover { background: #eef4fb; }
  .lesson-menu-links a.current { font-weight: bold; color: #1a5aa8; background: #dceafc; }
  .step-untracked { font-size: 0.72rem; color: #999; font-family: Georgia, serif; font-style: italic; }
  .done-chip { font-size: 0.68rem; padding: 0.1rem 0.5rem; border-radius: 999px; font-weight: bold; background: #ddeee3; color: #1f5c47; display: none; }
  .done-chip.shown { display: inline-block; }"""


def simplify_menu(text, current_folder):
    css_m = CSS_BLOCK_RE.search(text)
    if css_m:
        text = text[:css_m.start()] + SIMPLE_CSS + text[css_m.end():]

    m = MENU_BLOCK_RE.search(text)
    if not m:
        return text, False
    block = m.group(0)

    # Find the entry that is THIS lesson's own (its links don't start with "../").
    current_title, current_steps = None, None
    for entry_m in CURRENT_ENTRY_RE.finditer(block):
        title, steps = entry_m.group(1), entry_m.group(2)
        if 'href="../' not in steps:
            current_title, current_steps = title, steps
            break

    if current_title is None:
        return text, False

    new_block = (
        '<div class="lesson-menu-wrap">\n'
        f'  <div class="lesson-menu-title">{current_title}</div>\n'
        f'  <div class="lesson-menu-links">{current_steps.strip()}</div>\n'
        '</div>'
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
            new_text, changed = simplify_menu(text, folder)
            if changed:
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_text)
            else:
                print(f"WARNING: no menu simplified in {path}")
        print(f"Staged {folder}")

    print(f"\nDone. Staged at {DST_ROOT}")


if __name__ == "__main__":
    main()
