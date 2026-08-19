# FoxCS Instructional Image Generation Guide

**Moved here 2026-08-18 from `starter context/FoxCS_Instructional_Image_Generation_Guide.md`** — Jay's own starting draft, now the canonical illustration standard for FoxCS, superseding `image-style-guide.md`'s older validated-categorical-palette approach (see that file for why). The description scope below says "the FoxCS introductory Python curriculum," written before this session's multi-course expansion — treat it as applying to all three FoxCS courses (Game I, Game II, Web II), not Python only, until told otherwise. Also extended the same day with a new Section 10.7 (Micro Diagram) and its supporting Section 13/17/18/19/20 updates — a smaller, inline-illustration tier for breaking up lesson-page prose, distinct from the six full standalone template families this doc originally defined — plus **Section 21, a concrete SVG production recipe** for actually hand-coding Micro Diagrams (coordinates, color tokens, arrow/label conventions, a QA checklist), proven against two real examples in `illustration-examples-gallery.html`. See `../decisions-log.md`'s 2026-08-18 entry.

**Where this lives, per Jay (2026-08-18): this is authoring/teacher-side reference material, never distributed to students.** Same status as every other file in `02-authoring-system/` (`lesson-schema.md`, `authoring-workflow.md`, and the rest) — it stays out of `courses/<course>/content/` entirely. Images are generated separately, using this guide, and only the **finished image files** (plus their required alt text and text-equivalent, per Section 14) go into a lesson's actual `content/` folder alongside the instructional HTML. This guide itself, its production prompts, and its metadata records never ship to a student.

## 1. Purpose

This document defines the visual and instructional standards for images created for the FoxCS introductory Python curriculum.

Instructional images should help learners:

- Understand new concepts
- Build accurate mental models
- Break complex ideas into smaller parts
- Compare related concepts and approaches
- Follow processes and sequences
- Identify errors
- Debug code systematically
- Repair common misconceptions
- Learn technical vocabulary
- Recognize reusable programming patterns
- Make decisions about which programming tool or strategy to use

The images are instructional resources, not decoration. Every visual element should support understanding, attention, recall, or problem-solving.

The primary audience is high school students. Images should feel approachable and supportive without appearing juvenile.

---

## 2. Final Art Direction

Use a clean, flat educational illustration style.

The visual system should include:

- White or lightly tinted backgrounds
- Clean geometric shapes
- Crisp dark outlines
- Rounded panels and cards
- Flat vector-like illustrations
- Minimal, soft shading
- Strong visual hierarchy
- Clear arrows and labels
- Generous white space
- Simple instructional icons
- Monospaced code examples
- Restrained use of saturated colors

The style should feel:

- Modern
- Mature
- Supportive
- Accessible
- Calm
- Technically oriented
- Consistent across the course
- Appropriate for high school learners

The images should not feel:

- Elementary
- Mascot-driven
- Overly playful
- Like brightly colored classroom posters
- Overly corporate
- Visually crowded
- Photorealistic
- Heavily three-dimensional
- Like the same template with only the content replaced

---

## 3. Shared Style Versus Template Variation

All instructional images should belong to the same visual family, but different image types should use visibly different compositions.

Consistency should come from:

- The shared palette
- Semantic color meanings
- Typography
- Code formatting
- Outline style
- Icon style
- Spacing system
- Panel shapes
- Instructional tone
- Use of subtle shading

Variation should come from:

- Header placement
- Primary icon
- Number of panels
- Direction of information flow
- Content density
- Relative prominence of code
- Relative prominence of diagrams
- Footer treatment
- Symmetrical versus asymmetrical layouts
- Horizontal versus vertical sequencing

Do not create every image as a dense infographic with:

1. A large title
2. Four numbered panels
3. A worked example
4. A key takeaway bar

The template should reflect the instructional purpose.

---

## 4. Semantic Color System

Colors should carry consistent meaning throughout the course.

### 4.1 Navy

**Meaning:** primary visual anchor, major heading, foundational structure, main body text.

**Use for:** main titles, important headings, primary outlines, dark text, major structural elements.

### 4.2 Blue

**Meaning:** core concepts, syntax, names, structure, technical information.

**Use for:** variable names, function names, Python keywords, index labels, concept labels, step headings, structural arrows.

### 4.3 Green

**Meaning:** correct result, successful outcome, working code, resolved issue, recommended action.

**Use for:** correct output, fixed code, checkmarks, successful result panels, correct mental models, values when emphasizing results.

Green should not mean "easy" or "lower level."

### 4.4 Purple

**Meaning:** explanation, mental model, analogy, interpretation, reflection, conceptual connection.

