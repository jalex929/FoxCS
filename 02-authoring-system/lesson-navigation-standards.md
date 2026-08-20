# Lesson Navigation Standards

**Added 2026-08-18**, after a real session spent hand-fixing a cluster of navigation bugs across Unit 0 (inaccurate "next lesson" claims, a missing menu link, a stale overview-page description, a missing CSS rule) that a checklist like this would have caught before they ever shipped. Applies to every FoxCS lesson page — Unit 0's shared onboarding unit and every future course unit (Units 1+ under `courses/<course>/content/`) alike.

## The Pattern, As It Actually Exists Today

Every lesson page ends with a `.page-nav` footer containing exactly three links:

```html
<div class="page-nav">
  <div class="page-nav-note">[save reminder, or "Nothing to save on this page, it's reading only."]</div>
  <div class="page-nav-links">
    <a href="[prev lesson path]" class="page-nav-prev">← Back: [Real Lesson Title]</a>
    <a href="[path to that unit's overview.html]" class="page-nav-menu">Unit 0 Menu</a>
    <a href="[next lesson path]" class="page-nav-next">Next: [Real Lesson Title] →</a>
  </div>
</div>
```

```css
.page-nav-prev, .page-nav-next { font-weight: bold; color: #1a5aa8; text-decoration: none; }
.page-nav-prev:hover, .page-nav-next:hover { text-decoration: underline; }
.page-nav-menu { color: #445; text-decoration: none; font-size: 0.85rem; border: 1px solid #ccd3dd; padding: 0.3rem 0.8rem; border-radius: 5px; }
.page-nav-menu:hover { background: #eef1f5; }
```

**All three links are required on every lesson page, no exceptions:**
- **Prev/next link text must be the real lesson title**, never generic text like "Continue to the next lesson" — a student should be able to tell exactly where a link goes without clicking it. This applies to the footer nav *and* to any inline "What To Do Next" list link earlier in the page (see `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/01_instruction.html` for the original numbered-list pattern this extends).
- **A menu link back to the unit's own overview/hub page** (`unit_00_overview.html` for Unit 0; the equivalent hub for a future course unit) is required so a student can jump to any lesson, not just move one step at a time. This exists specifically because linear-only navigation was flagged as too restrictive — see `decisions-log.md`'s 2026-08-18 entry on the Unit 0 Menu addition.
- **A group-tag label** (`<span class="group-tag">[Group Name]</span>` right before the `<h1>`) showing which thematic section of the unit this lesson belongs to — see Unit 0's four groups (Getting Started / Thinking Like a Builder / Working With Others / Choosing Your Path) in `shared/unit_00_onboarding_level1/` and `_level2/` for the reference implementation, and each edition's `unit_00_overview.html` for how the same groups render as nested sections on the hub page itself.

**The hub/overview page itself is not exempt from having navigation.** It was originally shipped with no footer nav at all — a real gap, since a student landing there had no obvious way back into the unit. Every hub page needs at least a prominent "Start Lesson [X.Y]: [Title] →" call to action.

## The Real Risk: Insertion, Removal, or Reordering

Every navigation bug found in this session's cleanup pass came from the same root cause: a lesson's position in the sequence changed (or was described inaccurately from the start) and not every place that referenced its position got updated. **Whenever a lesson is added, removed, or reordered within a unit, work through this checklist completely — don't assume only the immediately obvious file needs a change:**

1. **The new/moved lesson's own footer nav** — correct prev, next, and menu links.
2. **Both of its new neighbors' footer nav** — the lesson that now comes before it needs its "next" updated to point at it; the lesson that now comes after it needs its "prev" updated to point at it.
3. **Any "What To Do Next" numbered-list link** in those same neighboring lessons (and anywhere else in the unit that might link to them).
4. **Every prose mention of "next lesson," "previous lesson," or a specific lesson number anywhere in the unit** — not just the immediate neighbors. A lesson three positions away might reference "Lesson 0.4" or "the previous lesson" for a reason that assumed the old numbering. Search the whole unit's files for phrases like "next lesson," "previous lesson," "future lesson," and the specific lesson number/title being moved, not just the files you already expect to be affected.
5. **The hub/overview page**: the lesson list itself (order, link, description) and which group it belongs to.
6. **Re-verify in an actual browser** — start a local server, click through the actual prev/next/menu links on the moved lesson and both its neighbors, don't just eyeball the source. Several of this session's bugs were things that read correctly in isolation but were only obviously wrong once actually clicked.

**A reference sentence never gets to say "next lesson" or "previous lesson" unless it is genuinely, currently, the adjacent lesson.** If it isn't adjacent, name it directly instead (e.g. "a future lesson (Getting Unstuck)" or "Lesson 0.4") — claiming false adjacency is exactly the bug class this document exists to prevent.

