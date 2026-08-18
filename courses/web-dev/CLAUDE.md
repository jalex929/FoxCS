# FoxCS: Web Dev ("Web II" / "Web Design II")

## Scope

Course name: **FoxCS: Web Dev**, referred to as "Web II" or "Web Design II" depending on context. Third of the FoxCS course line, alongside `courses/python/` (Game I) and `courses/game-programming-2/` (Game II). Skeleton only as of 2026-08-17 — see `../../decisions-log.md`'s 2026-08-17 entry for how this folder came to exist.

Per `../../CLAUDE.md`'s Courses table: HTML/CSS/JavaScript, usability/human-centered-design focus. A PHP (or similar) backend for data storage is listed there as eventual scope, but **must not be surfaced to students early** (per Jay, 2026-08-17) — see the Certification/Scope note below before adding backend content to any student-facing material. Structured/sequential (Game I) vs. choice-driven/independent-exploration (Game II, Web II) is a real pedagogical split, not just naming — see `../../open-questions.md`.

**Shared Unit 0**: Web II does not author its own onboarding unit. It shares one with Game II — see `../../00-project-overview/shared-unit-00-onboarding.md`. Web II students see the **Level 2** edition (both Web Dev and Game Design/Unity pathways shown, no Python). **A Web II student is not defaulted into Web Dev** — she may choose Web Dev or Game Design/Unity, same open choice a Game II student has. Units 1+ are course-specific and live here as normal; how a Game-Design/Unity-choosing Web II student's Units 1+ actually get delivered isn't resolved yet — see Open Questions below and the shared-unit-00 doc's Open Items.

## Source Material

- `../../starter context/Web_Development_Course_Map_Certification_Aligned.md` — pre-drafted, certification-aligned course map (1400+ lines), not yet digested into a `course-plan.md` for this course. Already covers computational thinking, UX/product thinking, user research, UI/interaction design, accessibility, testing, technical best practices, and a full certification-objective mapping. **Read this file before authoring anything** — a lot of the design thinking (adaptive project pathways, project-depth tiers, entry diagnostics) is already worked out there.
- `../../starter context/JavaScript_INF-302_Student_Workbook.pdf` + `.../JavaScript_INF-302_Student_Support_Files/` and `../../starter context/HTML5_Application_Development_Student_Workbook.pdf` + `.../HTML5_Application_Development_Student_Support_Files/` — LearnKey/Certiport-aligned workbooks and starter files, same role Python's GMetrix workbook plays for Game I. Licensing boundary treatment (see `../../01-privacy-and-governance/licensing-boundaries.md`) should extend to this material the same way it applies to GMetrix content — not yet written for these specific sources.
- `../../starter context/ITS OD 302 Javascript 0225.pdf` and `../../starter context/ITS OD 306 HTML App Develop 0225.pdf` — official exam objective documents for the two certifications.

## Status

**`course-plan.md` built 2026-08-17** — full Unit 01-21 checklist, translated from `Web_Development_Course_Map_Certification_Aligned.md`'s module tree, certification-objective-mapped, pacing constraint applied. No `content/` yet — nothing authored past the checklist stage. See `course-plan.md` for the real plan and its own Open Items section for what's still unresolved (the Web I/II acceleration-diagnostic mechanism, no confirmed post-AP-testing project activity the way Game I has MakeCode Arcade, whether Units 21.20/21.21 become the same cross-course journal thread Game I has).

**Scope resolved 2026-08-17**: this course folder's `course-plan.md` is the **Web-Dev-pathway curriculum** specifically (HTML/CSS/JS) — any Level 2 student who chooses that pathway follows it, regardless of whether they're enrolled in Web II or Game II. A Web II student who chooses Unity instead follows `../game-programming-2/course-plan.md`.

## Certification Framing

**Corrected 2026-08-18, per Jay — overrides the starter-context course map's own labeling.** The source map states HTML5 Application Development as required and JavaScript as encouraged; that's backwards from the real prerequisite structure — **JavaScript certification is a prerequisite for HTML5 Application Development.** Actual framing: **JavaScript is the required/mandatory credential**; **HTML5 Application Development is the encouraged second credential**, gated by the JavaScript prerequisite and achievable only for students who reach readiness in time. Matches Jay's general 2026-08-17 framing (one mandatory cert per pathway, a second encouraged where supported) and mirrors Game Design/Unity's Programmer-required/Artist-encouraged structure — the same "achievable, not guaranteed, tied to effective time use" tone confirmed for the Unity Artist credential likely applies here too, not yet written. See `course-plan.md`'s Certification Framing section for full detail.

**PHP/backend scope note:** a PHP or similar backend is listed in `../../CLAUDE.md`'s Courses table as part of this course's eventual scope, but per Jay (2026-08-17), that should not be identified to students early or promised in onboarding, in case it doesn't end up happening. Fine to keep as a longer-range internal course-plan note; don't surface it in student-facing material (including Unit 0) until it's actually confirmed.

## Open Questions

Course-specific — see `../../open-questions.md` for the full platform-wide list.

- Reconciling the starter-context map's own "Web Development I / Web Development II" framing (one continuous course with an HTML/CSS acceleration diagnostic into Web II) against this course being FoxCS's only web-track course — is there a Web I feeding into this, or does Web II's "II" just mean "second-year track" independent of a FoxCS-authored Web I? Not resolved.
- `course-plan.md` doesn't exist yet — everything above is scoping, not a real unit/lesson plan.