**Use for:** "Think of it like..." sections, "What is happening?" explanations, reflection prompts, interpretation panels, analogy diagrams, supporting conceptual explanations.

### 4.5 Yellow or Gold

**Meaning:** tip, reminder, example, attention, something worth noticing.

**Use for:** `TIP` labels, worked-example tabs, reminder panels, small attention markers, important notes.

Yellow should not indicate danger.

### 4.6 Orange

**Meaning:** active step, testing, experimentation, transition, work in progress.

**Use for:** testing steps, process stages, "Try this" actions, active investigation, intermediate states.

### 4.7 Red or Coral

**Meaning:** error, misconception, warning, incorrect code, needs attention.

**Use for:** error messages, incorrect syntax, misconception panels, error-location arrows, failed or unexpected results.

Red should never be used as general decoration.

### 4.8 Grey

**Meaning:** neutral information, secondary structure, inactive state, background support.

**Use for:** code backgrounds, dividers, neutral cards, secondary text, empty response areas, inactive examples.

---

## 5. Color Intensity Levels

Each semantic color should have a strong, standard, and muted version. Muted colors should be the default for large surfaces. Strong colors should be reserved for small icons, labels, borders, arrows, keywords, status indicators, and important highlights.

### 5.1 Palette Tokens

```css
:root {
  --navy-strong: #0b2347;
  --navy-standard: #17365f;
  --navy-muted: #dce5f0;

  --blue-strong: #1457d9;
  --blue-standard: #3d73c7;
  --blue-muted: #dce8f8;

  --green-strong: #138a3d;
  --green-standard: #4a9b67;
  --green-muted: #ddeee3;

  --purple-strong: #6530b8;
  --purple-standard: #8061b1;
  --purple-muted: #e8e0f2;

  --yellow-strong: #f4bf24;
  --yellow-standard: #d8b550;
  --yellow-muted: #f7efcf;

  --orange-strong: #ed7a00;
  --orange-standard: #c98a45;
  --orange-muted: #f4e5d2;

  --red-strong: #d83b32;
  --red-standard: #c76862;
  --red-muted: #f3dedc;

  --grey-strong: #3c4656;
  --grey-standard: #7b8491;
  --grey-muted: #edf0f3;

  --white: #ffffff;
  --off-white: #fafbfc;
  --page-grey: #f6f7f9;
}
```

### 5.2 Default Visual Balance

Most images should contain approximately:

- 60–70% white or off-white
- 20–30% muted semantic backgrounds
- 5–10% strong accent colors

Avoid using more than three highly saturated colors in one image.

---

## 6. Background and Panel Rules

Recommended hierarchy:

```text
Page background: off-white or very light tinted neutral
Primary panel: white
Secondary panel: muted semantic color
Code panel: very light grey
Correct output panel: muted green
Error panel: muted red
Explanation panel: muted purple
Tip panel: muted yellow
```

Prefer white panels with semantic borders, muted fills, and strong-color labels or tabs.

Avoid large saturated background regions, strong gradients, high-gloss effects, heavy drop shadows, and excessive glowing effects.

Shading should be subtle and used only to separate overlapping forms, add slight depth to an icon, clarify hierarchy, or prevent large flat objects from feeling visually unfinished.

---

## 7. Typography

### 7.1 Headings

Use a clean, modern sans-serif style. Main titles should be large, dark navy, bold, easy to scan, and written in title case or uppercase consistently.

Examples:

```text
WHAT IS INDEXING?
HOW USER INPUT WORKS
SPOT THE ERROR: FUNCTION SYNTAX
CONCATENATION VS. USING COMMAS
```

### 7.2 Body Text

Body copy should use dark navy or dark grey, remain short and direct, avoid dense paragraphs, use clear learner-facing language, and be readable at normal lesson-page size.

### 7.3 Code

Code should use a monospaced font, preserve exact Python syntax, avoid wrapping, use short examples, appear in a distinct code panel, and be separated from output.

Suggested syntax highlighting:

- Keywords: blue
- Strings: coral or muted red
- Variable and function names: navy or blue
- Numbers and values: green
- Comments: muted green or grey
- Operators and punctuation: dark navy

Generated images must be reviewed carefully for quotation marks, parentheses, brackets, braces, colons, commas, indentation, spaces, variable names, and output accuracy.

When exact text or code cannot be generated reliably, create the illustration layout separately and add final text in HTML, SVG, Figma, or another controlled design layer.

---

## 8. Template Labels

Images may include an inconspicuous template label in the upper-right corner.

Examples:

```text
Concept Breakdown
Misconception Repair
Debugging Guide
Spot the Error
Comparison
Process
Vocabulary
```

