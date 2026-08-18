# Canonical Lesson Schema

One canonical record per lesson is the single source of truth. Everything else — Moodle content, the VS Code student folder, teacher guides, rubrics, grader config, spreadsheet records, feedback templates — is generated or derived from this record, so nothing has to be hand-maintained in four different places.

**Terminology:** FoxCS calls the top-level curriculum grouping a **Unit** (`unit_id`, e.g. `unit_01`) rather than "Module" — reads more naturally for a high school audience. This applies across every FoxCS course. It does not change any source curriculum FoxCS adapts from (e.g. `adaptive-python` keeps calling them Modules) — only FoxCS's own records use "Unit."

## Two-Surface Model

Every lesson has content on both surfaces, and the record makes the split explicit:

- **Moodle** — video/instructional content, H5P interactive practice (drag-drop, vocabulary, guided practice with instant feedback), light adaptive support (reinforce/extend), optional extra-credit engagement for extra XP. This is where lower/varied DOK levels get covered — recall, understanding, guided application — before the student ever opens VS Code. Moodle also carries the **handoff instructions** that send the student into VS Code with an explicit task ("Open `example_01.py`. Add a print statement that...").
- **VS Code** — the applied/creative coding work. Higher DOK, more open-ended, where typing real code becomes second nature. Includes embedded reflection (graded, checked for genuine completion, not skippable) and a project/practice folder submitted **in Moodle** (Google Classroom is announcements/pointers only — see `../CLAUDE.md`). File-naming-convention compliance is itself a graded line item here. Every VS Code handoff instruction includes a reminder to save — see `vscode-content-conventions.md`.

A lesson should deliberately span a *range* of DOK levels across the two surfaces, not cluster all the "easy" DOK on Moodle and all the "hard" DOK in VS Code — some conceptual depth belongs in the reflection prompts, some straightforward application can be a warm-up VS Code file.

## Schema

```yaml
lesson_id: lesson_01_01_first_python_output
unit_id: unit_01
lesson_number: "01.01"
title: First Python Output

overview: >
  Students learn how Python displays information and use print()
  to create their first output.

objectives_visible_to_student: true    # always true — shown as a "What you'll learn" block before content starts

objectives:
  - Use print() to display text.
  - Identify a string literal.
  - Run a Python file using VS Code.
  - Correct common print syntax errors.

language_objectives:
  - Use the terms "output," "print," and "string" correctly in your own explanation.

skills:              # the individually-tracked, proficiency-scored units — see objectives-and-skills-proficiency.md
  - skill_id: uses_print
    description: Uses print() correctly to display text.
  - skill_id: identifies_string_literal
    description: Identifies a string literal and explains why the quotes aren't part of the output.

gmetrix_source: null   # set to the GMetrix domain/file reference if this lesson is GMetrix-derived — see vscode-content-conventions.md

prerequisites:
  - Open a folder in VS Code.
  - Locate a file in the Explorer panel.
  - Save a file.

vocabulary:
  - output
  - print
  - string
  - syntax

dok_levels_covered:
  1: [moodle_vocabulary, moodle_guided_practice]
  2: [moodle_h5p_drag_drop, vscode_examples]
  3: [vscode_core_practice, vscode_reflection]
  4: [vscode_extend_practice]     # omit if this lesson doesn't reach DOK 4

moodle:
  video: content/lesson_01_01_intro.mp4          # placeholder path, not yet produced
  h5p_activities:
    - type: vocabulary_match
      terms: [output, print, string, syntax]
    - type: drag_drop
      prompt: Put these lines of code in the order that produces the shown output.
  guided_practice: Walk through predicting output for three print() examples together.
  adaptive_support:
    reinforce: Extra worked examples + a simpler drag-drop set, surfaced if guided practice signals struggle.
    extend: A slightly trickier "predict the output" set, surfaced on strong guided-practice performance.
  extra_credit_xp:
    - activity: Complete the optional "common print errors" H5P set
      xp: 10
  handoff_instructions: >
    Open example_01.py in your lesson_01_01 folder. Read the comments at the top,
    then follow the instructions in practice/core/practice_01.py.

vscode:
  folder_ref: courses/python/content/lesson_01_01_first_python_output/   # generated student folder lives under the course, not here
  instruction:
    - content/introduction.md
  examples:
    - examples/example_01.py
    - examples/example_02.py
  practice:
    reinforce: [practice/reinforce/practice_01.py]
    core: [practice/core/practice_01.py, practice/core/practice_02.py]
    extend: [practice/extend/challenge_01.py]
  project: project/codename_message.py
  reflection:
    prompts:
      - Explain what print() does, in your own words.
      - Describe one error you fixed and how you found it.
    graded: true
    skip_check_required: true     # grader must flag empty/placeholder reflections, not just "field present"
  file_naming_convention: fixed   # see the 2026-08-04 note below — students don't self-name with a codename anymore

grading:
  total_points: 15
  rubric: rubrics/lesson_01_01.yaml      # each criterion in here should reference a skill_id above
  tests: tests/lesson_01_01_tests.yaml
  human_review_rules: config/review_rules.yaml

xp:
  reflection: 10
  revision: 15
  challenge: 20
  project_tier_1: 10     # added 2026-08-06 — bonus tier on the project/application step's checklist, see mvp-unit-folder-structure.md's Tiered Project XP section
  project_tier_2: 20     # stacks on top of tier_1, not instead of it
  vocab_quiz: 10          # added 2026-08-06 — completing the drag-to-match vocab quiz (all terms correct required to save), see mvp-unit-folder-structure.md's Vocab Quiz section

feedback:
  template: feedback/lesson_01_01.md

feedback_collection:   # meta-feedback about the course itself, not the student's grade — see feedback-collection.md
  include: true         # revised 2026-08-06 — now every lesson gets one (NN_feedback.html), not just larger checkpoints
  time_budget_minutes: 3

next_steps:
  mastery: lesson_01_02_strings_and_messages
  reinforce: lesson_01_01_reinforce
  reassess: lesson_01_01_reassessment
  extend: lesson_01_01_extension
```

