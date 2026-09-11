# 2.3 Adaptive Practice -- Full Question Bank

Backfilled 2026-09-09, matching 2.2's standing target of 2-of-each-tier from the start. `_01` items are live in `../01_instruction.html` (transcribed here from the real deployed page, not guessed) and described below. `_02` items are drafted here, ready to wire in as a second bank item per tier for reteaching/retry, not yet in the live page.

Grounded in `../../../../course-plan.md`'s Unit 02 skill list for 02.3 Floats and `../../../../../../02-authoring-system/content-authoring-standards.md`'s misconception-pairing rule.

---

## Skill 1: `identifies_float_type`

**Misconception targeted:** confusing a float with an integer or a numeric-looking string, not just recognizing the decimal point in isolation.

### Core (existing: `core_01`)
Fill-in-the-blank creating `game_speed = 1.5`, checked against `Game Speed: 1.5`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context (weather app).
**Prompt:** Fill in the blank so the program prints exactly:
```text
Rainfall: 2.75
```
```python
____________________
print("Rainfall:", rainfall)
```
**Expected fill:** `rainfall = 2.75`

### Reinforce (existing: `reinforce_01`)
MC: which of `7` / `7.5` / `"7.5"` / `True` is a float. Correct: `7.5`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these four are floats. Which one is not?
- A) `3.14`
- B) `0.5`
- C) `9`
- D) `12.75`
**Correct:** C
**Feedback if C:** "Right -- 9 has no decimal point, so it's an integer, not a float."
**Feedback if A/B/D:** "That one is a float -- it has a decimal point. Look for the value with no decimal point at all."

### Extend (existing: `extend_01`)
Fill-in-the-blank printing `type(distance)` against `distance = 3.75`, expected `<class 'float'>`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A recipe app stores `cups_of_flour = 2.5`. Fill in the blank so the program prints exactly:
```text
<class 'float'>
```
```python
cups_of_flour = 2.5
____________________
```
**Expected fill:** `print(type(cups_of_flour))`

---

## Skill 2: `distinguishes_int_vs_float`

**Misconception targeted:** deciding type by the value (does it have a fractional part?) instead of by how the value is written (is there a decimal point?).

### Core (existing: `core_01`)
MC: which of `12` / `12.0` / `"12"` / `True` is a float, not an integer. Correct: `12.0`. Live.

### Core (new: `core_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these are integers. Which one is a float?
- A) `40`
- B) `40.0`
- C) `-40`
- D) `0`
**Correct:** B
**Feedback if B:** "Right -- the decimal point makes 40.0 a float, even though it's a whole number mathematically."
**Feedback if wrong:** "That one has no decimal point -- it's an integer. Look again for the value written with a decimal point."

### Reinforce (existing: `reinforce_01`)
MC: `12.0` equals `12` mathematically -- is `12.0` still a float in Python. Correct: yes. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-type, new context.
**Prompt:** A submarine's `depth = 100.0`. Is `depth` an integer or a float?
- A) Integer, since 100.0 has no fractional part
- B) Float, since it has a decimal point regardless of its value
**Correct:** B
**Feedback if B:** "Right. Python decides type from how a value is written, not what it equals -- the decimal point makes this a float."
**Feedback if A:** "Not quite. Whether a value happens to be a whole number doesn't change its type -- the decimal point does."

### Extend (existing: `extend_01`)
Fill-in-the-blank creating `average_score = 88.0`, checked against `Average Score: 88.0`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A checkout screen needs to store the number of items purchased as a whole number, but the total cost as a float even if it comes out even. Fill in the blank so the program prints exactly:
```text
Total: 20.0
```
```python
items = 4
____________________
print("Total:", total)
```
**Expected fill:** `total = 20.0`

---

## Skill 3: `recognizes_float_disguised_as_whole`

**Misconception targeted:** treating a "round" decimal value (`70.0`, `20.0`) as secretly an integer because it has no fractional part.

### Core (existing: `core_01`)
Fill-in-the-blank printing `type(height)` against `height = 6.0`, expected `<class 'float'>`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** `speed_limit = 55.0` already exists. Fill in the blank so the program prints exactly:
```text
<class 'float'>
```
```python
speed_limit = 55.0
____________________
```
**Expected fill:** `print(type(speed_limit))`

