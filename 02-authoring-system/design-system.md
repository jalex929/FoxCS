# FoxCS Design System — Colors and Basic Visual Patterns

**Added 2026-08-06**, after finding real AA-contrast failures in the flashcard deck (a solid-blue card back with white text measured 4.42:1, just under the 4.5:1 AA threshold for normal text; a light-blue label on that same background measured 3.59:1). This doc exists so that mistake doesn't get repeated silently across every new page — check a new color pairing here before using it, and add it here if it's genuinely new.

This is deliberately small. It is not a full design system with spacing scales, typography ramps, and component variants — FoxCS doesn't need that yet, and building one now would be premature for content that's still finding its shape. It's a color-usage contract plus a few structural rules, sized for what's actually being built. Expand it only when a real, repeated need shows up, not speculatively.

**Placeholder status:** this palette is Jay's own placeholder set, not a final brand identity — an updated visual/illustration style guide is still pending (see `image-style-guide.md`, `../open-questions.md`). When that lands, reconcile the hex values below against it rather than starting over — the *contrast rules and pairing table structure* here should survive a palette swap; only the specific hex values should change.

## The Rule

**Every text/background pairing used anywhere in FoxCS content must meet WCAG AA: 4.5:1 contrast for normal text, 3:1 for large text (≥18px, or ≥14px bold).** Before introducing a new color pairing, check it against this doc's table below, or compute it — don't eyeball it. A pairing that looks fine on one monitor can fail this measurably; several already had before this doc existed.

## Verified Palette

### Backgrounds (pale/tint tier — for callout boxes, cards, panels)

| Hex | Use | Verified safe text colors on this bg |
|---|---|---|
| `#f4f6f9` | Neutral info/callout background (objectives box, intro box, code question blocks) | `#1a1a1a` (body), `#2a3a52` (headings), `#1a5aa8` (links/labels) |
| `#bbd4f2` | Pale blue accent (badges) | `#1a3a5c` |
| `#c5c0e3` | Pale violet (game-design tie-in callouts) | `#1a1a1a` |
| `#f9e1ad` | Pale amber (handoff/next-step boxes) | `#7a3a00` |
| `#f6c5c4` | Pale red (integrity/warning notices) | `#1a1a1a` |
| `#d7ecd7` | Pale green (correct-answer feedback) | `#1a1a1a` or `#1a3a5c` |
| `#f4e3d0` | Pale peach (incorrect-answer feedback, not an error color — see Tone note below) | `#1a1a1a` |
| `#eef1f5` | Code block background | `#1a1a1a` |

### Solid / Interactive Tier (buttons, filled surfaces — anywhere white text sits on top)

**Corrected 2026-08-06 — the previous values here failed AA and are retired, do not reuse them for anything with white text on top:**

| Hex | Use | Contrast with white text | Replaces (retired) |
|---|---|---|---|
| `#1a5aa8` | Primary interactive blue — buttons, filled card backs, active states | 6.84:1 (PASS) | `#2a78d6` (4.42:1, FAIL) |
| `#9a5a00` | Primary interactive amber — secondary/warm buttons | 5.47:1 (PASS) | `#eda100` (2.17:1, FAIL badly) and `#c68600` (3.08:1, FAIL) |

`#2a78d6` and `#eda100` (the old, failing values) can still be used as **thin accents only** — borders, small icons, underlines — anywhere they never carry white or light text directly on top of them. Don't use them as a filled background behind text.

### Body Text on White

| Hex | Use |
|---|---|
| `#1a1a1a` | Body text |
| `#2a3a52` | Headings |
| `#1a3a5c` | Term/label text, badge text |
| `#7a3a00` | Save-reminder / important-notice text on white or pale-amber backgrounds |

## Tone Note: Feedback Colors Aren't Red/Green Error Signals

Per `content-voice-and-tone.md`'s error-message philosophy (calm, non-judgmental, errors framed as information) — the "incorrect" feedback background is a **pale peach** (`#f4e3d0`), not red. Red (`#f6c5c4`) is reserved for the academic-integrity warning specifically, a genuinely different severity of message. Don't reach for red as a generic "wrong answer" color; that's a deliberate choice, not an oversight.

## Structural Patterns (not colors, but part of "basic design system")

