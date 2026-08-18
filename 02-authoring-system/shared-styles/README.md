# FoxCS Shared Styles

Added 2026-08-08, closing the "no shared CSS file yet" known gap flagged in `../design-system.md`.

## Files

- **`foxcs-base.css`** — the light-page palette, typography, buttons, feedback states, form controls, and every reusable interactive component's styling (flip card, block builder, drag-to-match, categorization, sequencing, video wrap, save-in-place/password-gate toy boxes, glossary term). Single source of truth going forward — edit here, not in a page's own `<style>` block, for anything that isn't page-specific chrome.
- **`foxcs-ide-dark.css`** — the code-execution-stepper's dark editor surface (component-library #14). Opt-in, only linked by pages that actually use the stepper. Deliberately not theme-variable-driven like the base file — it's simulating an editor, and editors stay dark regardless of the page's own light/dark toggle.
- **`foxcs-theme-toggle.js`** — light/dark toggle logic. Defaults to the browser's `prefers-color-scheme`, remembers a manual override in `localStorage`. Any page that includes a `<button id="theme-toggle-btn">` and this script gets a working toggle for free.

## Why the component library links these live, but real lesson content doesn't (yet)

`component-library/index.html` links all three files directly with relative `<link>`/`<script>` tags — safe, because Jay always opens it from the full local repo folder, so the relative paths always resolve.

**Real lesson content (anything distributed through Google Classroom) does not link these yet.** Whether Classroom preserves a unit folder's directory structure on download is a real, unresolved question (`../../open-questions.md`) — if it flattens folders, or a student ends up with a lesson HTML file separated from its containing folder, an external `<link>` would silently break and the page would render unstyled. Given that risk is still open, lesson pages keep their own embedded `<style>` block (fully self-contained, works no matter what happens to the folder around it) and should be **kept in sync with `foxcs-base.css` by hand** — copy real changes over, don't let them drift.

Once the Classroom folder-structure question resolves (or a simple CSS-inlining step exists as part of the distribution/build process), lesson pages can switch to linking these files directly, the same way the component library already does, and the manual-sync step goes away.

## Theme variables

Every color in `foxcs-base.css` is a CSS custom property (`--bg`, `--text`, `--heading`, `--primary`, `--box-bg`, `--feedback-correct-bg`, etc.), light values on `:root`, dark overrides on `[data-theme="dark"]`. Never hardcode a hex value in a shared component rule — add or reuse a variable so the toggle keeps working. Real per-lesson pages that hand-copy from this file should copy the variable declarations too, not just resolve them to static hex values, so they stay toggle-capable.

See `../design-system.md`'s "Dark Mode / Theme Toggle" section for the actual palette values and contrast notes.