### Reinforce (existing: `reinforce_01`)
MC: a variable holds `20.0` -- is it best described as an integer or a float. Correct: float. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-value, new context.
**Prompt:** A vending machine's `price = 2.0` (exactly two dollars, no cents). What type is `price`?
- A) Integer, because the price happens to be a whole number
- B) Float, because it's written with a decimal point
**Correct:** B
**Feedback if B:** "Right. The decimal point is what decides the type, no matter how the value happens to round."
**Feedback if A:** "Not quite. A value having no fractional part doesn't make it an integer -- look at how it's actually written."

### Extend (existing: `extend_01`)
Fill-in-the-blank in a thermostat context, `target = 70.0` checked against `Target: 70.0`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A scoreboard app always stores every player's average as a float, even when it comes out even. `average = 15.0` already exists. Fill in the blank so the program prints exactly:
```text
<class 'float'>
```
```python
average = 15.0
____________________
```
**Expected fill:** `print(type(average))`

---

## Skill 4: `uses_float_for_decimal_quantity`

**Misconception targeted:** defaulting to an integer for any number-shaped value, even one that genuinely needs decimal precision.

### Core (existing: `core_01`)
Fill-in-the-blank creating `game_speed = 1.25`, checked against `Game Speed: 1.25`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** Fill in the blank so the program prints exactly:
```text
Battery Level: 72.5
```
```python
____________________
print("Battery Level:", battery_level)
```
**Expected fill:** `battery_level = 72.5`

### Reinforce (existing: `reinforce_01`)
MC: which of (lives / price $4.99 / player name / paused state) should be a float. Correct: price. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Categorization, new scenarios.
**Prompt:** Which of these should be stored as a float?
- A) number of quests completed
- B) exact race time in seconds (12.84)
- C) whether the boss is defeated
- D) the boss's name
**Correct:** B
**Feedback if B:** "Right. Race time needs decimal precision."
**Feedback if wrong:** "A needs an integer, C needs a boolean, and D needs a string. Only B needs decimal precision."

### Extend (existing: `extend_01`)
`price = 4.99` exists, fill in `tax = 0.35` so `price + tax` prints `Total: 5.34`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** `distance_ran = 3.1` already exists (miles). Fill in the blank so the program prints exactly:
```text
Total Distance: 5.6
```
```python
distance_ran = 3.1
____________________
print("Total Distance:", distance_ran + extra_distance)
```
**Expected fill:** `extra_distance = 2.5`

---

## Skill 5: `predicts_mixed_numeric_result`

**Misconception targeted:** assuming mixing an integer and a float either crashes (like mixing a string and an integer does) or silently drops the decimal.

### Core (existing: `core_01`)
`lives = 3` and `bonus = 0.5` exist, fill in `total = lives + bonus` against `Total: 3.5`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** `quests_done = 4` and `bonus_xp = 0.5` already exist. Fill in the blank so the program prints exactly:
```text
Score: 4.5
```
```python
quests_done = 4
bonus_xp = 0.5
____________________
print("Score:", score)
```
**Expected fill:** `score = quests_done + bonus_xp`

### Reinforce (existing: `reinforce_01`)
MC: what is the result of `5 + 2.0`. Correct: `7.0`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-output, new expression.
**Prompt:** What does `print(10 * 0.5)` actually print?
- A) 5
- B) 5.0
- C) It crashes
**Correct:** B
**Feedback if B:** "Right. Mixing an integer and a float in math always produces a float, even when the result happens to be a whole number."
**Feedback if A:** "That's the value, but not the type Python actually prints -- mixing int and float always keeps the decimal point."
**Feedback if C:** "This never crashes -- mixing an integer and a float in math is completely legal in Python."

### Extend (existing: `extend_01`)
`base = 10` exists, fill in `adjusted = base * 0.75` against `Adjusted: 7.5`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context, multi-step.
**Prompt:** A recipe scales servings. `servings = 4` already exists. Fill in the blank so the program prints exactly:
```text
Scaled Servings: 6.0
```
```python
servings = 4
____________________
print("Scaled Servings:", scaled)
```
**Expected fill:** `scaled = servings * 1.5`