Label rules:

- Small
- Dark grey
- Unobtrusive
- Consistently positioned
- Not enclosed in a large badge
- Secondary to the instructional title

---

## 9. Standard Icon Language

Icons should carry stable meanings.

### 9.1 Debugging Icon

The standard debugging icon is a magnifying glass with a bug inside the lens.

Use it for debugging guides, spot-the-error activities, error clinics, error-message translation, troubleshooting pathways, and debugging reminders.

The icon should use clean navy outlines, a blue magnifying glass, a red or coral bug, minimal soft shading, and a clear silhouette.

Detail levels:

- **Large:** full lens, bug, handle, subtle highlight
- **Medium:** simplified lens and bug
- **Small:** outline magnifying glass with solid bug silhouette

At small sizes, remove thin leg details, strong gradients, tiny highlights, and unnecessary internal lines.

Do not use this icon for general observation or research.

### 9.2 Tip Icon

Use a small outlined lightbulb with the word `TIP`.

Reserve the lightbulb for actual advice, reminders, or insights. Do not use a lightbulb as a default decorative icon on every image.

### 9.3 Other Template Icons

| Purpose | Preferred icon |
|---|---|
| Concept breakdown | Puzzle piece, brackets, node diagram |
| Misconception repair | Wrench, repair arrow, refresh symbol |
| Debugging | Magnifying glass with bug |
| Comparison | Scale, split arrows, mirrored panels |
| Process | Numbered path, route markers, timeline |
| Vocabulary | Bookmark, index card, dictionary tab |
| Tip | Lightbulb labeled `TIP` |
| Success | Checkmark |
| Error | Warning triangle or error marker |
| Testing | Beaker or test tube |
| Revision | Circular arrow or wrench |

---

## 10. Primary Template Families

**Added 2026-08-18: two different jobs, two different tools.** The six families below (10.1-10.6) are all **standalone teaching artifacts** — each one is a complete resource with a title, definition, code, and takeaway, meant to teach or summarize a whole concept on its own. That's the right tool when a lesson needs a real reference resource a Learner might return to.

It is the *wrong* tool for the much more common moment: a sentence of lesson prose that would land better with a picture next to it. Trying to use a shrunk-down Concept Breakdown for that job is what produces the "wall of text broken up by small anchor charts" problem. **Section 10.7, Micro Diagram**, is the tool for that moment instead. It has no title, no code panel, no takeaway. It's one visual metaphor, sized to sit inline in the lesson and do the job of the single sentence it's illustrating, nothing more. In practice, Micro Diagrams should be the most frequently used family in this whole system, even though they're listed last below.

The first version of the illustration system should standardize six primary families, plus Micro Diagram.

### 10.1 Concept Breakdown

**Purpose:** Introduce a new concept and establish a strong mental model.

**Examples:** variables, indexing, slicing, functions, lists, user input, parameters, return values.

**Required content:** main title, brief definition, main visual model, code example, output or result, key takeaway.

**Optional content:** analogy, tip, second example, prediction question, vocabulary connection.

**Composition:** open and airy, one dominant visual, lower density, broad panels, generous white space, code supports the diagram rather than dominating it.

**Color emphasis:** blue for concept and structure, green for values and results, purple for analogy, yellow for tip or example.

**Distinguishing features:** large centered title, definition near the top, central diagram, predictable key-takeaway footer, puzzle piece/bracket/concept icon.

### 10.2 Misconception Repair

**Purpose:** Replace an inaccurate mental model with a more useful one.

**Examples:** `input()` returns a string, `=` assigns while `==` compares, the end of a slice is not included, `print()` and `return` are different, variables can change values.

**Required content:** misconception, why it feels reasonable, what actually happens, correct mental model, visual or code evidence, corrected rule.

**Optional content:** quick check, multiple examples, practice question, boundary diagram, “You may think / Python actually does” comparison.

**Composition:** segmented, medium density, incorrect-to-correct progression, strong visual contrast, central repair diagram.

**Color emphasis:** red for misconception, orange for why it is confusing, blue for technical explanation, green for corrected idea, purple for reflection or check.

**Distinguishing features:** red misconception panel, green repair panel, wrench or repair icon, corrected-rule footer.

### 10.3 Debugging and Error Clinic

**Purpose:** Help students identify, interpret, and fix errors systematically.

**Examples:** missing colon, type mismatch, misspelled variable, incorrect indentation, unexpected output, general debugging process.

**Required content for a specific error:** code sample, highlighted error location, error type, plain-language explanation, corrected code, expected output, debugging habit.

**Required content for a general guide:** repeatable debugging process, short example, quick checklist, tip or reminder.