## MVP Delivery Mapping (2026-08-04, while Moodle is paused)

The schema above is unchanged — only the delivery surface for the `moodle:` block's content is different right now. See `mvp-unit-folder-structure.md` for the full folder layout; this table is just the field-to-file mapping:

| `moodle:` field | MVP folder equivalent |
|---|---|
| `video`, `h5p_activities`, `guided_practice` | Baked directly into `content/lesson_XX_YY_instruction.html` |
| `adaptive_support.reinforce` / `.extend` | Unchanged — still `vscode.practice.reinforce` / `.extend`, just self-navigated (see `mvp-unit-folder-structure.md`'s Ladder section) instead of live-routed |
| `extra_credit_xp` | Optional section within `content/lesson_XX_YY_instruction.html`, or skip for a given lesson — not required for the MVP |
| `handoff_instructions` | Closing section of `content/lesson_XX_YY_instruction.html` — same explicit "Open file X, do Y, remember to save" requirement from `vscode-content-conventions.md` |

`vscode:` fields (`examples`, `practice`, `project`, `reflection`, `file_naming_convention`) need no mapping — they were already folder-native.

## Notes

- `dok_levels_covered` and the Moodle/VS Code split are new relative to the original handoff draft — added to reflect the actual two-surface plan (see `../decisions-log.md`). The rubric behind the DOK numbers (what 1-4 actually mean, with Python examples) lives in `content-authoring-standards.md`.
- Practice sets are still Reinforce/Core/Extend folders of files (not live per-question branching) — this superseded the earlier Moodle Lesson-branching design (`../open-questions.md` has the full history if that needs revisiting).
- **Students no longer self-name files with a codename, reversed 2026-08-04.** Every file in the distributed folder has a fixed, predictable name (e.g. `unit_01_project.py`, `unit_01_journal.txt`) — students edit and save the provided file, they never construct a codename-prefixed filename themselves. Jay's codename-swap script (`01-privacy-and-governance/codename-policy.md`'s "Tooling Needed" section) renames files and strips real names *after* collection, working from whatever real-identity metadata Google Classroom's submission already carries, before anything reaches Claude Code for analysis. This removed the old `file_naming_points` rubric line — there's no self-naming task left for a student to get right or wrong, so it's no longer a graded line item. See `vscode-content-conventions.md` and `mvp-unit-folder-structure.md` for the full convention this replaced.
- `skills` was added 2026-07-24 — see `objectives-and-skills-proficiency.md` for the full model (proficiency scale, evidence sources, "keep practicing"/"strong here" tips).
- `feedback_collection` was added 2026-07-24 — see `feedback-collection.md`. This is course-usefulness data, kept in its own dashboard lane, never merged with academic grading data.
- `gmetrix_source` was added 2026-07-24 to support content traceability — see `../01-privacy-and-governance/licensing-boundaries.md`.
