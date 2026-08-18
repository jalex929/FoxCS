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

### Confirmed via research, 2026-08-18 (web search + Jay's pasted video excerpt)

- **500×500 is not an arbitrary number Jay picked — it's MakeCode Arcade's own documented maximum image size.** The editor is "hardwired" that way. This means "size up to the max" and "500×500" are the same instruction, which is worth saying explicitly to students (it's the biggest their avatar is *allowed* to be, not an arbitrary target).
- **Changing the color palette (real, sourced steps):** in the **Assets tab**, click the **Colors** button (left side) to open the Color Palette window. From there, choose one of several built-in predefined palettes, or build a **custom palette** (Arcade supports up to 15 colors + transparent = 16 total) by entering hex codes, then click **Apply** to set it for the project. Source: [Switching Color Palettes in Microsoft MakeCode Arcade](https://medium.com/kikis-corner/switching-color-palettes-in-microsoft-makecode-arcade-7a9bf6874a8c), [Custom Color Palettes for MakeCode Arcade Games (Adafruit)](https://learn.adafruit.com/custom-color-palettes-for-makecode-arcade-games/custom-palettes-in-makecode-arcade).
- **Resizing/creating at a larger size:** the image editor has a **resizable marquee** — select all or part of the image and drag to resize by hand. Source: [His Heart Grew 3 Sizes — Resizing Sprites in MakeCode Arcade](https://medium.com/kikis-corner/his-heart-grew-3-sizes-resizing-sprites-in-makecode-arcade-c099f8d2e903). Exact click path (which button/handle, whether a new image asset can be created at 500×500 from the start rather than resized up after drawing small) still needs a live walkthrough before finalizing steps — drawing small and scaling up will look blocky/low-fidelity, so starting at full size if possible is the better answer if the editor supports it.
- **Drawing tool shortcuts (official MakeCode docs, [makecode.com/asset-editor-shortcuts](https://makecode.com/asset-editor-shortcuts)):** `b`/`p` Pen, `e` Eraser, `g` Fill, `l` Line, `u` Rectangle, `c` Circle; `ctrl+z`/`ctrl+y` (or `cmd`) undo/redo; `x` swaps foreground/background color; `shift+.`/`shift+,` adjust pen size; number keys `0`-`9` pick from the first ten palette colors.
- **From Jay's pasted video excerpt:** a practical drawing tip worth including in student instructions — if you're going to make mistakes, lift your finger off the mouse while drawing rather than dragging through the error, since a stray drag takes away more than intended; small mistakes are easy to clean up after. Clicking **Done** exits the image editor and shows the finished image centered in the simulator.

**Reference video, per Jay (2026-08-18):** [MakeCode Arcade image editor walkthrough](https://www.youtube.com/watch?v=zqGZOsdbybs) — shows someone actually working through drawing a sprite/image in the editor start to finish. Worth linking directly in student instructions so students can watch a real example before making their own. If this gets embedded (rather than linked out) in the real instructional HTML later, use `youtube-nocookie.com` per the existing pattern in `../02-authoring-system/mvp-unit-folder-structure.md`'s "Embedded Video" section — a plain link is simplest for now since this content isn't built yet.

**Still not verified — the one real remaining gap, needs a live test before finalizing student instructions:** how a student gets their finished image **out of MakeCode Arcade as a standalone `avatar.png` file** on their computer. MakeCode Arcade's project-level export produces a `.mkcd` project file, not a loose image — search results didn't surface a documented single-asset "export as PNG" button. The likely path is right-click → "Save image as" on the rendered asset thumbnail/canvas (most browsers support this on any canvas/image element), but this needs to actually be tried in a live MakeCode Arcade project before it goes into real student instructions. This is the step "seamless" most depends on — worth testing before building anything further here.

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

- ~~MakeCode Arcade's actual image-export/scaling mechanics~~ — **partially resolved 2026-08-18** via web research: 500×500 is Arcade's real documented max size, palette-changing is confirmed and sourced (Assets tab → Colors → pick/build a palette → Apply), and canvas resizing uses a resizable marquee. **Still unresolved**: how a student exports the finished image as a standalone `avatar.png` file (no documented single-asset PNG export found — likely right-click "Save image as," not yet tested live). See Part 1 above for full detail and sources.
- Exact folder path for `avatar.png` within the (not-yet-built) shared Unit 0 folder structure.
- Whether the Slides deck is shared/collaborative or per-student.
- Light privacy-governance check, not yet done: this activity uses a student's real name/likeness-adjacent avatar and personal info (grade, hobbies) for a printed physical display — a different data-handling context than the codename-based pipeline the rest of this repo is built around (`../01-privacy-and-governance/codename-policy.md`). Probably fine, since nothing here flows through the AI-grading pipeline or gets stored as a codename-tagged submission, but worth a deliberate "yes this is fine because X" rather than an assumed pass, especially since Jay has been careful about exactly this kind of boundary elsewhere in this repo.
- Whether this activity is graded/tracked at all, or purely a first-week culture-building activity with no grade attached. Not specified.
- Print logistics (paper size, color vs. B&W, where displayed) — entirely out of scope for this doc, Jay's own logistics.

## Cross-References

- `shared-unit-00-onboarding.md` — this activity sits alongside/before that doc's Level 1/Level 2 spine, but isn't part of it (no pathway differentiation here). That doc's own "Physical Location" section should eventually reserve a slot for this activity once both are built together.
- `../courses/python/course-plan.md`'s "Post-Capstone: MakeCode Arcade" section and `../courses/game-programming-2/course-plan.md`'s Phase 1 — both are real, later, course-specific MakeCode Arcade uses, unrelated to this one-time Day-1 avatar activity beyond sharing the same tool.
