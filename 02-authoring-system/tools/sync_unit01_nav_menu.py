#!/usr/bin/env python3
"""Rebuild and sync the unit-wide nav menu identically across every HTML file
in Unit 01's 6 lessons, using each lesson's true current file list."""
import re
import os

ROOT = "/home/jay/FoxCS/courses/python/content/unit_01_what_is_programming"

# (folder, title, [(filename, label, kind)]) kind: html|py|txt
LESSONS = [
    ("lesson_01_01_what_programs_do", "01.1 What Programs Do", [
        ("00_table_of_contents.html", "Table of Contents", "nav"),
        ("01_instruction.html", "Instruction", "html"),
        ("02_flashcards.html", "Flashcards", "html:flashcards"),
        ("03_vocab_quiz.html", "Vocab Quiz", "html:vocab_quiz"),
        ("04_practice.html", "Practice", "html:practice"),
        ("05_project.html", "Project Instructions", "html"),
        ("06_project.py", "Project", "py"),
        ("07_mastery_check.html", "Mastery Check", "html:mastery_check"),
        ("08_mastery_check.py", "Mastery Check Answers", "py"),
        ("09_feedback.html", "Feedback", "html:feedback"),
    ]),
    ("lesson_01_02_input_process_output", "01.2 Input-Process-Output", [
        ("00_table_of_contents.html", "Table of Contents", "nav"),
        ("01_instruction.html", "Instruction", "html"),
        ("02_flashcards.html", "Flashcards", "html:flashcards"),
        ("03_vocab_quiz.html", "Vocab Quiz", "html:vocab_quiz"),
        ("04_practice.html", "Practice", "html:practice"),
        ("05_mastery_check.html", "Mastery Check", "html:mastery_check"),
        ("06_mastery_check.py", "Mastery Check Answers", "py"),
        ("07_journal.txt", "Journal", "txt"),
        ("08_feedback.html", "Feedback", "html:feedback"),
    ]),
    ("lesson_01_03_writing_your_first_program", "01.3 Writing Your First Program", [
        ("00_table_of_contents.html", "Table of Contents", "nav"),
        ("01_instruction.html", "Instruction", "html"),
        ("02_example_01.py", "Example", "py"),
        ("03_flashcards.html", "Flashcards", "html:flashcards"),
        ("04_vocab_quiz.html", "Vocab Quiz", "html:vocab_quiz"),
        ("05_practice.html", "Practice", "html:practice"),
        ("06_application.py", "Application", "py"),
        ("07_project.html", "Project Instructions", "html"),
        ("08_project.py", "Project", "py"),
        ("09_mastery_check.html", "Mastery Check", "html:mastery_check"),
        ("10_mastery_check.py", "Mastery Check Answers", "py"),
        ("11_feedback.html", "Feedback", "html:feedback"),
    ]),
    ("lesson_01_04_printing_output", "01.4 Printing Output", [
        ("00_table_of_contents.html", "Table of Contents", "nav"),
        ("01_instruction.html", "Instruction", "html"),
        ("02_example_01.py", "Example", "py"),
        ("03_flashcards.html", "Flashcards", "html:flashcards"),
        ("04_vocab_quiz.html", "Vocab Quiz", "html:vocab_quiz"),
        ("05_practice.html", "Practice", "html:practice"),
        ("06_application.py", "Application", "py"),
        ("07_project.html", "Project Instructions", "html"),
        ("08_project.py", "Project", "py"),
        ("09_mastery_check.html", "Mastery Check", "html:mastery_check"),
        ("10_mastery_check.py", "Mastery Check Answers", "py"),
        ("11_feedback.html", "Feedback", "html:feedback"),
    ]),
    ("lesson_01_05_comments_and_documentation", "01.5 Comments and Documentation", [
        ("00_table_of_contents.html", "Table of Contents", "nav"),
        ("01_instruction.html", "Instruction", "html"),
        ("02_example_01.py", "Example", "py"),
        ("03_flashcards.html", "Flashcards", "html:flashcards"),
        ("04_vocab_quiz.html", "Vocab Quiz", "html:vocab_quiz"),
        ("05_practice.html", "Practice", "html:practice"),
        ("06_project.html", "Project Instructions", "html"),
        ("07_project.py", "Project", "py"),
        ("08_mastery_check.html", "Mastery Check", "html:mastery_check"),
        ("09_mastery_check.py", "Mastery Check Answers", "py"),
        ("10_feedback.html", "Feedback", "html:feedback"),
    ]),
    ("lesson_01_06_common_syntax_mistakes", "01.6 Common Syntax Mistakes", [
        ("00_table_of_contents.html", "Table of Contents", "nav"),
        ("01_instruction.html", "Instruction", "html"),
        ("02_flashcards.html", "Flashcards", "html:flashcards"),
        ("03_vocab_quiz.html", "Vocab Quiz", "html:vocab_quiz"),
        ("04_practice.html", "Practice", "html:practice"),
        ("05_project.html", "Project Instructions", "html"),
        ("06_project.py", "Project", "py"),
        ("07_mastery_check.html", "Mastery Check", "html:mastery_check"),
        ("08_mastery_check.py", "Mastery Check Answers", "py"),
        ("09_feedback.html", "Feedback", "html:feedback"),
    ]),
]

