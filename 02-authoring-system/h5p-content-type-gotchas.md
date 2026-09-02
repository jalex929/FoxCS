# H5P Content-Type Gotchas — Rules Learned the Hard Way

Real bugs hit while hand-authoring H5P content JSON programmatically for this project, and the rule that would have prevented each one. Read this before writing a new `essay_with_keyword()`-style helper or any other block builder in `07-infrastructure/moodle-scripts/python/h5p_book_builder.py` or its callers. Update this file the next time a new content type bites us.

## The one rule that would have caught all of these

**A content type's installed `semantics.json` tells you what the EDITOR form looks like. It does not reliably tell you the shape of the stored `content.json` the PLAYER reads at runtime.** The two are supposed to match, and usually do for official H5P.org content types installed cleanly — but don't assume it on this instance without checking. When in doubt, check runtime truth over declared schema:

1. Find a working real example of the content type already deployed (query `mdl_h5p.jsoncontent` for a content id that renders correctly), and match its shape exactly — this is more reliable than reading semantics.json cold.
2. If no working example exists yet, read the actual compiled runtime JS, not just semantics.json. The cached bundle is at `https://foxcs.online/pluginfile.php/1/core_h5p/cachedassets/<hash>.js` — the hash appears in any browser console error's stack trace, or in Network tab requests while the content loads. `grep`/search that file for the library's constructor function (e.g. `new Essay`, `new Column`) and read what fields it actually dereferences on `this.params`.

## Confirmed rule: H5P.Essay's `keywords` list — do NOT wrap items in a `groupy` key

The installed `H5P.Essay` semantics.json (majorversion 1, minorversion 5) declares the `keywords` list's item field with `"name": "groupy"`. That `name` is the semantics schema's own internal identifier for the field definition — **it is not a key that belongs in the stored content JSON.** The correct shape for each `keywords[]` entry is flat:

```json
{
  "keyword": "432",
  "alternatives": [],
  "options": { "points": 1, "occurrences": 1, "caseSensitive": false, "feedbackIncludedWord": "none", "feedbackMissedWord": "none" }
}
```

**Not** `{"groupy": {"keyword": ..., "options": {...}}}`.

Confirmed straight from the compiled runtime (`toPoints` inside the cached H5P.Essay bundle):

```js
const toPoints = function (keyword) {
  return (keyword.keyword && keyword.options && keyword.options.points || 0) * (keyword.options.occurrences || 1);
};
```

It reads `keyword.options.occurrences` directly, no wrapper. If you wrap in `groupy`, `keyword.options` is `undefined` on every entry, and the constructor throws `TypeError: Cannot read properties of undefined (reading 'occurrences')` while building the Essay's max-score calculation — a crash inside `new Essay(...)`.

**Blast radius: this crashes the entire parent `H5P.Column`, not just the one Essay block.** `H5P.Column`'s `createHTML()` synchronously instantiates every child block in order; one throwing constructor aborts the whole render. The activity shows a completely blank content area — no error banner, no partial content, nothing in the page for a non-technical viewer to go on. The browser console is the only place the real error appears.

This bug was introduced once, found and fixed (`patch_fix_essay_groupy.py`, 2026-08-30ish), then **reintroduced by a later full-rebuild of the same two activities** whose author re-read the semantics.json, saw `"name": "groupy"`, and assumed it had to be preserved — without testing the rebuilt package in a browser first. Server-side validation (`core_h5p\api::create_content_from_pluginfile_url()`, see next section) passed cleanly both times, because it only validates JSON parseability and library dependency resolution, not runtime field access. See `07-infrastructure/moodle-scripts/python/build_seminar_guided_practice.py` and `build_seminar_independent_practice.py` for the corrected `essay_with_keyword()`.

## Confirmed rule: H5P.Essay's `feedbackIncludedWord` / `feedbackMissedWord` are required enums, not free text

