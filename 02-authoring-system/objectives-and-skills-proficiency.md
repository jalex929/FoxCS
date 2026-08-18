# Learning Objectives, Skills, and Proficiency Tracking

## Objectives Are Student-Facing

Every lesson's `objectives` (already in `lesson-schema.md`) and language objectives must be visibly shown to students when they open the lesson — not just carried as internal metadata. This shows up in the Moodle-side content as an explicit "What you'll learn" block at the top of the lesson, before the video/H5P content starts. Include both programming objectives and language objectives (per the original `adaptive-python` curriculum format — see `../courses/python/course-plan.md` source), since language/vocabulary fluency is tracked alongside programming skill.

## Objectives vs. Skills

- **Objective** — the instructional framing. What the lesson is teaching, shown to the student up front. Usually 2-4 per lesson.
- **Skill** — the individually-tracked, proficiency-scored unit. Usually maps close to 1:1 with objectives, but a single objective can decompose into more than one trackable skill when it's worth distinguishing (e.g., "use conditionals" might split into `writes_if_else` and `reads_nested_conditionals` if a lesson genuinely exercises both separately).

Every skill needs a stable ID (reused across lessons when the same skill reappears — e.g., `print_output` shows up in unit 01 and gets reinforced in later units) so proficiency can accumulate across the whole course, not reset every lesson.

## Evidence Sources

A skill's proficiency is built from evidence on **both** surfaces, not just one:

- Moodle H5P/quiz items tagged with that skill ID (vocabulary checks, guided practice, drag-drop)
- VS Code practice files and project work tagged with that skill ID (both automated test results and grader-assessed rubric criteria)

This matches `adaptive-python`'s own mastery philosophy: proficiency should be inferred from **multiple signals over time**, not a single attempt. A skill isn't "Proficient" because of one correct H5P question, and it isn't "Not Started" because of one shaky first attempt in VS Code.

## Proficiency Scale

Your proposed scale, with two levels softened to match the supportive/growth-oriented tone required by `content-voice-and-tone.md` — "Insufficient" and "Not Evident" read as deficit/judgment language, which cuts against the same principle `adaptive-python`'s own docs establish (avoid ranking/deficit language, prefer growth framing). Everything else is unchanged from what you proposed.

| Level | Original | Revised (recommended) |
|---|---|---|
| 1 | Not Evident | **Not Started Yet** |
| 2 | Insufficient | **Getting Started** |
| 3 | Beginning Proficiency | Beginning Proficiency |
| 4 | Nearing Proficiency | Nearing Proficiency |
| 5 | Proficient | Proficient |
| 6 | Mastery | Mastery |

This is your call — the revision is a recommendation, not a decision I'm making for you. Both versions carry the same 6-level granularity and the same diagnostic meaning; only the two lowest labels changed.

## Skill Record Shape

```yaml
skill_id: writes_if_else
description: Writes a working if/else statement that branches correctly for both cases.
first_introduced: lesson_05_03_if_statements
reinforced_in: [lesson_05_04_if_else, lesson_05_06_nested_conditionals]
evidence_sources:
  moodle:
    - h5p_activity: lesson_05_03_guided_practice
  vscode:
    - practice: lesson_05_03_core_practice_02
    - rubric_criterion: lesson_05_03_project.target_concept
proficiency_scale: standard_6_level    # see this doc
```

## "Keep Practicing" / "Strong Here" Tips

Per-skill feedback tips, generated from current proficiency level, teacher-reviewed before release (same approval gate as everything else — see `../CLAUDE.md`). Directly modeled on `adaptive-python`'s support/challenge feedback pattern.

| Proficiency | Tip type | Example |
|---|---|---|
| Not Started Yet / Getting Started | Keep Practicing | "Keep practicing if/else — try `lesson_05_03/support/WHEN_YOU_ARE_STUCK.html` before your next attempt." |
| Beginning / Nearing Proficiency | (no tip, or optional encouragement) | — |
| Proficient / Mastery | Your Skills Are Strong Here | "Your if/else skills are strong — try the Extend challenge in this lesson if you want to push further." |

These tips are exactly the kind of thing the weekly grading pass should generate automatically (see `../05-grader/README.md`) — not something authored by hand per student.

## Reinforce / Core / Extend Ladder (routing logic)

