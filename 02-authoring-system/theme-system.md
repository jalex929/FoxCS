# Theme System — Student-Selectable Color Themes

Added 2026-08-08, palette updated 2026-08-08 (later) from Jay's real spec — `logos/waypoint_theme_typography_style_guide_full.md` — then given a full contrast rebuild + background textures + per-theme body fonts on 2026-08-10. Extends the light/dark toggle in `shared-styles/` to four themes, selectable by the student and persisted without depending on the browser (no `localStorage`-only state — a shared school Chromebook can lose that at any time).

## The Four Themes

| Theme | Role | Feel |
|---|---|---|
| **Light** | Default | Existing `foxcs-base.css` light palette. |
| **Dark** | Built 2026-08-08 | Existing `[data-theme="dark"]` palette — see `design-system.md`'s "Dark Mode / Theme Toggle" section for computed contrast ratios. |
| **Natural** | Real palette as of 2026-08-08 | Cream/parchment background, deep green as the high-contrast color. From `waypoint_theme_typography_style_guide_full.md`'s own Section 9, which already includes computed contrast ratios and an explicit rule keeping the decorative leaf-green (`#8EA893`) out of any text/border/fill use. |
| **Synthwave / Cyber** | Real palette as of 2026-08-08 | Deep blue/purple background, cyan primary, magenta used selectively — reference points are *Cyberpunk 2077* and *Stray*. From the guide's Section 14, including the Critical Synthwave Contrast Rule (Section 15): brand magenta `#D52AE3` is ~3.86:1, too low for text, so it's brand/decorative-only. |

Full palette + reasoning lives in `shared-styles/foxcs-theme-natural.css` and `foxcs-theme-synth.css` — both are drop-in replacements for the earlier placeholder files, same variable names, no changes needed elsewhere. A few things the guide leaves unspecified were filled in and flagged inline in those files: semantic warning/info colors (the guide only specs success/error's *existence*, not exact hex, per its own Section 25), and a button-safe "amber" secondary-action color for Synthwave (the guide's functional magenta is verified for *text*, not as a fill with FoxCS's existing hardcoded white button text on top).

**Real, working preview:** `theme-typography-specimen.html` — a toggleable page showing all four themes' typography, color palette (with hex + use), buttons, borders/focus, background texture, and semantic feedback states side by side. Colors are close to the current logo exploration (`logos/logo_natural.png`, `wavyLogo-synth*.png`) but not pinned to them exactly — not required to be, since the logos themselves aren't final either, and the guide's own Section 33 keeps every brand-direction option open.

**2026-08-08 revision:** Natural's background lightened (the guide's original `#FAF5E0` read too tan in practice), Synthwave's `--border-strong` swapped to the brand magenta for real visible pink (legitimate under the Critical Contrast Rule — non-text UI only needs 3:1, which `#D52AE3` clears).