**Composition:** utility-oriented, medium to high density, larger code panels, strong diagnostic labels, stacked process or checklist, compact spacing.

**Color emphasis:** blue for debugging process, red for error, purple for explanation, green for fix and successful output, orange for testing, yellow for reminder.

**Distinguishing features:** magnifying-glass-with-bug icon, left-aligned title, larger code panel, error-to-fix progression, checklist or debugging habit footer.

### 10.4 Side-by-Side Comparison

**Purpose:** Clarify differences and similarities between related concepts or approaches.

**Examples:** concatenation versus commas, f-strings versus concatenation, `print()` versus `return`, parameters versus arguments, `for` versus `while`, `=` versus `==`.

**Required content:** shared title, left concept, right concept, matching comparison categories, code example on each side, result or output on each side, shared takeaway.

**Optional content:** best-use guidance, common mistakes, shared similarities, decision recommendation.

**Composition:** mirrored two-column layout, central divider or `VS.` marker, equal visual weight, parallel information order, balanced density.

**Color emphasis:** blue for first concept, purple or green for second concept, yellow for shared note, red for limitations or errors only.

**Distinguishing features:** strong vertical split, matching panel structures, scale/split-arrow/comparison icon, footer labeled `WHEN TO USE EACH`, `KEY DIFFERENCE`, or `WHAT THEY SHARE`.

### 10.5 Process or Sequence

**Purpose:** Show what happens over time or in a defined order.

**Examples:** how user input works, how a function call runs, how a loop repeats, how code moves through revision, how a program handles input, how to submit work.

**Required content:** process title, three to six stages, directional arrows, one clear action per stage, final result, brief takeaway.

**Optional content:** code example, state labels, decision point, review question, interruption or error path.

**Composition:** horizontal, vertical, or circular path; strong directional movement; lower text density; repeated step cards; clear beginning and ending.

**Color emphasis:** blue for input or structure, purple for interpretation, orange for processing, green for successful completion, red for interruption only.

**Distinguishing features:** numbered path, timeline/route/step markers, final outcome card instead of a standard footer.

### 10.6 Vocabulary or Tip Card

**Purpose:** Provide compact, reusable lesson-page support.

**Vocabulary card required content:** term, definition, plain-language explanation, example sentence, code example.

**Optional vocabulary content:** related term, common confusion, word family, pronunciation support, visual analogy.

**Tip card required content:** `TIP` label, one clear action, why it helps, short example when useful.

**Composition:** compact, modular, low density, card-based, suitable for embedding in lessons, email feedback, or review pages.

**Color emphasis:** vocabulary uses blue for the term, purple for plain-language explanation, green for correct code use, grey for related terms. Tip cards use muted yellow backgrounds, blue action language, and green successful results.

**Distinguishing features:** bookmark/index card/dictionary tab for vocabulary; lightbulb labeled `TIP` for advice; no large infographic footer required.

### 10.7 Micro Diagram

**Purpose:** Illustrate a single visual metaphor inline, at the exact point in the lesson where the prose describes it, so the lesson page reads as text-and-picture together rather than text with an occasional poster dropped in.

**Examples:** a variable as a labeled box with an arrow pointing in and a value sitting inside; a function as a box with one arrow in and one arrow out; a loop as a circular arrow returning to its own start; a list as a row of connected boxes; a conditional as a fork in a path.

**Required content:** exactly one visual metaphor. Nothing else is required.

**Explicitly excluded, every time:** no title, no definition text, no code panel, no output/result panel, no key-takeaway footer, no template-type label in the corner. Any of these turns a Micro Diagram back into a small version of a Concept Breakdown, which defeats the point.

**Labels:** 0-2 short labels directly on the diagram, ideally single words (a variable name, "in," "out"). Full explanations belong in the surrounding lesson prose, never packed into the image. Keeping baked-in text minimal also sidesteps the AI-text-accuracy risk flagged in Section 7.3.

**Size:** a real illustration, not an icon. The full image file is roughly 700-760px wide so it spans a standard lesson content column (matching the `max-width: 760px` already used across FoxCS lesson pages) — but that width includes real padding around the metaphor itself, not just the shape stretched edge to edge. The visual metaphor should sit inside that canvas with generous margin on all sides, the same "generous white space" rule as the rest of this guide, so the composition breathes rather than filling the frame. Moderate height, landscape or square. Never a multi-panel layout.

**Composition:** one shape, or a small connected pair of shapes (a box and an arrow, two boxes and a connector). Generous white space around the metaphor itself. Same muted-background-plus-strong-accent color rule as every other family (Section 5.2).

