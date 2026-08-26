# Render Deck PDF

Renders a self-contained HTML file to PDF using headless Chrome, via Puppeteer.

Replaces the earlier `slide-deck-builder` (pptx-from-JSON) approach. Same underlying
problem, better fix: instead of generating a `.pptx` from a JSON spec, this renders the
*actual* HTML decks/documents that are already the source of truth (the presentation
decks in `../../teacher-materials/`, the instructional documents in
`../../instructional-content/`) using a real browser engine, so all CSS — colors,
callout boxes, chips, print page breaks — comes through exactly as authored.

## Why this exists

A rendered PDF, even a text-heavy one, is 100-300KB. That is too large to reliably
pass through a chat model as base64 without risking silent truncation or corruption.
Rendering happens locally on your machine instead — the binary never has to pass
through the assistant. Once rendered, drag the PDF into the right Google Drive folder
yourself.

## Usage

```
npm install
node render.js <input.html> <output.pdf> [slide|doc]
```

- `slide` (default) — 13.333x7.5in widescreen, no margins. Use for
  `teacher-materials/week-NN-presentation.html`.
- `doc` — US Letter, 0.4in margins. Use for `instructional-content/*.html`.

Example:

```
node render.js ../../teacher-materials/week-04-presentation.html week-04-presentation.pdf slide
node render.js ../../instructional-content/week-03-numbers-that-make-sense.html week-03-numbers-that-make-sense.pdf doc
```

## A note on the source HTML's print CSS

Every deck/document needs a `@media print` block. Two things to get right:

- Any absolutely-positioned element (e.g. a floating "note" callout) needs its
  containing block to be the slide/section itself, not the page — give the slide
  wrapper `position: relative` under `@media print`, not `position: static`.
  Getting this wrong makes every printed page show every slide's note stacked on
  top of each other (fixed 2026-08-26 across week-02/03/04-presentation.html).
- Flowing documents (the `doc` layout) should mark each section
  `break-inside: avoid` so a heading doesn't get orphaned at the bottom of a page.
