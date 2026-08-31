# Adaptive Practice Model — MVP Implementation

Added 2026-08-11. Answers a direct question from Jay: practice drills should have real adaptive branching baked in, but scaled back from the full original scope — not a flat list forever (the 2026-08-06 decision), and not the full-size question banks either.

**Status update, 2026-08-31: Moodle resumed 2026-08-28, superseding this doc's delivery mechanism.** This doc was written under the explicit assumption that "there's no Moodle Lesson activity to run [the ladder] in anymore... Moodle's paused" (see What Changes below) — that assumption no longer holds. Moodle is live again as of 2026-08-28 (see `../CLAUDE.md`). For any lesson built from this point forward, the Moodle-native `mod_lesson` ladder — mechanics in `moodle-lesson-ladder-setup.md`, routing rules and pool size in `objectives-and-skills-proficiency.md` — is the primary Reinforce/Core/Extend mechanism, not the static client-side JS engine designed below.

This doc isn't retired — it stays as reference for whatever VS Code-side static practice content still exists or gets built, where there's no live Moodle Lesson to run against. What's superseded is specifically the *delivery mechanism* (a client-side JS state machine standing in for a platform that was paused), not the authoring philosophy underneath it: the Guided Practice vs. Independent Adaptive Practice split, the 2-4-item spiral-review rule, the Game Connection/UX chip items, and the mixed auto-/teacher-graded assessment idea are all still good, current authoring guidance regardless of which surface actually runs the ladder. The pool-size numbers below are also unified with a single live number now — see the note in Skill Nodes, Not a Flat Drill List.

**This is not a new invention.** The Reinforce/Core/Extend ladder and its routing rules already exist, fully specified, in `objectives-and-skills-proficiency.md`'s "Reinforce / Core / Extend Ladder" section — and the telemetry schema for it (`drill_attempt` with `lane`/`skill_id`, `lane_transition`) has been sitting fully designed in `telemetry-and-analytics.md` since 2026-08-08. Neither has actually been wired into a real lesson yet — `05_practice.html` currently logs a flat `drill_id` with no lane or skill concept at all. This doc is the missing piece: how that already-designed ladder runs on the MVP's static-HTML surface (no Moodle, no live backend) instead of Moodle's Lesson activity, and at what scale.

## Naming

**Settled 2026-08-11, after some back-and-forth.** Two distinct things, two distinct names:

- **Guided practice** — the quick-checks embedded directly in `01_instruction.html`, right next to the teaching they check. Ungraded, formative, no adaptive branching.
- **Practice** — the standalone `NN_practice.html` page (`05_practice.html` in the reference lesson). Not "Practice Drills," not "Guided Practice" — those names are retired. This is where the adaptive skill-node model below lives.

## What Changes From the 2026-08-06 Decision

2026-08-06 dropped the *stateful engine* in favor of a flat drill list, explicitly flagging real branching as "a bigger architectural call than this pass covers." That's now being taken up, but narrower than either the original Moodle-Lesson-activity plan or a full rebuild of the old branching engine:

- **Routing lives in the practice page's own JS**, not a platform feature — there's no Moodle Lesson activity to run it in anymore (Moodle's paused), and no live backend to hold state server-side. The whole ladder is a small client-side state machine, same category of code as the block-builder drills already in `05_practice.html`.
- **Pool size is smaller than either prior plan.** `objectives-and-skills-proficiency.md` was already debating whether even its own 10-15-items-per-lesson cap was too generous once multiplied across 2-4 skills. For the MVP, land tighter — see Pool Sizing below.
- **One node at a time**, not all drills visible on one scrolling page (today's `05_practice.html` layout). A skill node occupies the practice page's visible area; the next node's Core question appears only once the current node's routing has resolved.

## Skill Nodes, Not a Flat Drill List

A **node** is one trackable skill (matches `objectives-and-skills-proficiency.md`'s `skill_id`), holding a small pool of items across three lanes:

- **Core** — 1 item. Every student sees this first.
- **Reinforce** — 1 item (2 at most). Shown only if Core (or the prior Reinforce item) was wrong.
- **Extend** — 1 item (2 at most). Shown only if Core (or the prior Extend item) was right — an optional stretch, not required to advance.

**Pool size, single source of truth (updated 2026-08-31): `objectives-and-skills-proficiency.md`, not here.** This section's Core 1/Reinforce 1-2/Extend 1-2 numbers were originally a tightening of that doc's own looser 2026-07-24 guess (1-2/2-4/2-4) — as of 2026-08-31 that doc has adopted these same tighter numbers directly, so there's exactly one live pool-size number across the repo. If the two ever look different again, `objectives-and-skills-proficiency.md` wins; update this doc to match, not the other way around. Fewer nodes, each authored well, beats more nodes authored thin — same "a few real variants, not one question repeated" principle already in `content-authoring-standards.md`.

**Whole-page target, confirmed by Jay: typically 8-15 questions total.** Not "attempt as many as you can, any number is fine" (the old `05_practice.html` wording, since corrected) — a real expected range, so a student who stops at 3 knows they're well short, not just "attempting what they could." That total isn't only adaptive-node items — it's the sum of adaptive nodes + spiral review + Game Connection/UX items below:

| Component | Typical count | Items |
|---|---|---|
| Adaptive skill nodes | 2-3 nodes | 3-5 items/node (Core + Reinforce + Extend) → 6-12 items |
| Spiral review | **2-4, hard bounds** | 1 item each |
| Game Connection / UX | 0-2 (see below — "when possible," not every lesson fits both) | 1 item each |

A lesson with 2 nodes + 3 spiral + 2 Game/UX lands at 11-13, comfortably inside 8-15. A lesson with 3 richer nodes might not need both Game/UX items to still land in range. Author to the range, don't pad to hit a number.

## Spiral Review

**Added 2026-08-11 per Jay: every Practice page includes 2-4 spiral review items — never fewer than 2, never more than 4.** A spiral review item revisits a skill from an *earlier* lesson, in a more varied or complex context than when it was first taught — per `content-authoring-standards.md`'s existing learning-science principle: "spiral review should feel like progress, not punishment... not a flat repeat that reads as 'you're being made to redo this.'" This doc is what finally turns that principle into a concrete authoring requirement with real bounds, instead of leaving it as a judgment call with no floor or ceiling.

- **Floor of 2**: a lesson with zero or one spiral item isn't really spiraling anything — it needs to be a real, visible pattern across the year, not an occasional afterthought.
- **Ceiling of 4**: spiral review is reinforcement, not the main event — a Practice page that's mostly spiral content has drifted from practicing *this* lesson's new material.
- Spiral items are auto-checkable, same item formats as the adaptive nodes (typed blank, dropdown, block builder) — they're pulling an earlier skill forward, not introducing a new assessment style.
- Lesson 01.4 is early enough in the year that spiral review has thin material to draw from (only 01.1-01.3 exist before it) — call this out explicitly wherever a unit doesn't have 2 real prior lessons' worth of distinct skills to draw on yet, rather than padding with a near-duplicate of something just taught. This is a real early-unit constraint, not a rule to quietly ignore.
- **Visual chip, distinct from regular items** — see Visual Treatment below.

## Game Connection and UX Items

**Added 2026-08-11 per Jay: include a Game Connection question and a UX question in Practice "when possible."** "When possible" is deliberate, not a soft requirement to skip when inconvenient — some lessons will have an obvious, ungimmicky tie-in for both; some will only have a clean fit for one. Forcing a strained connection to hit a quota would violate `content-voice-and-tone.md` and the game-design/UX journal thread's own standard (`course-plan.md`'s "Game Design, UX, and Journal Threads" section) — a weak tie-in is worse than skipping it.

- **Game Connection item**: ties the lesson's concept to a game-design idea, same throughline as the `.concept-card.game` cards already used in `01_instruction.html`/`07_project.html`. In Practice, this is a question, not a card — e.g., "why would a game show `Not enough gold. You need 20 more.` instead of `Error 402`?" — open-ended enough that it usually can't be auto-checked (see Mixed Assessment below).
- **UX item**: same idea, for usability/human-centered-design concepts specifically (the lighter UX throughline alongside MDA in the same journal-threads section). Also usually open-ended.
- Both get the same **visual chip** treatment as spiral review, using their existing concept-card icons (game controller / usability) at chip scale instead of full card scale — one consistent "this item has a special purpose" visual language across all three special types, not three different treatments invented separately.

## Visual Treatment — Chips

Spiral Review, Game Connection, and UX items each get a small label chip above the item (eyebrow-style, matching the existing `.drill-type` label's position but with its own color per type), so a student can tell at a glance "this one's revisiting something" or "this one's asking me to connect the idea, not just apply it" before reading the prompt. Reuses the existing icon set from the `.concept-card` family (game controller for Game Connection, the existing pro-tip/debug icon shapes as a starting point for a new UX icon) rather than inventing a fresh icon language for three items. Regular adaptive-node items (Core/Reinforce/Extend) keep their existing plain `.drill-type` label ("Build the Code," "Fill in the Blank," etc.) — the chip treatment is specifically for these three special types, so it stays meaningful instead of every item getting a badge.

## Mixed Assessment: Auto-Checked and Teacher-Checked, Together

**Added 2026-08-11 per Jay: not everything in Practice needs to be machine-gradable, but it needs to be checked.** Two categories, both real:

- **Auto-checked** — adaptive node items and spiral review items. Multiple choice, typed blank, block builder: the same JS-graded formats already in `05_practice.html`. Instant feedback, already logged via `drill_attempt`.
- **Teacher-checked** — Game Connection and UX items, and any other genuinely open-ended reasoning prompt. Not gradable by simple string/option matching. Saved into the page (same save-in-place mechanism as everything else) and reviewed in the weekly grading pass, same cadence as reflections and journal entries — not a new review channel, an addition to the existing one (`05-grader/README.md`).

**Why mix them, not pick one:** this is what makes Practice a real diagnostic signal instead of only a completion check. Auto-checked items tell Jay *immediately* (via telemetry, no waiting for the weekly pass) whether a student is landing the mechanical skill — the `lane_transition` and `lane_exhausted` signals already do this. Teacher-checked items tell Jay, a week later but with real depth, whether the student can actually *reason* about the concept, not just execute it. Together: a student who's clean on the auto-checked items but weak on the open-ended ones is a different case than one who's struggling on both — the first is probably ready to move to `06_application.py` and the mastery check with a note to watch their reflection quality, the second should probably revisit `01_instruction.html` first. Neither signal alone tells you that.

**This does not hard-gate Save or advancing.** Consistent with the existing "Save is not gated on correctness" decision for Practice (2026-08-11, `decisions-log.md`) — Practice stays a real record of where a student is, not a locked gate. The *signal* is what's new, not a new blocker. Whether/how to surface a lightweight version of this signal to the student themselves (not just Jay, in the weekly pass) is not decided here — flagged as an open question below.

## Routing Rules (unchanged from objectives-and-skills-proficiency.md, restated for this context)

- Start at **Core**.
- Core wrong → **Reinforce**. Reinforce wrong again → another Reinforce item if the pool has one left; if not, show a short non-graded review note (a Level-1-style conceptual nudge, not the answer) and advance to the next node regardless of outcome. Log this case as `lane_transition.reason: "lane_exhausted"` — a real signal ("needed more support than this node had available"), not a silent skip. **New reason value, added here to `telemetry-and-analytics.md`'s existing `lane_transition` event.**
- Core right → **Extend**. Extend right again → another Extend item if the pool has one; if not, advance. Extend is optional in spirit (a stretch, not a gate) even though it's offered by default — don't block advancing on an Extend miss.
- Reinforce and Extend are **sticky endpoints**, not the start of a fourth level, per the existing rule. No "Reinforce of a Reinforce."
- One move per attempt. No skipping a node entirely based on performance in an earlier node — the ladder operates within a node, not across the node sequence.

## Telemetry — Use the Existing Schema, Don't Invent a New One

`telemetry-and-analytics.md` already specifies exactly the events this needs:

- `drill_attempt` — `skill_id`, `item_id`, `lane`, `correct`, `attempt_number`. Replaces `05_practice.html`'s current flat `logDrillAttempt(drillId, correct, extra)` calls, which only carry a bare `drill_id`.
- `lane_transition` — `skill_id`, `from`, `to`, `reason` (`incorrect` \| `correct_advance` \| `correct_recovered` \| the new `lane_exhausted` above). Logs every move through a node, not just where the student ends up — this is specifically what answers Jay's "what happened when they struggled or got a question wrong" ask.
- `hint_reveal` — `hint_id`. **Newly wired into practice nodes, not previously used there.** Practice drills currently have no hint mechanism at all (unlike `07_project.html`'s 3-level project hints). Add one optional, single-level conceptual hint per Core item — lighter than the project's 3-stage system, since a practice node is meant to be quick, but enough to answer "where they leveraged support," which nothing in the current drills captures at all.

No new event types needed beyond the one `lane_exhausted` reason value. The schema was already built for this; it just hasn't been used yet.

## Guided Practice vs. Independent Adaptive Practice

Jay's question: could some current drills become guided practice embedded in `01_instruction.html` instead of living in the adaptive ladder? Yes, and it's the right move — DOK-1 pure recall (a term, a syntax rule just taught) fits the instructional page's existing quick-check pattern (ungraded, immediate, ends up right next to the content it's checking) better than a scored adaptive node. Save the ladder for items that actually warrant branching: something a student might get wrong in more than one way, where *which* way matters.

**Worked example — Lesson 01.4's current 8 flat drills, resorted:**

| Becomes | Content | Why |
|---|---|---|
| Guided practice (`01_instruction.html`, embedded quick-check) | Drill 3/4-equivalent: "which required part is this line missing" style, DOK 1 recall, expand the existing single quick-check to 2-3, one per concept as it's taught | Pure recall, one right answer, no real branching value — belongs right next to the teaching, ungraded |
| Guided practice | Drill 2-equivalent: pick the valid rewrite of a broken line (single error) | Same reasoning — a first, lighter pass at "spot the syntax problem" before the adaptive node raises the stakes |
| Adaptive Node A: `print_syntax` | Core = Drill 1 (build "Ready to play!"), Reinforce = a smaller single-blank fix, Extend = Drill 5 (build "Game Over," fresh scenario) | Genuine skill with more than one way to go wrong (order, missing piece, wrong piece) — worth the ladder |
| Adaptive Node B: `diagnosing_errors` | Core = Drill 8 (today's neutral-prompt version — diagnose what's wrong), Reinforce = an isolated single-error version, Extend = a second compound-error variant, different specifics | DOK 2-3 diagnostic reasoning, the clearest case in this lesson for "which way they got it wrong matters" |
| Stays exactly as-is, outside the ladder | Drill 7 (if-statement sneak peek) | Already explicitly bonus/preview-only per `mvp-unit-folder-structure.md`'s Interactive Drill Types table — not core graded content, don't fold it into a skill node |
| Folds into Node A as an alternate Reinforce/Extend format | Drill 6 (combined dropdown + typed blank) | Same `print_syntax` skill, different item format — a pool member, not a separate node |

Net effect for this one lesson: 8 flat drills become 2 adaptive nodes (≈6 items across Core/Reinforce/Extend) plus 2-3 lighter guided-practice quick-checks earlier in the page, plus Drill 7 untouched. Meaningfully smaller adaptive footprint than today's 8-drill page, with the DOK-1 recall load absorbed earlier where it's cheaper to author and lighter for the student.

**Filling out the rest of the 8-15 total for Lesson 01.4:** the 2 adaptive nodes (≈6 items) leave room for 2 spiral review items and up to 2 Game Connection/UX items before hitting even the low end of the range:

- **Spiral review (2 items — floor, given how early Unit 01 is):** Lesson 01.4 only has 01.1-01.3 to draw on. A candidate pair: something from 01.2 (Input/Process/Output classification) and something from 01.3 (execution order) — both genuinely distinct skills from what 01.4 itself teaches, not a near-duplicate of this lesson's own content.
- **Game Connection item (1):** e.g., "why would a game show a specific message instead of a generic error?" — open-ended, teacher-checked, direct extension of the Game Connection concept already taught in `01_instruction.html` and applied in `07_project.html`.
- **UX item (1):** Lesson 01.4 doesn't yet have a UX concept taught in `01_instruction.html` to draw a question from — per the standing rule ("a usability/UX concept must be expressly covered in the lesson before it's referenced elsewhere"), this lesson may be a legitimate case of skipping the UX item rather than force one that isn't grounded in anything actually taught. Worth confirming when this lesson is actually rebuilt, not assumed here.

That's 2 (nodes) + 2 (spiral) + 1-2 (Game/UX) = 10-11 items, solidly inside 8-15.

## What This Doc Does Not Resolve

- **`05_practice.html` has not been rebuilt to this model yet.** This is the design; the next concrete step is rebuilding Lesson 01.4's practice page as the reference implementation once Jay confirms this shape is right — same "prove it on the reference lesson first" order every other pattern in this repo has followed.
- **Whether guided-practice quick-checks need their own telemetry.** They're currently explicitly untracked (`01_instruction.html`'s own comment: "nothing saved or graded, so no telemetry hook needed"). Given Jay wants visibility into where support gets used, and a quick-check is exactly where a student's first struggle would show up, this is worth revisiting — not decided here, flagged as a real open question, not silently left alone.
- **The full DOK-rigor rewrite** flagged in earlier decisions-log entries is separate from this and still not done — this doc changes the *branching structure and pool size*, not the underlying question quality, which needs its own pass regardless.
- **Self-hosted Waypoint fonts in real lesson content** — unrelated, still not done, still flagged elsewhere.
- **Whether to surface any version of the readiness signal to the student, not just Jay.** The Mixed Assessment section above deliberately doesn't decide this — right now, "should I revisit the instruction or move on" would only ever be visible to Jay, a week later, in the grading pass. A lighter in-page version (e.g., a plain summary at the bottom of Practice: "X of Y core items correct on the first try") might be worth doing, might also undercut the "growth framing, not deficit" tone `content-voice-and-tone.md` and `objectives-and-skills-proficiency.md` both insist on if done carelessly. Not decided.
- **Whether spiral review pool material actually exists for a given lesson.** Flagged above for Lesson 01.4 specifically (thin, since only 01.1-01.3 exist before it) — this needs to be checked lesson-by-lesson as Unit 01 gets rebuilt, not assumed solved once for the whole course.

See `objectives-and-skills-proficiency.md` for the ladder rules this reuses, `telemetry-and-analytics.md` for the event schema this reuses, `mvp-unit-folder-structure.md`'s Interactive Drill Types table for where this sits alongside the other drill patterns, and `browser-python-execution.md` for the "Run & Check" real-code item type this model is designed to accommodate as a new, higher-DOK node item alongside block-builder/dropdown/typed items.