**Color emphasis:** blue for the primary structural shape (the box, the container), green for a value or successful state sitting inside it, purple only if the diagram is explicitly framed as an analogy rather than a literal model. Avoid reaching for more than two colors in one Micro Diagram, most need only one.

**Distinguishing features:** no icon required (the metaphor itself is the whole image), no corner label, no border/card treatment that would make it compete visually with the lesson page's own `.concept-card` boxes it's sitting next to.

**Where it lives on the page:** embedded directly in the instructional HTML at the point in the prose it illustrates, the same way a code example already breaks up a paragraph. Not a separate "see the diagram below" reference, adjacent to the sentence that needs it.

---

## 11. Additional Image Types

The system may later support:

1. Spot the Error
2. Error Message Translation
3. Multiple Valid Solutions
4. Before and After
5. Code Anatomy Diagram
6. Flowchart or Decision Aid
7. Trace the Code
8. Worked Example
9. Pattern Recognition
10. Quick Reference
11. Common Errors Checklist
12. Prediction Prompt
13. Choose the Best Tool
14. Input–Process–Output Diagram
15. Data or Value Journey
16. Memory Model
17. Concept Connection Map
18. Increasing Complexity
19. Revision or Reassessment Guide
20. Small-Group Review Graphic
21. Challenge Prompt
22. Reflection Prompt
23. Submission Checklist
24. Tool or Interface Guide
25. Progress Path
26. Misconception Versus Reality
27. Correct Versus Incorrect
28. Do This, Not That
29. Mini Case Study
30. Annotated Output
31. Edge Case Illustration
32. Testing Matrix
33. Lesson Summary Poster

These should inherit the shared visual language while using compositions appropriate to their purpose.

---

## 12. Important Concept-Specific Visual Models

### 12.1 Slicing

Slicing should be explained using boundaries and segments, not only item numbers.

For:

```python
word[1:4]
```

Show that:

- The slice begins at the boundary immediately before index `1`.
- The slice ends at the boundary immediately before index `4`.
- The selected segment contains indices `1`, `2`, and `3`.
- Index `4` is the stopping boundary and is not included.

Preferred phrasing:

> A slice starts at the boundary before the start index and stops at the boundary before the end index.

This mental model should take priority over simply saying “the end index is excluded.”

### 12.2 Variables

Variables should be shown as a named location, a label connected to a value, and a value that may change while the name remains stable.

Avoid malformed containers or boxes with broken edges.

### 12.3 Functions

Functions should be shown as a named set of instructions, something defined first, something that runs when called, and potentially something that receives input and produces a result.

### 12.4 User Input

User input should communicate that the program reaches `input()`, the program pauses, the user types information, Python receives that information as a string, and conversion is needed before numerical operations.

---

## 13. Image Density Rules

### Micro Density (added 2026-08-18)

Use for Micro Diagrams only (Section 10.7) — inline visual metaphors embedded directly in lesson prose.

Guidelines:

- One visual metaphor, nothing else
- 0-2 short labels, single words where possible
- No title, no code, no takeaway, no corner label
- Generous padding inside the frame around the metaphor itself, not edge to edge

This is a stricter, smaller tier than Low Density below, not just the low end of the same scale. If a draft has a title, a definition sentence, or a footer, it has drifted into Low Density and should either become a real Concept Breakdown or be stripped back down.

### Low Density

Use for concept introductions, process diagrams, vocabulary cards, and tip cards.

Guidelines:

- One dominant idea
- No more than four major sections
- Large visual
- Short text
- Significant white space

### Medium Density

Use for comparisons, misconception repair, before-and-after diagrams, and worked examples.

Guidelines:

- Four to six sections
- One or two code examples
- One main visual model
- Limited secondary examples

### High Density

Use for debugging guides, error clinics, lesson summaries, and reference sheets.

Guidelines:

- Strong grouping
- Clear headings
- No repeated explanations
- Code must remain readable
- Content must work at normal screen size
- Avoid adding sections only to fill space

---

## 14. Accessibility Standards

Every image should:

- Use strong text contrast
- Remain understandable without color alone
- Pair color with labels, symbols, or icons
- Have a clear reading order
- Use readable text sizes
- Avoid unnecessary visual clutter
- Include alt text
- Have a text equivalent in the lesson
- Include selectable code outside the image
- Avoid placing essential instructions only inside the graphic

Images should support instruction, but they should not be the sole source of required information.

---

## 15. Accuracy and Quality Control

Before approving an image, verify the following.

### Technical accuracy

- Does the Python code run?
- Is the syntax exact?
- Is the output correct?
- Are variable names consistent?
- Are indexes correct?
- Are slicing boundaries correct?
- Are spaces and punctuation correct?
- Is the error type accurate?
- Is the explanation technically precise?
- Does the analogy avoid introducing a new misconception?

