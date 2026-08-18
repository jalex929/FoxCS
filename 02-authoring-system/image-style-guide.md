# Image Style Guide — Conceptual Illustrations

For diagrams/illustrations that explain coding concepts (e.g. what a variable is, how a loop iterates, how a function call works) embedded in Moodle instructional content. Not for charts/data visualization — for illustration.

## Color Palette

Computed and validated, not eyeballed — same method used for `adaptive-python`'s own design work would use (color-formula: fixed hue order, checked for colorblind-safe separation and contrast, never picked by eye). Validated with the standard six-check categorical palette validator.

**Standard set** — 6 hues in fixed rainbow order. This order is load-bearing for colorblind accessibility; keep it when assigning a hue to a new concept family (don't reorder per-illustration).

| Slot | Hue | Hex | Use for |
|---|---|---|---|
| 1 | Red | `#e34948` | (reserve — see H5P note below) |
| 2 | Orange | `#eb6834` | |
| 3 | Yellow | `#eda100` | needs a visible label/icon alongside it — see WARN below |
| 4 | Green | `#008300` | (reserve — see H5P note below) |
| 5 | Blue | `#2a78d6` | |
| 6 | Violet | `#4a3aa7` | |

Validated: all 6 pass the lightness band, chroma floor, and CVD-separation checks (worst adjacent pair ΔE 16.2, well clear of the 12 target). One WARN: yellow sits below 3:1 contrast on a light background — always pair it with a visible label or outline, never rely on the fill alone to carry meaning.

**Pale set** — the same 6 hues, each lightened to a background/fill tint (68% mixed toward white).

| Hue | Pale hex |
|---|---|
| Red | `#f6c5c4` |
| Orange | `#f9cfbe` |
| Yellow | `#f9e1ad` |
| Green | `#add7ad` |
| Blue | `#bbd4f2` |
| Violet | `#c5c0e3` |

**Pale is for fills/backgrounds only — never for identity by itself.** These fail the categorical-identity checks on purpose (low chroma, low contrast) because they're not meant to distinguish concepts on their own. Use pale as a card/box background or soft highlight, with the matching standard hue carrying the actual identity (as a border, icon, or accent line). Never ask a reader to tell two concepts apart by pale-color alone.

## H5P Color Awareness

H5P activity feedback near-universally uses **green = correct/success, red = incorrect/error**. Two implications:

- Don't use red/green in a concept illustration in a way that could be misread as a right/wrong signal, especially on the same screen as an H5P activity's feedback state.
- Keep saturation moderate (as validated above, not neon) so illustrations sit calmly next to H5P's typically bright feedback colors rather than competing with them.
- Confirm against the actual installed H5P theme once Moodle is running (local install found at `C:\Users\Jay Fox\server\moodle`, version 5.3dev) — this is a reasonable default, not yet visually checked against your live instance.

## Illustration Principles

- One concept, one hue family per illustration where possible — don't rainbow an entire diagram just because 6 colors are available.
- Reserve color for what actually needs to be distinguished (e.g., different variables in a memory diagram) — don't decorate.
- Flat, simple shapes over realistic/detailed art — this is about conceptual clarity, not visual flourish, and it needs to be fast to produce consistently across ~140 lessons.
- Consistent visual vocabulary across the course: once a shape/metaphor represents something (e.g., a labeled box = a variable), reuse it every time rather than reinventing per lesson.

## Open Question

Exact illustration tool/generation pipeline (hand-drawn, AI-generated, a simple diagramming tool) isn't decided yet — this doc defines the palette and principles so that whichever generation method gets used, the output stays consistent. See `../open-questions.md`.
