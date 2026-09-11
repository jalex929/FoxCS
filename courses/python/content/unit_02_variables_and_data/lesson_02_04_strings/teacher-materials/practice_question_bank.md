# 2.4 Adaptive Practice -- Full Question Bank

Backfilled 2026-09-09, matching 2.2's standing target of 2-of-each-tier from the start. `_01` items are live in `../01_instruction.html` (transcribed here from the real deployed page, not guessed) and described below. `_02` items are drafted here, ready to wire in as a second bank item per tier for reteaching/retry, not yet in the live page.

Grounded in `../../../../course-plan.md`'s Unit 02 skill list for 02.4 Strings and `../../../../../../02-authoring-system/content-authoring-standards.md`'s misconception-pairing rule.

---

## Skill 1: `identifies_string_type`

**Misconception targeted:** confusing an unquoted word (which Python would actually try to read as a variable name) with a real string, or confusing a string with an integer/boolean.

### Core (existing: `core_01`)
Fill-in-the-blank creating `player_name = "Rowan"`, checked against `Player Name: Rowan`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context (school announcement app).
**Prompt:** Fill in the blank so the program prints exactly:
```text
Today's Lunch: Pizza
```
```python
____________________
print("Today's Lunch:", lunch)
```
**Expected fill:** `lunch = "Pizza"`

### Reinforce (existing: `reinforce_01`)
MC: which of `Rowan` (no quotes) / `"Rowan"` / `5` / `True` is a string. Correct: `"Rowan"`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these four are strings. Which one is not?
- A) `"forest"`
- B) `"12"`
- C) `12`
- D) `"True"`
**Correct:** C
**Feedback if C:** "Right -- 12 with no quotation marks is an integer, not a string."
**Feedback if A/B/D:** "That one has quotation marks around it -- it's a string. Look again for the value with no quotes."

### Extend (existing: `extend_01`)
Fill-in-the-blank printing `type(greeting)` against `greeting = "Hello"`, expected `<class 'str'>`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A chat app stores `message = "brb"`. Fill in the blank so the program prints exactly:
```text
<class 'str'>
```
```python
message = "brb"
____________________
```
**Expected fill:** `print(type(message))`

---

## Skill 2: `recognizes_quotes_override_appearance`

**Misconception targeted:** assuming what's inside the quotes changes the type -- that a quoted number is somehow still numeric, or a quoted `True` is somehow still boolean.

### Core (existing: `core_01`)
Fill-in-the-blank creating `id_code = "100"` on purpose (text ID, not a number), checked against `ID Code: 100`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** A library app keeps a book's barcode as text, since it's never used in math and leading zeros matter. Fill in the blank so the program prints exactly:
```text
Barcode: 00452
```
```python
____________________
print("Barcode:", barcode)
```
**Expected fill:** `barcode = "00452"`

### Reinforce (existing: `reinforce_01`)
MC: `"True"` is written with quotation marks -- what type is it. Correct: string. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-type, new context.
**Prompt:** A survey app stores `answer = "7"` (a rating typed by a user). What type is `answer`?
- A) Integer, since it's made of a digit
- B) String, since it's inside quotation marks
**Correct:** B
**Feedback if B:** "Right. The quotation marks make it a string, no matter what's inside them."
**Feedback if A:** "Not quite. Python checks for quotation marks to decide type, not what the characters inside look like."

### Extend (existing: `extend_01`)
Fill-in-the-blank printing `type(quantity)` against `quantity = "42"`, expected `<class 'str'>`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A form stores `is_registered = "False"` as text on purpose, since it came from a text field. Fill in the blank so the program prints exactly:
```text
<class 'str'>
```
```python
is_registered = "False"
____________________
```
**Expected fill:** `print(type(is_registered))`

---

## Skill 3: `distinguishes_string_from_variable`

**Misconception targeted:** confusing a bare variable name with the literal quoted word, in either direction -- expecting `print(room)` to print the word "room," or expecting `print("room")` to look up the variable.