### Visual accuracy

- Are boxes and containers structurally complete?
- Are all object edges closed?
- Are arrows pointing to the correct location?
- Are labels attached to the correct element?
- Is the reading order clear?
- Are icons recognizable at the intended size?
- Is subtle shading applied consistently?
- Are any objects malformed or unnecessarily detailed?

### Semantic consistency

- Is red used only for errors, warnings, or misconceptions?
- Is green used for successful or correct outcomes?
- Is purple used for explanation or mental models?
- Is yellow used for tips, reminders, or examples?
- Is orange used for action, testing, or process?
- Is blue used for structure, syntax, or core concepts?
- Does the primary icon match the image type?

### Audience fit

- Does the image feel mature enough for high school students?
- Is it supportive without appearing juvenile?
- Does it avoid mascot-heavy styling?
- Is the language respectful?
- Is the image visually calm enough for sustained use?
- Does it look like part of the same course without copying another layout?

---

## 16. Production Prompt Base

Use the following as the shared starting point for future image generation:

```text
Create a clean, flat educational illustration for a high school introductory
Python course.

Use a white or lightly tinted background, crisp dark navy outlines, rounded
panels, minimal soft shading, generous spacing, and a modern vector-like
instructional style.

The image should feel supportive and approachable without appearing juvenile.
Do not use cartoon animals, a recurring mascot, decorative confetti, glossy 3D
effects, or unnecessary visual clutter.

Use colors semantically:

- Navy for major headings and visual anchors
- Blue for concepts, syntax, names, and structure
- Green for correct results, working code, and successful outcomes
- Purple for explanations, mental models, analogies, and reflection
- Yellow for tips, reminders, examples, and attention
- Orange for testing, active steps, and transitions
- Red only for errors, warnings, incorrect code, and misconceptions
- Grey for neutral structure and secondary information

Use muted semantic colors for large panels and reserve strong colors for small
labels, borders, arrows, icons, and important highlights.

Keep Python syntax exact. Use monospaced code. Separate code from output.
Ensure arrows and labels point to the correct elements.

Use an inconspicuous image-type label in the upper-right corner.

Choose a composition that matches the instructional purpose rather than
reusing a generic infographic layout.
```

---

## 17. Template-Specific Prompt Additions

### Concept Breakdown

```text
Use the Concept Breakdown template.

Create an open, lower-density composition with one dominant central visual.
Include a short definition, a visual mental model, one code example, the
result or output, and one key takeaway.

Use a puzzle piece, bracket, node, or concept-specific icon. Do not use the
debugging icon.
```

### Misconception Repair

```text
Use the Misconception Repair template.

Show the common misconception, why it feels reasonable, what actually happens,
the corrected mental model, visual or code evidence, and a corrected rule.

Use restrained red for the misconception and muted green for the repaired idea.
Use a wrench, repair arrow, refresh symbol, or correction icon.
```

### Debugging or Error Clinic

```text
Use the Debugging and Error Clinic template.

Use the standard debugging icon: a blue magnifying glass with a simplified red
bug inside the lens.

Give the code sample strong visual priority. Highlight the relevant line,
identify the error type, translate the issue into plain language, show the
corrected code, and provide a reusable debugging habit.

Use red for the error, purple for explanation, green for the fix, blue for the
debugging process, orange for testing, and yellow only for a short reminder.
```

### Comparison

```text
Use the Side-by-Side Comparison template.

Create two mirrored columns with the same comparison categories in the same
order. Use a central divider or subtle VS marker. Give both approaches equal
visual weight unless one is genuinely incorrect.

Include code and results for both sides and finish with guidance about when to
use each.
```

### Process or Sequence

```text
Use the Process or Sequence template.

Show three to six ordered stages connected by clear arrows. Use one action,
one visual, and one short explanation per stage. Reduce prose and emphasize
directional movement.

End with a final outcome card rather than a generic key-takeaway footer.
```

### Vocabulary Card

```text
Use the Vocabulary Card template.

Create a compact modular card containing the term, precise definition,
plain-language explanation, example sentence, code example, related term, and
common confusion where relevant.

Use a bookmark, dictionary tab, or index-card icon.
```

### Tip Card

```text
Use the Tip Card template.

Create a small reusable card with a muted yellow accent, an outlined lightbulb,
and the word TIP. Include one clear action, why it helps, and a brief code
example only when needed.
```

### Micro Diagram

