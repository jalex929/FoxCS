# Waypoint Learning Theme & Typography Style Guide
## Draft Exploration Specification

> **Purpose:** Define a shared visual foundation for Waypoint Learning while supporting student-selectable themes. This document focuses on color, typography, accessibility, theme behavior, and the metadata that should be captured when students submit work.

---

# 1. Why Waypoint Has Multiple Themes

Waypoint Learning should allow students to choose the visual environment they prefer without changing the instructional content, information architecture, or functionality of the platform.

The current direction is to support four themes:

1. **Standard Light** — familiar, neutral, low-distraction light interface.
2. **Standard Dark** — familiar, neutral, low-distraction dark interface.
3. **Natural / Organic** — warm cream, parchment-like texture, deep greens, and muted botanical accents.
4. **Synthwave / Cyber** — deep blue-purple surfaces with highly saturated cyan and magenta accents.

The Natural and Synthwave themes are intentionally more expressive.

They are being explored as potential visual directions for the broader Waypoint brand, but they can also coexist as optional student-selectable themes even if one is ultimately chosen as the primary brand direction.

Students should be able to:

- Select a theme during onboarding or from a theme control near the top of the interface.
- Change themes at any time.
- Have their selection persist across sessions.
- Use the same content and functionality regardless of theme.
- Complete assignments without theme choice affecting grading, mastery, or adaptive sequencing.

Theme selection is a presentation preference, not an academic variable.

---

# 2. Accessibility Is a Release Requirement

**WCAG 2.2 AA is the absolute minimum standard for every Waypoint theme. Nothing should ship if it fails AA.**

Accessibility is not something that should be checked only after a theme has been designed.

Every theme must be designed around accessible contrast, legibility, interaction states, keyboard access, scaling, and motion from the beginning.

Every theme must be tested independently.

A component that passes in Standard Light does not automatically pass in Natural, Synthwave, or Standard Dark.

Minimum requirements include:

- **4.5:1 contrast** for normal-sized text.
- **3:1 contrast** for large text where the WCAG large-text exception applies.
- **3:1 contrast** for meaningful non-text UI elements such as control boundaries, selected states, icons, and focus indicators where required.
- Color must never be the only way information is communicated.
- Hover, focus, active, selected, correct, incorrect, warning, and disabled states must remain distinguishable.
- Keyboard focus must always be clearly visible.
- Text placed over texture, gradients, glow, or imagery must still meet contrast requirements.
- Motion and glow effects must respect `prefers-reduced-motion`.
- Decorative texture must never reduce legibility.
- The Synthwave theme must avoid excessive bloom, flicker, flashing, or chromatic effects that interfere with reading.
- The Natural theme must avoid making low-contrast muted greens responsible for essential information.
- Typography must remain usable at 200% browser zoom and with increased text size.

When a logo color does not meet AA for a specific text or control use, preserve it as a **brand/decorative color** and introduce an accessibility-adjusted functional variant.

Brand colors do not automatically become UI colors.

---

# 3. Theme Architecture

Themes should be implemented through semantic CSS custom properties rather than component-specific hard-coded colors.

Recommended structure:

```css
:root,
[data-theme="standard-light"] {
  --color-bg: ...;
  --color-surface: ...;
  --color-surface-raised: ...;

  --color-text: ...;
  --color-text-muted: ...;

  --color-primary: ...;
  --color-primary-hover: ...;
  --color-on-primary: ...;

  --color-accent: ...;

  --color-border: ...;
  --color-border-strong: ...;
  --color-focus: ...;

  --color-success: ...;
  --color-warning: ...;
  --color-error: ...;
  --color-info: ...;
}
```

Components should consume semantic tokens:

```css
.card {
  background: var(--color-surface);
  color: var(--color-text);
  border: 1px solid var(--color-border);
}

.primary-button {
  background: var(--color-primary);
  color: var(--color-on-primary);
}
```

Avoid styling components directly with literal theme colors:

```css
/* Avoid */
.button {
  background: #16E2F5;
}
```

This keeps all four themes interchangeable and makes future themes much easier to add.

---

# 4. Shared Typography Strategy

Typography should prioritize:

1. **Legibility**
2. **Reading comfort**
3. **Accessibility**
4. **Consistency**
5. **Theme personality**

in that order.

Waypoint is an instructional product.

Students may spend long periods reading:

- Directions
- Explanations
- Feedback
- Rubrics
- Vocabulary
- Assessment questions
- Help text
- Error messages
- Code
- Documentation

Theme personality should therefore come primarily from:

- Heading typography
- Color
- Decorative graphics
- Texture
- Layout details
- Accent treatment

rather than from making body text stylistically unusual.

---

# 5. Shared Body Font

## Atkinson Hyperlegible

Use **Atkinson Hyperlegible** as the primary body and instructional font across all four themes.

Why:

- Designed specifically to improve character recognition.
- Distinguishes commonly confused letterforms clearly.
- Highly readable at interface sizes.
- Appropriate for longer instructional passages.
- Strong accessibility-first choice.
- Allows theme-specific display typography without changing how students read lesson content.

Recommended stack:

```css
--font-body:
  "Atkinson Hyperlegible",
  "Source Sans 3",
  system-ui,
  sans-serif;
```

If Atkinson Hyperlegible is unavailable, **Source Sans 3** is the preferred fallback.

---

# 6. Body Text Standards

Default application body text:

```text
16px minimum
```

Preferred instructional reading size:

```text
17–18px
```

Recommended body line height:

```text
1.55–1.7
```

Recommended instructional line length:

```text
60–75 characters
```

Additional rules:

- Do not use ultra-light font weights.
- Use `400` for standard body text.
- Use `600` or `700` for emphasis.
- Avoid long all-caps passages.
- Do not justify instructional body text.
- Maintain comfortable paragraph spacing.
- Allow browser zoom without clipping or overlap.
- Avoid condensed fonts for instructional text.
- Test actual lessons, not only sample marketing copy.

---

# 7. Shared Code Font

## JetBrains Mono

Use **JetBrains Mono** for code.

Recommended stack:

```css
--font-code:
  "JetBrains Mono",
  "SFMono-Regular",
  Consolas,
  "Liberation Mono",
  monospace;
```

Use for:

- Code editors
- Inline code
- Terminal/output examples
- File names when presented as code
- Syntax examples
- Console-style feedback

JetBrains Mono may also be used as a **display font in the Synthwave theme**.

Do not use JetBrains Mono for long-form body copy.

Monospaced text generally creates a less natural reading rhythm and requires more horizontal space.

---

# 8. Theme A — Natural / Organic

## Design Intent

The Natural theme should feel:

- Calm
- Warm
- Tactile
- Grounded
- Thoughtful
- Slightly handcrafted

Visual references include:

- Cream paper
- Botanical greens
- Printed educational materials
- Softly textured sketchbooks
- Natural materials
- Growth and wayfinding motifs

The current Waypoint Natural logo suggests:

- Warm cream
- Deep teal-green
- Softer sage green

The application should still feel modern and precise.

It should not feel rustic, vintage, or like a wellness application.

---

# 9. Natural Palette

| Token | Color | Use |
|---|---|---|
| `--natural-bg` | `#FAF5E0` | Primary page background |
| `--natural-surface` | `#FFFDF4` | Cards and reading surfaces |
| `--natural-surface-alt` | `#F2ECD4` | Secondary sections |
| `--natural-text` | `#0F312E` | Primary text |
| `--natural-text-muted` | `#506E67` | Secondary text |
| `--natural-primary` | `#2A5C59` | Buttons, links, active controls |
| `--natural-primary-dark` | `#1A423C` | Hover / pressed states |
| `--natural-leaf` | `#8EA893` | Decorative botanical accent |
| `--natural-border` | `#B4C5B7` | Low-emphasis dividers |
| `--natural-border-strong` | `#759189` | Meaningful control boundaries |
| `--natural-focus` | `#2A5C59` | Keyboard focus outline |

Approximate contrast against `#FAF5E0`:

```text
#0F312E → ~12.8:1
#2A5C59 → ~6.9:1
#506E67 → ~5.1:1
#759189 → ~3.1:1
#8EA893 → ~2.35:1
```

Therefore:

**`#8EA893` should not be used for normal text, essential icons, or control boundaries on the cream background.**

