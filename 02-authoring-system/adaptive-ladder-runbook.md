# Adaptive Ladder Runbook: Building the Next Skill Cluster

**Added 2026-08-31.** A practical "how to build the next one" guide, written the same night the first real cluster went live, so Jay can keep authoring without re-deriving tonight's work. This is the *doing* doc — for the *policy* (why Core/Reinforce/Extend, pool size, density rules), see `objectives-and-skills-proficiency.md`. For the *manual click-by-click* version (no script), see `moodle-lesson-ladder-setup.md`. This doc is the fast path: copy a working script, change the content, run a checker.

## What happened tonight, in one paragraph

Following `pipeline-comparison-python-app-2026-08-31.md`'s 5 recommendations, this session ran 5 parallel/sequenced Claude Code subagents: (A) doc-process fixes, (B) reconciled two stale docs that assumed Moodle was still paused and that H5P BranchingScenario (not Moodle's native Lesson activity) was the branching mechanism, (C) built automated checker scripts, and (D1/D2) built the first two real adaptive clusters — one in Python (heavy/CS-pathway density), one in Seminar III (light/selective density). D1 (Python) is done and verified; D2 (Seminar III) was still finishing as this doc was written — check `worklog.md`'s latest entry for its final result before assuming its section/naming details below are current.

## The settled design (don't re-derive)

- **Mechanism: Moodle's native Lesson activity (`mod_lesson`)**, not H5P BranchingScenario, not a custom JS engine. Core question → wrong jumps to Reinforce, right jumps to Extend. Reinforce/Extend loop within their own lane (sticky endpoints, never a 4th level).
- **Pool size: Core 1, Reinforce 1-2, Extend 1-2** items per skill (`objectives-and-skills-proficiency.md`).
- **Reinforce decomposes** — a smaller/more scaffolded step (fewer moving parts), not just an easier version of the same question.
- **Extend adds context, not scaffolding** — a genuine richer/stretch scenario, no restated basics, since the student already showed Core competency.
- **Density**: CS pathways (Game I/II, Web Dev, Software Dev) get a full cluster for every trackable skill, every lesson. Seminar III gets a cluster only where there's a real, likely intervention need — typically 0-1 per lesson, not forced.
- **Never show students the words "Reinforce," "Core," or "Extend"** — internal routing only.
- **Answers must save server-side in Moodle itself** (never a local file save) and **students must be able to review their own past attempt.**

## Information architecture — where a new cluster actually goes

Moodle has no true nested folders — a course is a flat list of Sections, each holding a flat list of Activities. Both FoxCS courses already solve "Unit/Lesson hierarchy" by folding the sub-level into the container + the activity name, not real nesting. Verified directly against the live DB, not assumed:

**Python (and by extension Game I/II, Web Dev, Software Dev, once they exist):** one Moodle **Section per Unit** (e.g. Section 2 = "Unit 01: What Is Programming?"). Inside it, every lesson's 4 modules are separate activities sharing the `"NN.M <Lesson Title> (<Type>)"` name — e.g. `01.1 What Programs Do (Instruction)`, and now `01.1 What Programs Do (Practice)`. A new cluster for lesson `01.2` goes in the **same Unit 01 section**, named `01.2 <that lesson's title> (Practice)`.

**Seminar III:** one Moodle **Section per Lesson** (no Unit grouping at all — e.g. Section 2 = "Lesson 1: Academic Problem-Solving"). Inside it, activities use `"N.M -- Title"` (double-hyphen, spaces around it) — e.g. `1.13 -- ACT Math Baseline`. A new cluster goes in that Lesson's own section, named with the next free `M` in sequence (check the section's current max `M` first — don't assume it hasn't grown).

**Before building into either pattern, always check the live section/activity list directly** (a 5-line PHP script against `course_sections`/`course_modules`, same pattern as tonight's IA check) rather than assume the last-known layout — sections get reorganized (see `worklog.md`'s several "renamed/consolidated" entries this month).

## How to actually build one (fast path)

1. **Copy the reference script**: `07-infrastructure/moodle-scripts/build-lesson-01-01-practice-ladder.php`. It's heavily commented — read the whole header before changing anything, it explains every non-obvious setting below.
2. **Ground the skill in what's actually taught.** Don't invent content or reuse a schema's placeholder example — pull the real Instruction content for the target lesson (extract the live H5P package from moodledata by contenthash, or read the source file under `courses/<course>/content/`) and pick a skill that's a genuine "more than one way to go wrong" candidate, per `adaptive-practice-model.md`'s own test.
3. **Write Core/Reinforce/Extend content** per the rules above. Each wrong Core answer should map to a *distinct* real misconception, not one generic "wrong."
4. **Set these exact Lesson settings** (verified against `mod/lesson`'s own source this session, not guessed):
   - `custom = 1` — REQUIRED. Moodle's default "simple" scoring judges correctness by whether a jump target is physically later in the page sequence, which misclassifies a wrong-but-forward-jumping answer (like Core→Reinforce) as correct. Custom scoring uses each answer's own explicit score instead.
   - `retake = 0`, `modattempts = 1` — gives a read-only "review your past attempt" view after a student's first pass, satisfying the "students can go back to it" requirement.
   - `displayleft = 0` — hides the sidebar nav, which would otherwise list page titles (including "Reinforce"/"Extend" if they're in a page name) to the student.
   - A `grade_items` row in the same gradebook category as the lesson's existing Instruction/Mastery Check items, `grademax = 100` — matches the pattern already used by the Quiz.
5. **Run the checker**: `php 02-authoring-system/tools/check-lesson-ladder-wiring.php --cmid=<your cmid> --pool-cap=2` (the `--pool-cap` should match whatever's current in `objectives-and-skills-proficiency.md` — 2 as of tonight). Fix anything it flags before considering it done. Zero errors, zero warnings is the bar.
6. **Verify against the live DB directly**, not just the script's own "success" output — query `mdl_lesson`, `mdl_lesson_pages`, `mdl_lesson_answers`, `mdl_grade_items` yourself. This session's own repeated lesson: a script reporting success and the database actually reflecting it are two different claims: check both.

## Known open item, not yet resolved

Moodle's Lesson renderer puts the current page's title into the browser tab (`course: activity: page title`), even with `displayleft=0` hiding the sidebar. If a page is literally named "01.1 Reinforce 1," that word is technically visible in the tab title — a minor, real tension with "never show students the tier names." Not fixed yet. Worth deciding: rename pages to tier-neutral titles (e.g. "01.1 Practice B" instead of "01.1 Reinforce 1") the next time a cluster gets built, and retrofit tonight's Python cluster to match once a naming convention is chosen.

## Reference implementation to copy from

`build-lesson-01-01-practice-ladder.php`'s own header comment documents the full worked example end-to-end (skill chosen and why, all 6 pages' content and jumps, every setting and the exact source-code line that justifies it). Read it once in full before building the second cluster — it's written to be copy-and-adapt, not just historical record.
