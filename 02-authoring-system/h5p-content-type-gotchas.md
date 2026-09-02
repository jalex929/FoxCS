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

## Process rule: server-side H5P validation is necessary but not sufficient — always confirm in a real browser

`core_h5p\api::create_content_from_pluginfile_url()` (wrapped in `07-infrastructure/moodle-scripts/verify-h5p-content.php`) is worth running after every H5P deploy — it catches real package/library/JSON problems, and it's fast to run in bulk across a whole course. **But it does not execute the content type's own JS constructor**, so it cannot catch a runtime field-access crash like the `groupy` bug above. It is not a substitute for actually loading the page.

The real verification workflow, every time new or rebuilt H5P content goes live:

1. Run `verify-h5p-content.php <cmid>` — catches package/import-level failures fast, before touching a browser.
2. **Load the actual `mod_h5pactivity/view.php?id=<cmid>` page in Chrome** (via Claude-in-Chrome or manually) and take a real look — an empty content area with no error message on the page is a genuine failure, not a fluke. Note: the very first page load after a fresh deploy can be slow (H5P processes/caches the package lazily on first view) — if it looks blank on the very first load, wait a few seconds and reload once before concluding it's broken.
3. **Check `read_console_messages` with `onlyErrors: true`** on that same fresh load. This is where the real error surfaces (`TypeError: Cannot read properties of undefined...`, `Invalid selected option in select`, etc.) — the page itself gives no visible indication to a normal user.
4. If the activity has an editable structure (most do), also open **"Edit H5P content"** and confirm the block list actually populates and is interactive, not just present as inert labels — this is a second, independent render path (the H5P *editor* widgets) that can fail even when the *player* path above succeeds, or vice versa.
5. Only consider the content genuinely fixed once both the player and (if applicable) the editor render cleanly with zero console errors on a fresh load — not once the CLI validator says "OK."

**Never rely on Claude's own password-entry to reach a logged-in view for this check** — Claude does not type credentials into login forms (a hard rule, not a preference). If a fresh authenticated session is needed for verification, ask the person to log in in the browser tab themselves; Claude can navigate/inspect from there.
