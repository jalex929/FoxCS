# Repo Map

**Added 2026-09-09**, per Jay's direct request: too many sessions were re-deriving context that already existed, or worse, building against a doc that had already been superseded by a different one without either session noticing the conflict. This file exists so a session can get oriented fast and correctly, instead of guessing which doc to trust or asking Jay to re-explain something already written down.

**Read this file right after `CLAUDE.md`, before touching any content.** `CLAUDE.md` tells you the project's current phase and status. This file tells you where everything lives and, critically, **which doc wins when two disagree** — that second part is the part sessions have been getting wrong.

## Authority Hierarchy — read this section first

When two docs give different guidance on the same thing, this is the order that wins, most authoritative first:

1. **Jay, in the current conversation.** Always wins. Write his decision into the relevant doc(s) below before the session ends, so the next session doesn't have to be told again.
2. **The 7 canonical `02-authoring-system/` docs**, listed in `CLAUDE.md`'s "Source of Truth for Content Authoring" section: `content-authoring-standards.md`, `lesson-quality-standards.md`, `lesson-schema.md`, `authoring-workflow.md`, `content-voice-and-tone.md`, `mastery-check-standards.md`, `objectives-and-skills-proficiency.md`. These govern *how content gets authored* across every course. **A course-specific doc that conflicts with one of these seven is the one that's wrong**, not the other way around — see the real worked example in "Known Tensions" below.
3. **`decisions-log.md`** — once something is decided (by Jay or resolved against #2), it's recorded here permanently. If a course-specific doc looks stale next to a `decisions-log.md` entry, the log wins; go fix the doc.
4. **Course-specific docs** (`courses/<course>/course-plan.md`, `skills-map.md`, `*-workbook-map.md`, etc.) — the content-level detail (what this specific lesson covers, what order, what date). These should never contradict tier 2, but they sometimes do because nobody cross-checked at build time. **Cross-check tier 4 against tier 2 before building, don't just follow the course-specific doc.**
5. **Everything else** (`00-project-overview/`, paused/historical docs marked as such, `open-questions.md`) — background and context, not standing instruction.

**Before authoring anything new, especially a new *kind* of module (a lesson's first Mastery Check, a course's first Project, etc.), check tier 2's relevant doc even if a course-specific doc (tier 4) already seems to answer the question.** This is the single most common failure mode so far — see Known Tensions.

## Known Tensions — real conflicts found between docs, read before you repeat them

This section is a living list. When a session finds two docs disagreeing, or catches itself about to build against a superseded plan, add an entry here (dated), not just a fix buried in `decisions-log.md` — the point is that the *next* session sees this list before it makes the same mistake, without having to already know to search for it.

- **2026-09-09 — `mastery-check-standards.md` (tier 2, canonical) vs. `courses/python/skills-map.md` (tier 4, course-specific) on where Mastery Check lives for Unit 02.** `mastery-check-standards.md` says explicitly: every lesson gets its own Mastery Check (3-5 items), and there should be **no separate unit-level Mastery Check** — the Unit Project already covers cross-lesson synthesis. `skills-map.md` scoped Unit 02's Mastery Check to the *unit* level (one cumulative check after 02.7) instead. The 2026-09-08 build session followed `skills-map.md` and built 02.2-02.5 with no per-lesson Mastery Check at all — nobody checked it against tier 2 first. Caught and reversed 2026-09-09 (Jay, directly) — see `decisions-log.md`'s matching entry. **Standing rule now enforced: per-lesson Mastery Check for every lesson in every course, unit-level cumulative checks are not built.**

## Directory Index

```
FoxCS/
  CLAUDE.md                    Read first — phase, status, platform decisions, hard constraints
  REPO_MAP.md                  This file — read second
  decisions-log.md             Append-only, permanent record of what changed and why (tier 3)
  worklog.md                   Technical state, session to session — what's actually built/deployed
  chat-log.md                  Conversational TLDR — questions asked, answered, or still open
  open-questions.md            Unresolved cross-course questions
  Python_v2_Student_Workbook.pdf   Licensed GMetrix/Certiport source (see licensing-boundaries.md)
  Python v2 Support Files/     GMetrix Domain 1-6 starter .py files, licensed source material
  logos/, teacher-materials/, starter context/, Sample Content/, makecode images/, shared/
                                Assets and reference material, not authoring docs

  00-project-overview/         Original braindump + handoff docs (tier 5, historical context)
    source-material/           braindump.md, the original curriculum-authoring-grading handoff doc
    h5p-authoring-and-automation.md   Can H5P be generated programmatically — yes, how

  01-privacy-and-governance/   Cross-course policy (tier 2-adjacent, always applies)
    codename-policy.md         Pseudonymous student identifiers
    data-boundaries.md         What data can/can't flow where; the Release Gate
    licensing-boundaries.md    GMetrix content must never reach the commercial adaptive-python app

  02-authoring-system/         THE canonical authoring docs — see Authority Hierarchy tier 2
    doc-health.md              Per-file staleness tracker for this folder specifically — check before trusting a "not yet audited" file
    content-authoring-standards.md, lesson-quality-standards.md, lesson-schema.md,
    authoring-workflow.md, content-voice-and-tone.md, mastery-check-standards.md,
    objectives-and-skills-proficiency.md         The 7 canonical docs (tier 2)
    instructional-image-guide.md   Current illustration standard (image-style-guide.md is superseded, kept for reference)
    telemetry-and-analytics.md, adaptive-practice-model.md, theme-system.md,
    vscode-content-conventions.md, xp-and-incentives.md, project-rubric-and-xp-tiers.md,
    feedback-collection.md, lesson-navigation-standards.md, design-system.md   Supporting system docs
    certiport-gmetrix-account-setup.md   The 02.0-style orientation step, reusable per course
    tools/                     check_live_publish_readiness.py (hard pre-publish gate) and other scripts
    shared-styles/, pyodide-runtime/, skulpt-runtime/, component-library/   Real shared code/assets

  05-grader/                   Grading pipeline — README explains the two-tier (school-side auto / home-side Claude) split
    feedback-and-grading-spec.md   Canonical rubric/voice/output-format spec — read before writing ANY rubric or grading feedback template, don't re-derive
    reflection-rubric-general.md
    school-side/auto_grade.py + tests/   Stdlib-only, structural auto-grading, no AI
    sample-submissions/        Real fixture data auto_grade.py is tested against

  06-data-and-spreadsheets/    Teacher spreadsheet dashboard — not fully built, see its README
    roster-schema.md

  07-infrastructure/           The live droplet, Moodle setup, deploy scripts
    droplet-setup.md, moodle-vm-setup.md, moodle-course-shells.md, h5p-content-type-guide.md
    onboarding-new-students.md
    moodle-scripts/            PHP/Python deploy scripts. Root-level = one-off per-lesson builds (build-lesson-01-04-*.php pattern). moodle-scripts/python/ = reusable builders (h5p_book_builder.py, create-h5p-instruction.php, create_lesson1_mastery_check_quiz.php) plus more one-offs. No naming convention beyond "descriptive" — grep for the cmid or lesson name if unsure whether a script already exists before writing a new one.

  templates/                   lesson-template.md (fill-in schema), grading-rubric-template.md (unfilled), question-branching-template.csv

  courses/<course>/            Each course is self-contained: CLAUDE.md (scope + status) + course-plan.md (unit/lesson checklist, tier 4) + content/
    python/                    ACTIVE course. Also has: skills-map.md (imported Google Doc, tier 4 — watch for conflicts with tier 2, see Known Tensions), gmetrix-content-mapping.md, python-certification-workbook-map.md (canonical GMetrix video/workbook/file map), video-resources.md (per-lesson video assignments), unit-01-content-inventory.md
      content/unit_NN_<name>/lesson_NN_MM_<name>/    Per-lesson folder: NN_instruction.html, coding-exercise/, teacher-materials/ (practice_question_bank.md, mastery-check rubrics/keys), lesson_NN_MM_<name>.md (lesson record)
    seminar-iii/                In progress, own Lesson-N numbering (not Units). 01_SEMINAR_III_COURSE_PLAN and 02_SEMINAR_III_ACADEMIC_CONTENT_MAP are its course-plan-equivalent tier-4 docs. instructional-content/, printable-sheets/ (paused, see Hard Constraints in CLAUDE.md), teacher-materials/, lesson-N-plan files.
    game-programming-2/         course-plan.md built, no content/ yet. unity-*-cert-objectives.md for the 3 Unity certs.
    web-dev/                    course-plan.md built, no content/ yet.
    software-dev/               course-plan.md built (16 units), no content/ yet, no licensed Java source — see its own CLAUDE.md.
```

## Task Router — what to read before doing common things

- **Building any lesson's first Instruction/Project/Coding Exercise/Mastery Check/Feedback module** → `CLAUDE.md` Purpose section (the 5-module structure) + the relevant tier-2 doc (`lesson-schema.md`, `mastery-check-standards.md`, etc.) + that course's `course-plan.md` entry for the lesson. Reconcile any conflict per the Authority Hierarchy before building, don't just follow whichever you read first.
- **Deploying anything to a real (non-sandbox) Moodle course** → `CLAUDE.md`'s "Data Safety" section (run the backup, first, every time) then its "Publishing Live Content — Pre-Publish Checklist" section (5 items, run `check_live_publish_readiness.py`, then the 4 manual read-through items).
- **Writing a rubric or grading feedback for anything** → `05-grader/feedback-and-grading-spec.md` first. Don't design a new rubric format from scratch, this one's comprehensive and already adopted.
- **GMetrix/Certiport content placement for Python** → `courses/python/python-certification-workbook-map.md` (canonical video/workbook/file map) cross-checked against `course-plan.md`'s own GMetrix tie-in notes for that unit — these two have disagreed before (see Known Tensions pattern), check both.
- **Anything response-eliciting (quiz, check, reflection)** → `CLAUDE.md`'s Hard Constraints section: must be real interactivity, printable static sheets are paused repo-wide.
- **Picking up a session ("where did we leave off")** → `CLAUDE.md`, then `chat-log.md`, `decisions-log.md`, `worklog.md`, in that order, per `CLAUDE.md`'s own logging paragraph — this file doesn't replace that step, it's a supplement for orientation, not a session-state log.

## Keeping This File Useful

This map goes stale the same way any doc does. When a session creates a new top-level folder, a new tier-2 doc, or a new course, add a line here in the same pass — don't leave it for a future audit. When a session finds a new cross-doc conflict, add it to Known Tensions before fixing it, so the fix's reasoning survives even if `decisions-log.md`'s entry is long and easy to skim past.
