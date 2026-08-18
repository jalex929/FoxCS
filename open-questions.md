# Open Questions

Consolidated from both source docs plus new questions raised during reconciliation. Grouped by area. Add my own leaning where I have one — these are still Jay's calls, not decisions.

**See also `02-authoring-system/authoring-flow-gaps-2026-08-11.md`** for a separate, more process-focused audit — gaps in *how* content gets authored/checked/rolled out, distinct from the platform/privacy/grading-workflow questions below.

## MVP Folder Model (new 2026-08-04 — see `decisions-log.md`)

- ~~Naming convention for unit folders and their contents~~ — resolved 2026-08-04, see `02-authoring-system/mvp-unit-folder-structure.md`.
- ~~How does the Reinforce/Core/Extend ladder logic work without a live engine?~~ — resolved 2026-08-04: self-navigated via a visible answer key in `practice/core/`, with explicit routing text in the instructional HTML. See `mvp-unit-folder-structure.md`'s Ladder section. Known accepted cost: nothing stops a student from skipping straight to Extend or peeking at the key early — no engine to enforce order, worth watching during the pilot.
- **What does the instructional HTML page template actually look like?** Waiting on Jay's forthcoming updated image-style-guide/visual-generation reference before finalizing — don't build a template around the current placeholder palette in `image-style-guide.md` if it's about to be replaced.
- **VS Code's role under the MVP** — under the Two-Surface model, VS Code was the applied/creative surface distinct from Moodle. Under the folder MVP, is VS Code still a separate "surface," or does the folder's own instructional HTML + practice files absorb that role, with VS Code just being the editor students happen to use to open the practice files? Not settled.
- **Codename-swap-on-download script** — Jay wants real names stripped and codenames substituted automatically when he downloads submitted folders from Classroom, before anything reaches an AI grading tool. Needs: input format (however Classroom names downloaded folders/files), matching real name → codename (roster lookup), and where it lives (`05-grader/` intake step vs. its own small tool in `01-privacy-and-governance/`). Not built.
- **Student-copy export script** — producing the distributed (no-answer-keys) copy of a unit folder from the authoring source is currently a manual "remember not to include the KEY files" step. Should be scripted before real distribution, same urgency as the codename-swap script. Not built.
- **Does the sequential unit-by-unit model (Unit 00, 01, 02...) even apply to Game II / Web II?** Clarified 2026-08-04: Game II and Web Dev/"Web II" lean on goal-setting and independent student exploration rather than a fixed unit sequence, and Game II is explicitly a student-chosen lane (JS/HTML5 app dev and/or Unity — a student may do Unity only). `mvp-unit-folder-structure.md`'s unit-folder layout was designed against Game I (Python)'s sequential model; Game II/Web II likely need a different shape — something more like a menu/choice-board of goal-driven content than `unit_01 → unit_02 → unit_03`. Not designed yet; revisit once Game I's real folder is built and proven.
- **Is "Unity" a separate course/folder, or fully a Game II lane?** `CLAUDE.md`'s Courses table originally planned Unity as its own course; Jay's 2026-08-04 clarification describes it as a lane students choose within Game II. Not settled — Jay flagged the whole catalog as still-forming ("perhaps this may look like something else").
- **Curated third-party Unity content** — for the Unity lane, Jay wants students able to try existing Unity tutorials/content to get familiar with the platform, not just FoxCS-original material. Needs sourcing (e.g. Unity Learn) and a licensing check before it's referenced the way GMetrix content is (`01-privacy-and-governance/licensing-boundaries.md`).

## Grading Workflow

- **Submission cadence: whole lesson at once, or one file at a time?** *My recommendation: whole lesson/codename folder at once, on a predictable weekly cadence.* This matches the 1-hour/week budget much better — per-file submission multiplies the number of discrete review actions and context switches, and the entire codename-folder / "download all submissions" design in both source docs assumes a batch, not a drip. Worth pressure-testing during the pilot rather than deciding purely in the abstract.
- Expected grading runtime per batch — unknown until the grader exists and there's a real class size to test against.
- Final rubric scale and relationship between points, mastery, and XP.
- How reassessment replaces or supplements an earlier score.
- What similarity-flag threshold triggers review.
- What grading-confidence threshold triggers mandatory human review. **Confirmed 2026-08-04 for one specific case:** any AI-generated-content flag (on journal text or on submitted code) always requires human confirmation before the 0-and-Aspen-documentation consequence is applied — never an automatic action, regardless of detector confidence. See `01-privacy-and-governance/academic-integrity-ai-use.md`. The general threshold question for *other* grading decisions is still open.
- Which AI-text/AI-code detection method or tool the grader will actually use for the authenticity check required by `01-privacy-and-governance/academic-integrity-ai-use.md`. Not chosen yet — quality varies a lot across tools and deserves its own evaluation pass.
- Retention period for grading files and reports.

## Platform / Delivery

- Whether Moodle is district-approved or needs to be independently hosted (relevant to real student data timing, not the pilot).
- Which Python version and VS Code extensions are standard on school machines; whether the visible Run button is reliably configured out of the box.
- Whether downloaded/submitted folders preserve directory structure through Google Classroom. Blocks the codename-swap script (`01-privacy-and-governance/codename-policy.md`'s "Tooling Needed" section) and the pilot-loop test (`05-grader/README.md`'s "Testing Needs" section) — both documented 2026-08-04, neither built/run yet.
- Interactive-practice-HTML compatibility on real school devices/browsers (Chromebooks especially) — untested as of the Unit 01 build. See `05-grader/README.md`'s "Testing Needs."
- Whether reflections are completed locally (in the `.py` file or a text file) or inside Moodle — moot while Moodle is paused; current MVP direction leans toward embedded directly in the submitted folder. Confirm before building the reflection-completion check.

## Codenames / Privacy

- Exact codename format — `PY1-A-ALPHA01` is proposed and provisionally adopted in `01-privacy-and-governance/codename-policy.md`, not finalized.
- Maximum class size / number of sections, which affects codename padding and roster tooling.
- Which AI tools are approved for codename-based grading (SOPPA-relevant — needs district confirmation, not just a technical decision).
- What data may be compared across current and prior performance for proficiency-consistency checks.

## Content Model

- How much of each `adaptive-python` module's existing question bank is directly reusable vs. needs a rewrite for the lighter, two-surface format.
- Where mini-project prompts come from — adapt `adaptive-python`'s `curriculum/projects/project_module_XX.tsv`, or write new ones suited to a classroom (group-friendly, presentable, demoable).
- Exact DOK-level tagging convention — `dok_levels_covered` exists in the schema now but the underlying rubric for "what counts as DOK 3 vs DOK 4 in this course" isn't written yet.

## Superseded / Resolved (kept for history, not actionable)

- ~~Moodle's role~~ — resolved 2026-07-24, see `decisions-log.md`. Two-surface model, not either/or.
- ~~Whether to build a multi-course FoxCS structure now~~ — resolved, parent `FoxCS/` folder adopted.
- ~~Where the identity operator (`is` vs `==`) gets taught~~ — resolved 2026-07-24, placed in Unit 05 alongside comparison operators. See `courses/python/course-plan.md`'s GMetrix Domain Mapping section.
