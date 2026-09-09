# 2.2 Adaptive Practice — Full Question Bank

Built 2026-09-08, at 2-of-each-tier from the start (Jay's standing target as of 2026-09-08 — 2.1 had to backfill this after going live 1-per-tier; this lesson doesn't repeat that gap). `_01` items are live in `../01_instruction.html`, described briefly below. `_02` items are drafted here, ready to wire in as a second bank item per tier for reteaching/retry, not yet in the live page.

Grounded in `../../../skills-map.md`'s "02.2 Integers" section (Adaptive Question Targets) and `../../../../../02-authoring-system/content-authoring-standards.md`'s misconception-pairing rule.

---

## Skill 1: `identifies_integer_type`

**Misconception targeted:** confusing an integer with a float (`7.0`) or a boolean (`True`), not just a quoted string.

### Core (existing: `core_01`)
Fill-in-the-blank creating `enemies_remaining = 8`, checked against `Enemies Remaining: 8`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context (inventory).
**Prompt:** Fill in the blank so the program prints exactly:
```text
Potions: 4
```
```python
____________________
print("Potions:", potions)
```
**Expected fill:** `potions = 4`

### Reinforce (existing: `reinforce_01`)
MC: which of `7` / `"7"` / `7.0` / `True` is an integer. Correct: `7`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these four are integers. Which one is not?
- A) `12`
- B) `-3`
- C) `12.0`
- D) `0`
**Correct:** C
**Feedback if C:** "Right — the decimal point makes 12.0 a float, even though it's a whole number mathematically."
**Feedback if A/B/D:** "That one is an integer. Look for the value with a decimal point."

### Extend (existing: `extend_01`)
Fill-in-the-blank printing `type(treasure)`, expected `<class 'int'>`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A weather app stores `days_of_rain = 5`. Fill in the blank so the program prints exactly:
```text
<class 'int'>
```
```python
days_of_rain = 5
____________________
```
**Expected fill:** `print(type(days_of_rain))`

---

## Skill 2: `distinguishes_integer_from_string`

**Misconception targeted:** assuming a numeric-looking string behaves like a number in arithmetic.

### Core (existing: `core_01`)
MC: which of `10` / `"10"` / `-10` / `1000` is a string. Correct: `"10"`. Live.

### Core (new: `core_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these are integers. Which one is a string?
- A) `-8`
- B) `200`
- C) `"200"`
- D) `0`
**Correct:** C
**Feedback if C:** "Right — the quotation marks make this text, even though it looks numeric."
**Feedback if wrong:** "That one has no quotation marks — it's an integer. Look again for the one wrapped in quotes."

### Reinforce (existing: `reinforce_01`)
MC predicting the `TypeError` from `points = "10"` then `print(points + 5)`. Correct: crashes. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-error, new context.
**Prompt:** `quantity = "3"` was created. What happens when the program runs `print(quantity * 2)`?
- A) It prints `6`
- B) It prints `"33"` (the text repeated twice)
- C) It crashes with a TypeError
**Correct:** B
**Feedback if B:** "Right, and this one's a genuine surprise: Python allows `string * integer` — it just repeats the string, it doesn't do math. `+` between a string and an int crashes, but `*` between them does something else entirely. Worth remembering that these don't behave the same way."
**Feedback if A:** "quantity is a string, so this isn't doing math — but it also doesn't crash. Think about what `*` does to text."
**Feedback if C:** "This specific combination doesn't crash — `*` between a string and an integer is actually legal Python. Try running it in your head again."

### Extend (existing: `extend_01`)
Fill-in-the-blank creating `player_id = "042"` on purpose (text ID, not a number). Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A store receipt should keep a product code as text, since it's never used in math and a leading zero matters. Fill in the blank so the program prints exactly:
```text
Product Code: 007
```
```python
____________________
print("Product Code:", product_code)
```
**Expected fill:** `product_code = "007"`

---

## Skill 3: `recognizes_negative_integer`

**Misconception targeted:** treating a negative sign as making a value "not a real number" or confusing it with subtraction.

### Core (existing: `core_01`)
Fill-in-the-blank creating `temperature = -12`, checked against `Temperature: -12`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** Fill in the blank so the program prints exactly:
```text
Elevation: -25
```
```python
____________________
print("Elevation:", elevation)
```
**Expected fill:** `elevation = -25`

