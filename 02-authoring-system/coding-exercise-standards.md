# Coding Exercise Authoring & Grading Standards

**Added 2026-09-14, per Jay directly** — prompted by a real gap: Unit 01's 4 Coding Exercises (01.3-01.6) went live with no rubric file, forcing an ad-hoc, self-derived grading pass when the backlog finally got graded. This doc exists so that never happens again.

## Standing rule: no Coding Exercise goes live without a rubric

**Every Coding Exercise must have a real rubric file authored before it's published to a live (non-sandbox) course** — see `../CLAUDE.md`'s "Publishing Live Content — Pre-Publish Checklist," which this requirement extends. Follow the naming pattern already established for the one lesson that has one (`courses/python/content/unit_02_variables_and_data/lesson_02_06_type_conversion/teacher-materials/coding_exercise_rubric.md`): a `coding_exercise_rubric.md` in that lesson's own `teacher-materials/` folder.

## The rubric split: 50% runs, 50% correct

**Per Jay directly:** whether the code runs without error is treated as its own major test, worth **50% of the Coding Exercise score**. The other 50% is whether the code actually does what the exercise asked (correct logic/output). This produces three real bands, not just pass/fail:

- **Flawless** — runs without error AND produces the correct result. Full credit.
- **Doesn't run at all** — a real syntax/runtime error prevents execution. Fails the 50% "runs" component; the "correct output" component can't even be evaluated since there's nothing to check. This is the harshest band.
- **Runs, but something's wrong** — no syntax/runtime error, but a logic error, wrong output, or similar means it doesn't do what was asked. Passes the 50% "runs" component; partial credit on the "correct" component depending on how close it is.

A lesson's own `coding_exercise_rubric.md` should spell out, concretely, what "correct" means for that specific exercise (the exact expected output, the specific bug that must be fixed, etc.) — this doc sets the universal 50/50 split and the three-band shape; the per-lesson file supplies the specific pass/fail criteria within it.

## Applies retroactively to Unit 01's backlog, going forward

The four already-live Unit 01 Coding Exercises (01.3-01.6) still don't have a rubric file — author one for each, using this framework, even though they're already built and live. The 2026-09-14 grading pass that cleared their submission backlog was done before this doc existed, using self-derived criteria per lesson; it doesn't need to be redone under this framework unless Jay says otherwise, but any lesson still in progress at the time this landed should use it.