MENU_CSS = """  .unit-menu-wrap { position: sticky; top: 0; z-index: 20; background: #fff; border: 1px solid #dde3ea; border-radius: 0 0 8px 8px; margin-bottom: 1.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
  .unit-menu-toggle { cursor: pointer; padding: 0.7rem 1.3rem; font-family: Verdana, Arial, sans-serif; font-weight: bold; color: #1a5aa8; font-size: 0.92rem; list-style: none; user-select: none; }
  .unit-menu-toggle::-webkit-details-marker { display: none; }
  .unit-menu-toggle:hover { background: #f4f6f9; }
  .unit-menu-panel { padding: 0.3rem 1.3rem 1.1rem; max-height: 60vh; overflow-y: auto; border-top: 1px solid #eef1f5; font-family: Verdana, Arial, sans-serif; }
  .unit-menu-section { margin-top: 0.9rem; }
  .unit-menu-section-label { font-size: 0.72rem; letter-spacing: 0.07em; text-transform: uppercase; font-weight: bold; color: #1a5aa8; margin-bottom: 0.3rem; }
  .unit-menu-panel a.current { font-weight: bold; color: #1a5aa8; background: #dceafc; border-radius: 4px; }
  .lesson-entry { margin: 0.15rem 0; }
  .lesson-entry summary { cursor: pointer; display: flex; align-items: center; gap: 0.5rem; padding: 0.32rem 0.2rem; border-radius: 4px; font-size: 0.9rem; color: #1a1a1a; }
  .lesson-entry summary:hover { background: #eef4fb; }
  .lesson-entry summary::-webkit-details-marker { display: none; }
  .lesson-entry summary::after { content: '▸'; color: #99a; font-size: 0.75rem; margin-left: auto; padding-left: 0.6rem; }
  .lesson-entry[open] summary::after { content: '▾'; }
  .lesson-steps { padding-left: 1.85rem; display: flex; flex-direction: column; gap: 0.1rem; margin: 0.15rem 0 0.4rem; }
  .lesson-steps a { display: flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0.2rem; color: #1a1a1a; text-decoration: none; font-size: 0.85rem; border-radius: 4px; }
  .lesson-steps a:hover { background: #eef4fb; }
  .lesson-steps a.current { font-weight: bold; color: #1a5aa8; background: #dceafc; border-radius: 4px; }
  .step-untracked { font-size: 0.72rem; color: #999; margin-left: auto; font-family: Georgia, serif; font-style: italic; }
  .done-chip { font-size: 0.68rem; padding: 0.1rem 0.5rem; border-radius: 999px; margin-left: auto; font-family: Verdana, Arial, sans-serif; font-weight: bold; background: #ddeee3; color: #1f5c47; display: none; }
  .done-chip.shown { display: inline-block; }"""


def step_link(current_folder, folder, filename, label, kind, current_file):
    href = filename if folder == current_folder else f"../{folder}/{filename}"
    is_current = (folder == current_folder and filename == current_file)
    cls = ' class="current"' if is_current else ""
    if kind == "nav":
        return f'<a href="{href}"{cls}>{label}</a>'
    if kind == "py" or kind == "txt":
        return f'<a href="{href}"{cls}>{label} <span class="step-untracked">can\'t auto-check</span></a>'
    if kind.startswith("html:"):
        step = kind.split(":", 1)[1]
        lesson_key = folder
        return f'<a href="{href}"{cls}>{label}<span class="done-chip" data-lesson="{lesson_key}" data-step="{step}"></span></a>'
    return f'<a href="{href}"{cls}>{label}</a>'


def build_menu(current_folder, current_file):
    lines = []
    lines.append('<div class="unit-menu-wrap">')
    lines.append('<details class="unit-menu">')
    lines.append('  <summary class="unit-menu-toggle">☰ Unit 01: What Is Programming?</summary>')
    lines.append('  <nav class="unit-menu-panel">')
    lines.append('    <div class="unit-menu-section">')
    lines.append('      <div class="unit-menu-section-label">Unit 01: What Is Programming?</div>')
    for folder, title, files in LESSONS:
        is_current_lesson = (folder == current_folder)
        open_attr = " open" if is_current_lesson else ""
        lines.append(f'      <details class="lesson-entry"{open_attr}>')
        lines.append(f'        <summary>{title}</summary>')
        lines.append('        <div class="lesson-steps">')
        for filename, label, kind in files:
            lines.append('          ' + step_link(current_folder, folder, filename, label, kind, current_file))
        lines.append('        </div>')
        lines.append('      </details>')
    lines.append('      <a href="../project/unit_01_project_instructions.html">Unit Project</a>')
    lines.append('    </div>')
    lines.append('  </nav>')
    lines.append('</details>')
    lines.append('</div>')
    return "\n".join(lines)


def main():
    changed = 0
    for folder, title, files in LESSONS:
        for filename, label, kind in files:
            if not filename.endswith(".html"):
                continue
            path = os.path.join(ROOT, folder, filename)
            if not os.path.exists(path):
                print(f"MISSING: {path}")
                continue
            with open(path, "r", encoding="utf-8") as f:
                text = f.read()

            new_menu = build_menu(folder, filename)

            # Replace CSS block (between the two known marker rules) if present.
            css_pattern = re.compile(
                r"  \.unit-menu-wrap \{.*?\.done-chip\.shown \{ display: inline-block; \}",
                re.DOTALL,
            )
            if css_pattern.search(text):
                text = css_pattern.sub(MENU_CSS, text, count=1)
            else:
                print(f"NO CSS MATCH: {path}")

            # Replace the menu markup block (<div class="unit-menu-wrap"> ... its matching </div>
            # right after </nav></details>) if present.
            menu_pattern = re.compile(
                r'<div class="unit-menu-wrap">.*?</details>\s*</div>',
                re.DOTALL,
            )
            if menu_pattern.search(text):
                text = menu_pattern.sub(new_menu, text, count=1)
                changed += 1
            else:
                print(f"NO MENU MARKUP MATCH: {path}")

            with open(path, "w", encoding="utf-8") as f:
                f.write(text)

    print(f"\nUpdated {changed} files")


if __name__ == "__main__":
    main()