### Reinforce (existing: `reinforce_01`)
MC: which of `-5` / `"-5"` / `-5.0` / `0` is a negative integer. Correct: `-5`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-value.
**Prompt:** A variable `x` holds `-5`. What is the value of `x` right now — is it greater than, less than, or equal to `0`?
- A) Greater than 0
- B) Less than 0
- C) Equal to 0
**Correct:** B
**Feedback if B:** "Right. Negative integers are always less than zero, no matter how small the number after the minus sign looks."
**Feedback if wrong:** "A minus sign in front of a number always means it's below zero. Reconsider."

### Extend (existing: `extend_01`)
Fill-in-the-blank subtracting past zero (`balance = balance - 150`), checked against `Balance: -50`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A submarine starts at sea level (`depth = 0`) and dives. Fill in the blank so the program prints exactly:
```text
Depth: -40
```
```python
depth = 0
____________________
print("Depth:", depth)
```
**Expected fill:** `depth = depth - 40`

---

## Skill 4: `uses_integer_for_countable_quantity`

**Misconception targeted:** defaulting to integer for any number-shaped value, even ones that need decimals or are really booleans/text.

### Core (existing: `core_01`)
Fill-in-the-blank creating `arrows_left = 6`, checked against `Arrows Left: 6`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** Fill in the blank so the program prints exactly:
```text
Students Present: 22
```
```python
____________________
print("Students Present:", students_present)
```
**Expected fill:** `students_present = 22`

### Reinforce (existing: `reinforce_01`)
MC: which of (lives remaining / player name / paused state / exact height 2.5m) should be an integer. Correct: lives remaining. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Categorization, new scenarios.
**Prompt:** Which of these should be stored as an integer?
- A) number of enemies defeated
- B) the player's favorite color
- C) whether the door is locked
- D) exact reaction time in seconds (0.34)
**Correct:** A
**Feedback if A:** "Right. Enemies defeated is a plain count."
**Feedback if wrong:** "B needs a string, C needs a boolean, and D needs a float (decimal). Only A is a plain count with no fractions."

### Extend (existing: `extend_01`)
Fill-in-the-blank creating a second integer (`gems = 15`) and combining with an existing one. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** `books_read = 12` already exists. Fill in the blank so the program prints exactly:
```text
Total books this year: 20
```
```python
books_read = 12
____________________
print("Total books this year:", books_read + books_this_summer)
```
**Expected fill:** `books_this_summer = 8`

---

## Skill 5: `predicts_basic_integer_arithmetic`

**Misconception targeted:** applying left-to-right evaluation instead of operator precedence (multiplication/division before addition/subtraction).

### Core (existing: `core_01`)
Fill-in-the-blank continuing a reassignment chain (`hp = hp + 2`), checked against `HP: 17`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** `coins = 10` already exists, and one line has already doubled it. Fill in the blank so the program prints exactly:
```text
Coins: 15
```
```python
coins = 10
coins = coins * 2
____________________
print("Coins:", coins)
```
**Expected fill:** `coins = coins - 5`

### Reinforce (existing: `reinforce_01`)
MC predicting `4 + 3 * 2`. Correct: `10`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-output, new expression.
**Prompt:** What does `print(20 - 2 * 5)` actually print?
- A) 90
- B) 10
- C) 18
**Correct:** B
**Feedback if B:** "Right. 2 * 5 happens first (10), then 20 - 10 = 10."
**Feedback if A:** "That's what you'd get by subtracting left to right first (20 - 2 = 18) and then multiplying by 5 — but multiplication happens before subtraction, not after."
**Feedback if C:** "That's 20 - 2, stopping before the multiplication ever happens. Multiplication has to happen first, on the whole 2 * 5 term."

### Extend (existing: `extend_01`)
Fill-in-the-blank continuing `score = score * 3` then subtracting, checked against `Score: 11`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context, multi-step.
**Prompt:** A thermostat starts at `68` degrees. Fill in the blank so the program prints exactly:
```text
Temperature: 74
```
```python
temperature = 68
temperature = temperature + 10
____________________
print("Temperature:", temperature)
```
**Expected fill:** `temperature = temperature - 4`
