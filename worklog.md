# Worklog

Session-to-session continuity notes — what's mid-flight and what's next. Not append-only like `decisions-log.md`; update/trim this freely as work completes. See `decisions-log.md` for the permanent record of what was actually decided, and `open-questions.md` for longer-lived unresolved questions.

## Where things stand as of 2026-08-06 (consolidated — see `decisions-log.md` for full entries on each)

**Moodle is paused, not abandoned.** FoxCS pivoted to an MVP: self-contained unit folders, distributed and submitted through Google Classroom, carrying the same instructional logic (DOK spread, Reinforce/Core/Extend ladder, objectives) the Moodle plan was built around. `CLAUDE.md`, `02-authoring-system/mvp-unit-folder-structure.md`, and `courses/python/course-plan.md` all reflect this.

**Course catalog** (still forming): 4 courses — Game Programming I (Python, sequential, active), Game Programming II (JS/HTML5 app dev and/or Unity, student's choice), Web Dev/"Web II" (same independent-exploration model, HCD focus, PHP-ish backend). Whether "Unity" is a separate course or a Game II lane is unresolved — see `open-questions.md`.

**FoxCS: Python has a year-long game-design/MDA/journal thread** woven through all 21 units (`course-plan.md`'s "Game Design, UX, and Journal Threads" section) — MDA framework, journal prompts growing from 50-75 words (Unit 00) to a ~2-page paper (Unit 20), a confirmed grading rubric, and a platform-wide AI-use academic-integrity policy (`01-privacy-and-governance/academic-integrity-ai-use.md`: AI-generated writing/code = 0 + Aspen record, always human-confirmed first).

**Unit 01 exists in two different states right now — know which lesson you're looking at:**
- **Lesson 01.4** (`lesson_01_04_printing_output/`) is the **current reference implementation**: flat numbered files `01_instruction.html` through `11_feedback.html` (11 steps, no subfolders), mastery-check/project answers in plain `.py` files saved via VS Code, Duolingo-style disposable practice drills, tiered project XP, a drag-to-match vocab quiz gated on 100% completion (saves with a `_completed` filename suffix), an HTML feedback form using save-in-place, AA-corrected colors per the new `design-system.md`. Built 2026-08-06 after researching and rejecting Monaco/Pyodide as overkill (students already have Python via VS Code) — see `decisions-log.md`'s two 2026-08-06 entries for the full reasoning, including a couple of features (flashcard self-assessment, obfuscated mastery-check content) that were built and then deliberately dropped in the same session.
- **Lessons 01.1, 01.2, 01.3, 01.5, 01.6** are still on the **prior (2026-08-04) engine**: stateful practice-routing JS, mastery checks with embedded answer textareas + save-in-place, old un-corrected colors (`#2a78d6`/`#eda100` fail AA contrast with white text — see `design-system.md`), multi-variant password-gating only exists on 01.1. Don't treat these as the current pattern.
- The Unit Project, journal (in `lesson_01_02.../`), and codename-policy/naming decisions (no self-naming, numbered-not-subfoldered files) apply across all 6 lessons already.

**Added later the same day (2026-08-06), several more rounds:**
1. A drag-to-match vocab quiz (`04_vocab_quiz.html`) as the real XP-earning flashcard-study activity — save gated on getting all terms correct, filename gets a `_completed` suffix on save. This bumped every later file in Lesson 01.4 up one number (now `01` through `11`, ending at `11_feedback.html`).
2. An indentation-aware two-line "sneak peek" block builder previewing Unit 05's `if` statements (Drill 7 on `05_practice.html`, clearly bonus/not-core-content since Unit 01 doesn't teach indentation-requiring syntax yet), and a combined dropdown+typed-blank drill (Drill 6, same file). Also surveyed all of Unit 01 and identified two more drag-drop types worth building later — categorization (01.2's I/P/O sort, 01.6's error-type sort) and sequencing (01.3's line-reordering).
3. **A video embed was added to `01_instruction.html`, then removed the same day.** Jay clarified he didn't want fabricated content in real lessons, just proven functionality — confirmed hard by the placeholder producing a real YouTube Error 153 when tested. Replaced with **`02-authoring-system/component-library/index.html`** — a real, browsable HTML page cataloging every interactive pattern (12 total) with working demos using deliberately generic, non-curriculum content. This is also where the categorization and sequencing types got their first real, working implementation (demoed there, not yet built into any real lesson) — Jay can review and approve the mechanic before it's invested into 01.2/01.3/01.6.

See `decisions-log.md`'s matching same-day entries and `mvp-unit-folder-structure.md`'s "Component Library" section (which now contains "Interactive Drill Types" and "Embedded Video" as subsections).

Marked ✅ drafted, not 🔍 reviewed, in `course-plan.md` — none of this has had Jay's eyes on it yet as a real class experience.

## Added 2026-08-07/08 — component library review pass

Jay reviewed the component library and flagged real fixes, all applied: multi-line block builder now uses valid, labeled Python instead of ambiguous pseudo-syntax; feedback across most components now explains *why* an answer is right, with a general-reminder fallback for genuinely undiagnosable wrong answers (typed free-recall especially); drag-to-match shows a labeled badge for which term landed on which definition; categorization has real text feedback instead of a silent counter; sequencing has ▲▼ button backups to dragging; glossary card clamps to the viewport. Video embed is now **Live** — Jay provided a real video and it's embedded in the library for the first time, first real proof the pattern works (not yet deployed into any real lesson). Full detail in `decisions-log.md`'s 2026-08-07 entries.

**Mastery-check timestamp mechanism corrected**, both in the component library (#12) and the real `lesson_01_04_printing_output/09_mastery_check.html`: students no longer copy a visible timestamp by hand (a mistake in the original design, per Jay) — unlock/completion times now write automatically as hidden DOM fields and save with the page itself. `mvp-unit-folder-structure.md` and the teacher-materials KEY doc (which also had a stale `08_/09_` file-number reference from an earlier renumbering pass) are corrected to match.

**Resolved:** simulated in-browser IDE that matches typed code against accepted responses — declined, same reasoning as the earlier Monaco/Pyodide rejection. **Built instead:** component #14, a code execution stepper (simulated IDE look, syntax highlighting, Play/Pause/Step/speed transport, a curated-branch dropdown for "what if" input, and a separate randomized-speed typing animation for debugging/edit demos). Nothing executes — every step is hand-authored. Refined same day: speed control is now a 0.25-2.0 quarter-step slider, and all three traces now include a 4th "after the loop" line showing execution continues past the loop regardless of iteration count. Not yet deployed into any real lesson.

**Shared CSS + design system built** — `02-authoring-system/shared-styles/` (`foxcs-base.css`, `foxcs-ide-dark.css`, `foxcs-theme-toggle.js`, `README.md`). Component library now links these live instead of repeating its own copy, with a working light/dark toggle. Real lesson content intentionally does NOT link them yet — see `shared-styles/README.md`: the open question of whether Classroom preserves folder structure on download makes an external `<link>` a real risk for distributed content, so lesson pages stay self-contained and hand-synced for now. Full detail, including real computed contrast ratios for the new dark theme, in `decisions-log.md`'s 2026-08-08 entries and `design-system.md`'s new "Dark Mode / Theme Toggle" section.

## Added 2026-08-08 (later) — theme system + telemetry, design only

Jay wants 4 student-selectable color themes (light default, dark, new Natural/parchment, new Synthwave/cyber — palettes pending his own visual reference) and a full interaction-telemetry layer (theme choice, every stepper speed change, hints used, Core/Reinforce/Extend routing per skill, stuck/recovery evidence, start/save timestamps), aimed at markdown/JSON files he can later load into a database. Two new design docs written, nothing built yet: `02-authoring-system/theme-system.md` and `02-authoring-system/telemetry-and-analytics.md`. See `decisions-log.md`'s matching entry for the full design (link-edit + dropdown reconciled at Save; one hidden JSON event log per page; pipeline rides the existing not-yet-built codename-swap script).

**Reopened, not resolved:** the Classroom-folder-structure-on-download question now blocks three things (shared CSS rollout, the codename-swap script's scoping, and this theme system). Worth Jay running the cheap empirical test described in `theme-system.md` before more is built around the unknown.

## Added 2026-08-08 (later still) — theme system + telemetry wired into the component library (#15, #16), browser-tested

Both designs are now real, working demos, not just docs: 4 new theme files (`shared-styles/foxcs-theme-{light,dark,natural,synth}.css` — Natural/Synthwave explicitly placeholder), the reusable `shared-styles/foxcs-telemetry.js` event-log mechanism, and a new `component-library/theme-and-telemetry-demo.html` showing both working together (theme dropdown + link-edit reconciled at Save, a throwaway Core/Reinforce/Extend drill generating real events, a toggle-able panel showing the live telemetry JSON). Embedded into `component-library/index.html` as #15/#16. Browser-tested end to end (local server + Chrome automation) — no console errors, all 4 themes render, both theme-change methods fire events correctly, the Reinforce path and "stuck" flag both work. Full detail in `decisions-log.md`'s matching entry.

**Next up, added to the existing list:** wire `FoxCSTelemetry.log()` into the *other* library components (stepper transport controls, drag-to-match, categorization, sequencing, hints) — not done yet, this pass only proved the mechanism on a standalone demo.

## Added 2026-08-10 (even later) — block builder layout, color fixes, misconception redesign + reveal, Key Terms analogies, vocab quiz reflection

A long stretch of concrete fixes across both the theme system and real Lesson 01.4 content, all browser-tested: multi-line block builder now shows both target lines together before the piece banks (component-library #3 + Drill 7); Light/Dark's Warning and Error colors were too similar, now genuinely distinct hues; Synthwave's violet accent extended to drag-drop borders and "already placed" blocks (feedback colors themselves confirmed and left untouched); the "Two Mistakes" section restyled from a heavy red block (which turned out to be a real Tone Note violation — red is reserved for academic integrity) to a plain reading card, with a new "click to see the fixed version" reveal showing the diff in red; every Key Term now has an Example/Note and the more abstract ones get a real analogy; and a new optional reflection prompt at the end of the vocab quiz asks about memory tricks. Full detail in `decisions-log.md`'s matching entry. Also flagged for later, not built: overprovisioned block-builder banks with real distractors, and typed (not just dragged) blanks.

## Added 2026-08-10 (later) — texture tuning + real Lesson 01.4 content fixes

More live review, two threads: the theme specimen's texture needed more presence and to scroll with the page (now 0.1 opacity, yellow-gold tint, `position: absolute`), and a real contrast bug surfaced in inline `<code>` nested in colored feedback boxes (fixed — explicit `color` instead of inheriting). Separately, Jay reviewed actual Lesson 01.4 content and flagged real issues, all fixed: the "Two Mistakes" section's first example was silently teaching two errors as one (fixed to isolate the quote issue); bolded `Label:` lead-ins now always start their own line (new standing rule in `content-voice-and-tone.md`); Key Terms redesigned from indented `<dl>` to non-clickable-looking cards; the passive "Before You Submit" checklist moved from the instructional page (where students couldn't act on it) to sit right above the first practice drill as a reminder; and a new Drill 8 gives students real practice diagnosing a compound error (missing both the quote and the paren at once), separated from the now-isolated teaching example. Full detail in `decisions-log.md`'s matching entry, browser-tested end to end.

## Added 2026-08-10 — full contrast rebuild, background textures, per-theme body fonts

Jay's review of the live specimen (real WCAG math, not eyeballing) found the feedback boxes in Natural/Synthwave were only ~1.2-2.1:1 against their own page background — technically AA-passing text, but not reading as a distinct surface. Rebuilt both themes' feedback as rich chips (now ~5.4-9.6:1 vs page, AAA text everywhere), lightened Natural's background again, gave Synthwave's Accent badge its own violet hue instead of reusing Error's magenta ("expand the palette"), and built real background textures (SVG paper grain for Natural, CSS line grid for Synthwave, both using the style guide's own opacity numbers). Also relaxed the "body text is always Atkinson Hyperlegible" rule — Natural now reads in Lora, Synthwave in Sora, both self-hosted, free/OFL, genuinely legible text faces. Full numbers and reasoning in `decisions-log.md`; `theme-system.md` updated to match. Production theme files (`shared-styles/foxcs-theme-natural.css`/`-synth.css`) carry all of this now — the component library and telemetry demo pick up the new colors automatically since they link those files directly.

**Not yet done:** wiring the new font tokens into `foxcs-base.css` itself (still hardcodes Georgia) or the background texture into any real component — both exist only in `theme-typography-specimen.html` so far.

## Added 2026-08-09 — Code Hotspot component (#17)

New component-library pattern: hover/click annotations on specific code tokens (why is this keyword here, not what does it execute), plus an ordered step-through slideshow sharing the same state — both requested by Jay mid-session, using his own C# `public`/`private`/`void` example. Reuses the dark IDE surface from the code stepper (#14) and the hover/pin mechanism from Glossary Term (#13) rather than building either from scratch. Browser-tested (click-to-pin, step transport, sync between the two modes) — see `decisions-log.md`'s matching entry. Not yet deployed to any real lesson; natural fit once Game II/Unity content exists.

## Added 2026-08-08 (even later) — real Natural/Synthwave palette, self-hosted fonts, typography specimen

`logos/waypoint_theme_typography_style_guide_full.md` (Jay's real spec, replacing the earlier placeholder guesswork) is now implemented: `shared-styles/foxcs-theme-natural.css`/`-synth.css` carry the guide's real palette, `shared-styles/foxcs-fonts.css` + `shared-styles/fonts/` self-host all 4 required fonts (Atkinson Hyperlegible, Nunito Sans, JetBrains Mono, Source Sans 3 — all free/OFL, confirmed downloadable from fonts.google.com), and `theme-typography-specimen.html` is a real toggleable page showing all 4 themes' typography and color palette side by side. Jay reviewed the rendered page live and asked for 3 fixes, all applied and re-verified in-browser: Natural's background lightened (was reading too tan), Synthwave's Border Strong swapped to the brand magenta for real pink presence (plus a new badge pattern using the guide's functional magenta), and every dark-background theme's semantic feedback colors brightened so they read as distinct surfaces instead of nearly blending into the page. Full reasoning in `decisions-log.md`'s matching entry; `theme-system.md` updated to match.

**Resolved, not still "Waiting on Jay":** the "updated visual-generation reference" item below — it arrived and is now implemented. What's left: real background texture for Natural (not attempted yet) and Jay's continued visual review as the logos themselves finalize.

## Waiting on Jay

- **`02-authoring-system/image-style-guide.md` (conceptual illustration palette) still not updated** — `waypoint_theme_typography_style_guide_full.md` covers UI/theme colors and typography, not illustration style specifically. Don't build a visual illustration template around the current placeholder until Jay's illustration-specific reference lands. The Natural/Synthwave *theme* palettes themselves are resolved (see the entry above) — this is narrower, just the illustration/graphic-asset guidance.
- **Real background texture for the Natural theme** — `waypoint_theme_typography_style_guide_full.md` Section 10 describes the requirement (subtle parchment/speckled feel, low-opacity, never touching text contrast) but nothing is implemented; needs either a real texture image or a CSS-only approximation.
- **A real answer on whether Google Classroom preserves folder structure on download** — a cheap, one-time empirical test (see `theme-system.md`'s "Known Risk" section) that now unblocks three separate decisions at once.
- **Reaction to the Lesson 01.4 reference implementation** — this should decide whether it becomes the template for rebuilding Lessons 01.1-01.3/01.5-01.6, or needs adjustment first.
- **Whether Week 39 ("Final Game Jam Warm-Up — Mechanic redesign") is the design-your-own-game/MakeCode moment**, and whether it pairs with the Unit 20 capstone's already-planned design-document journal entry. Flagged, not confirmed.
- Real weekly Game of the Week pages haven't been built yet — the calendar unblocked this (see below) but nothing beyond the Week-4-adjacent template exists.

## Added 2026-08-06 — revisit/iterate design (Guess-the-Number spine + Game of the Week)

Two designs, confirmed with Jay, neither built into real lesson content yet:

1. **Guess-the-Number revisit spine** — connects three projects that were already independently planned (Unit 06 Number Guessing Game, Unit 11 Game of Chance, Unit 14 Safe Input System) into one continuous thread, seeded at Unit 05, with an optional bonus tail through Units 08-10/16/19. Python turtle graphics as a separate visual thread for Units 06-07 only. Full design in `decisions-log.md`.
2. **Game of the Week** — weekly, low-stakes game-analysis habit, deliberately not tied to unit content, distributed via Classroom (scheduled posts, not a second hosting site), reflection saved in place in the same page. Real 39-week dated calendar now in hand (Jay's `Sample Content/GAME OF THE WEEK CALENDAR (2026–27).pdf`, transcribed to `courses/python/game_of_the_week/game_of_the_week_calendar_2026-27.md`) — the "blocked on Jay's game list" item is resolved. Reference template at `_TEMPLATE_reference.html` (Rock-Paper-Scissors) is now close to real Week 4 content. No real weekly pages built yet.

Neither of these has been rolled into `course-plan.md`'s per-unit entries yet — that's the next real step once Jay confirms the spine design in practice (e.g., reacts to a built Unit 05/06 reference) and once the game sheet arrives.

## Resolved 2026-08-06, Sample Content review

Jay added real prior-year materials (`Sample Content/`) — reviewed in full, findings preserved in `00-project-overview/source-material/sample-content-review-2026-08-06.md`. Key outcomes: validated the numbered-file lesson structure against the real problem it fixes (the old U1L3 packet needed 6+ separate files, objectives duplicated 4x); adopted a complete, ready-to-use grading/feedback spec as `05-grader/feedback-and-grading-spec.md` (resolves the queued "sample teacher feedback responses" task); confirmed AI-use policy stays all-or-nothing to start the year, with a documented-use model as real but not-yet-active future intent. See `decisions-log.md`'s matching entry.

**Two real design opportunities surfaced, not yet built:**
- A FoxCS-native **project bank** (Prompt / What You'll Make / Core Skills / Creative Twist / Challenge Mode format, modeled on 3 real prior banks totaling 65 project entries) for embedded student choice.
- A concrete **"revisit and iterate" mechanic** — Jay's own example (teach input, later add a loop, first bounded-guess-count then guess-until-correct) has no prior precedent to port; needs fresh design, modeled loosely on the real Wasteland Adventure → Expansion Pack revisit pattern.

## Next up

1. **Roll the Lesson 01.4 pattern out to the rest of Unit 01** (01.1, 01.2, 01.3, 01.5, 01.6) — the natural next step now that the pattern is proven on one lesson. Not started. Include the two newly-identified drag-drop types while rolling out: **categorization** on 01.2 (Input/Process/Output sort) and 01.6 (SyntaxError vs. NameError sort), **sequencing** on 01.3 (reorder scrambled print() lines) — see `mvp-unit-folder-structure.md`'s "Interactive Drill Types" table.
2. **Build Unit 00: Course Onboarding end-to-end** — 7 lessons, no project, introduces the MDA framework + general game-mechanics vocabulary and the Unit 00 journal. Should use the Lesson 01.4 pattern from the start. Not started.
3. **Sample teacher feedback responses** — requested by Jay, explicitly queued. Per `content-voice-and-tone.md`'s What-happened/Why/Next-step structure and `lesson-schema.md`'s `feedback.template` field.
4. **Scope and build the codename-swap-on-download script** — see `01-privacy-and-governance/codename-policy.md`'s "Tooling Needed" section. Blocked on knowing what Classroom's bulk-download format actually looks like.
5. **Grading engine, smallest real loop** — against Unit 01. Co-priority with content per Jay.
6. **Test save-in-place on real school Chromebooks**, especially over `file://` — not yet done, see `05-grader/README.md`'s Testing Needs.
7. **Not yet started, lower priority:** whether Game II/Web II need a different (menu/choice-board, not sequential-unit) folder shape — see `open-questions.md`.
8. **Not done, flagged rather than attempted:** a full prose pass of Unit 01 against every rule in `waypoint_curriculum_copywriting_guide.md` (cognitive-load sequencing, feedback-progression staging, etc.) — only the concretely-requested pieces were applied so far.

## Superseded by the pivot — not being done for now

The 2026-07-24 plan was to sample lesson 01.4 side-by-side across Moodle H5P, the Moodle Lesson-activity ladder, and VS Code, plus research whether Moodle can host runnable Python. On hold along with the rest of the Moodle side — worth returning to once Moodle resumes, not deleted from history.

## Longer-term, not urgent

- Pool-size math for the Reinforce/Core/Extend ladder vs. per-unit practice caps needs pressure-testing against real classroom use.
- VS Code's role under the MVP isn't fully settled — still a distinct "surface," or just the editor for the files that need one? (see `open-questions.md`).
