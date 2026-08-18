# FoxCS: Game Programming II ("Game II")

## Scope

Course name: **FoxCS: Game Programming II**. Second of the FoxCS course line, alongside `courses/python/` (Game I) and `courses/web-dev/` (Web II). Skeleton only as of 2026-08-17 — see `../../decisions-log.md`'s 2026-08-17 entry for how this folder came to exist.

**Scope resolved 2026-08-17**: this course folder's `course-plan.md` is the **Unity-pathway curriculum** specifically — the JS/HTML5 app-dev lane referenced in `../../CLAUDE.md`'s Courses table has fully moved to `../web-dev/course-plan.md` (the Web-Dev-pathway curriculum). Any Level 2 student who chooses the Unity pathway follows this course-plan, regardless of whether they're enrolled in Game II or Web II. A Game II student who chooses Web Dev instead follows `../web-dev/course-plan.md`. Structured/sequential (Game I) vs. choice-driven/independent-exploration (Game II, Web II) is a real pedagogical split, not just naming — see `../../open-questions.md`.

**Shared Unit 0**: Game II does not author its own onboarding unit. It shares one with Web II — see `../../00-project-overview/shared-unit-00-onboarding.md`. Game II students see the **Level 2** edition (both Web Dev and Unity pathways shown, no Python). **A Game II student is not defaulted into Unity** — she may choose Unity or Web Dev, same open choice a Web II student has. Units 1+ are course-specific and live here as normal; how a Web-Dev-choosing Game II student's Units 1+ actually get delivered isn't resolved yet — see Open Questions below and the shared-unit-00 doc's Open Items.

## Source Material

- `../../starter context/Unity_Game_Development_Course_Map_Certification_Aligned_Complete.md` — pre-drafted course map, certification-aligned, not yet digested into a `course-plan.md` for this course.
- `../../starter context/Unity Exam Objectives - Digital Artist - Digital.pdf` and `../../starter context/Unity Exam Objectives - Programmer - Digital.pdf` — the two available Unity certification tracks. **Which one (or both) is the mandatory-floor certification for this course isn't decided yet** — see `../../open-questions.md`.
- **No Unity student workbook exists** (per Jay, 2026-08-17) — unlike Python's GMetrix workbook or Web II's JavaScript/HTML5 workbooks, there's no equivalent hands-on courseware to adapt exercises from directly. Unity Learn (unity.com/learn) is a plausible source of outside curated content, especially once students reach 3D work (Unity Essentials content specifically mentioned) — needs a licensing check before being referenced the way GMetrix content is, per `../../01-privacy-and-governance/licensing-boundaries.md`'s pattern (that file is scoped to GMetrix specifically; a Unity Learn equivalent hasn't been written).
- **No longer relevant here**: `../../starter context/JavaScript_INF-302_Student_Workbook.pdf` and its support files — that's Web-Dev-pathway material now, see `../web-dev/CLAUDE.md`.

## Status

**`course-plan.md` built 2026-08-17** — full Unit 01-29 checklist (source map's Modules 00-28, offset by +1 since FoxCS Unit 00 is the shared onboarding unit, not authored per-course here), certification-objective-mapped against the Programmer/Artist Objective Mapping tables, pacing constraint applied. No `content/` yet — nothing authored past the checklist stage. See `course-plan.md` for the real plan and its own "Open Items" section for what's still unresolved (no journal/Game-UX thread the way Python has one, Unity Learn licensing, the source map's own 23-item "still needs to be created" list).

## Certification Framing

**Resolved 2026-08-17, recommendation not yet confirmed by Jay**: adopt the source course map's own built-in recommendation — **Unity Certified User Programmer is the required/mandatory credential**, **Unity Certified User Artist is the encouraged progress credential**, not required for every student. Reasoning (from the source map, matches the course's own "Game Programming" framing): C# programming, debugging, API interpretation, and Unity workflow are the central technical outcomes; Artist skills (assets, sprites, materials, lighting, Terrain) are valuable breadth every student touches but aren't the primary target. See `course-plan.md`'s "Certification Framing" section for full reasoning and the objective-mapping detail.

## Open Questions

Course-specific — see `../../open-questions.md` for the full platform-wide list, several of which name this course directly (sequential-vs-choice model, curated third-party Unity content licensing).

- **Confirm or override the Unity-cert recommendation above** — it's adopted from the source map's own reasoning, not yet a decision Jay has explicitly made.
- Unity Learn licensing for curated third-party content, especially 3D — not checked.
- Whether this course gets its own Game/UX-tie-in and journal thread the way Python has one — not decided, see `course-plan.md`'s Open Items.
- Whether Phase 4-5 (3D transfer through capstone, course-plan.md Units 21-29) needs to be compressed to land before the AP-testing/senior-checkout pacing window, or whether the capstone's later stages are treated as intentionally low-stakes work that continues through it — not decided, see `course-plan.md`'s Pacing section.