```text
Use the Micro Diagram template.

Illustrate exactly one visual metaphor: nothing else. No title, no definition
text, no code panel, no output panel, no takeaway footer, no corner label.

Include at most two short labels directly on the diagram, single words where
possible (a variable name, "in," "out"). Do not attempt to explain the concept
inside the image, the surrounding lesson text does that.

The full image is roughly 700-760px wide with generous padding around the
metaphor itself, not the shape stretched edge to edge. Moderate height,
landscape or square, never a multi-panel layout.

Use no more than two colors: blue for the primary structural shape, green only
if showing a value or successful state inside it.
```

---

## 18. Metadata Schema

Each generated image should have a companion metadata record. Micro Diagrams (Section 10.7) use the same schema with a much shorter `required_sections` list (just `visual_metaphor`, nothing else) — don't force in fields like `misconception` or `worked_example` that don't apply.

```yaml
illustration_id: lesson_04_03_misconception_slicing_boundaries
lesson_id: lesson_04_03_slicing
template_family: misconception_repair
concept: slicing_boundaries
audience: high_school
orientation: landscape
density: medium

primary_icon: repair_arrow

semantic_colors:
  navy: headings_and_anchors
  blue: indices_and_structure
  green: correct_selection
  purple: mental_model
  yellow: tip
  red: misconception

required_sections:
  - misconception
  - why_it_is_confusing
  - correct_mental_model
  - visual_evidence
  - worked_example
  - corrected_rule

alt_text_required: true
text_equivalent_required: true
code_validation_required: true
teacher_review_required: true
```

---

## 19. File Naming Convention

Use:

```text
[lesson_id]_[template_type]_[concept]_[version].png
```

Examples:

```text
lesson_03_02_concept_user_input_v01.png
lesson_03_04_compare_concatenation_commas_v01.png
lesson_04_03_misconception_slicing_boundaries_v02.png
lesson_07_01_error_function_colon_v01.png
lesson_03_05_vocab_parameter_v01.png
lesson_05_02_debug_type_error_v01.png
```

Suggested template codes:

```text
concept
misconception
debug
error
compare
process
vocab
tip
anatomy
flow
trace
before_after
micro
```

Micro Diagram example: `lesson_02_01_micro_variable_box_v01.png`

---

## 20. Final Nonnegotiable Rules

- Images must feel appropriate for high school students.
- Use the clean flat style as the primary course illustration system.
- Use muted colors by default.
- Reserve saturated colors for small semantic accents.
- Colors must retain consistent meanings.
- Red must never be decorative.
- The lightbulb must be reserved for actual tips.
- The magnifying glass with a bug is the standard debugging icon.
- Do not use cartoon animals or recurring mascots.
- Do not use literal fox imagery as FoxCS branding.
- Do not create every resource from the same underlying page template.
- Let instructional purpose determine composition and density.
- A Micro Diagram (Section 10.7) must never gain a title, code panel, or takeaway footer. The moment it does, it has become a Concept Breakdown and should be built as one on purpose, not by drift.
- Keep code exact and readable.
- Provide all essential content outside the image as accessible text.
- Review every image for technical, visual, and instructional accuracy.

---

## 21. SVG Production Recipe for Micro Diagrams

**Added 2026-08-18.** Appended as a new section rather than inserted earlier, to avoid renumbering Sections 1-20 (several are already cross-referenced by number elsewhere in this repo). This section is the concrete, repeatable recipe for hand-coding a Micro Diagram (Section 10.7) as inline SVG — proven against two real examples (`02-authoring-system/illustration-examples-gallery.html`: Variable, Decomposition), not theoretical.

### 21.1 Why SVG, and only for this one tier

Micro Diagrams are simple by design: one visual metaphor, 0-2 short labels, no title, no code panel, no takeaway. That simplicity is exactly what makes hand-coded SVG the right production method for this tier specifically: it hits the guide's exact spec every time — exact hex colors, exact shapes, zero risk of AI-garbled label text. **This does not extend to the six full template families in Section 10.1-10.6.** Those are genuinely complex, multi-panel, code-heavy compositions where AI generation (Sections 16-17) remains the right tool. SVG is a Micro Diagram technique, not a replacement for the whole illustration system.

### 21.2 Canvas and coordinate conventions