## Sections, Boxed and Prominent (added 2026-08-18)

The level of hierarchy between **Unit** and **Lesson** is called a **Section** — e.g. Unit 0 has four sections (Getting Started / Thinking Like a Builder / Working With Others / Choosing Your Path for Level 2 only), each containing 2-3 lessons. Use "section" consistently in code (`.section`, `.section-label`, `.section-tag`), comments, and prose — not "group."

**On the hub/overview page**, each section is a bordered box (`.section`), same visual language as `.step`/`.concept-card`/`.pathway-box` elsewhere in the system (`border: 1px solid #ccd3dd; border-radius: 10px; padding: 1.3rem 1.4rem 1.5rem; margin-top: 2.2rem;`). The section label is a real heading, not a small kicker: `font-size: 1.2rem; font-weight: bold;` with a colored left-accent bar (`border-left: 5px solid #1a5aa8; padding-left: 0.7rem;`) — deliberately **larger than the lesson titles inside it**, since a section heading should outrank what it contains. This replaces an earlier version where the label rendered smaller than the lesson links below it, which read backwards. The box edge itself provides the "extra space after a section's last lesson" — margin-top on the next `.section` plus the box's own padding does the separating, rather than relying on margin alone between flat, unboxed groups.

**On individual lesson pages**, the small uppercase kicker (`.section-tag`, right before the `<h1>`) stays as it was — that's a different, legitimate pattern, since the page's own H1 is already the dominant heading there and the section-tag is correctly secondary to it. Only the hub page's group-level labels needed to get bigger; don't inflate `.section-tag` to match.

See `shared/unit_00_onboarding_level1/unit_00_overview.html` and `.../lesson_00_01_welcome/01_instruction.html` for the reference implementation of both.

## Top Unit Menu and Completion Checkmarks (added 2026-08-18)

Every page in a unit — every lesson, every activity page, and the hub page itself — gets a sticky dropdown at the very top of `<body>`, above everything else:

```html
<div class="unit-menu-wrap">
<details class="unit-menu">
  <summary class="unit-menu-toggle">☰ Unit 0 Menu</summary>
  <nav class="unit-menu-panel">
    <div class="unit-menu-section">
      <div class="unit-menu-section-label">Getting Started</div>
      <a href="[path]/01_instruction.html"><span class="menu-check" data-lesson="lesson_00_01_welcome"></span>0.1 Welcome to Game Programming I</a>
      <!-- one line per lesson in this section, repeated for every section in the unit -->
    </div>
  </nav>
</details>
</div>
```

```css
.unit-menu-wrap { position: sticky; top: 0; z-index: 20; background: #fff; border: 1px solid #dde3ea; border-radius: 0 0 8px 8px; margin-bottom: 1.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
.unit-menu-toggle { cursor: pointer; padding: 0.7rem 1.3rem; font-family: Verdana, Arial, sans-serif; font-weight: bold; color: #1a5aa8; font-size: 0.92rem; list-style: none; user-select: none; }
.unit-menu-toggle::-webkit-details-marker { display: none; }
.unit-menu-toggle:hover { background: #f4f6f9; }
.unit-menu-panel { padding: 0.3rem 1.3rem 1.1rem; max-height: 60vh; overflow-y: auto; border-top: 1px solid #eef1f5; font-family: Verdana, Arial, sans-serif; }
.unit-menu-section { margin-top: 0.9rem; }
.unit-menu-section:first-child { margin-top: 0.6rem; }
.unit-menu-section-label { font-size: 0.72rem; letter-spacing: 0.07em; text-transform: uppercase; font-weight: bold; color: #1a5aa8; margin-bottom: 0.3rem; }
.unit-menu-panel a { display: flex; align-items: center; gap: 0.5rem; padding: 0.32rem 0.2rem; color: #1a1a1a; text-decoration: none; font-size: 0.9rem; border-radius: 4px; }
.unit-menu-panel a:hover { background: #eef4fb; }
.unit-menu-panel a.current { font-weight: bold; color: #1a5aa8; }
.menu-check { display: inline-block; width: 1.05rem; height: 1.05rem; border: 1.5px solid #ccd3dd; border-radius: 50%; flex-shrink: 0; font-size: 0.72rem; line-height: 1rem; text-align: center; color: transparent; }
.menu-check.done { background: #2f7a2f; border-color: #2f7a2f; color: white; }
```

**On the page currently being viewed**, add `class="current"` to that page's own `<a>` in the menu so it's visually distinguishable while the dropdown is open — the hub/overview page has no "current" entry since it isn't itself in the list.

