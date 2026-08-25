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

## Open Questions

- Does Seminar III get its own parallel authoring system (lesson architecture, error taxonomy, templates) inside this folder, or does FoxCS's shared `02-authoring-system/` get extended to cover both shapes? Not decided — likely needs Jay's read on how much cross-course consistency he actually wants.
- Real `course-plan.md`/`content/` structure for this course isn't designed yet — the two source docs above are specs to build from, not the FoxCS-native artifacts themselves.
- Printable worksheets and fill-in-style Google Doc templates (single-cell-table response boxes) — format/workflow not yet built for this course; see root `worklog.md`'s "Google Doc / styled-worksheet path" note for the general approach already validated elsewhere in FoxCS.
- Google Drive folder organization for this course — not yet designed.