### Core (existing: `core_01`)
`location = "cave"` exists, fill-in-the-blank creating `print(location)`, checked against `cave`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** `team_name = "Falcons"` already exists. Fill in the blank so the program prints exactly:
```text
Falcons
```
```python
team_name = "Falcons"
____________________
```
**Expected fill:** `print(team_name)`

### Reinforce (existing: `reinforce_01`)
MC: `x = "score"` was created, what does `print(x)` print. Correct: `score`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-output, new context.
**Prompt:** `y = "level"` was created. What does `print(y)` actually print?
- A) y
- B) level
- C) "level"
**Correct:** B
**Feedback if B:** "Right. With no quotes around y, Python looks up the variable's stored value."
**Feedback if A:** "y is the variable name -- Python looks up what it's storing, not the letter y itself."
**Feedback if C:** "Quotation marks only appear if you literally print the quoted word \"level\" -- printing the variable y doesn't add any."

### Extend (existing: `extend_01`)
Same `location = "cave"`, fill-in-the-blank creating `print("location")` to print the literal word `location` instead of the stored value. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** `team_name = "Falcons"` already exists. Fill in the blank so the program prints the literal word **team_name**, not the variable's stored value:
```text
team_name
```
```python
team_name = "Falcons"
____________________
```
**Expected fill:** `print("team_name")`

---

## Skill 4: `recognizes_numeric_looking_string`

**Misconception targeted:** assuming a numeric-looking string behaves like a number in arithmetic (that `+` will add rather than join text).

### Core (existing: `core_01`)
Fill-in-the-blank creating `zip_code = "60601"` on purpose, checked against `Zip Code: 60601`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** A student ID card stores a code as text, since it's never used in math. Fill in the blank so the program prints exactly:
```text
Student ID: 00913
```
```python
____________________
print("Student ID:", student_id)
```
**Expected fill:** `student_id = "00913"`

### Reinforce (existing: `reinforce_01`)
MC: is `"100"` an integer or a string. Correct: string. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these are integers. Which one is a string?
- A) `-15`
- B) `300`
- C) `"300"`
- D) `0`
**Correct:** C
**Feedback if C:** "Right -- the quotation marks make this text, even though it looks numeric."
**Feedback if wrong:** "That one has no quotation marks -- it's an integer. Look again for the one wrapped in quotes."

### Extend (existing: `extend_01`)
`count = "5"` exists, fill in `print(count + count)` against `55` (string concatenation, not addition). Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A locker app stores `code = "12"` as text (a combination, not a number). Fill in the blank so the program prints exactly:
```text
1212
```
```python
code = "12"
____________________
```
**Expected fill:** `print(code + code)`

---

## Skill 5: `recognizes_boolean_looking_string`

**Misconception targeted:** treating a quoted `"True"`/`"False"` as functionally the same as the real boolean, rather than as plain text that happens to say those words.

### Core (existing: `core_01`)
Fill-in-the-blank creating `status = "True"` (a string, not the real boolean) on purpose, checked against `Status: True`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** A saved-game file stores every value as text, including this one. Fill in the blank so the program prints exactly:
```text
Sound On: False
```
```python
____________________
print("Sound On:", sound_on)
```
**Expected fill:** `sound_on = "False"`

### Reinforce (existing: `reinforce_01`)
MC: which of `"True"` / `True` is the real Python boolean, not a string that looks like one. Correct: `True`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-type, new context.
**Prompt:** A form's `submitted = "True"` came from a text field on a webpage. What type is `submitted`?
- A) Boolean, since it says True
- B) String, since it's inside quotation marks
**Correct:** B
**Feedback if B:** "Right. Quotation marks always win -- this is text that happens to say True, not the real boolean."
**Feedback if A:** "Not quite. What the word says doesn't matter -- the quotation marks make this a string."

### Extend (existing: `extend_01`)
Fill-in-the-blank printing `type(door_locked)` against `door_locked = "False"`, expected `<class 'str'>`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A quiz app stores `answered_correctly = "True"` as text, read from a saved file. Fill in the blank so the program prints exactly:
```text
<class 'str'>
```
```python
answered_correctly = "True"
____________________
```
**Expected fill:** `print(type(answered_correctly))`
