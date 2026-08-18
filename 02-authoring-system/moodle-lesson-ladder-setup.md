# Setting Up the Reinforce/Core/Extend Ladder in Moodle's Lesson Activity

How to actually build the ladder from `objectives-and-skills-proficiency.md` inside Moodle, for someone who hasn't used the Lesson activity's branching before. See that file for the policy (why 3 lanes, sticky endpoints, pool sizing); this file is the mechanics.

## The mechanism, in one paragraph

A Lesson activity is a sequence of **pages**. A **Question page** presents one question with one or more **Answers**. Each Answer carries two independent things: a **Response** (feedback text shown after picking it) and a **Jump** (which page to go to next, chosen from a dropdown listing every page in the Lesson by title). That's the whole mechanism — there's no separate "branching" feature to learn, it's just that every answer gets to pick its own next page instead of always advancing linearly. No plugin required; this is core Moodle.

## Building one skill's ladder cluster

For each skill checkpoint, you're building a small cluster of pages: 1 Core page, N Reinforce pages, N Extend pages (N per the pool-size guidance in `objectives-and-skills-proficiency.md`).

1. **Name every page clearly before you touch jumps.** Something like `5.3 Core`, `5.3 Reinforce 1`, `5.3 Reinforce 2`, `5.3 Extend 1`, `5.3 Extend 2`. You'll be picking these out of a plain alphabetical/creation-order dropdown when setting jumps, so a clear naming convention (unit.skill + lane + number) is what keeps this sane once you have 20+ clusters in one course.
2. **Add the Core question page.** Set its Answers (however many the question needs), and mark which one(s) count as correct.
3. **Set the Core page's Jumps:**
   - Correct answer(s) → Jump to `5.3 Extend 1`.
   - Incorrect answer(s) → Jump to `5.3 Reinforce 1`.
4. **Add the Reinforce pages.** Each is its own Question page. Set their Jumps to implement the sticky rule:
   - `5.3 Reinforce 1`, wrong → Jump to `5.3 Reinforce 2` (next item in the pool, not deeper).
   - `5.3 Reinforce 1`, right → Jump to **Next page** (or a specific "continue" page) — they've shown they've got it with support, move on.
   - `5.3 Reinforce 2` (last item in the pool), wrong → Jump to a **Reteach page** (a static Content page, not another question): brief re-explanation of the concept, then a direct instruction to check in with your teacher to talk it through. Say "your teacher," not a specific name — this content needs to work unmodified for other teachers piloting it, not just Jay's own class. This is the actual exit from the ladder when self-service support hasn't worked — don't build a `5.3 Reinforce 3` to keep trying automatically; a real human conversation is the right next step at that point, not more auto-served questions.
5. **Add the Extend pages**, same shape:
   - `5.3 Extend 1`, right → Jump to `5.3 Extend 2` (another stretch item, sticky).
   - `5.3 Extend 1`, wrong → Jump to **Next page** (a miss on enrichment content isn't a gate — don't punish it. This is a default recommendation, not locked in; revisit if it doesn't feel right once you're using it.)
   - `5.3 Extend 2`, either outcome → Jump to **Next page** (exit the ladder either way once they've reached the top of the pool).
6. **The "Next page" you're jumping to from every exit point** should be the start of the *next* skill's Core page — that's what actually chains skill checkpoints together into one flowing Lesson.

## Sustainability — three tiers, start at the bottom

Don't build tier 2 or 3 until tier 1 actually hurts. This is a judgment call worth revisiting after the pilot lesson, not something to decide in the abstract.

1. **Manual, in the Lesson editor.** At the pool sizes in `objectives-and-skills-proficiency.md` (roughly 5 pages per skill checkpoint, 2-4 checkpoints per lesson), that's maybe 10-20 pages of clicking per lesson. For one pilot lesson, and honestly for a fair number of lessons after that, this is probably just fine — it's bounded, repetitive-but-simple work, not something that needs tooling before you've felt how long it actually takes.
2. **Templated export/import.** Once you've hand-built one clean cluster, Moodle's course backup format (`.mbz`, a zip of XML) includes the Lesson's pages/answers/jumps. In principle you could export a known-good cluster, and generate new ones by scripted find/replace on the XML (question text, answers, jump targets) from the canonical lesson record, then restore/import. This turns "build 21 units by hand" into "build the pattern once, generate the rest" — but the Lesson backup XML schema hasn't been verified against this instance yet, so treat this as a real next step, not a confirmed plan.
3. **Web Services automation.** If `mod_lesson`'s create/edit functions are enabled on this dev instance, a script could build the whole cluster directly from the canonical lesson record — the same idea already planned for H5P in `h5p-authoring-and-automation.md`. Most powerful, most setup cost, and this instance is `5.3dev` (a development branch — Web Services availability/behavior is less predictable here than on a stable release, same caution as the H5P doc). Only worth pursuing if tier 2 turns out not to be enough.

