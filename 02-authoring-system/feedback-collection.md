# Content/Platform Feedback Collection

Separate from lesson reflection (which is about the *content* the student just learned — see `lesson-schema.md`). This is feedback about whether the *course itself* is working — the thing that lets the pilot actually validate the direction, per the goal in `../decisions-log.md`.

**Format decided 2026-08-06:** every lesson's last numbered file (`NN_feedback.html`) — see `mvp-unit-folder-structure.md`'s "Feedback" section. Click-based scale ratings, typed open-ended answers, one "Save My Feedback" button using the save-in-place mechanism. Not a copy-paste workflow, not a Google Form, not a second file — one page, one save, done.

## Where This Lives

One per lesson now, not just larger checkpoints — the reference implementation (`courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/10_feedback.html`) treats it as a standard closing step for every lesson, not an occasional add-on. Budget: **2-3 minutes**, explicitly time-boxed so it doesn't become its own burden.

## Question Bank

Mix of fast 1-5 scale items and a small number of open-ended prompts. Not every lesson needs every question — rotate/select based on what's most useful to learn about that particular lesson. The reference implementation uses 3 scale items + 3 open-ended as a reasonable default load.

### Scale Items (1-5)

- How clear was it what you were being asked to do?
- How challenging was this lesson for you? (too easy → too hard)
- How relevant or interesting did this lesson feel to you?
- How confident do you feel with this lesson's skill(s) now?

### Open-Ended (specific examples required for full XP — see below)

- **Which term(s) from this lesson's flashcards are still fuzzy for you, if any?** Added 2026-08-06 — this is where flashcard vocabulary-confusion signal lives now, in the student's own words. A per-term rating UI on the flashcards themselves was tried and deliberately dropped in favor of this; see `mvp-unit-folder-structure.md`'s "What Flashcards Don't Do" section.
- If you got stuck this lesson, were you able to find help? What worked, or what would have made it easier?
- If you tried a challenge/extend or bonus-XP activity, what was most fun or interesting about it?
- What helped you learn this the most — be specific (a particular example, explanation, or activity)?
- What was confusing or frustrating — be specific?

## XP Incentive for Specificity

Extra XP for open-ended answers that give a concrete example and explain *why*, not just "it was good" / "it was confusing." This needs a simple, teacher-reviewable rule the grader can apply — e.g., a short response naming a specific file, activity, or moment earns full XP; a vague one-line answer earns partial or none. Exact XP value and specificity bar: not yet set (see `../open-questions.md`) — needs calibration against real responses from the pilot lesson before locking in.

## What This Data Is For

Two audiences, kept separate:

- **You** — is the content, pacing, and challenge level actually working? Where should authoring effort go next?
- **The student** — the act of reflecting is itself useful, separate from what you do with the data.

This feedback is about the *course*, not the *student's* performance — it should never feed into a student's academic grade or proficiency tracking (see `objectives-and-skills-proficiency.md`). Keep it in its own data lane in the dashboard (`../06-data-and-spreadsheets/`), not mixed into the grading/results tab.

## Tone

Same voice as everything else (`content-voice-and-tone.md`) — this should read as "help me make this better for you," not "grade this course." Frame it as the student's chance to shape what comes next, which is also just true.

## What Was Considered and Rejected (2026-08-06)

Recorded so these don't get re-proposed without knowing why they were set aside — see `../decisions-log.md`'s full entry:

- **A "fill out the form, copy the answers, paste into a separate file" workflow.** Jay rejected this directly as too complex a hand-in process.
- **A Google Form → Google Sheet pipeline.** Genuinely simple to build and would give Jay a real spreadsheet directly, but it's new infrastructure outside FoxCS's self-contained-folder model, and the actual goal was pulling from *fewer* places, not adding one.
- **Google Sites as a hosting layer.** Same reasoning — everything already works as plain files with zero hosting needed; Sites would add a location, not remove one.
