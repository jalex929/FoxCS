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

## Applies Beyond Unit 0

This whole pattern (page-nav footer, group tags, hub-page nav, the insertion checklist) should be the starting template for Units 1+ in every course, not something reinvented per course. When authoring `courses/<course>/content/unit_NN_slug/`, follow this same structure from the start rather than retrofitting it after the fact the way Unit 0 needed.