**Checkmarks are backed by `localStorage`, not by anything submitted or graded.** Each page hardcodes its own lesson key (its folder name, e.g. `lesson_00_04_troubleshooting_is_learning`, or `kickoff_avatar`/`kickoff_slide` for the two kickoff pages) and marks itself done in `localStorage` the moment a student's browser loads it — see the script block near the end of `lesson_00_01_welcome/01_instruction.html`:

```html
<script>
(function() {
  var STORAGE_KEY = 'foxcs_unit00_level1_progress'; // 'foxcs_unit00_level2_progress' in the Level 2 edition
  var THIS_LESSON = 'lesson_00_01_welcome'; // this page's own folder name — change per file
  var done = {};
  try { done = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}'); } catch (e) { done = {}; }
  done[THIS_LESSON] = true;
  try { localStorage.setItem(STORAGE_KEY, JSON.stringify(done)); } catch (e) {}
  document.querySelectorAll('[data-lesson]').forEach(function(el) {
    if (done[el.dataset.lesson]) { el.classList.add('done'); el.textContent = '✓'; }
  });
})();
</script>
```

The hub/overview page runs the same read-and-render block but *without* the "mark this lesson done" step (it isn't a lesson itself) — see `unit_00_overview.html`'s own script block, and note it also applies `.done`/`✓` to the `.lesson-check` circles in its own inline lesson list (`data-lesson` attributes there use the exact same keys), not just the dropdown menu, so progress is visible in two places on that page.

**Why "visited" is the completion signal, not a submitted/graded action:** Unit 0 is almost entirely non-graded reading with occasional save-your-own journal entries — there's no save-gated task most lessons could hook a "real completion" event to the way `05-grader`'s auto-graded quiz/practice pages can (those use the `_completed` filename convention instead, see `mvp-unit-folder-structure.md`). "Reached the page" is the honest, available signal for this content, and it's framed to students as a convenience/progress indicator, never as something that is submitted, synced across devices, or read by any grading tool. If Unit 0 later gets real quiz/practice components (see the next section), a lesson that has one should key its checkmark off that page's own actual save-completion instead of page-load, for consistency with the rest of the system.

**Different lesson set per edition:** Level 1 and Level 2 have different section/lesson lists (Level 2 adds section "Choosing Your Path" and lesson 0.9) — each edition's menu content reflects only its own lessons, this is not a shared/identical block the way the six truly-shared lesson files are.

## Interactive Checks (vocab quiz / practice) for Non-Python Content

Added 2026-08-18: the same self-contained `_completed`-suffix + hidden `foxcs-telemetry` JSON pattern used in `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/` (see `04_vocab_quiz.html`, `05_practice.html`) is course-agnostic — it's plain HTML/CSS/JS with no Python-specific dependency, and `05-grader/school-side/auto_grade.py` matches on filename *suffix* only, not course or path. Reuse that exact pattern (same telemetry JSON shape: `{"events":[{"type":"quiz_check"|"drill_attempt", "attempted":[...], "correct":...}]}`, same hidden-timestamp convention for mastery-check-style content) for any future Unit 0 (or other non-Python unit) vocab quiz or practice page, rather than inventing a new format — it means the existing grader and its test suite work against new courses with zero changes, which is the whole reason to keep the format identical rather than course-flavored.

## Rule: Matching/Bank Order Must Never Be Positionally Solvable (added 2026-08-18)

Any interactive pattern with two parallel lists a student pairs up (a term bank + a definition list, a block-builder bank, etc.) must guarantee the two lists can never be solved by row position alone — a student should have to actually read both sides, never just match row 1 to row 1. Two independent `shuffle()` calls are **not** enough: they can still coincide in several positions by chance, which is exactly what happened live in `lesson_00_05_computational_thinking/02_vocab_quiz.html` during this session's own testing (caught by Jay, not guessed at). This is the same bug class already hit once before in `courses/python`'s `05_practice.html` Drill 7 (fixed 2026-08-11, see that file's header comment) — it keeps recurring because "shuffle both sides independently" *looks* safe but isn't.

**The fix, required in every future matching component:** derange the second list against the first — shuffle it, then reject and reshuffle until no index holds the same value in both lists (a full derangement), not just two independent shuffles. See `shuffleDerangement()` in `02_vocab_quiz.html` for the reference implementation (small rejection-sampling loop, safe for the list sizes these quizzes use). Copy that function verbatim into any new matching component rather than re-deriving it.

## Applies Beyond Unit 0

This whole pattern (page-nav footer, group tags, hub-page nav, the insertion checklist) should be the starting template for Units 1+ in every course, not something reinvented per course. When authoring `courses/<course>/content/unit_NN_slug/`, follow this same structure from the start rather than retrofitting it after the fact the way Unit 0 needed.