Use it for:

- Leaf motifs
- Illustration
- Decorative fills
- Background tags with dark text
- Non-essential visual accents

---

# 10. Natural Background Treatment

Primary background:

```css
background: #FAF5E0;
```

Reading surfaces:

```css
background: #FFFDF4;
```

Secondary surfaces:

```css
background: #F2ECD4;
```

A subtle parchment or speckled-paper effect may be used.

The texture should be implemented as a low-opacity decorative layer rather than becoming part of the functional background color.

Example:

```css
.page {
  background-color: var(--color-bg);
  background-image: var(--paper-texture);
}
```

Texture should:

- Remain subtle at normal zoom.
- Never interfere with text.
- Never reduce contrast.
- Avoid strong repeating patterns.
- Be removable without changing information hierarchy.

---

# 11. Natural Typography

## Heading Font

**Nunito Sans**

Why:

- Rounded forms complement the Waypoint wordmark.
- Friendly without being juvenile.
- Readable at large and medium sizes.
- Adds warmth without becoming decorative.

Recommended:

```css
--font-heading:
  "Nunito Sans",
  "Atkinson Hyperlegible",
  sans-serif;
```

Suggested weights:

```text
700–800 → major page titles
700 → section headings
600–700 → card titles
```

## Body Font

**Atkinson Hyperlegible**

```css
--font-body:
  "Atkinson Hyperlegible",
  "Source Sans 3",
  system-ui,
  sans-serif;
```

Use for:

- Lesson content
- Directions
- Feedback
- Forms
- Rubrics
- Navigation
- Help text
- Reading passages

## Code Font

**JetBrains Mono**

The Natural typography hierarchy is:

```text
Nunito Sans
→ display
→ headings
→ theme personality

Atkinson Hyperlegible
→ reading
→ learning
→ interface

JetBrains Mono
→ code
→ syntax
→ technical content
```

---

# 12. Natural Visual Character

Prefer:

- Generous whitespace
- Slightly rounded corners
- Soft surface separation
- Restrained shadows
- Botanical line illustrations
- Path and wayfinding motifs
- Very subtle paper texture
- Deep green for strong interaction states

Avoid:

- Heavy gradients
- Glossy surfaces
- Neon effects
- Low-contrast beige-on-beige interfaces
- Excessively muted controls
- Making everything green
- Making the product resemble a wellness application

---

# 13. Theme B — Synthwave / Cyber

## Design Intent

The Synthwave theme should feel:

- Futuristic
- Energetic
- Technological
- Game-adjacent
- Immersive
- High contrast

Visual inspiration may draw broadly from futuristic game environments such as:

- Cyberpunk 2077
- Stray

The goal is not to reproduce either visual identity.

Instead, use qualities such as:

- Deep navy and indigo environments
- Electric cyan
- Hot magenta
- Digital paths
- Nodes
- Interface panels
- Grid or signal motifs
- Controlled glow

The interface should feel like a **learning environment inside a futuristic system**.

It should not look like a nightclub poster.

---

# 14. Synthwave Palette

| Token | Color | Use |
|---|---|---|
| `--synth-bg` | `#1D1E54` | Primary background |
| `--synth-surface` | `#272765` | Cards and panels |
| `--synth-surface-raised` | `#303075` | Raised interactive surfaces |
| `--synth-deep` | `#11123B` | Deep inset surfaces |
| `--synth-text` | `#F8F7FF` | Primary text |
| `--synth-text-muted` | `#C8CAF6` | Secondary text |
| `--synth-cyan` | `#16E2F5` | Primary accent / action |
| `--synth-magenta-brand` | `#D52AE3` | Decorative brand magenta |
| `--synth-magenta-ui` | `#E656F3` | Accessibility-adjusted magenta |
| `--synth-border` | `#636BC4` | Functional border |
| `--synth-focus` | `#16E2F5` | Keyboard focus |

Approximate contrast against `#1D1E54`:

```text
#F8F7FF → very high contrast
#16E2F5 → ~9.7:1
#D52AE3 → ~3.86:1
#E656F3 → ~5.1:1
#636BC4 → ~3.2:1
```

---

# 15. Critical Synthwave Contrast Rule

