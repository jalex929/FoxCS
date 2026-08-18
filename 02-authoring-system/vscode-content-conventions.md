# VS Code Content Conventions

Recurring rules that apply across every lesson's VS Code-side content, so they're defined once instead of re-decided per lesson.

## Always Remind Students to Save

**Every** page/instruction that sends a student to complete work in VS Code — whether it's regular course content or GMetrix content — must include an explicit reminder to save the file. This is non-negotiable, not a nice-to-have: saving is not yet second nature for most students at this stage, and a lost unsaved submission is a bad failure mode for both the student and the grading pipeline.

Standard phrasing (adjust to fit context, keep the substance):

> Don't forget to save your file (Ctrl+S) before you're done.

This belongs in the handoff instructions block (`lesson-schema.md` → `moodle.handoff_instructions`) and again at the end of any multi-step VS Code task, not just once at the top.

## GMetrix File Naming

Any file derived from or supporting GMetrix/Certiport content (see `../01-privacy-and-governance/licensing-boundaries.md`) is prefixed `GMETRIX-`, preserving the original GMetrix filename after the prefix:

```
GMETRIX-114-boolean.py
GMETRIX-211-if.py
```

This keeps GMetrix-derived files visually distinct and alphabetically grouped together within a lesson folder, separate from regular course-authored files.

## Workbook Content Gets Recreated, Not Attached

The GMetrix student workbook (`FoxCS/Python_v2_Student_Workbook.pdf`) should not be handed to students as a raw PDF to manage alongside everything else. Recreate its instructional content as H5P components and other lesson-native formats (per `lesson-schema.md`'s Moodle content block), the same as any other lesson. This is about reducing the number of places students have to manage content, not about the workbook being lower quality — the underlying GMetrix material and domain structure stays intact, just delivered through the same surfaces as the rest of the course.

GMetrix support files are organized by domain (`Domain 1` through `Domain 6`, found in `FoxCS/Python v2 Support Files/`), each with a `Student/` folder of numbered `.py` files (e.g. `114-boolean.py`, `211-if.py`). Domain-to-unit mapping is done — see the "GMetrix Domain Mapping" section at the bottom of `../courses/python/course-plan.md`. The fit is imperfect in places (a few units have no GMetrix tie-in at all); that's expected, not a sign something's wrong.

## File Naming Convention (Regular Course Content)

**Superseded 2026-08-04 — students no longer self-name with a codename.** Previously: `{codename}_lesson_XX_YY.py`, a graded line item. Now: every file ships with a fixed, predictable name (e.g. `unit_01_project.py`, `unit_01_journal.txt`); students edit and save the provided file directly, they never construct a filename themselves. The whole lesson folder is submitted via Google Classroom (already tied to the student's real Classroom identity), and Jay's codename-swap script (`../01-privacy-and-governance/codename-policy.md`'s "Tooling Needed" section) renames files and strips real names *after* collection, before anything reaches Claude Code for analysis. There's no longer a self-naming task for a rubric to grade — don't reintroduce a `file_naming_points` line for a future lesson.

## MVP Folder Naming (added 2026-08-04)

The unit/lesson folder structure and the instructional/mastery-check files that used to live in Moodle are documented in `mvp-unit-folder-structure.md` — the naming table there is the canonical reference, including the numbered-folder convention (`1_content/`, `2_examples/`, `3_flashcards/`, `4_practice/`, `5_mastery_check/`, `6_journal/`) that makes completion order visible directly in the file browser, not just stated in the instructional text. Two rules worth calling out here since they're easy to get wrong:

- Mastery-check answer keys (`lesson_XX_YY_mastery_check_KEY.md`) are never included in the folder actually distributed to students — only in the authoring source.
- The practice-ladder self-check key, where a lesson still has one, is the opposite — it's *meant* to be visible to students, since there's no live engine to check their work for them.

## Provide an Editable File, Not a Blank Page (added 2026-08-04)

Per Jay: wherever a student needs to write something (a reflection, a journal entry, a project), give them an actual file already sitting in the folder with the prompt/rubric/instructions built into it as text, ready to open and edit directly. Don't show them a read-only instructions page and expect them to separately create a new file from scratch — that's an avoidable barrier, especially for students who aren't yet comfortable with file management. Concretely: the journal is a single `.txt` file with the prompt, rubric, and academic-integrity notice already written at the top, followed by a clear "write your answer below this line" marker — not a webpage that tells them to go create their own text file. The project starter file follows the same principle already (a real `.py` file with a starting comment, not a blank prompt to build from). Apply this to any future writing task before defaulting to "here's an HTML page describing what to do."
