# FoxCS: Seminar III

## Scope

Fourth FoxCS course, alongside `../python/` (Game I), `../game-programming-2/` (Game II), and `../web-dev/` (Web II) — but a genuinely different kind of course, not a CS/certification track. Seminar III combines ACT academic readiness (Math/Reading/English/Data), academic & life skills (grade monitoring, study strategy, financial literacy, professional communication), and postsecondary planning (College Prep vs. Workforce Readiness pathways, chosen and revisable through the year). See `01_SEMINAR_III_COURSE_PLAN` for the full year-at-a-glance/weekly-structure spec and `02_SEMINAR_III_ACADEMIC_CONTENT_MAP` for the per-week skill/vocabulary/concept breakdown both source docs are meant to drive.

## Source Material

- `01_SEMINAR_III_COURSE_PLAN` — course purpose, three pillars (Academic & ACT Readiness / Academic & Life Skills / Postsecondary Readiness), standard weekly structure (Mon–Fri, plus 3-/4-day short-week variants), instructional design principles, the academic problem-solving process, the error-analysis system, a full Quarter 1–4 year-at-a-glance and week-by-week outline (Aug 24 – Jun 11), Albert.io's role, assessment philosophy, and course-end outcomes.
- `02_SEMINAR_III_ACADEMIC_CONTENT_MAP` — the detailed academic-skill progression meant to drive teacher materials, guided notes, paper practice, ACT-style practice, Albert.io assignments, retrieval warm-ups, and assessments: a standard lesson architecture (Today's Skill → Why This Matters → Important Words → Understand It → Remember It → Watch → Try It Together → Your Turn → ACT Connection → If You Forget → Check Your Thinking → Retrieval), full ACT Math/Reading/English/Data trajectories, per-week objectives/vocabulary/concepts/misconceptions down to individual weeks, a spiral-review map, ACT domain-to-week content mapping, and 15 authoring rules for writing this course's content.
- **Filename note:** both files landed without a `.md` extension and don't follow FoxCS's `course-plan.md` naming convention used by the other three courses. Not renamed here — flag to Jay before treating either as the course's canonical `course-plan.md`.

## Status

Two full source/spec documents landed 2026-08-24. **No FoxCS-native content authored yet** — no `lesson-schema.md`-conformant lesson records, no printable worksheets, no fill-in-style Google Doc templates, no `content/` folder.

## How This Course Differs From FoxCS's Existing Model

Real structural mismatches with the rest of FoxCS, not yet reconciled — read before authoring:

- **Not unit-folder/lesson-sequence shaped.** The other three courses (or their planned shape) organize around `unit_NN` folders submitted via Google Classroom. Seminar III organizes around a **fixed weekly day-of-week rhythm** (Monday Study Hall + grade check, Tuesday Skill Instruction, Wednesday Practice & Application, Thursday Life/Postsecondary Skill, Friday Application/Project/Pathway) that repeats all year, with 3-/4-day short-week variants. Whether this becomes real unit folders, a different delivery shape entirely, or something in between is undecided.
- **Its own lesson architecture**, distinct from `../../02-authoring-system/lesson-schema.md` and `content-authoring-standards.md`'s DOK rubric — Seminar III's own spec (Today's Skill/Why This Matters/Understand It/Remember It/Watch/Try It Together/Your Turn/ACT Connection/If You Forget/Check Your Thinking/Retrieval) isn't mapped onto FoxCS's existing schema fields at all yet.
- **Its own error taxonomy** (Knowledge / Process / Execution / Comprehension / Strategy errors) — check for overlap or conflict with however the CS courses currently handle misconception/error documentation before writing a shared doc, if one ends up warranted.
- **Albert.io** is a new named third-party platform, not referenced anywhere else in FoxCS. No licensing/data-boundary treatment exists for it yet (contrast GMetrix, which has `../../01-privacy-and-governance/licensing-boundaries.md`).
- **Real calendar dates already baked in** (Aug 24 – Oct 23 for Q1, etc., through Jun 11). This conflicts with root `CLAUDE.md`'s Hard Constraints note that no course-plan should hard-code SY26-27 dates until the official CPS academic calendar lands in `starter context/` — flag to Jay rather than silently overriding either document.
- **Submission/grading model unclear.** The course reads as largely in-class (study hall, paper practice, Albert.io, guided notes) rather than submitted coding artifacts — whether the codename-privacy/Classroom-submission/AI-grading pipeline (`../../01-privacy-and-governance/`, `../../05-grader/`) applies here at all, partially, or not is undecided.
- **No pillar maps to a certification.** The other three courses anchor to Certiport/Unity credentials; Seminar III's "credential" is ACT performance plus a postsecondary plan — different enough that the certification-framing sections in the other courses' `CLAUDE.md`s don't have an equivalent here yet.

## Week at a Glance: Standing Requirement (added 2026-08-30)

Every `printable-sheets/lesson-N-week-at-a-glance.html` must do two things, not just one — confirmed against Lesson 1's page, which had the first but not the second until Jay flagged it:

1. **Show students how the week's content will be covered** — the existing day-by-day breakdown (what's taught each day, which Moodle activities go with it) already does this.
2. **Show due dates for parts of the content** — each day's block needs its own real calendar date (not just "Day 1"/"Day 2") and an explicit due-date badge (e.g., "Due by end of class, Wed Sep 2"), not just one due date for the whole week. Students should be able to tell, at a glance, when each piece is actually due, not just when it's taught.

Real calendar dates are already in use in this file (the banner's "August 31 – September 4, 2026"), so per-day dates follow the same precedent — don't treat this as violating root `CLAUDE.md`'s no-hardcoded-SY26-27-dates caution, that caution was about *not yet knowing* Quarter 1's real dates, which is resolved here.

Lessons 2-8 don't have a week-at-a-glance page yet (only Lesson 1's exists) — apply this same two-part standard whenever each one gets built, not just to Lesson 1's retrofit.

## Pacing Philosophy: Less Self-Paced Than the CS Courses (added 2026-08-30)

Per Jay directly: Seminar III is **less self-paced** than the CS courses (which lean on the Reinforce/Core/Extend ladder and independent-exploration pacing for Game II/Web II). Seminar III's day-by-day structure and per-day due dates (see Week at a Glance above) are the real pacing mechanism, not a suggestion.

If a student finishes a day's content early, they're welcome to use the remaining time as study hall — working on something for another class, checking in with the teacher if they need help with it. **But this should never read as an invitation to rush.** The explicit framing, every week: work through the content thoughtfully, not quickly — finishing first isn't the goal. This belongs in every week-at-a-glance page (see the standing requirement above), not just stated once.

## Live Content Audit and Fixes (2026-08-30)

An audit of the live `foxcs-seminar3` Lesson 1 section found real problems, now partly fixed:

- **All 8 graded H5P activities had `enableSolutionsButton: true`** (students could reveal the correct answer with a click) — this directly violated the standing rule enforced everywhere in the Python course. Fixed across all 8 (36 total instances) via `07-infrastructure/moodle-scripts/patch_disable_show_solution.py`.
- **A deeper answer-leak, found separately by Jay reviewing 1.3 Error Types live:** every wrong-answer feedback ended with "Try: review the [Correct Category] definition again" — literally naming the correct answer in the hint. 90 instances across 4 activities (1.3, 1.6, 1.7, 1.9), fixed via `07-infrastructure/moodle-scripts/patch_remove_answer_leak.py` with a generic, non-revealing redirect. **Any future Seminar III question feedback needs a human (or a careful review pass) checking specifically for this pattern — "explain why this is wrong" easily slides into "name what's actually right" without meaning to.**
- **Two teacher-only files were live and visible to students**: "Lesson 4 Presentation (Teacher)" and "Lesson 1 Answer Keys (Teacher)" — not just present-but-hidden, actually `visible=1`. Hidden immediately. **Not fully resolved** — 10 more teacher-only files (presentations, answer keys) still sit inside the student-facing course section, currently hidden but architecturally exposed to the same mistake happening again. These should move to a properly role-restricted area, not just stay hidden-by-flag inside the student section.
- **Real duplicate/superseded content**: two generations of the same lessons existed side by side (an early build superseded by a "-merged" rebuild), plus duplicate plain-resource versions of H5P activities. Partly cleaned up during the fixes above; a full consolidation pass (see below) is still the real fix.

## Content Redesign, Lesson 1 (2026-08-30)

Per Jay directly:

- **1.2 "Sequence the Five-Question Routine" removed outright** — not replaced, just cut.
- **1.4 and 1.5 merged and rebuilt** as "1.4 -- Order of Operations Practice": 5 fixed-difficulty-progression questions (two simple with process-guidance tips, one real-world application — the former standalone 1.5 activity, now folded in here — two harder multi-step problems). Built in `07-infrastructure/moodle-scripts/build_ooo_practice.py`, using H5P MultiChoice's native "tip" feature (shown on request, before checking, never revealing the answer) for the simpler questions' "how to approach this without being told the answer" guidance.
- **This is NOT true adaptive branching.** Jay asked for genuinely reactive difficulty (harder/easier based on live answers), and a fixed 5-question progression doesn't do that — flagged honestly rather than dressed up as adaptive. FoxCS's own established tool for real per-answer branching is Moodle's native **Lesson activity** (`mod_lesson`), not a fixed H5P question set — see `02-authoring-system/objectives-and-skills-proficiency.md`'s Reinforce/Core/Extend Ladder section. Building a real `mod_lesson`-based adaptive version of this practice is a genuine next task, not done here.

## H5P Content-Type Lesson Learned (2026-08-30)

Hand-authoring H5P content JSON blind (without a real semantics.json reference or visual testing) is unreliable — a first attempt at H5P.DragQuestion for a drag-and-drop vocab quiz rendered completely empty in production because several fields were nested under the wrong parent group (`settings` vs the real `behaviour` group). Confirmed by extracting the actual installed `mdl_h5p_libraries.semantics` field for the content type in question (MySQL CLI batch-mode output escapes real backslashes as `\\` and real newlines as `\n` — un-escape backslashes first, then newlines, or the JSON won't parse). **Before hand-authoring any new H5P content type not already proven working in this repo, pull and check its real semantics.json first**, and visually verify the result in a real browser (Claude-in-Chrome / Playwright are both available) rather than trusting that valid-looking JSON actually renders.

## Open Questions

- Does Seminar III get its own parallel authoring system (lesson architecture, error taxonomy, templates) inside this folder, or does FoxCS's shared `02-authoring-system/` get extended to cover both shapes? Not decided — likely needs Jay's read on how much cross-course consistency he actually wants.
- Real `course-plan.md`/`content/` structure for this course isn't designed yet — the two source docs above are specs to build from, not the FoxCS-native artifacts themselves.
- Printable worksheets and fill-in-style Google Doc templates (single-cell-table response boxes) — format/workflow not yet built for this course; see root `worklog.md`'s "Google Doc / styled-worksheet path" note for the general approach already validated elsewhere in FoxCS.
- Google Drive folder organization for this course — not yet designed.