The original logo magenta:

```text
#D52AE3
```

is **not appropriate for normal-sized heading or body text against the deep indigo background**.

It should primarily remain a:

- Brand color
- Illustration color
- Decorative path color
- Large graphical accent
- Ambient glow color

Do not assume that a bright neon color automatically has high contrast on a dark background.

---

# 16. Synthwave Text Hierarchy

Primary text:

```css
color: #F8F7FF;
```

Secondary text:

```css
color: #C8CAF6;
```

Primary headings should normally use:

```css
color: #F8F7FF;
```

Interactive or highlighted heading accents may use:

```css
color: #16E2F5;
```

Accessibility-adjusted magenta may be used selectively:

```css
color: #E656F3;
```

but only after verifying contrast for the actual:

- Background
- Font size
- Font weight
- Component state

Default rule:

```css
.synthwave h1,
.synthwave h2,
.synthwave h3 {
  color: #F8F7FF;
}

.synthwave .heading-accent {
  color: #16E2F5;
}

.synthwave .decorative-magenta {
  color: #D52AE3;
}
```

## Recommended Visual Pattern

Rather than making entire titles neon:

```text
LOOPS
```

use:

```text
LOOPS
──────── cyan accent rule
```

or:

```text
03 / LOOPS
```

where the number or small detail is cyan or magenta while the primary heading remains near-white.

This preserves the cyber identity without sacrificing readability.

---

# 17. Synthwave Primary Actions

Electric cyan should generally function as the primary interaction color.

```css
--color-primary: #16E2F5;
--color-on-primary: #1D1E54;
```

Recommended uses:

- Primary buttons
- Focus indicators
- Links
- Selected navigation
- Progress visualization
- Current waypoint
- Active states

Example:

```css
.primary-button {
  background: #16E2F5;
  color: #1D1E54;
}
```

---

# 18. Synthwave Magenta Usage

## Brand Magenta

```text
#D52AE3
```

Use for:

- Logo artwork
- Decorative paths
- Illustrations
- Large shapes
- Ambient effects
- Non-essential highlights

## Functional Magenta

```text
#E656F3
```

Use when magenta must carry actual interface meaning and passes contrast.

Potential uses:

- Badges
- Selected states
- Short labels
- Small highlighted UI moments

Do not use magenta for long instructional passages.

---

# 19. Synthwave Glow

Glow should reinforce a component.

It should never define the component by itself.

Good:

```css
.focused-control {
  box-shadow:
    0 0 0 2px #16E2F5,
    0 0 16px rgba(22, 226, 245, 0.22);
}
```

The solid focus ring carries accessibility information.

The glow is decorative.

Avoid:

```text
glow only
```

as the keyboard focus state.

---

# 20. Synthwave Typography

## Heading / Display Font

**JetBrains Mono**

JetBrains Mono is a strong fit for Synthwave headings because it:

- Signals a technical environment.
- Has recognizable programming associations.
- Provides distinctive but readable letterforms.
- Connects the visual identity of Waypoint to coding.
- Works well with cyan, magenta, node, path, and terminal-inspired graphics.

Recommended:

```css
--font-heading:
  "JetBrains Mono",
  "SFMono-Regular",
  Consolas,
  monospace;
```

Suggested weights:

```text
700 → major titles
600–700 → section headings
500–600 → short labels
```

Use for:

- Major titles
- Module titles
- Dashboard headings
- Short system callouts
- Small amounts of branded UI text

Do not use it for long instructional paragraphs.

## Body Font

**Atkinson Hyperlegible**

```css
--font-body:
  "Atkinson Hyperlegible",
  "Source Sans 3",
  system-ui,
  sans-serif;
```

The intended distinction is:

```text
JetBrains Mono
→ technology
→ system identity
→ headings
→ code

Atkinson Hyperlegible
→ learning
→ reading
→ instructions
→ feedback
→ navigation
```

## Code

Continue using **JetBrains Mono**.

Because code and headings use the same family in this theme, distinguish them through:

- Size
- Surface treatment
- Syntax highlighting
- Layout
- Spacing
- Context

Do not rely on typography alone.

---

# 21. Synthwave Visual Character

Prefer:

- Deep navy and indigo surfaces
- Near-white instructional text
- Cyan primary interaction color
- Selective magenta accents
- Thin luminous route/path lines
- Nodes
- Grids
- Signals
- Layered panels
- Controlled glow
- Strong visual hierarchy

Avoid:

- Neon body text
- Neon-colored full paragraphs
- Low-contrast magenta headings
- Bloom behind instructional text
- Constant animation
- Scanlines over reading surfaces
- Flickering effects
- Chromatic aberration on text
- Making every component glow
- Excessive visual noise

The strongest accessible version of the Synthwave theme should rely primarily on:

```text
deep navy
+
near-white
+
cyan
```

with magenta used more selectively.

---

# 22. Standard Light Theme

The Standard Light theme should be intentionally familiar and restrained.

It exists for students who want:

- Maximum familiarity
- Low visual novelty
- A conventional productivity-tool aesthetic
- A neutral alternative to expressive themes

## Palette

| Token | Color |
|---|---|
| Background | `#F7F8FA` |
| Surface | `#FFFFFF` |
| Surface Alt | `#EEF1F5` |
| Primary Text | `#18202A` |
| Secondary Text | `#56616F` |
| Primary | `#3157D5` |
| Primary Hover | `#2446B8` |
| Border | `#C9D0D9` |
| Strong Border | `#7B8794` |
| Focus | `#3157D5` |

Typography:

```css
--font-heading:
  "Atkinson Hyperlegible",
  "Source Sans 3",
  system-ui,
  sans-serif;

--font-body:
  "Atkinson Hyperlegible",
  "Source Sans 3",
  system-ui,
  sans-serif;

--font-code:
  "JetBrains Mono",
  monospace;
```

The Standard Light theme should not use:

- Paper texture
- Neon effects
- Theme-specific decorative motifs
- Strong branded visual effects

---

# 23. Standard Dark Theme

The Standard Dark theme should be a neutral dark interface rather than a simplified version of Synthwave.

## Palette

| Token | Color |
|---|---|
| Background | `#111318` |
| Surface | `#1A1D24` |
| Surface Alt | `#222630` |
| Primary Text | `#F5F7FA` |
| Secondary Text | `#B7C0CC` |
| Primary | `#8DA2FF` |
| Primary Hover | `#A6B5FF` |
| Border | `#4A5360` |
| Strong Border | `#6F7A89` |
| Focus | `#A6B5FF` |

Typography:

```css
--font-heading:
  "Atkinson Hyperlegible",
  "Source Sans 3",
  system-ui,
  sans-serif;

--font-body:
  "Atkinson Hyperlegible",
  "Source Sans 3",
  system-ui,
  sans-serif;

--font-code:
  "JetBrains Mono",
  monospace;
```

The Standard Dark theme should avoid strong cyan/magenta branding so that it remains visually distinct from Synthwave.

---

# 24. Theme Comparison

| Dimension | Standard Light | Standard Dark | Natural | Synthwave |
|---|---|---|---|---|
| Feeling | Familiar | Familiar / low-light | Warm / grounded | Futuristic / energetic |
| Background | Cool off-white | Neutral charcoal | Warm cream | Deep indigo |
| Primary accent | Blue | Periwinkle | Deep green | Cyan |
| Secondary accent | Minimal | Minimal | Sage | Magenta |
| Heading font | Atkinson Hyperlegible | Atkinson Hyperlegible | Nunito Sans | JetBrains Mono |
| Body font | Atkinson Hyperlegible | Atkinson Hyperlegible | Atkinson Hyperlegible | Atkinson Hyperlegible |
| Code font | JetBrains Mono | JetBrains Mono | JetBrains Mono | JetBrains Mono |
| Texture | None | None | Subtle paper | Optional grid/noise |
| Glow | None | None | None | Selective |
| Brand intensity | Low | Low | Medium | High |
| Reading treatment | Neutral | Neutral | Calm | High-contrast neutral |
| Intended experience | Low distraction | Low distraction | Grounded | Immersive |

---

# 25. Semantic Colors

Success, warning, error, and informational states should remain semantically consistent across themes even when exact colors differ.

Recommended semantic API:

```css
--color-success:
--color-success-bg:

--color-warning:
--color-warning-bg:

--color-error:
--color-error-bg:

--color-info:
--color-info-bg:
```

Do not assume:

```text
green = success
red = error
yellow = warning
```

without additional communication.

Pair semantic states with:

- Icons
- Text labels
- Shapes
- Borders
- Supporting descriptions

Example:

```html
<div class="feedback feedback--error">
  <span aria-hidden="true">!</span>

  <div>
    <strong>Check this line.</strong>
    <p>Python expected a closing parenthesis.</p>
  </div>
</div>
```

Exact semantic palettes should be tested independently in every theme.

---

# 26. Theme Selector Behavior

Theme selection should be available from a consistently placed control near the top of the application.

Recommended student-facing choices:

```text
Light
Dark
Natural
Cyber
```

Internal IDs:

```text
standard-light
standard-dark
natural
synthwave
```

Example:

```html
<html data-theme="natural">
```

The selected theme should persist across sessions.

When accounts are available, the theme preference may also be stored with the user's profile so it follows them between devices.

Recommended resolution order:

```text
1. Explicit student selection
2. Saved account preference
3. Saved local preference
4. Waypoint platform default
```

Do not override a student's explicit selection merely because their operating system changes between light and dark mode.

---

# 27. Theme Selection UI

Students should be able to switch themes quickly.

The theme selector should communicate both:

- Theme name
- Visual preview

A theme selection interface may show:

```text
Light
[neutral light swatch]

Dark
[neutral dark swatch]

Natural
[cream + green swatch]

Cyber
[indigo + cyan + magenta swatch]
```

Do not rely on the theme name alone if a visual preview can make the choice clearer.

---

# 28. Submission Metadata

Waypoint should record the active theme when a student submits work.

This may later help evaluate whether presentation preferences correlate with:

- Usability
- Engagement
- Time on task
- Completion behavior
- Student preference

Theme metadata must **not** influence grading.

Recommended fields:

```json
{
  "ui_theme_id": "natural",
  "ui_theme_version": "1.0",
  "ui_theme_source": "user",
  "ui_theme_selected_at": "2026-08-08T02:00:00-05:00"
}
```

Definitions:

| Field | Purpose |
|---|---|
| `ui_theme_id` | Exact active theme at submission |
| `ui_theme_version` | Version of the design tokens |
| `ui_theme_source` | How the theme was selected |
| `ui_theme_selected_at` | When the current preference was selected |

Possible values:

```text
ui_theme_id:
- standard-light
- standard-dark
- natural
- synthwave
```

```text
ui_theme_source:
- user
- account-default
- local-default
- platform-default
```

If submissions already include a client-context object, theme data may live inside it.

Example:

```json
{
  "submission_context": {
    "theme": {
      "id": "synthwave",
      "version": "1.0",
      "source": "user"
    }
  }
}
```

Capture only metadata useful for legitimate product and usability analysis.

Do not collect unrelated system-level personalization information merely because it is available.

---

# 29. Suggested CSS Token Skeleton