**2026-08-10 revision — full contrast rebuild.** Jay's review of the live specimen found the first pass technically passed AA/AAA for text-on-its-own-background, but the feedback boxes still read as "low contrast" — because nothing checked whether a box's *background* stood out from the *page* background around it. Measured with the real WCAG formula: the original boxes were only ~1.2-2.1:1 against their page (Natural's accent/warning/error were all the literal same color, `#6f3a17` on `#E8D3AE`, indistinguishable from each other). Rebuilt as rich, saturated chips instead of pale tints:

| | Natural (before → after) | Synthwave (before → after) |
|---|---|---|
| Page bg | `#F9F5E7` → `#FCFAF1` (paler) | unchanged |
| Feedback box-vs-page | ~1.2-1.3:1 | ~1.4-2.1:1 |
| Feedback box-vs-page, rebuilt | ~7.5-9.6:1 | ~5.4-9.6:1 |
| Feedback text contrast | AA, some AAA-large-only | now AAA (7:1+) everywhere |
| Accent/badge hue | same as Error (literally identical) | same as Error (literally identical) |
| Accent/badge hue, rebuilt | its own warm gold, `#664C15` | its own violet, `#B79CFF` — a genuine 5th hue, part of "expand the palette" |

Every other functional color (text, muted-text, primary, border-strong) was also pushed from AAA-large-only to full AAA-normal (7:1) where the hue could support it without breaking identity. Full numbers and reasoning: the header comments in `shared-styles/foxcs-theme-natural.css` / `foxcs-theme-synth.css`.

**Background texture, built 2026-08-10, tuned same day after Jay's review.** Per the guide's Section 30 decorative tokens (`--decoration-texture-opacity`, `--decoration-grid-opacity`, `--decoration-glow`): Natural gets a subtle SVG fractal-noise paper grain (`feTurbulence`, no repeat seam, unlike a tiled photo); Synthwave gets a quiet CSS `repeating-linear-gradient` line grid tinted with `--color-primary`; Light/Dark get neither. Implemented as a `body::before`/`::after` pair sitting behind all content (`z-index:0`, `pointer-events:none`), reading the opacity from CSS custom properties so JS can also render a boosted-visibility preview swatch.

Two rounds of tuning after seeing it live: opacity started at the guide's own suggested 0.035, doubled to 0.08, then raised again to **0.1** since Jay still couldn't pick up the grain at 0.08 — "should remain subtle" (the guide's own Section 10 language) still has to mean *perceptible*, not invisible. The noise's own tint also shifted from a dark brown (`R:0.10 G:0.07 B:0.03`) toward a warmer yellow-gold (`R:0.80 G:0.68 B:0.22`) per Jay's "ok if it's more yellow than brown" note — real limit here: because the grain varies by *alpha* (not by swapping in a second color), low-alpha pixels still show the page's own pale background through, so the boosted swatch reads as a yellow-gold/cream blend rather than a pure saturated yellow. Positioning also changed from `position: fixed` to `position: absolute` on both `::before`/`::after` — Jay pointed out the pattern should scroll with the page like it's really texturing the paper/panel, not stay pinned to the viewport while content scrolls past it; `absolute` on a `position: relative` body with `inset: 0` covers the full scrollable content height, not just the viewport.

**Inline `<code>` inside colored feedback boxes was a real contrast bug, not just a design nitpick.** `code, pre` didn't set its own `color`, so it inherited whatever text color surrounded it — inside Synthwave's Error box (near-black text, `#0D0110`) that meant near-black code text on `--color-surface-alt` (`#303075`, dark blue), unreadable. Fixed by giving `code, pre` an explicit `color: var(--color-text)`, so inline code always pairs with its own background regardless of what colored context it's sitting inside.

**Light/Dark's Warning and Error were too similar, same-day fix.** Both had been built as the same pale-amber family (`#6a4a1a`/`#f4e3d0` vs `#7a3a00`/`#f9e1ad` in Light; the dark-mode equivalents just as close) — technically distinct hex values, but not visually distinct at a glance. Rebuilt as two genuinely separate hues, both as real chips per the same box-vs-page fix as Natural/Synthwave: Warning stays amber/gold, Error moves to a muted wine/rose family — still nowhere near alarm-red (design-system.md's Tone Note governs this: red is reserved for academic-integrity flags only).

**Synthwave's violet given more real presence, per Jay's request.** Was previously only the Accent/badge token. Now also `--accent-dashed` (drag-and-drop zone borders — a real interactive surface, not just decoration) and `--placed-bg`/`--placed-text` (already-placed block-builder pieces, previously the same plain blue-violet as `--box-bg-2`, now a distinct violet identity separating "done" from "still in the bank"). The already-approved feedback colors (success/warning/error/info) were explicitly *not* touched — Jay confirmed those are staying as-is.

## Typography

Per the guide's Sections 5–7: **JetBrains Mono** for code everywhere (and doubles as Synthwave's heading font), and a per-theme heading font — Atkinson Hyperlegible for Light/Dark, **Nunito Sans** for Natural, **JetBrains Mono** for Synthwave.

