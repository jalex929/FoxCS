# FoxCS: Python

## Scope

Course name: **FoxCS: Python**. First of the FoxCS course line (Web Dev and Unity planned later, as sibling folders under `FoxCS/courses/`).

Unit/lesson skeleton is pulled from `adaptive-python`'s `Curriculum_Python Fundamentals.md` — 21 modules there (called Units 00-20 in FoxCS, since it reads more naturally for a high school audience — see the terminology note in `course-plan.md`), full breakdown in `course-plan.md`. A lot of content will be *adapted* from what's already built in `adaptive-python` (`curriculum/questions/`, `curriculum/projects/`, `curriculum/json/`) rather than written from scratch — see the Reuse Notes at the bottom of `course-plan.md`.

See `../../CLAUDE.md` (parent `FoxCS/`) for platform-level decisions that apply to every FoxCS course: the two-surface delivery model (Moodle conceptual layer + VS Code applied layer), privacy/codename policy, authoring schema, and the 1-hour/week grading constraint. This file is scoped to what's specific to the Python course.

## Status

No lesson content authored yet. Ready to start on the first test lesson — structure, schema, and workflow are locked in as of 2026-07-24 (see `../../decisions-log.md`).

## Content Model

- **As of 2026-08-04, Moodle is paused platform-wide** — see `../../CLAUDE.md`'s Status section. Every lesson is still authored once as a canonical record (`../../templates/lesson-template.md`, schema in `../../02-authoring-system/lesson-schema.md`), but the `moodle:` block's content now lands in a folder-native instructional HTML page per `../../02-authoring-system/mvp-unit-folder-structure.md`, not in Moodle. `vscode:` fields (examples, Reinforce/Core/Extend practice, project, reflection, file naming) are unchanged.
- Practice volume is intentionally lighter than `adaptive-python`'s 75-180-question-per-lesson schema — a handful of files per Reinforce/Core/Extend lane, not an exhaustive question bank. Most instructional time is meant to go to hands-on coding and mini-projects, not quiz volume.
- **Game design / UX / journal thread (added 2026-08-04):** every unit in `course-plan.md` carries a Game/UX tie-in and a year-long, iteratively-building journal-writing prompt (50-75 words in Unit 00, growing to a ~2-page design-document paper by the Unit 20 capstone), organized around the MDA framework (Mechanics/Dynamics/Aesthetics) and a lighter usability/HCD throughline. Full rationale, the word-count progression schedule, and the Game Maker's Toolkit video-analysis tie-in points are in `course-plan.md`'s "Game Design, UX, and Journal Threads" section — read that before authoring any unit's journal content.

## Open Questions

- How much of each adaptive-python module's existing question bank is directly reusable vs. needs a rewrite for this lighter, two-surface format
- Where mini-project prompts come from — adapt `adaptive-python`'s `curriculum/projects/project_module_XX.tsv`, or write new ones suited to a classroom (group-friendly, presentable, demoable)
- Which lesson to build first as the pilot test lesson — likely early Unit 00/01 given both source docs' own "first pilot unit" sketch (course orientation → VS Code basics → print() → first small project), but not yet picked against `course-plan.md`
- Grading weights/thresholds for this course specifically (see `../../templates/grading-rubric-template.md` — unfilled)

Platform-wide open questions (submission cadence, codename format finalization, etc.) live in `../../open-questions.md`.