This is the concrete algorithm behind the "Keep Practicing" / "Strong Here" tips above, and behind Moodle's "light adaptive support" in the Two-Surface model (`../CLAUDE.md`). It's deliberately shallow — three lanes, one move per attempt, no deeper branching tree:

- Start at **Core**.
- Core wrong → **Reinforce**. Reinforce wrong again → another Reinforce item (stay in-lane, don't go deeper).
- Core right → **Extend**. Extend right again → another Extend item (stay in-lane, don't go further).
- Reinforce and Extend are sticky endpoints, not the start of a fourth level. A four-level "Reinforce of a Reinforce" would recreate the deep branching-tree complexity that got `templates/question-branching-template.csv` and the Moodle-Lesson-branching design superseded in the first place (see `../decisions-log.md`, 2026-07-24 entry) — don't rebuild that.

**Pool sizing — constrained by a whole-lesson cap, not just per-skill:** Jay set a hard ceiling of **~10-15 practice items total per lesson** (assuming most are simple; fewer if they're more involved). That doesn't divide cleanly against "2-4 skills per lesson" (see Open Question below) at the Core 1-2/Reinforce 2-4/Extend 2-4-per-skill rate floated earlier today — that rate alone is 5-10 items *per skill*, which blows the whole-lesson budget once multiplied by more than 1-2 skills. Unresolved as of 2026-07-24, worth pressure-testing on the actual pilot lesson rather than locking in now:
- A lesson with 2 skills fits comfortably at roughly Core 1, Reinforce 2, Extend 2 per skill (5/skill × 2 = 10 total).
- A lesson with 3-4 skills either needs a tighter per-skill rate (e.g. Core 1, Reinforce 1-2, Extend 1-2) or the skill count itself needs to trend toward the lower end of "2-4" for lessons that lean on this ladder heavily.
- The 2x-Reinforce/Extend-vs-Core ratio should hold even at the tighter rate — it's the total that needs to shrink, not the shape.

**Where this actually runs — decided: Moodle's Lesson activity, kept light.** On the Moodle side, this ladder will run live via `mod/lesson` (confirmed present on the local instance), not just as a weekly-batch tip. This is a partial return of the original Lesson-branching mechanism (`../decisions-log.md`, 2026-07-24) — but the thing that got that design retired was the *depth* (a many-level branching tree) and spreadsheet-based authoring, not the Lesson activity itself. This is explicitly not that: it's the same shallow 3-lane structure above, implemented live instead of via weekly tip. "Keeping it light" means, concretely:
- One Lesson-activity branch point per skill checkpoint: a Core question with exactly two outcomes, wrong → jump to a Reinforce page, right → jump to an Extend page. No answer-specific branch targets beyond right/wrong.
- Reinforce and Extend pages loop back to another item in the *same* lane (per the sticky-endpoint rule above) or exit forward to the next skill — never deeper into a third level.
- Page count per skill checkpoint should track the pool-size cap directly below, not exceed it — the Lesson activity's page count *is* the pool size, so if the cap says "5 items for this skill," that's 5 Lesson pages, not more.
- Reuse one consistent page/branch template across skills so each new skill checkpoint is fast to author, not a bespoke structure every time.
On the VS Code side, nothing changes — practice files are still static, and the weekly "Keep Practicing"/"Strong Here" tips still drive what a student is pointed to there, since there's no live grading engine for code submissions. H5P's Branching Scenario content type is no longer the live-branching candidate (Lesson activity is the pick) — doesn't need checking on this instance now.

**How to actually build this in Moodle:** see `moodle-lesson-ladder-setup.md` for the click-by-click mechanics (Question page → Answer → Jump), a worked example for one skill's cluster, and the sustainability tiers (manual first, templated export/import next, Web Services only if needed).

## Rubrics Must Map to Objectives/Skills, Not Just Generic Criteria

Every rubric criterion in a lesson (see `grading-rubric-template.md` in `../templates/`) should reference the specific skill(s) it's evidence for, not just be a generic "code quality" line. This is what makes the proficiency tracking real instead of aspirational — if a rubric criterion doesn't map to a skill ID, it isn't feeding the proficiency system.

## Open Question

Skill granularity itself is unvalidated — how many skills per lesson is useful vs. noisy overhead isn't known until the pilot lesson is built and actually graded once. Start with 2-4 skills per lesson (roughly one per objective) rather than over-decomposing; add granularity later if the coarse version isn't diagnostically useful.
