# 2.5 Adaptive Practice -- Full Question Bank

Backfilled 2026-09-09, matching 2.2's standing target of 2-of-each-tier from the start. `_01` items are live in `../01_instruction.html` (transcribed here from the real deployed page, not guessed) and described below. `_02` items are drafted here, ready to wire in as a second bank item per tier for reteaching/retry, not yet in the live page.

Grounded in `../../../../course-plan.md`'s Unit 02 skill list for 02.5 Booleans and `../../../../../../02-authoring-system/content-authoring-standards.md`'s misconception-pairing rule.

---

## Skill 1: `identifies_boolean_type`

**Misconception targeted:** confusing a boolean with an integer that can act like one (`1`/`0`) or with a numeric/lowercase lookalike, not just a quoted string.

### Core (existing: `core_01`)
Fill-in-the-blank creating `game_paused = True`, checked against `Game Paused: True`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context (smart-home app).
**Prompt:** Fill in the blank so the program prints exactly:
```text
Light On: True
```
```python
____________________
print("Light On:", light_on)
```
**Expected fill:** `light_on = True`

### Reinforce (existing: `reinforce_01`)
MC: which of `True` / `"True"` / `1` / `true` is a boolean. Correct: `True`. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these four are booleans. Which one is not?
- A) `True`
- B) `False`
- C) `"False"`
- D) `True`
**Correct:** C
**Feedback if C:** "Right -- the quotation marks make this a string, not a real boolean, even though the word inside says False."
**Feedback if A/B/D:** "That one is a real boolean, capitalized and unquoted. Look again for the one wrapped in quotation marks."

### Extend (existing: `extend_01`)
Fill-in-the-blank printing `type(door_locked)` against `door_locked = False`, expected `<class 'bool'>`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A quiz app stores `passed = True`. Fill in the blank so the program prints exactly:
```text
<class 'bool'>
```
```python
passed = True
____________________
```
**Expected fill:** `print(type(passed))`

---

## Skill 2: `applies_boolean_casing`

**Misconception targeted:** assuming Python's booleans follow the same lowercase convention as most other keywords, or that any casing of true/false is interchangeable.

### Core (existing: `core_01`)
MC: which of `is_alive = True` / `is_alive = true` / `is_alive = TRUE` is valid Python. Correct: `True`. Live.

### Core (new: `core_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these are written correctly. Which one is not valid Python?
- A) `has_key = True`
- B) `has_key = False`
- C) `has_key = false`
- D) `has_key = True`
**Correct:** C
**Feedback if C:** "Right -- lowercase false is not a Python keyword. Python would treat it as an undefined variable name and crash."
**Feedback if A/B/D:** "That one is written correctly. Look again for the value that isn't capitalized the way Python requires."

### Reinforce (existing: `reinforce_01`)
MC: what actually happens when `sound_enabled = true` (lowercase) runs. Correct: crashes -- Python looks for a variable named `true`, which doesn't exist. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-error, new context.
**Prompt:** A line of code reads `door_open = FALSE` (all caps). What happens when this runs?
- A) It works fine -- Python treats FALSE as a boolean
- B) It crashes -- Python looks for a variable named FALSE, which doesn't exist
**Correct:** B
**Feedback if B:** "Right. Only the exact casing True/False is a real Python keyword -- ALL CAPS isn't recognized either, so Python reads FALSE as an undefined variable name."
**Feedback if A:** "Not quite. Python's boolean casing is exact -- ALL CAPS FALSE isn't a keyword any more than lowercase false is."

### Extend (existing: `extend_01`)
Fill-in-the-blank creating `sound_enabled = True`, checked against `Sound Enabled: True`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A settings menu needs a variable to track dark mode, currently on. Fill in the blank so the program prints exactly:
```text
Dark Mode: True
```
```python
____________________
print("Dark Mode:", dark_mode)
```
**Expected fill:** `dark_mode = True`

---

## Skill 3: `distinguishes_boolean_from_string`

**Misconception targeted:** treating a quoted `"True"`/`"False"` as functionally the same as the real boolean, the same quotes-override-appearance rule from Lesson 2.4 applied to booleans specifically.

### Core (existing: `core_01`)
`quest_complete = True` exists, fill-in-the-blank creating `print(type(quest_complete))`, checked against `<class 'bool'>`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** `is_raining = False` already exists. Fill in the blank so the program prints exactly:
```text
<class 'bool'>
```
```python
is_raining = False
____________________
```
**Expected fill:** `print(type(is_raining))`

