# Kickoff Activity: MakeCode Avatar + Self-Intro Slide

**New 2026-08-18.** A Day-1-ish icebreaker activity, done identically by **all three courses** (Game I, Game II, Web II) — not Level 1/Level 2 differentiated like the rest of shared Unit 0, since every student regardless of pathway does the exact same thing. Two parts: (1) create a pixel-art avatar in MakeCode Arcade, export it at a fixed size and filename; (2) build one Google Slides slide introducing themselves, using that avatar. Status: **designed, not yet built** — no real lesson content, no tested MakeCode export workflow yet.

## Why This Exists

Per Jay (2026-08-18): he wants every student, in every course, introduced to MakeCode Arcade early — not as a course tool yet (Game II uses it as a real Phase 1 on-ramp per `../courses/game-programming-2/course-plan.md`; Game I uses it as real post-capstone project work per `../courses/python/course-plan.md`'s "Post-Capstone: MakeCode Arcade" section — **this activity is unrelated to both of those uses**, a separate, much earlier touchpoint) — but as the tool for making a personal avatar image tied to their account.

**This is a surprise, per Jay: he intends to get these avatars printed.** Not disclosed to students as the reason for the activity. **Authoring caution, applies to any future session drafting the real student-facing instructions:** do not mention printing, display, or any purpose beyond "make an avatar for your account" in student-facing copy. This doc itself is fine to keep the real reason in, since it's Jay's own planning record, not distributed to students.

## Part 1: MakeCode Arcade Avatar

**Requirements, as specified by Jay:**

- Every student, in every course, creates a personal avatar image in MakeCode Arcade.
- Exported/saved as a **fixed, simple filename** — Jay's own suggestion: `avatar.png`. Adopted here as the working filename unless a technical reason surfaces to change it.
- Sized/scaled to **exactly 500×500 px** (Jay: "size up and scale their image when complete to the max size, which should be 500x500") before final export.
- Saved into the student's folder in a **specific, predictable location** so a later process can collect every student's avatar without manual matching — Jay's word was "seamless." This is the same fixed-filename spirit as `../02-authoring-system/mvp-unit-folder-structure.md`'s "No Self-Naming" rule (no student-chosen filenames, ever), applied to a file the student *creates* rather than one provided empty — see the open item below on why that's a real difference, not just a restatement.

**Not yet verified — needs testing before real student instructions get written:** MakeCode Arcade's native image/sprite canvas is small pixel art (its default project assets are typically tens of pixels, not hundreds), and this repo has an explicit prior lesson about not fabricating instructional steps for a mechanic that hasn't actually been tried (`../02-authoring-system/mvp-unit-folder-structure.md`'s Component Library section — the placeholder-video incident). **Don't write final click-by-click MakeCode instructions until someone (Jay or a session with a real MakeCode Arcade project open) has actually walked the export path and confirmed:**
- Where in the MakeCode Arcade UI a student draws/picks their avatar image (a sprite editor? a dedicated image asset?).
- Whether MakeCode Arcade can export an asset directly as a 500×500 PNG, or whether the export comes out small and needs a separate upscale/resize step (e.g., in an OS image tool) to hit 500×500 — this matters a lot for how simple "seamless" actually is to pull off with 9th-13th graders across three different courses, some of whom will never open MakeCode again all year.
- The exact save location a browser-downloaded MakeCode asset lands in by default, and what the actual student instructions need to say to get it into the right course folder under the exact filename `avatar.png`.

**Physical location — proposed, not finalized:** the shared Unit 0 folder structure itself isn't built yet (see `shared-unit-00-onboarding.md`'s own Open Items). Once it is, this activity needs its own slot — e.g. a `kickoff/` folder alongside `lesson_00_01_welcome/`, holding the avatar-creation instructions page and the `avatar.png` the student saves there. Not designed further than that yet.

## Part 2: Google Slides Self-Intro

One slide per student, in Google Slides, including:

- Their MakeCode avatar image (from Part 1).
- What grade they're in.
- What they're looking forward to in this class.
- A hobby or two.
- Favorite game — **explicitly open-ended per Jay**: console, mobile, tabletop, or anything else. Not scoped to video games only.

**Not yet decided:** whether this is one shared class deck (each student adds a slide to a common deck — simpler for Jay to browse/present, but requires a shared-doc permissions setup) or individual per-student files submitted separately. Not specified by Jay yet — flag before building.

## Open Items

- MakeCode Arcade's actual image-export/scaling mechanics — untested, see Part 1 above. This is the biggest real risk to "seamless."
- Exact folder path for `avatar.png` within the (not-yet-built) shared Unit 0 folder structure.
- Whether the Slides deck is shared/collaborative or per-student.
- Light privacy-governance check, not yet done: this activity uses a student's real name/likeness-adjacent avatar and personal info (grade, hobbies) for a printed physical display — a different data-handling context than the codename-based pipeline the rest of this repo is built around (`../01-privacy-and-governance/codename-policy.md`). Probably fine, since nothing here flows through the AI-grading pipeline or gets stored as a codename-tagged submission, but worth a deliberate "yes this is fine because X" rather than an assumed pass, especially since Jay has been careful about exactly this kind of boundary elsewhere in this repo.
- Whether this activity is graded/tracked at all, or purely a first-week culture-building activity with no grade attached. Not specified.
- Print logistics (paper size, color vs. B&W, where displayed) — entirely out of scope for this doc, Jay's own logistics.

## Cross-References

- `shared-unit-00-onboarding.md` — this activity sits alongside/before that doc's Level 1/Level 2 spine, but isn't part of it (no pathway differentiation here). That doc's own "Physical Location" section should eventually reserve a slot for this activity once both are built together.
- `../courses/python/course-plan.md`'s "Post-Capstone: MakeCode Arcade" section and `../courses/game-programming-2/course-plan.md`'s Phase 1 — both are real, later, course-specific MakeCode Arcade uses, unrelated to this one-time Day-1 avatar activity beyond sharing the same tool.
