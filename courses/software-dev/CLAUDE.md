# FoxCS: Software Dev

## Scope

Course name: **FoxCS: Software Dev**. Fifth FoxCS course, created 2026-08-30 — the newest and least source-material-backed of the five. Alongside `../python/` (Game I), `../game-programming-2/` (Game II), and `../web-dev/` (Web II), but structurally different from all three: it is a **continuation course, not a same-day parallel choice**. A student reaches Software Dev only after making substantial progress through `../web-dev/course-plan.md`'s HTML/CSS/JavaScript content — see Prerequisite Relationship below.

Per the CPS-authenticated "Fox Game II/Web II Syllabus SY27" Google Doc Jay shared this session (no local copy or export exists in this repo — see Source Material below), the pathway runs a 5-stage certification progression:

1. HTML + CSS
2. JavaScript
3. HTML5 Application Development
4. **Java** ← this course's real starting point
5. **Software Development** ← this course's own deep content

**Stages 1-3 are Web Dev's curriculum, not re-taught here.** `../web-dev/course-plan.md` already covers HTML/CSS and JavaScript, with HTML5 Application Development as its encouraged second credential (per `../web-dev/CLAUDE.md`'s Certification Framing section). This course's own `course-plan.md` begins at Stage 4 (Java) and treats Stages 1-3 as a prerequisite satisfied by the Web Dev course-plan, not content to duplicate. Unit numbers here are **SD-01 through SD-16**, a separate sequence from Web Dev's Unit 01-21 — deliberately not continuing that numbering, so it stays clear a Software Dev student has already been through a distinct prior course before Unit SD-01 begins.

**Framing already established in the shared Unit 0 pathway-choice page** (`../../shared/unit_00_onboarding_level2/lesson_00_09_choosing_your_pathway/01_instruction.html`, `.pathway-box.softwaredev` and `.concept-card.softwaredev`): this pathway is for students "genuinely interested in programming, computer science, application development, and software engineering as a field, not just building one website or one app," spends more time on "the 'why' behind the code than the other two pathways," and is explicitly **not** a same-day starting choice — it's a "keep going" option once a student is already moving through the web track. Keep this course's own materials consistent with that framing rather than re-deriving it differently.

## Source Material

**Thinnest of any FoxCS course — flagged directly, not glossed over.** Unlike Python (GMetrix `Python_v2_Student_Workbook.pdf`) and Web Dev (LearnKey `JavaScript_INF-302_Student_Workbook.pdf` + `HTML5_Application_Development_Student_Workbook.pdf`, both with official exam-objective PDFs in `../../starter context/`), **no licensed Java workbook, support-file set, or exam-objective document exists anywhere in this repo.** `../../starter context/` was checked directly (2026-08-30) — confirmed absent, not just unlinked. Before authoring real Java lesson content (as opposed to this skeleton), Jay needs to either source an equivalent LearnKey/Certiport workbook for the Java exam or decide on a different curriculum source. This is a real procurement gap, not a documentation gap.

- The syllabus Google Doc itself ("Fox Game II/Web II Syllabus SY27") was read via browser earlier this session but never saved locally — recommend exporting it into `../../starter context/` so future sessions (and this fork's own claims above) can be checked against the primary source instead of session memory.
- `../../starter context/Web_Development_Course_Map_Certification_Aligned.md` is directly relevant as the Stage 1-3 source `../web-dev/` already builds from — read it for continuity of tone/structure even though this course doesn't reuse its content directly.

## Certification Framing

**Unconfirmed — flagged, not guessed.** Root `../../CLAUDE.md` states "Certiport IT Specialist certifications are the throughline" across FoxCS. Certiport's IT Specialist line does include a Java exam, which would make this course's Stage 4 checkpoint consistent with Python's (IT Specialist – Python) and Web Dev's (IT Specialist – JavaScript / HTML5 Application Development) certifications. **This has not been confirmed with Jay and no exam-objective document exists locally for it** — treat "IT Specialist – Java" as a working assumption in `course-plan.md`'s Java-stage units, not a locked fact. Stage 5 ("Software Development") does not obviously map to any single named certification — flagged as fully open below.

## Prerequisite Relationship to Web Dev

- A student cannot start Unit SD-01 without having substantially completed Web Dev's JavaScript content (the mandatory credential per `../web-dev/CLAUDE.md`) — exact readiness threshold (a specific unit checkpoint? a certification pass? teacher judgment?) is not defined anywhere yet. Open question below.
- Because Software Dev depends on Web Dev's own pacing, this course's `course-plan.md` cannot assume a fixed start-of-year entry point the way the other four courses can — an individual student's Unit SD-01 start date is variable, tied to when they clear the Web Dev prerequisite. Delivery/scheduling mechanism for a variable-entry course is not designed yet.

## Status

**Created 2026-08-30.** `CLAUDE.md` (this file) and `course-plan.md` (Stage 4-5 unit skeleton, SD-01 through SD-16) built for the first time — no prior version of either existed. This resolves the placeholder in the Unit 0 pathway-choice page's `.placeholder-flag` ("Software Dev's total unit count isn't set yet") with a first real number: **16 units**, a first-pass estimate based on giving Java Fundamentals and Software Development roughly equal weight — not yet validated against a real school-year calendar or confirmed with Jay. No `content/` folder yet — this is scope/skeleton only, same stage Game II and Web Dev were at before their own course-plans were drafted.

## Open Questions

- **No Java curriculum source exists.** Top priority before any real lesson content gets authored — see Source Material above.
- **Exact prerequisite threshold** for leaving Web Dev and entering Software Dev is undefined (specific unit? certification pass? teacher sign-off?).
- **Certiport IT Specialist – Java** is an assumed, unconfirmed certification target for the Java stage.
- **Stage 5 ("Software Development") has no certification mapping at all** — is it meant to culminate in a capstone/portfolio instead of an exam, the way Game I's post-certification MakeCode Arcade work does? Not decided.
- **Scheduling/delivery for a variable-entry-point course** — how does a teacher run a class where students arrive at Unit SD-01 on different dates depending on their own Web Dev pace? Not designed.
- **Realistic enrollment size** — how many students in a given year are actually expected to reach Stage 4? This affects whether `course-plan.md`'s 16-unit scope should assume a full year or a partial-year population. Not estimated by Jay yet.
- Whether this course shares Game I/Game II's Game/UX-and-journal thread, has its own, or opts out entirely — not addressed in `course-plan.md` yet; flagged there too.

Platform-wide open questions live in `../../open-questions.md`.