```css
/* =========================================================
   SHARED
   ========================================================= */

:root {
  --font-body:
    "Atkinson Hyperlegible",
    "Source Sans 3",
    system-ui,
    sans-serif;

  --font-code:
    "JetBrains Mono",
    "SFMono-Regular",
    Consolas,
    monospace;
}

/* =========================================================
   STANDARD LIGHT
   ========================================================= */

[data-theme="standard-light"] {
  --font-heading:
    "Atkinson Hyperlegible",
    "Source Sans 3",
    system-ui,
    sans-serif;

  --color-bg: #F7F8FA;
  --color-surface: #FFFFFF;
  --color-surface-alt: #EEF1F5;

  --color-text: #18202A;
  --color-text-muted: #56616F;

  --color-primary: #3157D5;
  --color-primary-hover: #2446B8;
  --color-on-primary: #FFFFFF;

  --color-border: #C9D0D9;
  --color-border-strong: #7B8794;
  --color-focus: #3157D5;
}

/* =========================================================
   STANDARD DARK
   ========================================================= */

[data-theme="standard-dark"] {
  --font-heading:
    "Atkinson Hyperlegible",
    "Source Sans 3",
    system-ui,
    sans-serif;

  --color-bg: #111318;
  --color-surface: #1A1D24;
  --color-surface-alt: #222630;

  --color-text: #F5F7FA;
  --color-text-muted: #B7C0CC;

  --color-primary: #8DA2FF;
  --color-primary-hover: #A6B5FF;
  --color-on-primary: #111318;

  --color-border: #4A5360;
  --color-border-strong: #6F7A89;
  --color-focus: #A6B5FF;
}

/* =========================================================
   NATURAL
   ========================================================= */

[data-theme="natural"] {
  --font-heading:
    "Nunito Sans",
    "Atkinson Hyperlegible",
    sans-serif;

  --color-bg: #FAF5E0;
  --color-surface: #FFFDF4;
  --color-surface-alt: #F2ECD4;

  --color-text: #0F312E;
  --color-text-muted: #506E67;

  --color-primary: #2A5C59;
  --color-primary-hover: #1A423C;
  --color-on-primary: #FFFFFF;

  --color-accent: #8EA893;

  --color-border: #B4C5B7;
  --color-border-strong: #759189;
  --color-focus: #2A5C59;
}

/* =========================================================
   SYNTHWAVE
   ========================================================= */

[data-theme="synthwave"] {
  --font-heading:
    "JetBrains Mono",
    "SFMono-Regular",
    Consolas,
    monospace;

  --color-bg: #1D1E54;
  --color-surface: #272765;
  --color-surface-alt: #303075;
  --color-surface-inset: #11123B;

  --color-text: #F8F7FF;
  --color-text-muted: #C8CAF6;

  --color-primary: #16E2F5;
  --color-primary-hover: #4DEAF7;
  --color-on-primary: #1D1E54;

  --color-accent-brand: #D52AE3;
  --color-accent-ui: #E656F3;

  --color-border: #636BC4;
  --color-border-strong: #858AF0;
  --color-focus: #16E2F5;
}
```

---

# 30. Theme-Specific Decorative Tokens

Functional components should use semantic tokens.

Decorative effects may use separate theme-specific tokens.

Example:

```css
[data-theme="natural"] {
  --decoration-texture-opacity: 0.035;
  --decoration-grid-opacity: 0;
  --decoration-glow: none;
}

[data-theme="synthwave"] {
  --decoration-texture-opacity: 0;
  --decoration-grid-opacity: 0.08;

  --decoration-glow:
    0 0 18px rgba(22, 226, 245, 0.18);
}
```

This prevents decorative styling from becoming entangled with accessibility-critical colors.

---

# 31. Same Waypoint, Different Atmosphere

Themes should change the **atmosphere**, not the underlying experience.

A student switching from Natural to Synthwave should still immediately understand:

- Where they are
- What is clickable
- What is selected
- What is required
- Whether an answer is correct
- How much progress they have made
- Where to go next

The following should remain consistent across themes:

- Component structure
- Spacing logic
- Interaction behavior
- Icon meaning
- Information hierarchy
- Navigation patterns
- Feedback structure
- Accessibility behavior

This allows Waypoint to support expressive customization without maintaining four unrelated applications.

---

# 32. Current Theme Model

Think of the four themes as two groups:

```text
Neutral
├── Standard Light
└── Standard Dark

Expressive
├── Natural
└── Synthwave / Cyber
```

This gives students:

- Familiar low-distraction choices
- More expressive personalized choices

without making visual expression mandatory.

---

# 33. Current Design Direction

The system should be built so that any of the following outcomes remain possible:

### Option A

Natural becomes the primary Waypoint brand.

Synthwave remains an optional theme.

### Option B

Synthwave becomes the primary Waypoint brand.

Natural remains an optional theme.

### Option C

Waypoint maintains a more neutral core identity.

Natural and Synthwave become equally supported student customization themes.

### Option D

Student testing suggests that customization itself is more valuable than selecting one dominant branded style.

The design architecture should support all four outcomes without requiring the application to be rebuilt.

---

# 34. Guiding Principle

The goal is not:

> Make four versions of Waypoint.

The goal is:

> Build one accessible Waypoint interface that can support different visual atmospheres.

The instructional experience should remain stable.

The visual environment may change.

Accessibility does not.
