# Shared Unit 0: Cross-Course Onboarding

**New 2026-08-17. Built 2026-08-18.** Design doc for a single onboarding unit delivered, in substance, to all three FoxCS courses (Game I / Python, Game II, Web II) — not three separately authored Unit 0s. See `../decisions-log.md`'s 2026-08-17 and 2026-08-18 entries for how this was decided and built. **Status: real HTML built and verified in-browser** at `../shared/unit_00_onboarding_level1/` (Game I) and `../shared/unit_00_onboarding_level2/` (Game II + Web II) — all 8-9 lessons per edition, the kickoff activity, and both overview pages. Not yet distributed to any real class; no `content/`-tree integration with the three courses' own `course-plan.md` files beyond the existing text pointers.

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

## Kickoff Activity (precedes the spine, both editions, no L1/L2 split)

**Added 2026-08-18** — see `kickoff-avatar-and-intro-activity.md` for the full design. Before (or alongside) 00.1 Welcome, every student in all three courses does the same two-part activity: create a personal avatar in MakeCode Arcade (exported as a fixed `avatar.bmp` — corrected 2026-08-18, MakeCode's export is `.bmp` not `.png` — at exactly 500×500px, into a predictable folder location — "seamless" collection is the whole point, per Jay), then build one Google Slides self-intro (grade, hobbies, favorite game, what they're looking forward to) using that avatar. Unlike the rest of Unit 0, this has **no Level 1/Level 2 distinction at all** — identical for every student regardless of pathway or course. **This is a surprise Jay intends to print the avatars from — never state that purpose in student-facing copy**, see the linked doc's authoring caution.

## Shared Spine (applies to both editions)

Base skeleton reuses Game I's existing Unit 00 checklist (`../courses/python/course-plan.md` lines 21-32) as a starting point — it was already close to pathway-agnostic. Revised here for two editions instead of one Python-only unit. **This supersedes that section of `course-plan.md`'s Unit 00 once this outline is confirmed — not yet applied there, see Open Items.**

| # | Lesson | Shared or edition-specific? |
|---|---|---|
| 00.1 | Welcome | Shared intro + one edition-specific orientation block: L1 states "you're doing Python all year"; L2 introduces "you'll choose a pathway" without naming Web Dev/Game Design/Unity in depth yet (that's 00.9). |
| 00.2 | How Learning Works | Fully shared, verbatim across both editions. |
| 00.3 | Using Your Tools | Shared "why tools matter" intro + pathway-tagged setup callout boxes (Python/VS Code for L1; VS Code + browser dev tools for Web, Unity Hub/Editor for Unity, both shown at L2). |
| 00.4 | Troubleshooting Is Learning | Fully shared. Generalized from Python's existing "Debugging Is Learning" title/framing so the same page reads naturally whether the student's "bug" is a Python traceback, a broken CSS layout, or a Unity scene that won't run. |
| 00.5 | Introduction to Computational Thinking | Fully shared. |
| 00.6 | How Problem-Solving Works | Fully shared. Generalized from Python's "How Programmers Solve Problems" — Web Dev's HTML/CSS work isn't always "programming" in the strict sense, and the shared page shouldn't imply otherwise. |
| 00.7 | Getting Unstuck | Fully shared — how to ask for help the *right* way: use documentation, ask a specific question, go to the teacher, or ask a peer to explain their thinking rather than hand over an answer. Sets up 00.8's boundary from the resourcefulness side before 00.8 states the boundary itself. |
| 00.8 | Academic Integrity: Doing Your Own Work | **Promoted to its own lesson, 2026-08-18** (previously folded into 00.7 as a minor aside — Jay wants this substantial enough to warrant real space). Fully shared, no L1/L2 difference. Covers the full policy in `../01-privacy-and-governance/academic-integrity-ai-use.md`: why attempting your own work matters (you won't learn otherwise; the material is genuinely hard — you're learning a new language), being present matters given how much content these courses cover, partner-work expectations (partners work *together*; abandoning a partner means restarting solo with no credit for work you didn't do), the peer-help boundary (explain how, never hand over code to copy/paste — the helper is as accountable as the copier), the current AI-use policy (not active yet as a permissive model; AI never does the work *for* a student; Jay states explicitly if/when that changes), the exact consequences (call/email home, Aspen write-up, a 0%/F that can't be made up, applied to every involved party), and the partial-credit philosophy (genuine effort always beats a cheated 0, even when the honest attempt is wrong). This is real, substantial content — not a paragraph. |
| 00.9 | *(L2 only)* Choosing Your Pathway | Introduces Web Dev and Game Design/Unity side by side, plain language, no jargon. States plainly that **every Level 2 student chooses between Game Design/Unity and Web Dev regardless of which course (Game II, Web II, or both) they're enrolled in** — a Game II student isn't defaulted into Game Design/Unity, a Web II student isn't defaulted into Web Dev. Also addresses the "go deep on one, or do both" option for students enrolled in both courses. Could reuse the Web course map's "Entry Diagnostics and Acceleration Path" idea (`../starter context/Web_Development_Course_Map_Certification_Aligned.md` line 1380) as a model for how a placement/diagnostic conversation could work, though that doc scopes diagnostics to HTML/CSS/JS acceleration specifically, not pathway choice — worth a lighter, non-diagnostic version here. |
| — | *(L1 only)* MDA framework intro | Kept exactly as Python's existing Unit 00 already has it (Mechanics/Dynamics/Aesthetics, using games students already play) — L1 is Game I, this is core, not a tagged aside. |
| — | *(L2, Game Design/Unity-tagged callout)* MDA framework intro | Same content, presented as a "if you're leaning Game Design/Unity" callout rather than core spine content, since a Web-only-focused L2 student shouldn't be required to engage with it the same way. |
| — | *(L2, Web-tagged callout)* Usability/HCD first look | The Web-pathway analog to the Game Design/Unity-tagged MDA box — a first, light pass at "designing for a user," expanded properly once Web II's own units begin. Mirrors the existing "usability/HCD is a real but lighter throughline" note already written for Game I (`../courses/python/course-plan.md`'s Game Design/UX section). |

