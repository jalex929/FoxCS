# Licensing Boundaries

## The Rule

**GMetrix/Certiport content never flows into the `adaptive-python` commercial app. Ever, in any form.**

The GMetrix "Python v2" student workbook and support files (`FoxCS/Python_v2_Student_Workbook.pdf`, `FoxCS/Python v2 Support Files/`) are covered by an educational content license obtained so FoxCS students can prepare for an industry certification. That license does not extend to a commercial product. `adaptive-python` is a separate, commercially-intended app — content originating from GMetrix/Certiport material must not be adapted, paraphrased, restructured, or reused there, even in a "lightly rewritten" form.

## What This Means Practically

- Any FoxCS lesson content derived from or referencing GMetrix/Certiport material must be clearly traceable as such (see the `GMETRIX-` file-naming convention in `../02-authoring-system/vscode-content-conventions.md`).
- When adapting content in the *other* direction — `adaptive-python` → FoxCS, which is fine and already the plan for the non-GMetrix parts of the course (see `../courses/python/course-plan.md` Reuse Notes) — do not accidentally fold GMetrix-derived material back into anything that touches the `adaptive-python` repository. If a future session is asked to "port FoxCS content into the app" or similar, it must first check whether the content in question is GMetrix-derived and exclude it.
- This applies to code examples, exercise prompts, explanations, workbook text, and images — not just literal file copies.

## Why This Is Called Out Explicitly

Both `adaptive-python` and FoxCS: Python cover the same subject and the same general Python curriculum sequence, and content already flows from the former into the latter. That makes it easy for a future session (human or AI) to lose track of which direction is safe and which isn't, especially once GMetrix-derived lessons are interleaved with regular course content in the same `content/` folder. This file exists so that check doesn't depend on memory.
