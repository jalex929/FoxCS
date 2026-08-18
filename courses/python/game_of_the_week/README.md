# Game of the Week

A weekly, lightly-graded habit separate from the unit projects. Where the Guess-the-Number revisit spine (see `course-plan.md` and `decisions-log.md`) teaches iteration on *your own code* at a few big milestones across the year, Game of the Week builds the same iteration/design mindset through frequent, low-stakes analysis of *someone else's finished game* — weekly instead of a handful of times a year, so it becomes a reflex rather than an event.

Deliberately **not** tied to that week's unit content. Jay's call: forcing tight alignment would fight the course's real pacing (units run long or short) and turn an intentionally fun, break-up-the-week moment into another content dependency.

## Format

One self-contained HTML file per week — same static, no-build-step pattern as everything else in FoxCS. Each page:

1. **How to Play** — brief, especially for games students already know.
2. **What This Game Is Actually Doing** — a worked explanation of a design concept the game demonstrates (see Scaffolding below).
3. **Reflect** — 2-3 short guided questions, not a long response. Genuinely brief on purpose; this is weekly, and `06-data-and-spreadsheets`/`05-grader`'s 1-hour/week grading budget doesn't have room for a rubric-scored artifact every week. Treat these as completion/authenticity checks, not full rubric grading.
4. **Save** — reflection is answered directly in the page and saved in place (`showSaveFilePicker`), the same mechanism already proven on `lesson_01_04`'s feedback form and vocab quiz. No separate file, no copy-paste.

See `_TEMPLATE_reference.html` for a full worked example (Rock-Paper-Scissors, generic placeholder content — built per the component-library-first rule since Jay's real game list hasn't been provided yet).

## Scaffolding fades over the year — and stays lean even early on

Early weeks carry a short worked explanation of the concept (walking through *why* a mechanic works, not just naming it) because students don't have game-design vocabulary yet. **Lean, not a lecture** — 2 short paragraphs max, one concept at a time. Jay's correction 2026-08-06: too much explanation per week is boring and defeats the purpose; the pattern recognition is supposed to build gradually across many light weekly exposures, not get front-loaded into any single week. Later weeks should shrink the explanation further and open the reflection prompts toward fully independent "what did you notice" questions — same gradual-release shape as the journal thread's word-count progression, just compressed into much smaller weekly doses.

## Where this is heading — designing their own game concepts

Jay's real end goal for this thread: by building pattern-recognition across a whole year of weekly games, students should be able to **design their own game concept** by year's end — not necessarily coded by them, though ideally realized as an actual prototype in **MakeCode**. This has a strong existing landing spot: the journal thread's own Unit 20 capstone entry is *already* planned as a ~2-page game-design-document paper (see `course-plan.md`'s Journal Threads section). Worth confirming with Jay whether the MakeCode piece extends/pairs with that existing capstone moment rather than being a separate new deliverable, and whether MakeCode is meant as an approved non-Python option specifically for that one culminating exercise (given the course otherwise teaches Python) or points toward Game II instead. Not resolved yet — flagged, not decided.

**Proposed, not yet built:** a single persistent "Patterns Log" file (same one-file-added-to-over-time shape as other running artifacts in this repo) living in the student's Game of the Week folder alongside the weekly pages — a running list of mechanics/connections they've noticed across games, so by Unit 20 they have an actual accumulated bank to draw from instead of designing from a blank page. Reflection question 3 on each weekly page already nudges toward this (asks students to connect this week's game to another game they know) without requiring the separate file to exist yet.

## Distribution — Classroom only, scheduled in advance

No second hosting location (Jay considered a Google Site with iframe embeds specifically to prepopulate the whole year at once, and dropped it — see `decisions-log.md`'s matching entry for the two reasons: it duplicates the "don't add a second submission location" rule already applied to the feedback form, and it would stack an untested cross-origin File System Access API question on top of the already-untested Chromebook save-in-place question).

The actual goal (prepopulate early, touch it once) is achievable natively: write the whole year's worth of weekly pages up front, attach each to its own Classroom assignment, and use Classroom's **Schedule** (not "Post now") to set each week's real publish date. Zero manual weekly work, one location.

Students create one persistent **"Game of the Week"** folder in their Classroom-connected class folder, made once at the start of the year and reused every week (unlike unit folders, which are per-unit). Each week's file downloads into that same folder — Jay names the file (`week_03_<gamename>.html`, etc.), no student renaming, consistent with the platform-wide no-self-naming rule.

## The real calendar

**`game_of_the_week_calendar_2026-27.md`** — the full 39-week, dated calendar (transcribed from Jay's real `Sample Content/GAME OF THE WEEK CALENDAR (2026–27).pdf`), game + a terse 2-4 word Focus per week. This is the real content source now — build each week's page around its Focus column, not a broader survey of the game. See that file's "Notable connections" section for Week 4 (RPS, matches the template almost exactly), Week 39 (last week, "Mechanic redesign" — likely landing spot for the design-your-own-game/MakeCode idea, not yet confirmed), and Week 31 (Snake, "Input systems, loops" — a possible natural tie-in to Python's loops unit, pacing not yet checked).

## Reflection design note (revised 2026-08-07)

Don't ask students to anticipate a future week's game — they don't know what's coming, so a forward-looking reflection prompt doesn't work.

Reflection questions are drawn from a **varied pool**, not a fixed set reused verbatim every week — pick 2-3 per week, filled in with that week's actual concept(s):

- **Open/general:** "What's the most interesting thing you learned about game design this week?"
- **Generative/apply-elsewhere:** "How else might [concept] be a good thing to consider for a game someone is making?"
- **Design-generative:** "Describe a different way that someone could use [concept] in a game."
- **Transfer:** "Are there any other games you can think of that use [concept]?"

The point is educated guessing and taking a stance, not just noticing — this is direct practice for the design-your-own-game skill the whole thread is building toward (see Week 39, below). Should get less scaffolded (fewer sentence starters, more open framing) as the year goes on, same as everything else in this thread. See `_TEMPLATE_reference.html`'s Reflect section for a worked example (one open question + two concept-filled questions, covering both of the week's Focus terms).

## Vocabulary — glossary-term hover/click cards (added 2026-08-07)

Both the week's specific concept terms (e.g. "hidden information," "balance") and general MDA-framework vocabulary ("mechanic," "aesthetic") should use the **glossary-term component**: an underlined term shows a small definition card on hover, or pinned open on click/tap (important for touch devices where hover isn't reliable) — closes on a second click, clicking elsewhere, or Escape. Keyboard-accessible. Prototyped and documented at `02-authoring-system/component-library/index.html`'s #13 before being used here, per the component-library-first rule. `_TEMPLATE_reference.html` is the first real (non-generic) usage. **Same pattern is proposed for the first appearance of any major vocabulary term on instructional pages generally** — not scoped to Game of the Week only.

## Not yet done

- Real weekly pages haven't been built from the calendar yet — only the Week 4-adjacent template exists.
- Whether Week 39 is really the design-your-own-game/MakeCode moment, and whether it pairs with the Unit 20 capstone journal entry, is flagged but not confirmed with Jay.
- No decision yet on whether Game of the Week extends to Game II / Web Dev, or stays Python-specific. Scoped to Python only for now; don't assume it generalizes without asking.
