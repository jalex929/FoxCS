# Shared Unit 0: Cross-Course Onboarding

**New 2026-08-17.** Design doc for a single onboarding unit delivered, in substance, to all three FoxCS courses (Game I / Python, Game II, Web II) — not three separately authored Unit 0s. See `../decisions-log.md`'s 2026-08-17 entry for how this was decided. Status: **outline only, no instructional content authored yet.**

## Why This Exists

Jay's framing (2026-08-17): it would be *nice* to deliver exactly the same Unit 0 to every course, since it functions as onboarding across the whole program, not a course-specific lesson. Not all of it needs to be relevant to every student, but a student should always be able to tell what's relevant to them. This is a stronger version of the existing per-course model — see `../open-questions.md`'s "Does the sequential unit-by-unit model even apply to Game II/Web II?" question, which this doc resolves for Unit 0 specifically (not for Units 1+, which stay course-specific).

## Two Editions, One Shared Spine

Not a single flat document and not three separate ones — **two editions** of the same underlying spine, matching the real split in how the courses run:

| Edition | Who sees it | Pathways shown |
|---|---|---|
| **Level 1** | Game I (Python) | Python only. No Web Dev, no Game Design/Unity — Game I is single-pathway by design. |
| **Level 2** | Game II **and** Web II | Web Dev **and** Game Design/Unity, both — regardless of which of the two courses a student is actually enrolled in. No Python. |

**Confirmed directly by Jay (2026-08-17), reinforced 2026-08-17:** a Level 2 student sees both pathways no matter which course period she's in, **and the pathway choice itself is not tied to course enrollment either.** This is a general rule, not a special case that only applies to a student enrolled in both courses: a Game II student may choose Game Design/Unity or Web Dev; a Web II student may equally choose Game Design/Unity or Web Dev. Neither pathway "belongs" to one course. A student enrolled in *both* Game II and Web II is just the clearest illustration of this (she can go deep on one pathway or split across both), not the only student it applies to — a student enrolled in only one of the two courses still has the same open choice between Game Design/Unity and Web Dev. This is a real departure from treating Game II and Web II as fully separate courses for onboarding purposes; treat them as one shared Level 2 cohort for Unit 0 only. Units 1+ still live in separate course folders per course — how a Game-Design/Unity-choosing Web II student's Units 1+ actually get scheduled/delivered isn't resolved yet, see Open Items.

**Not decided yet, deliberately left open:** whether Level 2's course-vs-pathway distinction extends past Unit 0 into the rest of the year (i.e., does a Web II student who wants to go deep on Game Design/Unity get graded/scheduled through Game II's content instead?). Out of scope for this doc — flagged in Open Items below.

## Pathway Scope — Keep It Simple For Now (per Jay, 2026-08-17)