**Body font is no longer one face across every theme, as of 2026-08-10.** The guide's original Section 4/5 recommendation (Atkinson Hyperlegible everywhere, personality only from headings/color) is superseded per Jay's direction: body text can carry some theme character too, as long as it stays a genuinely legible text face — no script/handwritten faces, nothing decorative enough to raise cognitive load over a long reading passage. Current assignment:

| Theme | Body font | Why |
|---|---|---|
| Light / Dark | Atkinson Hyperlegible (unchanged) | Their whole brief is familiar/low-distraction — a personality font would undercut that goal |
| Natural | **Lora** | A contemporary text serif built for screen/print reading, not a display or script face — warm, calligraphic roots without tipping into "rustic/vintage" (the guide's own Section 8 warning) |
| Synthwave | **Sora** | A geometric sans with a technological character, but designed for UI/body legibility — unlike JetBrains Mono, which the guide explicitly rules out for long-form copy (Section 7) |

**Self-hosted, not linked to Google's CDN** — `shared-styles/foxcs-fonts.css` + `shared-styles/fonts/*.woff2`. Same "no external dependency in distributed content" reasoning as everything else here (see Known Risk below) — a font request to `fonts.googleapis.com` at render time is exactly the kind of external call real lesson content avoids. All six families (Atkinson Hyperlegible, Nunito Sans, JetBrains Mono, Source Sans 3 as the Light/Dark body fallback, Lora, Sora) are free, open-source (SIL OFL), and downloadable from fonts.google.com, per Jay's explicit requirement. Latin-subset only; most are variable fonts, so Google serves one file per family (not one per weight) — see `foxcs-fonts.css`'s header comment for the detail.

## Why Four Separate Files, Not Four `[data-theme]` Blocks in One File

The existing light/dark toggle keeps both palettes in one file (`foxcs-base.css`, `:root` + `[data-theme="dark"]`) because the toggle is pure runtime JS/CSS — no file editing involved. This feature is different: Jay wants the *initial, persistent* choice to be a real `<link href>` a student edits by hand (see Selection Mechanism below), which means each theme needs to be its own linkable file.

**Restructuring required:** `foxcs-base.css` currently defines both structure (layout, components, typography) *and* the light/dark variable values in the same file. Split into:

- `foxcs-base.css` — structure only. References CSS custom properties (`--bg`, `--text`, `--heading`, `--primary`, `--box-bg`, `--feedback-correct-bg`, etc.) but no longer defines their values.
- `foxcs-theme-light.css`, `foxcs-theme-dark.css`, `foxcs-theme-natural.css`, `foxcs-theme-synth.css` — each defines the same variable set under `:root`, nothing else. Whichever one is linked wins.

**Not yet done** — this is a design doc, not a completed restructuring. `foxcs-base.css` and the toggle JS still work exactly as documented in `shared-styles/README.md` today. Splitting it is the first real implementation step once this design is confirmed.

## Selection Mechanism

Two ways to change theme, feeding the same underlying state:

1. **Persistent / initial choice — edit the link.** Each page ships with `<link rel="stylesheet" id="foxcs-theme-link" href="foxcs-theme-light.css">` in its `<head>`, alongside `foxcs-base.css`. The onboarding moment Jay described — walking students through picking a theme on a sample lesson page — is literally teaching them to change that `href` to `foxcs-theme-natural.css` etc. This is real, meaningful HTML editing (an authentic tie-in if this ever crosses over with Web Dev), and it's robust: the choice lives in the file itself, not the browser, so it survives a different Chromebook, a cleared profile, or Classroom re-download.
2. **Live convenience — a top-of-page selector.** A small fixed selector (buttons or dropdown, four options) previews instantly by swapping `document.getElementById('foxcs-theme-link').href` — no reload, no file edit needed for a same-session change.
3. **Reconciling the two:** on Save (the existing save-in-place flow), the page rewrites the actual `<link href>` attribute in the DOM to match whatever the selector currently shows, *before* serializing. Whatever the student last picked — by hand-editing or by the dropdown — is what's baked into the file and what they'll see next time they open it. This is what makes "choose once, don't have to reset it every time" true without any dependency on browser storage.

## Known Risk: Classroom Folder Structure on Download

Same open question that already stopped `shared-styles/` from being linked into real lesson content (`shared-styles/README.md`) — if Google Classroom flattens a unit folder on download, or separates a lesson's HTML from files it depends on, an external `<link>` silently breaks and the page renders unstyled.

**This now blocks three separate decisions** (shared CSS rollout, the codename-swap-on-download script's scoping, and this theme system) — worth Jay actually running the empirical test rather than continuing to design around the unknown: create one throwaway unit folder with a lesson HTML file + a linked CSS file, distribute it to yourself (or a test account) via Classroom, download it back, and check whether the folder survives intact.

**Until that's answered, mitigate by keeping theme files same-folder, not shared-folder.** The four theme files (plus `foxcs-base.css`, and `foxcs-ide-dark.css`/`foxcs-theme-toggle.js` where used) should ship duplicated inside each lesson folder that uses them, not linked back to `02-authoring-system/shared-styles/` across unit boundaries — a same-folder relative link survives even if Classroom flattens folder *nesting*, since everything travels together. This trades duplication/drift risk (same tradeoff already flagged for the embedded-`<style>`-block approach) for robustness against the unresolved unknown. Revisit once the empirical test above is run — if Classroom preserves structure faithfully, a single shared `themes/` link becomes safe and the duplication goes away.

## Telemetry Hook

Every theme change — link edit detected on page load (compare current `href` to the file's last known value) or a dropdown pick — logs a `theme_change` event, and the theme active at Save time is captured in that save's session summary. See `telemetry-and-analytics.md` for the shared event-log mechanism this plugs into; theming doesn't get its own separate tracking channel.

## Not Yet Decided

- Whether the top-of-page selector shows on every page from day one, or rolls out alongside the Lesson 01.4 pattern like everything else in the MVP build.
- Whether `foxcs-ide-dark.css` (the code stepper's simulated-editor surface) should also theme-vary or stay fixed-dark regardless of the page theme — currently designed to stay fixed dark since it's simulating a real editor, not page chrome; worth confirming that reasoning still holds once Synthwave exists (a neon-on-dark IDE surface might actually want to lean into the Synthwave palette rather than clash with it).
- Migrating `shared-styles/`'s older ad-hoc token names (`--bg`, `--box-bg`, `--term-color`, etc.) to the guide's fuller semantic architecture (`--color-surface`, `--color-on-primary`, `--color-border-strong`, per-theme success/warning/error/info) — `theme-typography-specimen.html` implements that fuller architecture standalone for documentation purposes, but the actual component library and lesson content still run on the older, simpler token set. Not migrated in this pass; the two coexist for now.
- Submission metadata fields the guide proposes in its Section 28 (`ui_theme_id`, `ui_theme_version`, `ui_theme_source`, `ui_theme_selected_at`) — conceptually the same ground `telemetry-and-analytics.md`'s `theme_change` event and `saves[].theme` field already cover; not reconciled field-by-field against the guide's exact naming yet.
- `foxcs-theme-natural.css`/`-synth.css` now carry `--font-heading`/`--font-body` tokens (2026-08-10), but `foxcs-base.css` still hardcodes `Georgia, 'Times New Roman', serif` for `body` rather than reading `var(--font-body)`, and doesn't link `foxcs-fonts.css` at all — so the component library and `theme-and-telemetry-demo.html` inherit the new *colors* automatically (they link the theme files directly) but not the new *fonts* yet. Same "coexist for now" status as the semantic-token migration above.
- The background texture layer (`body::before`/`::after`) exists only in `theme-typography-specimen.html`, not in `foxcs-base.css` — real lesson content has no hook to turn it on yet.