### Reinforce (existing: `reinforce_01`)
MC: `"True"` is written with quotation marks -- what type is it. Correct: string. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-type, new context.
**Prompt:** A weather app reads `is_sunny = "False"` from a saved file. What type is `is_sunny`?
- A) Boolean, since it says False
- B) String, since it's inside quotation marks
**Correct:** B
**Feedback if B:** "Right. Quotation marks always win -- this is text that happens to say False, not the real boolean."
**Feedback if A:** "Not quite. What the word says doesn't matter -- the quotation marks make this a string, same rule as Lesson 2.4."

### Extend (existing: `extend_01`)
`status = "True"` exists, fill-in-the-blank creating `print(type(status))`, checked against `<class 'str'>`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A save file stores `unlocked = "True"` as text. Fill in the blank so the program prints exactly:
```text
<class 'str'>
```
```python
unlocked = "True"
____________________
```
**Expected fill:** `print(type(unlocked))`

---

## Skill 4: `interprets_true_false_as_program_state`

**Misconception targeted:** reading a boolean's value as a label rather than a live fact, or not connecting reassignment (from Lesson 2.1) to how a program tracks that something changed.

### Core (existing: `core_01`)
Fill-in-the-blank creating `assignment_submitted = False`, checked against `Assignment Submitted: False`. Live.

### Core (new: `core_02`)
**Format:** Build the Code, new context.
**Prompt:** Fill in the blank so the program prints exactly:
```text
Homework Done: False
```
```python
____________________
print("Homework Done:", homework_done)
```
**Expected fill:** `homework_done = False`

### Reinforce (existing: `reinforce_01`)
MC: `game_over` holds `False` -- what does that tell you about current state. Correct: the game has not ended. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Predict-the-meaning, new context.
**Prompt:** A variable `door_locked` holds `True` right now. What does that tell you?
- A) The door is currently locked
- B) The door is currently unlocked
**Correct:** A
**Feedback if A:** "Right. True means the fact the variable name describes is currently the case -- the door is locked."
**Feedback if B:** "Not quite. True means the state described by the variable name is currently happening, not the opposite of it."

### Extend (existing: `extend_01`)
`level_complete = False` exists (level just finished), fill-in-the-blank creating `level_complete = True`, checked against `Level Complete: True`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A library checkout app has `book_checked_out = False` already, and a student just checked the book out. Fill in the blank so the program prints exactly:
```text
Checked Out: True
```
```python
book_checked_out = False
____________________
print("Checked Out:", book_checked_out)
```
**Expected fill:** `book_checked_out = True`

---

## Skill 5: `selects_boolean_for_two_state_information`

**Misconception targeted:** defaulting to an integer (like `1`/`0`) or a string (`"yes"`/`"no"`) for information that actually has exactly two states and belongs in a boolean.

### Core (existing: `core_01`)
MC: which of (door locked / score / player name / exact game speed 1.5) should be a boolean. Correct: door locked. Live.

### Core (new: `core_02`)
**Format:** Categorization, new scenarios.
**Prompt:** Which of these should be stored as a boolean?
- A) whether the alarm is armed
- B) number of days until the deadline
- C) the assignment's title
- D) exact temperature reading (68.4)
**Correct:** A
**Feedback if A:** "Right. Armed/not-armed is exactly two states."
**Feedback if wrong:** "B needs an integer, C needs a string, and D needs a float. Only A has exactly two possible states."

### Reinforce (existing: `reinforce_01`)
MC: which of (coins collected / sound enabled / username) has exactly two states. Correct: sound enabled. Live.

### Reinforce (new: `reinforce_02`)
**Format:** Identify-the-odd-one-out.
**Prompt:** Three of these fit a boolean well. Which one does not?
- A) whether the notification is read
- B) whether Wi-Fi is connected
- C) the number of unread messages
- D) whether the app is in dark mode
**Correct:** C
**Feedback if C:** "Right -- a message count can be many different values, not just two, so it needs an integer instead."
**Feedback if A/B/D:** "That one has exactly two states and fits a boolean well. Look again for the one that could be many different values."

### Extend (existing: `extend_01`)
Fill-in-the-blank creating `is_alive = True`, checked against `Is Alive: True`. Live.

### Extend (new: `extend_02`)
**Format:** Build the Code, unfamiliar context.
**Prompt:** A group project tracker needs a variable for whether a task is complete, currently not done yet. Fill in the blank so the program prints exactly:
```text
Task Complete: False
```
```python
____________________
print("Task Complete:", task_complete)
```
**Expected fill:** `task_complete = False`