- **One shared visual language per page type.** Every instructional page, mastery check, practice drill, etc. reuses the same handful of box styles (info box, game-tie-in box, handoff box) rather than inventing new ones per lesson.
- **Flip-card faces need a labeled front/back**, not just a color change, so the state is legible even to someone glancing quickly — see the flashcard reference implementation in `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/03_flashcards.html`.
- **Numbered files are the navigation system**, not colored buttons or icons — see `mvp-unit-folder-structure.md`. Don't invent a competing visual wayfinding system.

## Dark IDE-Simulation Surface (added 2026-08-08)

The code execution stepper (`component-library/index.html`'s #14) is a deliberate exception to the light-page palette above — it's simulating a code editor, and real editors are dark. Don't reuse these for anything that isn't specifically simulating an IDE/terminal.

| Hex | Use | Notes |
|---|---|---|
| `#1e2430` | Editor body background | Very dark slate |
| `#161b24` | Toolbar/side-panel background (slightly darker) | |
| `#e6e9ef` | Default code/output text | Light gray on very dark bg — comfortably high contrast |
| `#7fb0ff` | Syntax: keywords (`if`, `for`, `print`, etc.) | |
| `#f0b866` | Syntax: string literals | |
| `#8fd19e` | Syntax: numbers | |
| `#8a93a6` | Syntax: comments | Muted on purpose |
| `#33415c` bg / `#5b9bd8` left-border accent | Active/current-line highlight | |

Not individually contrast-computed the way the light-page pairings above were (all are light tones on a very dark background, which reliably passes AA in practice) — if this surface gets reused more broadly, compute and log real ratios here rather than continuing to eyeball it.

## Dark Mode / Theme Toggle (added 2026-08-08)

Per Jay's request, `shared-styles/foxcs-base.css` now defines the full palette above as CSS custom properties, with a dark-mode override set on `[data-theme="dark"]`, toggled by `shared-styles/foxcs-theme-toggle.js`. Both light and dark defaults deliberately avoid the extremes (pure `#000000`/`#ffffff`) — Jay's framing: stark black-on-white or white-on-black reads harsh, not what we want. Light mode uses near-black text (`#1a1a1a`, unchanged from above) on an off-white page background (`#fbfbf9`, not pure white); dark mode uses off-white text (`#e6e9ef`) on a dark navy page background (`#1e2430`, not pure black) — the same family as the IDE-simulation surface below, for visual continuity between the two dark surfaces.

**Real computed contrast ratios** (WCAG relative-luminance formula, not eyeballed):

| Pair | Ratio | Verdict |
|---|---|---|
| Light: `#1a1a1a` text on `#fbfbf9` bg | ~17.9:1 | PASS (huge margin) |
| Dark: `#e6e9ef` text on `#1e2430` bg | 12.79:1 | PASS |
| Dark: `#8fbdf0` heading/link on `#1e2430` bg | 7.93:1 | PASS |
| Dark: `#e0a84a` amber-accent text on `#1e2430` bg | 7.31:1 | PASS |
| Dark: `#9fe3ab` "correct" feedback text on `#1f3d28` bg | 8.00:1 | PASS |

Note what these ratios ruled out: the *existing* light-mode accent hexes (`#1a5aa8` primary blue, `#9a5a00` amber) do **not** work as plain text directly on the new dark background — `#1a5aa8` on `#1e2430` measured only 2.28:1, `#9a5a00` measured 2.84:1, both fail badly. That's why dark mode uses brighter substitute accents (`#8fbdf0`, `#e0a84a`) for text/headings specifically. Button fills are unaffected either way, since `#1a5aa8`/`#9a5a00` were verified against white text as a self-contained pairing, independent of whatever the page background is doing.

The remaining dark-mode box/border pairs (`--box-bg`, `--border`, the "incorrect" feedback pair) were **not individually computed** — they were reasoned by strong analogy to the pairs above (same dark-navy family, same large light-text-on-dark-bg separation), not run through the formula one by one. Flag it here and compute a real number before trusting any of them in a context where getting it wrong would actually matter (e.g., real assessment content), same honesty standard as the IDE-surface note below.

## Known Gap

**Partially closed 2026-08-08** — `shared-styles/foxcs-base.css` is now the single source of truth for the light/dark palette and every reusable component's styling; `component-library/index.html` links it live and is the first real proof the extraction works. Real lesson content distributed through Google Classroom does **not** link it yet — see `shared-styles/README.md` for why (the unresolved question of whether Classroom preserves folder structure on download makes an external `<link>` a real risk there). Lesson pages still keep their own embedded `<style>` block, hand-synced against the shared file, until that question resolves.
