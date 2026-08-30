# html-to-pdf

Renders self-contained HTML (Seminar III presentation decks, and any future printable
worksheet built the same way) to PDF via headless Chromium. No display/GUI required —
this runs fine over SSH, including on the FoxCS droplet.

## One-time setup

```
cd 02-authoring-system/tools/html-to-pdf
npm install
npx playwright install --with-deps chromium
```

`--with-deps` pulls in the system libraries headless Chromium needs (fonts, `libnss3`,
etc.) via `apt-get` — requires `sudo`, which the droplet's `jay` user already has
passwordless. On a fresh droplet this is the step that used to fail silently; see
`../../../07-infrastructure/droplet-setup.md` for what does and doesn't work there.

## Usage

```
node render.mjs path/to/deck.html [more.html ...]
node render.mjs --portrait path/to/worksheet.html
```

Writes a `.pdf` next to each source `.html`. Defaults to landscape, 13.333in × 7.5in
(a 16:9 slide page) — matches the presentation decks' own print CSS, which lays out one
`<section class="slide">` per PDF page. Pass `--portrait` for Letter-portrait output
(worksheets, not slides).

`node_modules/` here is gitignored — Chromium's own binary lives outside it, in a
Playwright-managed cache, and doesn't get committed either. Run the one-time setup
again on any machine (or the droplet) that needs to render PDFs.