No unit project for Unit 0 in either edition, consistent with Python's existing "onboarding only" note.

## Marking What's Relevant (per Jay, 2026-08-17)

**Inline labeled callout boxes on one linear page/lesson sequence** — not a branching picker or separate filtered builds. A student reads mostly the same content everyone else does and just recognizes, by a visible label ("Python Pathway," "Web Dev Pathway," "Game Design/Unity Pathway"), which boxes are core-for-them vs. exposure/preview. Matches the existing component-library visual language rather than introducing a new interaction pattern — a simple labeled/colored callout box, no new component needed. Follow `../02-authoring-system/component-library/index.html`'s existing patterns when this gets built as real HTML; don't invent a new box style without checking there first.

## Physical Location

**Single shared source, not per-course copies.** Lives outside any one course's `content/` tree so both editions can be built from one authored source without drift. Proposed location, following the existing `courses/<course>/content/unit_XX_slug/` naming pattern one level up:

**Revised 2026-08-18 — two real physical editions, not one file with a toggle.** Jay's instruction is precise: Game I sees Python only, never a Web Dev or Game Design/Unity reference; Level 2 (Game II + Web II) sees both those pathways, never Python. A single shared file showing all three pathways in labeled boxes (the original plan below) would let a Game I student scroll past Web/Unity content even if labeled "not for you" — too loose for what Jay actually asked. Since this repo has no live templating (everything is hand-authored static HTML per the MVP's own scrappy-but-real-quality philosophy), the safe way to guarantee that separation is **two real folders**, not one:

```
FoxCS/
  shared/
    unit_00_onboarding_level1/                 Distributed to Game I only
      unit_00_overview.html
      lesson_00_01_welcome/
      lesson_00_02_how_learning_works/          identical content to Level 2's copy
      lesson_00_03_using_your_tools/
      lesson_00_04_troubleshooting_is_learning/ identical content to Level 2's copy
      lesson_00_05_computational_thinking/      identical content to Level 2's copy
      lesson_00_06_problem_solving/             identical content to Level 2's copy
      lesson_00_07_getting_unstuck/             identical content to Level 2's copy
      lesson_00_08_academic_integrity/          identical content to Level 2's copy
      kickoff/                                  identical content to Level 2's copy (built 2026-08-18)
    unit_00_onboarding_level2/                  Distributed to Game II and Web II
      unit_00_overview.html
      lesson_00_01_welcome/
      lesson_00_02_how_learning_works/
      lesson_00_03_using_your_tools/
      lesson_00_04_troubleshooting_is_learning/
      lesson_00_05_computational_thinking/
      lesson_00_06_problem_solving/
      lesson_00_07_getting_unstuck/
      lesson_00_08_academic_integrity/
      lesson_00_09_choosing_your_pathway/       L2 only
      kickoff/
```

The 6 fully-shared lessons (00.2, 00.4, 00.5, 00.6, 00.7, 00.8) and the kickoff activity are **authored once and copied into both editions verbatim** — if one ever needs a real edit, edit both copies together, don't let them drift. Only 00.1 (Welcome) and 00.3 (Using Your Tools) have genuinely different content per edition; 00.9 (Choosing Your Pathway) exists only in the Level 2 copy. `kickoff/`, built 2026-08-18 under a placeholder `shared/unit_00_onboarding/` path (created before this two-folder revision), needs to move into both real edition folders once they exist — not yet done.

Each course's own `course-plan.md` should link to the correct edition rather than re-listing it, once both are built.

## Certification Framing Touches Unit 0 Lightly

Per Jay's broader 2026-08-17 scope note (full detail belongs in each course's own course-plan.md, not here): one industry certification is the mandatory floor per pathway, a second is encouraged where the pathway supports it. Game I (Python) is the exception — one certification (IT Specialist Python), then the course moves on to MakeCode Arcade for 2D projects rather than a second cert. Unit 0 doesn't need to teach the certification details, just plant the idea that a real industry credential is part of where the year is headed, consistent with the "certifications establish a technical floor, not the ceiling" framing already written in `../starter context/Web_Development_Course_Map_Certification_Aligned.md`.

## Open Items This Doc Doesn't Resolve

- ~~Not yet applied: rewriting `courses/python/course-plan.md`'s existing Unit 00 section to point at this shared unit~~ — done 2026-08-17.
- ~~`courses/game-programming-2/` and `courses/web-dev/` don't exist yet~~ — both now have real `course-plan.md`s (29 and 21 units) with full per-unit journal threads, built 2026-08-17/18.
- Whether the Level 2 "one shared pathway pool regardless of course enrollment" model extends past Unit 0 into actual scheduling/grading for a dual-enrolled student — still not decided.
- ~~The actual instructional HTML for every lesson above~~ — **built 2026-08-18**, both editions, verified in-browser. See `../shared/unit_00_onboarding_level1/` and `../shared/unit_00_onboarding_level2/`. No `03_flashcards.html`/`04_vocab_quiz.html`/`05_practice.html`/mastery-check/feedback pages built for Unit 0 — each lesson is instruction-only, which fits Unit 0's actual content (no code being learned yet, nothing to drill), unlike Units 1+.
- Whether 00.9's pathway-choice framing should borrow anything from the Web course map's "Adaptive Project Pathways" (Guided Build / Design Challenge / Build Your Own) or "Starter/Skilled/Legendary/Mythic" project-depth tiers — **partially addressed 2026-08-18**: the built 00.9 lesson now includes a real "How They're Alike / How They're Different" comparison (per Jay's request) covering project openness, pacing structure, and unit count, but doesn't name the Guided Build/Design Challenge/Build Your Own tiers specifically. Worth a deliberate yes/no on naming those explicitly, still not decided.
- **Not yet done**: linking each course's `course-plan.md` to the real built Unit 0 path (`shared/unit_00_onboarding_level1/` or `_level2/`) instead of just the design doc — the text pointers exist but don't give a clickable path yet.
- **Not yet done**: distributing either edition to a real Google Classroom, or building the codename-swap/no-answer-keys export step this would need before real distribution (see `../02-authoring-system/mvp-unit-folder-structure.md`'s Distribution section — Unit 0 has no answer keys to worry about, but the general export step still isn't built).