- Default canvas: `viewBox="0 0 700 280"`. This matches the ~700-760px column-width guidance from Section 10.7 and gives enough height for a labeled box or a small branching structure without going tall/multi-panel. Adjust the height for a genuinely wider or narrower composition, but keep it one landscape or near-square frame.
- Leave real margin inside the frame before the first and after the last shape — nothing should start at `x="0"` or touch an edge. In practice: keep at least 15-20px of clear space around the outermost shapes on every side. This is what "generous padding" (Section 10.7's size rule) actually means in coordinates, not just a principle to remember.

### 21.3 Shape recipe — boxes and containers

```text
<rect rx="14-20" fill="#dce8f8" stroke="#3d73c7" stroke-width="2.5-3" />
```

- `rx`: 18-20 for a primary/larger box, 12-14 for a smaller secondary box, so the rounding stays proportional to size rather than looking identical on every shape.
- `fill`: always `#dce8f8` (blue-muted) for a structural container, per the semantic color system (Section 4.2) — blue means concept/structure.
- `stroke`: always `#3d73c7` (blue-standard). Thicker (3) for a primary shape, thinner (2.5) for smaller satellite shapes, so the eye still reads which one is "main."

### 21.4 Arrow recipe

- Shaft: `<line>`, `stroke="#1457d9"` (blue-strong), `stroke-width="3"`.
- Arrowhead: a small `<polygon>` triangle at the line's end, roughly 14px wide by 16px tall, pointed in the direction of travel. **Use an explicit polygon, not an SVG `<marker>` element** — markers are less predictable to hand-tune and less portable if this SVG is ever copy-pasted or exported elsewhere; a plain polygon is simple, visible in the raw markup, and easy to nudge.
- **Fan-out pattern** (one thing becoming several, e.g. Decomposition): branch from a single point partway along the main shaft into multiple arrows, rather than drawing several separate parallel arrows from the source shape. Reads as "one becomes many" much more clearly than parallel arrows do. See the Decomposition example for the exact coordinates.

### 21.5 Labels and values (text)

- `font-family`: always `Consolas, monospace`, even for a plain-English label — this visually signals "this came from real code or real data," consistent with how code renders everywhere else on FoxCS lesson pages.
- A **structural label** (a name attached to something, e.g. a variable name): `fill="#17365f"` (navy-standard), `font-weight="bold"`, `font-size` roughly 34-36.
- A **value sitting inside a container**: `fill="#138a3d"` (green-strong), `font-weight="bold"`, `font-size` roughly 40-44 — slightly larger than the label, since it's the "payload" and should read as the most important thing inside its own box.
- `text-anchor="middle"`, and hand-compute the `y` position against the actual box coordinates (box `y` + box `height / 2` + roughly 12-14 for baseline correction) — don't eyeball it, calculate it from the real rect coordinates so it's genuinely centered.
- **Stay at 0-2 labels total, full stop.** If a diagram seems to need a third word to make sense on its own, it has outgrown the Micro Diagram tier — either simplify the metaphor further, or it should be a real Concept Breakdown instead.

### 21.6 Wrapper and embedding pattern

```html
<svg class="micro-diagram" viewBox="0 0 700 280" role="img" aria-label="[a real one-sentence description of what the image actually shows]">
  ...
</svg>
```

```css
.micro-diagram { display: block; width: 100%; max-width: 620px; height: auto; margin: 1.4rem auto; }
```

- `role="img"` and a real, specific `aria-label` are required every time, not optional — this is the image's accessible text equivalent per Section 14. "A box labeled score with an arrow pointing into it, and the value 100 sitting inside" is a real label; "variable diagram" is not.
- The `.micro-diagram` CSS class is what makes the SVG scale responsively and sit centered with real vertical margin. Reuse this exact class/rule across lessons rather than redefining sizing per page.
- **No surrounding `<div class="concept-card">` or similar bordered wrapper.** Per Section 10.7, a Micro Diagram must not compete visually with the page's existing card system — it drops directly into the flow of a term card, paragraph, or list item.

### 21.7 QA checklist before calling one done

- Uses only the guide's real hex tokens (Section 5.1) — never an eyeballed or approximate color.
- Zero baked-in explanatory sentences; 0-2 short labels, maximum.
- No title, no takeaway, no corner label anywhere in the SVG.
- Real padding around every shape — nothing touches the frame edge.
- A real, specific `aria-label` — not a placeholder, not just the concept name.
- Actually rendered and checked in a browser at the real lesson column width (`max-width: 760px`), not just eyeballed in the source.

### 21.8 Where new examples go

- **Prove a new metaphor in `02-authoring-system/illustration-examples-gallery.html` first** if there's any real doubt about whether it reads clearly, using the same "prove the mechanic before deploying it" principle as `component-library/index.html` (see that file's own header comment for why — a fabricated placeholder that turned out broken once deployed is exactly the mistake this principle exists to prevent).
- **Deployed Micro Diagrams live inline in the lesson's own instructional HTML**, directly in the flow of the prose they illustrate (inside the relevant term card, paragraph, or section) — never as a separately linked-out image file a student has to click through to.