These are `select` fields in the semantics, not `optional`. An empty string (`""`) is not a valid option and throws `"Invalid selected option in select"`, again crashing the whole `H5P.Column`. Valid values:

- `feedbackIncludedWord`: `keyword` | `alternative` | `answer` | `none`
- `feedbackMissedWord`: `keyword` | `none`

Use `"none"` for both when you don't want the extra word prefix, not `""`.

## Confirmed rule: `mod_assign` needs a real positive `grade`, never `0`

Setting `$moduleinfo->grade = 0` (intending "ungraded") triggers a circular dependency inside `assign_grade_item_update()` / `is_gradebook_feedback_enabled()`: it instantiates the assign class to check feedback settings, which itself needs the grade item to already exist — so the grade item is never created, and the module 500s on load. Use a nominal positive grade (`100` is the established convention here) and track actual completion separately via `completion = 1` / `completionview` etc. — don't try to express "ungraded" through the grade field.

## Confirmed rule: H5P.Column with many graded sub-questions cannot reliably grade across multiple sessions — use Moodle completion tracking instead

Real incident, 2026-09-02: students reported they could work through `1.5 -- Guided Practice` / `1.6 -- Independent Practice` (both `H5P.Column`s with ~10-13 graded sub-questions: Essay + MultiChoice) but it "wouldn't save and they couldn't return to it." Root-caused by inspecting the live H5P instance in Chrome (`H5P.instances` inside the nested `iframe.h5p-iframe`) and the compiled runtime JS:

- **Resuming/typed answers genuinely do persist correctly** across sessions, via a completely separate mechanism (`mdl_xapi_states`, saved on each "Check" click). This was never actually broken.
- **The final graded attempt (`mdl_h5pactivity_attempts`) only gets created once literally every sub-question in the Column has been answered.** `H5P.Column` tracks this with an in-memory counter (`numTasksCompleted` vs `numTasks`, incremented by a live `'xAPI'` event listener on each task instance) that lives entirely in that page load's JS closure. **Restoring previously-saved answers on page load does NOT re-fire those live events**, so the counter never gets credit for work done in an earlier session. A student who answers 12 of 13 questions today and the 13th tomorrow gets ZERO credit for any of it — not partial credit, none — because the counter resets to 0 on each fresh load and can only ever count events fired live in the current session.
- Confirmed empirically: completing every single question within one unbroken session correctly fires Column's `'completed'` xAPI event and creates a real attempt row. Splitting the exact same set of answers across two page loads (even with 100% of it eventually answered) never does, no matter how many times you return.
- This is **not fixable via content JSON or server-side Moodle settings** — the counter is closed-source, in-memory JS logic inside H5P core's `H5P.Column` (`/h5p/h5plib/v128/joubel/core/js/` on this instance). It would require patching the H5P core library itself to seed the counter from restored state, which is a real, standing option but a much bigger and riskier undertaking than it sounds (core library patches don't survive H5P library upgrades cleanly, and this project has been burned by exactly that kind of patching before — see the multiple `*_patched.h5p`/`*_patched_v2.h5p` files already in `mdl_files`).
- An H5P **Interactive Book** does not avoid this — a book is just multiple `H5P.Column`s (one per chapter) with a chapter menu, so the identical per-session all-or-nothing behavior applies *within each chapter*. Splitting content into a book only helps by shrinking how many questions have to be finished together in one sitting (e.g. 3-4 per chapter instead of 13 in one scroll) — a real practical mitigation, not an actual fix.

**The actual fix, and the one to reach for whenever a Column-based activity doesn't need a real numeric grade:** stop depending on H5P's own internal scoring/completion signal for these activities. Set the course module's own completion tracking instead (`$DB->set_field('course_modules', 'completion', 1, ['id' => $cmid])` for student-controlled manual "Mark as done", or `2` + `completionview=1` for automatic-on-view). This lives in Moodle's completion system, entirely separate from H5P's internal JS, so it is trivially safe across any number of sessions, needs no scoring logic, and matches "no barrier, complete this whenever" content exactly. Only reach for a real H5P numeric grade on Column-based content when you're confident the whole thing is short enough to realistically finish in one sitting.

