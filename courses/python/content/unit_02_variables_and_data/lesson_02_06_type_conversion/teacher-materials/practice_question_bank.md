# 2.6 Adaptive Practice — Full Question Bank

Built 2026-09-10, at 2-of-each-tier from the start (Jay's standing 2026-09-08 target, same as 2.2-2.5). `p1`-`p6` are live in `../01_instruction.html`, described briefly below. New items are drafted here, ready to wire in, not yet in the live page.

Grounded in `../../../skills-map.md`'s "02.6 Type Conversion" section (Skills + Adaptive Question Targets) and `../../../../../02-authoring-system/content-authoring-standards.md`'s misconception-pairing rule.

**Real gap this bank closes:** the live Instruction page has 6 Practice items covering 6 of this lesson's 8 skills. `uses_type_function` and `converts_to_float` have no dedicated live item -- both are demonstrated in the Learn section / Troubleshooting Routine but never practiced on their own. Each gets its first drafted item below (not a `_02` backfill of an existing `_01`, since neither skill has one yet).

---

## Skill 1: `uses_type_function`

**Misconception targeted:** knowing `type()` exists but not actually reaching for it as the first troubleshooting move -- guessing a value's type by eye instead of checking.

### Core (new: `core_01`)
**Format:** Predict-the-output.
**Prompt:** What does `print(type(3.0))` print?
- A) `<class 'int'>`
- B) `<class 'float'>`
- C) `<class 'str'>`
**Correct:** B
**Feedback if B:** "Right -- the decimal point makes this a float, and `type()` reports it exactly."
**Feedback if wrong:** "Look at the value itself, not what it's used for -- `3.0` has a decimal point, which is what `type()` is reporting on."

---

## Skill 2: `interprets_type_output`

**Misconception targeted:** reading `<class 'int'>` as if the word "class" means something is wrong, or missing that the type name is the part inside the quotes.

### Core (existing: `p1`)
MC: Python shows `<class 'float'>` -- what type is this describing? Correct: a decimal number. Live.

### Core (new: `core_02`)
**Format:** Predict-the-output, new context.
**Prompt:** A program runs `print(type(grade))` and it prints `<class 'str'>`. What does that tell you about `grade`?
- A) It's a whole number
- B) It's a decimal number
- C) It's text, even if it looks like a number
**Correct:** C
**Feedback if C:** "Right -- `str` means text. Whatever `grade` looks like on screen, Python is treating it as a string, not a number."
**Feedback if wrong:** "`str` is the type name inside the quotes -- that always means text, regardless of what the value looks like."

---

## Skill 3: `converts_to_string`

**Misconception targeted:** believing `+` can join any two values into one printed line, instead of recognizing `+` between a string and a non-string as the actual crash.

### Core (existing: `p5`)
Debug: fix a `TypeError: can only concatenate str (not "int") to str` by adding `str()` around the numeric value. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** `age = 12` already exists. Fill in the blank so the program prints exactly:
```text
Age: 12
```
without crashing.
```python
age = 12
____________________
```
**Expected fill:** `print("Age: " + str(age))`

---

## Skill 4: `converts_to_integer`

**Misconception targeted:** assuming a value from `input()` is already numeric because the student typed digits.

### Core (existing: `p6`, open-ended)
Explains why `age = "16"` (from `input()`) needs conversion before `age >= 13` will work correctly. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** `tickets = input("How many tickets?")` already exists and the program needs to add `2` more to whatever the player typed. Fill in the blank so the math works instead of crashing or repeating text.
```python
tickets = input("How many tickets?")
____________________
print("Total tickets:", tickets)
```
**Expected fill:** `tickets = int(tickets) + 2`

---

## Skill 5: `converts_to_float`

**Misconception targeted:** reaching for `int()` on any numeric-looking string, even when the value needs to keep a decimal.

### Core (new: `core_01`)
**Format:** Build the Code, new context.
**Prompt:** `price = "4.50"` was read from a form. Fill in the blank so the program prints exactly:
```text
Price with tax: 4.86
```
```python
price = "4.50"
____________________
print("Price with tax:", round(price * 1.08, 2))
```
**Expected fill:** `price = float(price)`
**Feedback if student uses `int(price)` instead:** flag this as the common wrong answer for grading -- `int("4.50")` actually raises a `ValueError` (a decimal string can't convert straight to `int`), which is itself worth calling out as a `predicts_invalid_conversion` connection.

---

## Skill 6: `predicts_valid_conversion`

**Misconception targeted:** assuming any string that "looks like a number to a person" will convert successfully, without checking that it's actually all digits (and at most one decimal point).

### Core (existing: `p3`)
MC: will `int("7")` succeed or fail? Correct: succeed. Live.

### Core (new: `core_02`)
**Format:** Predict-the-outcome, new value.
**Prompt:** Will `float("3.5")` succeed or fail?
- A) Succeed -- it's digits with one decimal point
- B) Fail -- `float()` only works on whole numbers
**Correct:** A
**Feedback if A:** "Right -- `float()` accepts a decimal point as long as there's at most one and everything else is digits."
**Feedback if B:** "That's backwards -- `float()` is specifically for values with a decimal point. This one converts cleanly."

---

## Skill 7: `predicts_invalid_conversion`

**Misconception targeted:** assuming a conversion either always works or the program will crash loudly and obviously, rather than recognizing exactly which characters break it.

### Core (existing: `p4`)
MC: will `int("seven")` succeed or fail? Correct: fail. Live.

### Core (new: `core_02`)
**Format:** Predict-the-outcome, new value.
**Prompt:** Will `int("12.0")` succeed or fail?
- A) Succeed -- it's still digits
- B) Fail -- `int()` can't parse a decimal point in text
**Correct:** B
**Feedback if B:** "Right, and this one's a real gotcha: `int(12.0)` (an actual float value) works fine, but `int(\"12.0\")` (the same thing as text) raises a ValueError -- `int()` can't parse a decimal point out of a string. `float(\"12.0\")` then `int(...)` that result would work instead."
**Feedback if A:** "Try it in your head character by character -- `int()` parsing a string requires every character to be a plain digit. The `.` breaks that."

---

## Skill 8: `selects_conversion_for_context`

**Misconception targeted:** picking a conversion function by habit (defaulting to whichever was used most recently) instead of by what the value needs to do next.

### Core (existing: `p2`)
MC: which function converts player input so it can be used in math? Correct: `int()`. Live.

### Core (new: `core_02`)
**Format:** Categorization, new scenario.
**Prompt:** A program has `score = 40` (a real integer) and needs to print it inside a sentence using `+` concatenation. Which conversion is needed?
- A) `int(score)` -- it's already an int
- B) `str(score)` -- turn it into text so `+` can join it with other text
- C) `float(score)` -- add a decimal point
**Correct:** B
**Feedback if B:** "Right -- `score` doesn't need to change value, just type, so it can join with text via `+`. `str()` is the one that goes int-to-text."
**Feedback if wrong:** "`score` is already the number it needs to be -- the only problem is `+` can't join a number directly to text. That calls for `str()`, not another numeric conversion."