- **Web Dev pathway** = HTML, CSS, JavaScript. That's it as of this writing. **Do not mention PHP or a backend/"app dev" track in Unit 0 or in early Web II framing.** PHP may get introduced later in the actual Web II course if it happens, but it should not be a promise made this early, in case it doesn't happen. See `../CLAUDE.md`'s Courses table, which still lists a PHP backend as part of Web Dev's eventual scope — that's fine to keep as a longer-range course-plan detail, just not surfaced to students in onboarding.
- **Game Design/Unity pathway** = game development in Unity (C#). No separate JS/HTML5-app-dev-vs-Unity split needs to be explained in Unit 0 — that nuance (Game II historically JS-first, now reversing toward Unity-first, "Unity-only" being a valid student choice) belongs in Game II's own course-plan.md, not the shared onboarding unit. Unit 0 just needs to name the two pathways ("Web Dev" and "Game Design/Unity") and let students know they'll choose.
- **Don't enumerate every tool/language a pathway might eventually touch.** Follows from the point above — Unit 0 introduces pathways at the level a 9th-13th grader needs to make an informed first choice, not a full tech-stack breakdown.

## Shared Spine (applies to both editions)

Base skeleton reuses Game I's existing Unit 00 checklist (`../courses/python/course-plan.md` lines 21-32) as a starting point — it was already close to pathway-agnostic. Revised here for two editions instead of one Python-only unit. **This supersedes that section of `course-plan.md`'s Unit 00 once this outline is confirmed — not yet applied there, see Open Items.**

| # | Lesson | Shared or edition-specific? |
|---|---|---|
| 00.1 | Welcome | Shared intro + one edition-specific orientation block: L1 states "you're doing Python all year"; L2 introduces "you'll choose a pathway" without naming Web Dev/Game Design/Unity in depth yet (that's 00.8). |
| 00.2 | How Learning Works | Fully shared, verbatim across both editions. |
| 00.3 | Using Your Tools | Shared "why tools matter" intro + pathway-tagged setup callout boxes (Python/VS Code for L1; VS Code + browser dev tools for Web, Unity Hub/Editor for Unity, both shown at L2). |
| 00.4 | Troubleshooting Is Learning | Fully shared. Generalized from Python's existing "Debugging Is Learning" title/framing so the same page reads naturally whether the student's "bug" is a Python traceback, a broken CSS layout, or a Unity scene that won't run. |
| 00.5 | Introduction to Computational Thinking | Fully shared. |
| 00.6 | How Problem-Solving Works | Fully shared. Generalized from Python's "How Programmers Solve Problems" — Web Dev's HTML/CSS work isn't always "programming" in the strict sense, and the shared page shouldn't imply otherwise. |
| 00.7 | Getting Unstuck | Fully shared — how to ask for help, use documentation, and (per the existing academic-integrity policy already in `../courses/python/course-plan.md`) what AI-assistance use is and isn't allowed. Good place to plant that policy program-wide instead of just in Python. |
| 00.8 | *(L2 only)* Choosing Your Pathway | Introduces Web Dev and Game Design/Unity side by side, plain language, no jargon. States plainly that **every Level 2 student chooses between Game Design/Unity and Web Dev regardless of which course (Game II, Web II, or both) they're enrolled in** — a Game II student isn't defaulted into Game Design/Unity, a Web II student isn't defaulted into Web Dev. Also addresses the "go deep on one, or do both" option for students enrolled in both courses. Could reuse the Web course map's "Entry Diagnostics and Acceleration Path" idea (`../starter context/Web_Development_Course_Map_Certification_Aligned.md` line 1380) as a model for how a placement/diagnostic conversation could work, though that doc scopes diagnostics to HTML/CSS/JS acceleration specifically, not pathway choice — worth a lighter, non-diagnostic version here. |
| — | *(L1 only)* MDA framework intro | Kept exactly as Python's existing Unit 00 already has it (Mechanics/Dynamics/Aesthetics, using games students already play) — L1 is Game I, this is core, not a tagged aside. |
| — | *(L2, Game Design/Unity-tagged callout)* MDA framework intro | Same content, presented as a "if you're leaning Game Design/Unity" callout rather than core spine content, since a Web-only-focused L2 student shouldn't be required to engage with it the same way. |
| — | *(L2, Web-tagged callout)* Usability/HCD first look | The Web-pathway analog to the Game Design/Unity-tagged MDA box — a first, light pass at "designing for a user," expanded properly once Web II's own units begin. Mirrors the existing "usability/HCD is a real but lighter throughline" note already written for Game I (`../courses/python/course-plan.md`'s Game Design/UX section). |

No unit project for Unit 0 in either edition, consistent with Python's existing "onboarding only" note.

## Marking What's Relevant (per Jay, 2026-08-17)

**Inline labeled callout boxes on one linear page/lesson sequence** — not a branching picker or separate filtered builds. A student reads mostly the same content everyone else does and just recognizes, by a visible label ("Python Pathway," "Web Dev Pathway," "Game Design/Unity Pathway"), which boxes are core-for-them vs. exposure/preview. Matches the existing component-library visual language rather than introducing a new interaction pattern — a simple labeled/colored callout box, no new component needed. Follow `../02-authoring-system/component-library/index.html`'s existing patterns when this gets built as real HTML; don't invent a new box style without checking there first.

## Physical Location

**Single shared source, not per-course copies.** Lives outside any one course's `content/` tree so both editions can be built from one authored source without drift. Proposed location, following the existing `courses/<course>/content/unit_XX_slug/` naming pattern one level up:

```
FoxCS/
  shared/
    unit_00_onboarding/
      unit_00_overview.html              Two entry points or a toggle: Level 1 / Level 2
      lesson_00_01_welcome/
      lesson_00_02_how_learning_works/
      lesson_00_03_using_your_tools/
      lesson_00_04_troubleshooting_is_learning/
      lesson_00_05_computational_thinking/
      lesson_00_06_problem_solving/
      lesson_00_07_getting_unstuck/
      lesson_00_08_choosing_your_pathway/     L2 only
```

Each course's own `course-plan.md` should link to this shared unit rather than re-listing it, once it's built. **Not yet created — this is the proposed location, nothing physically built here yet.**

## Certification Framing Touches Unit 0 Lightly

Per Jay's broader 2026-08-17 scope note (full detail belongs in each course's own course-plan.md, not here): one industry certification is the mandatory floor per pathway, a second is encouraged where the pathway supports it. Game I (Python) is the exception — one certification (IT Specialist Python), then the course moves on to MakeCode Arcade for 2D projects rather than a second cert. Unit 0 doesn't need to teach the certification details, just plant the idea that a real industry credential is part of where the year is headed, consistent with the "certifications establish a technical floor, not the ceiling" framing already written in `../starter context/Web_Development_Course_Map_Certification_Aligned.md`.

## Open Items This Doc Doesn't Resolve

- Not yet applied: rewriting `courses/python/course-plan.md`'s existing Unit 00 section to point at this shared unit instead of describing its own copy.
- `courses/game-programming-2/` and `courses/web-dev/` don't exist yet — see `../decisions-log.md`'s 2026-08-17 entry for the skeleton just created, and each new course's own `CLAUDE.md`/`course-plan.md` for what's still unbuilt there.
- Whether the Level 2 "one shared pathway pool regardless of course enrollment" model extends past Unit 0 into actual scheduling/grading for a dual-enrolled student — not decided, flagged above.
- The actual instructional HTML for every lesson above — none written yet. Follow `../02-authoring-system/authoring-workflow.md`'s 8-phase process per lesson, same as Python's Unit 01.
- Whether 00.8's pathway-choice framing should borrow anything from the Web course map's "Adaptive Project Pathways" (Guided Build / Design Challenge / Build Your Own) or "Starter/Skilled/Legendary/Mythic" project-depth tiers (`../starter context/Web_Development_Course_Map_Certification_Aligned.md` lines 1057-1101) — those are project-structure concepts, not obviously onboarding content, but worth a deliberate yes/no rather than silently ignoring them.