## Real incident, 2026-09-02: swapping an H5P package in place can still wipe a student's in-progress resume state

While removing the Essay "Show sample solution" button (see above) from `1.5`/`1.6` mid-class, used `update-h5p-package.php` specifically to replace the package file **in place** (same cmid, same context) rather than the usual delete-and-recreate, on the theory that keeping the same context id would protect students' saved `mdl_xapi_states` resume rows (that table is keyed by context id). It didn't fully protect them: one real student's pre-existing saved progress (two `mdl_xapi_states` rows with real answer data, confirmed readable twice before the swap) read back as `NULL` afterward, confirmed both via the raw DB and via Moodle's own `$DB` layer (so not a client-side read artifact). Root mechanism traced partway into `h5p.js`/`embed.js`'s state-save path (a `state === null` case explicitly triggers a state *delete* call) but not conclusively pinned to package-hash change specifically — treat the correlation as strong, not proven, and do not assume in-place package replacement is actually safe for students with unsaved/in-progress work.

**Every other student actively using the activity at the same time kept saving correctly through the swap** — so this isn't "package swaps always break saves," it's specifically a risk to *pre-existing* saved state from *before* the swap.

Practical rule until this is understood more precisely: **do not replace an H5P activity's package file (in place or otherwise) while any student might have unsaved/in-progress work on it** — content JSON fixes (button labels, wording, bug fixes) should wait for a genuinely idle window, not just "same cmid should be safe." If a fix can't wait and there's real in-progress work at stake, back up affected students' current `mdl_xapi_states` rows first (`check-state-rows.php` or a similar direct read) so there's at least a recovery record, and tell the affected student(s) directly rather than assuming their work survived.

## Process rule: server-side H5P validation is necessary but not sufficient — always confirm in a real browser

`core_h5p\api::create_content_from_pluginfile_url()` (wrapped in `07-infrastructure/moodle-scripts/verify-h5p-content.php`) is worth running after every H5P deploy — it catches real package/library/JSON problems, and it's fast to run in bulk across a whole course. **But it does not execute the content type's own JS constructor**, so it cannot catch a runtime field-access crash like the `groupy` bug above. It is not a substitute for actually loading the page.

The real verification workflow, every time new or rebuilt H5P content goes live:

1. Run `verify-h5p-content.php <cmid>` — catches package/import-level failures fast, before touching a browser.
2. **Load the actual `mod_h5pactivity/view.php?id=<cmid>` page in Chrome** (via Claude-in-Chrome or manually) and take a real look — an empty content area with no error message on the page is a genuine failure, not a fluke. Note: the very first page load after a fresh deploy can be slow (H5P processes/caches the package lazily on first view) — if it looks blank on the very first load, wait a few seconds and reload once before concluding it's broken.
3. **Check `read_console_messages` with `onlyErrors: true`** on that same fresh load. This is where the real error surfaces (`TypeError: Cannot read properties of undefined...`, `Invalid selected option in select`, etc.) — the page itself gives no visible indication to a normal user.
4. If the activity has an editable structure (most do), also open **"Edit H5P content"** and confirm the block list actually populates and is interactive, not just present as inert labels — this is a second, independent render path (the H5P *editor* widgets) that can fail even when the *player* path above succeeds, or vice versa.
5. Only consider the content genuinely fixed once both the player and (if applicable) the editor render cleanly with zero console errors on a fresh load — not once the CLI validator says "OK."

**Never rely on Claude's own password-entry to reach a logged-in view for this check** — Claude does not type credentials into login forms (a hard rule, not a preference). If a fresh authenticated session is needed for verification, ask the person to log in in the browser tab themselves; Claude can navigate/inspect from there.
