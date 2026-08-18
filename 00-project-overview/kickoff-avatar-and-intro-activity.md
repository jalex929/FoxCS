# Kickoff Activity: MakeCode Avatar + Self-Intro Slide

**New 2026-08-18.** A Day-1-ish icebreaker activity, done identically by **all three courses** (Game I, Game II, Web II) — not Level 1/Level 2 differentiated like the rest of shared Unit 0, since every student regardless of pathway does the exact same thing. Two parts: (1) create a pixel-art avatar in MakeCode Arcade, export it at a fixed size and filename; (2) build one Google Slides slide introducing themselves, using that avatar. Status: **the MakeCode workflow is now confirmed** — Jay walked through it himself and captured every step as a screenshot (`../makecode images/`, 8 numbered PNGs + his own `avatar.bmp` example). No real student-facing lesson HTML built yet.

## Why This Exists

Per Jay (2026-08-18): he wants every student, in every course, introduced to MakeCode Arcade early — not as a course tool yet (Game II uses it as a real Phase 1 on-ramp per `../courses/game-programming-2/course-plan.md`; Game I uses it as real post-capstone project work per `../courses/python/course-plan.md`'s "Post-Capstone: MakeCode Arcade" section — **this activity is unrelated to both of those uses**, a separate, much earlier touchpoint) — but as the tool for making a personal avatar image tied to their account.

**This is a surprise, per Jay: he intends to get these avatars printed.** Not disclosed to students as the reason for the activity. **Authoring caution, applies to any future session drafting the real student-facing instructions:** do not mention printing, display, or any purpose beyond "make an avatar for your account" in student-facing copy. This doc itself is fine to keep the real reason in, since it's Jay's own planning record, not distributed to students.

## Part 1: MakeCode Arcade Avatar

**Requirements, as specified by Jay:**

- Every student, in every course, creates a personal avatar image in MakeCode Arcade.
- Exported/saved as a **fixed, simple filename** — **`avatar.bmp`** (corrected 2026-08-18: MakeCode Arcade's export is a `.bmp` file, not `.png` — Jay confirmed this by actually doing it; his own example is saved as `avatar.bmp`). Every reference to `avatar.png` anywhere else in this repo's docs is stale and should read `.bmp`.
- Sized/scaled to **exactly 500×500 px** (Jay: "size up and scale their image when complete to the max size, which should be 500x500") before final export — see confirmed steps below; in Jay's own run this came out 500×512, not perfectly square, which the student instructions should account for (see the note in step 7).
- Saved into the student's folder in a **specific, predictable location** so a later process can collect every student's avatar without manual matching — Jay's word was "seamless." This is the same fixed-filename spirit as `../02-authoring-system/mvp-unit-folder-structure.md`'s "No Self-Naming" rule (no student-chosen filenames, ever), applied to a file the student *creates* rather than one provided empty — see the open item below on why that's a real difference, not just a restatement.

### Confirmed steps, 2026-08-18 — Jay walked through the real workflow himself

**Source: `../makecode images/`** — 8 numbered screenshots (`01-assets-tab.png` through `08-click-done-then-right-click-on-your-image-and-save-as.png`) plus Jay's own finished `avatar.bmp`, captured 2026-08-18. Verified against the actual images, not just the filenames. This supersedes the earlier web-research-only guesses below — **this is the real, confirmed workflow:**

1. **Open the Assets tab** — top-right of the MakeCode Arcade editor, next to Blocks/JavaScript. (`01-assets-tab.png`)
2. **Click the green "+"** tile in the asset grid to create a new asset. (`02-green-plus-create-new-asset.png`)
3. In the **Create New Asset** dialog (options: Image, Tile, Tilemap, Animation, Song), **choose Image**. This opens the image editor at its default small canvas size (16×16 in Jay's run — shown as two "16" fields at the bottom-left of the editor, width and height, with a lock icon between them). (`03-click-image-and-see-canvas.png`)
4. **Draw the avatar** at this small native size, using the pencil, fill, rectangle, circle, and line tools on the left, and the color palette swatches below them. (`04-design-your-avatar.png`) — draw first, resize after; don't try to draw directly at 500×500, the canvas starts small.
5. Once the drawing is done, **select the marquee/selection tool** — the grid-shaped icon in the left toolbar, next to the hand/pan tool. (`05-select-marquee-tool-and-drag-to-select-entire-canvas-corner-to-corner.png`)
6. At the bottom-left of the editor, **type 500 into both the width and height fields** (they were showing 16/16) to resize the *canvas* to 500×500. Note: this resizes the canvas only — the drawn artwork stays at its original small size, now sitting in the corner of a much larger canvas. (`06-change-canvas-size-to-500-by-500.png`)
7. Using the marquee tool, **drag a selection box around the small artwork** (corner to corner), then **click and drag the corner handle of that selection box** out to the bottom-right corner of the now-larger canvas — this stretches the artwork to fill the 500×500 canvas. (`07-click-and-drag-corner-of-marquee-box-to-the-bottom-right-corner-of-larger-canvas.png`) **Not pixel-perfect in practice**: Jay's own result came out **500×512**, not a perfect square, confirmed by the Asset Preview panel reading "Size: 500 x 512" — dragging by hand doesn't guarantee an exact square. Worth telling students close-enough is fine, or to drag slowly/re-check the size fields before finishing.
8. **Click Done** to exit the image editor back to the Assets panel. Then **right-click directly on the image thumbnail** and choose **"Save image as"** from the browser's context menu — this downloads the file. **The download is a `.bmp` file**, not PNG. (`08-click-done-then-right-click-on-your-image-and-save-as.png`)
9. Rename/save the downloaded file as **`avatar.bmp`** in the correct location (see Physical Location below).

**Side note confirmed by the same screenshots:** the Assets panel's **Colors** button (bottom-left when an asset is selected) is real and present, matching the earlier web-research finding — palette customization is available from there, not yet walked through step-by-step the way the size/export path now is.

**Reference video, per Jay (2026-08-18):** [MakeCode Arcade image editor walkthrough](https://www.youtube.com/watch?v=zqGZOsdbybs) — shows someone working through drawing a sprite/image in the editor start to finish, including a practical tip (lift your finger off the mouse rather than dragging through a mistake — easier to clean up a small slip than a long stray line). Worth linking directly in student instructions. If embedded (rather than linked out) in real instructional HTML later, use `youtube-nocookie.com` per `../02-authoring-system/mvp-unit-folder-structure.md`'s "Embedded Video" section — a plain link is simplest for now.

**Physical location — proposed, not finalized:** the shared Unit 0 folder structure itself isn't built yet (see `shared-unit-00-onboarding.md`'s own Open Items). Once it is, this activity needs its own slot — e.g. a `kickoff/` folder alongside `lesson_00_01_welcome/`, holding the avatar-creation instructions page (with the 8 screenshots above embedded as step illustrations) and the `avatar.bmp` the student saves there. **The 8 screenshots in `../makecode images/` are the real illustrations for this lesson** — per Jay, they can be moved wherever the student HTML content ends up living once that folder structure is built; recorded here in the meantime so they aren't lost or orphaned.

## Part 2: Google Slides Self-Intro

One slide per student, in Google Slides, including:

- Their MakeCode avatar image (from Part 1).
- What grade they're in.
- What they're looking forward to in this class.
- A hobby or two.
- Favorite game — **explicitly open-ended per Jay**: console, mobile, tabletop, or anything else. Not scoped to video games only.

**Not yet decided:** whether this is one shared class deck (each student adds a slide to a common deck — simpler for Jay to browse/present, but requires a shared-doc permissions setup) or individual per-student files submitted separately. Not specified by Jay yet — flag before building.

## Open Items

- ~~MakeCode Arcade's actual image-export/scaling mechanics~~ — **fully resolved 2026-08-18.** Jay walked through the real workflow and captured every step as a screenshot (`../makecode images/`). Full 9-step sequence in Part 1 above: Assets tab → new Image asset → draw small → marquee tool → type 500/500 into the canvas size fields → drag the selection corner to stretch the art to fill the canvas → Done → right-click the thumbnail → "Save image as." Exports as **`.bmp`**, not PNG — corrected everywhere in this repo that said `avatar.png`.
- Exact folder path for `avatar.bmp` within the (not-yet-built) shared Unit 0 folder structure — the 8 step-screenshots also need a home there once it's built.
- Whether the Slides deck is shared/collaborative or per-student.
- Light privacy-governance check, not yet done: this activity uses a student's real name/likeness-adjacent avatar and personal info (grade, hobbies) for a printed physical display — a different data-handling context than the codename-based pipeline the rest of this repo is built around (`../01-privacy-and-governance/codename-policy.md`). Probably fine, since nothing here flows through the AI-grading pipeline or gets stored as a codename-tagged submission, but worth a deliberate "yes this is fine because X" rather than an assumed pass, especially since Jay has been careful about exactly this kind of boundary elsewhere in this repo.
- Whether this activity is graded/tracked at all, or purely a first-week culture-building activity with no grade attached. Not specified.
- Print logistics (paper size, color vs. B&W, where displayed) — entirely out of scope for this doc, Jay's own logistics.

## Cross-References

- `shared-unit-00-onboarding.md` — this activity sits alongside/before that doc's Level 1/Level 2 spine, but isn't part of it (no pathway differentiation here). That doc's own "Physical Location" section should eventually reserve a slot for this activity once both are built together.
- `../courses/python/course-plan.md`'s "Post-Capstone: MakeCode Arcade" section and `../courses/game-programming-2/course-plan.md`'s Phase 1 — both are real, later, course-specific MakeCode Arcade uses, unrelated to this one-time Day-1 avatar activity beyond sharing the same tool.
- **`../makecode images/`** — Jay's own 8 step screenshots (`01-assets-tab.png` through `08-click-done-then-right-click-on-your-image-and-save-as.png`) plus his finished `avatar.bmp` example, captured 2026-08-18. This is the real source for Part 1's confirmed steps above. Currently sits at the `FoxCS/` root — per Jay, fine to move into the real lesson content folder once the shared Unit 0 structure is built; recorded here so it isn't lost or orphaned in the meantime.
