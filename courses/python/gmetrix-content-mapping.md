# UNIT 16: File Input & Output — Skills Review

## Unit Scope

Unit 16 includes:

- 16.1 Why Files Matter
- 16.2 Reading Files
- 16.3 Writing Files
- 16.4 Appending Files
- 16.5 Context Managers
- 16.6 Processing Text Files

Project:

- Journal Application

The main conceptual progression is:

```text
program data exists temporarily
↓
save data outside the running program
↓
read saved data
↓
write new data
↓
add to existing data
↓
manage files safely
↓
process stored text
```

This unit introduces persistence.

Until now, most program state has disappeared when the program ends.

Files allow programs to remember information between runs.

---

# 16.1 Why Files Matter

## Primary Assessed Skills

- **explains_file_persistence** — Explains why files allow information to remain available after a program stops.
- **distinguishes_memory_and_file_storage** — Distinguishes temporary program variables from persistent file data.
- **identifies_file_use_case** — Recognizes when a program should store information in a file.
- **distinguishes_read_write_append_goals** — Identifies whether a task requires reading, replacing, or adding data.
- **recognizes_file_path_role** — Understands that a program needs a location/name to access a file.
- **selects_file_operation_for_goal** — Chooses an appropriate general file operation from a stated need.

## Core Mental Model

Variables are like information written on a temporary whiteboard:

```text
program starts
↓
variables exist
↓
program ends
↓
variable state disappears
```

A file is more like information saved in a notebook:

```text
program writes information
↓
program ends
↓
file remains
↓
future program run can read it
```

## Game Connection

Files can store:

- player names,
- saved progress,
- high scores,
- settings,
- inventory,
- logs,
- game history.

A save system is fundamentally a persistence system.

## Core File Operations

Students should conceptually distinguish:

```text
READ
→ get existing information

WRITE
→ create or replace information

APPEND
→ add information to the end
```

## Adaptive Question Targets

Write question families that ask students to:

- distinguish persistent and temporary information,
- choose read/write/append for a scenario,
- identify why a program may need a file,
- identify what could be stored in a save file,
- distinguish replacing data from adding data.

---

# 16.2 Reading Files

## Primary Assessed Skills

- **opens_file_for_reading** — Opens a file in read mode.
- **uses_read_method** — Reads file content using `.read()`.
- **stores_file_content** — Stores retrieved file content in a variable.
- **predicts_file_read_result** — Predicts what information is retrieved.
- **distinguishes_file_object_and_contents** — Distinguishes the opened file object from the text stored inside the file.
- **closes_open_file** — Closes a manually opened file when appropriate.
- **debugs_basic_read_failure** — Diagnoses straightforward problems in file-reading code.

## Core Example

```python
file = open("message.txt", "r")

message = file.read()

print(message)

file.close()
```

## Conceptual Flow

```text
file on computer
↓
open connection
↓
read contents
↓
store contents
↓
use contents in program
↓
close connection
```

## Important Distinction

This:

```python
file = open("message.txt", "r")
```

does not mean:

> `file` contains the text itself.

It represents the opened file object.

This:

```python
message = file.read()
```

retrieves the contents.

## Common Misconceptions

Students may:

- forget quotation marks around the filename,
- confuse the file object with file contents,
- expect `open()` to automatically print the file,
- use the wrong mode,
- forget `.read()`,
- attempt to work with a file that is not where the program expects it.

## Adaptive Question Targets

Write question families that ask students to:

- identify read mode,
- sequence opening and reading,
- identify which variable stores content,
- predict printed output,
- identify a missing `.read()`,
- repair straightforward file-reading code.

---

# 16.3 Writing Files

## Primary Assessed Skills

- **opens_file_for_writing** — Opens a file using write mode.
- **uses_write_method** — Writes text to a file.
- **recognizes_write_can_replace_content** — Understands that writing to an existing file can overwrite prior contents.
- **creates_file_with_write_mode** — Recognizes that write mode can create a file when appropriate.
- **writes_newline_character** — Uses `\n` when stored output needs a new line.
- **writes_string_data_to_file** — Supplies appropriate text data to `.write()`.
- **verifies_written_file_content** — Checks whether the expected information was saved.

## Core Example

```python
file = open("score.txt", "w")

file.write("100")

file.close()
```

## Critical Warning

Students should understand:

```text
"w"
```

is not:

> add more information.

It may replace what was already stored.

That distinction becomes essential before 16.4.

## Newline Example

```python
file.write("Alex\n")
file.write("Jordan\n")
```

creates separate lines.

## Important Type Connection

`.write()` expects string data.

Students may need:

```python
file.write(str(score))
```

rather than:

```python
file.write(score)
```

This meaningfully retrieves Unit 02 type-conversion skills.

## Adaptive Question Targets

Write question families that ask students to:

- identify write mode,
- predict whether existing content is replaced,
- add newline characters,
- identify a type problem,
- sequence opening/writing/closing,
- repair write code,
- determine what a resulting file contains.

---

# 16.4 Appending Files

## Primary Assessed Skills

- **opens_file_for_appending** — Opens a file in append mode.
- **uses_append_file_pattern** — Adds new text without replacing existing content.
- **distinguishes_append_and_write** — Chooses correctly between `a` and `w`.
- **predicts_appended_file_content** — Predicts resulting content after appending.
- **uses_newline_when_appending** — Formats appended records appropriately.
- **selects_append_for_history_data** — Recognizes when accumulating information is appropriate.

## Core Example

Existing file:

```text
Alex
Jordan
```

Code:

```python
file = open("players.txt", "a")

file.write("Maya\n")

file.close()
```

Result:

```text
Alex
Jordan
Maya
```

## Core Distinction

```text
WRITE
→ replace/create content

APPEND
→ keep old content and add more
```

## Strong Use Cases

Append is appropriate for:

- journals,
- activity logs,
- score history,
- event logs,
- game session history.

## Adaptive Question Targets

Write question families that ask students to:

- select append vs write,
- predict resulting file contents,
- identify an incorrect mode,
- add properly separated entries,
- choose append for a persistent-history scenario.

---

# 16.5 Context Managers

## Primary Assessed Skills

- **uses_with_statement_for_file** — Opens a file using a `with` statement.
- **recognizes_automatic_file_closing** — Understands that the context manager handles closing automatically.
- **identifies_context_manager_scope** — Identifies which statements operate while the file is open.
- **rewrites_manual_file_pattern_with_with** — Converts open/use/close code to a context-manager structure.
- **selects_context_manager_for_safe_file_use** — Recognizes `with` as the preferred beginner pattern for routine file access.
- **traces_with_statement_execution** — Predicts what happens inside and after the block.

## Core Example

```python
with open("message.txt", "r") as file:
    message = file.read()

print(message)
```

## Mental Model

Think:

> Use this file while I am inside this block.

When execution leaves the block:

```text
file is automatically closed
```

## Before and After

### Manual

```python
file = open("message.txt", "r")
message = file.read()
file.close()
```

### Context Manager

```python
with open("message.txt", "r") as file:
    message = file.read()
```

## Important Misconception

Students may think:

```python
as file
```

means the file's text is immediately stored in `file`.

It does not.

`file` is still the file object.

The program still needs:

```python
file.read()
```

to retrieve content.

---

# 16.6 Processing Text Files

## Primary Assessed Skills

- **processes_file_text** — Uses file contents as program data.
- **iterates_through_file_lines** — Processes text one line at a time when appropriate.
- **removes_unwanted_line_breaks** — Handles newline characters when processing stored text.
- **splits_file_content** — Breaks stored text into useful components when appropriate.
- **combines_file_io_with_prior_skills** — Uses loops, conditionals, lists, or functions with file data.
- **extracts_information_from_text_file** — Retrieves useful information from stored text.
- **transforms_file_data** — Converts stored text into a useful representation.
- **selects_processing_strategy** — Chooses an appropriate approach for a file-processing task.

## Example

File:

```text
Alex
Maya
Jordan
```

Possible program:

```python
with open("players.txt", "r") as file:
    for line in file:
        print(line.strip())
```

## Integration

This lesson should deliberately retrieve:

```text
strings
+
loops
+
lists
+
conditionals
+
functions
+
files
```

Students are no longer learning these concepts independently.

They are composing them.

---

# Certification Supporting Content: File Existence and Deletion

The certification sequence also includes:

- checking whether a file exists,
- deleting a file.

These do not need new full FoxCS lessons, but students should receive explicit exposure during Unit 16.

## Supporting Skills

- **recognizes_file_existence_check** — Understands why a program may verify that a file exists before using it.
- **selects_file_existence_check_for_safety** — Recognizes appropriate situations for checking before access.
- **recognizes_file_deletion_operation** — Understands that programs can remove files.
- **recognizes_file_deletion_risk** — Understands that deletion is destructive and should be used deliberately.

## Course Boundary

Do not turn this into the full operating-system module lesson.

Unit 18 owns:

- `os`,
- `os.path`,
- system-level path operations.

Unit 16 owns the file-I/O concept:

> What should a program do with persistent data?

---

# Unit 16 Recommended Skill Categories

The major mastery categories are:

1. persistence,
2. reading,
3. writing,
4. appending,
5. file modes,
6. context managers,
7. text-file processing,
8. combining files with prior programming structures.

---

# Unit 16 Project: Journal Application

## Project Goal

Students create a program that stores written journal entries persistently.

This deliberately connects the programming project to the journal-writing habit students have used throughout the course.

## Likely Required Skill Areas

Students should:

- accept a journal entry,
- save the entry to a file,
- preserve earlier entries,
- read stored entries,
- use a context manager,
- format stored entries clearly,
- use appropriate file modes,
- handle newlines correctly,
- organize code with functions where appropriate.

## Possible Features

Core:

```text
Write entry
View entries
Exit
```

## Project Assessment

Assess:

1. correct file mode selection,
2. persistence between runs,
3. readable stored data,
4. correct use of context managers,
5. successful reading,
6. successful appending,
7. integration of prior programming skills.

## Stretch Opportunities

Students may add:

- timestamps later after Unit 17,
- entry titles,
- search,
- multiple journal files,
- categories,
- deletion with confirmation,
- summary statistics.

Do not require Unit 17 datetime functionality in the core project before it is taught.

---

# UNIT 17: Dates, Times, and Calendars — Skills Review

## Unit Scope

Unit 17 includes:

- 17.1 What Is Datetime?
- 17.2 Current Date and Time
- 17.3 Timedelta
- 17.4 Date Calculations
- 17.5 `strftime`
- 17.6 Practical Date Programs

Project:

- Event Countdown

The main conceptual progression is:

```text
represent time
↓
get current time
↓
represent a duration
↓
calculate between dates
↓
format time for humans
↓
build useful time-based behavior
```

Certification coverage particularly includes:

- `now`
- `strftime`
- `weekday`

FoxCS extends this into broader practical date calculations.

---

# 17.1 What Is Datetime?

## Primary Assessed Skills

- **recognizes_datetime_module** — Recognizes Python's datetime tools as support for dates and times.
- **distinguishes_date_time_and_duration** — Distinguishes a moment/date from an amount of elapsed time.
- **identifies_datetime_use_case** — Recognizes when a program needs date/time information.
- **imports_datetime_tools** — Imports the required datetime functionality.
- **reads_datetime_value** — Interprets the major components of a datetime value.

## Conceptual Model

A datetime represents:

> a particular point on a calendar and clock.

Examples:

```text
September 5, 2026
3:30 PM
September 5, 2026 at 3:30 PM
```

A duration is different:

```text
three days
two hours
45 seconds
```

That distinction becomes important in 17.3.

## Game Connection

Datetime tools can support:

- cooldowns,
- daily rewards,
- event start/end dates,
- session logs,
- countdowns,
- scheduled content.

---

# 17.2 Current Date and Time

## Primary Assessed Skills

- **gets_current_datetime** — Retrieves the current date/time.
- **stores_current_datetime** — Stores the returned value for later use.
- **accesses_datetime_component** — Reads useful components when appropriate.
- **uses_weekday_value** — Retrieves or interprets weekday information.
- **predicts_dynamic_time_behavior** — Recognizes that current-time code produces different values at different moments.
- **distinguishes_fixed_and_current_datetime** — Distinguishes hard-coded dates from dynamically retrieved current time.

## Core Example

```python
from datetime import datetime

now = datetime.now()

print(now)
```

## Conceptual Shift

Students should understand:

> The exact result depends on when the program runs.

The code is predictable.

The returned data changes.

---

# Certification Supporting Skill: `weekday()`

## Primary / Supporting Skills

- **uses_weekday_method** — Retrieves weekday information from a date.
- **interprets_weekday_number** — Interprets the returned weekday number using the relevant Python convention.
- **connects_weekday_to_date** — Uses weekday information in a practical program.

This can live inside 17.2 or 17.6 rather than requiring another lesson.

---

# 17.3 Timedelta

## Primary Assessed Skills

- **creates_timedelta** — Creates a duration using `timedelta`.
- **recognizes_timedelta_as_duration** — Understands that a timedelta represents elapsed time rather than a specific calendar moment.
- **uses_timedelta_days** — Represents a straightforward number of days.
- **uses_timedelta_hours_minutes** — Represents smaller time intervals when appropriate.
- **adds_timedelta_to_datetime** — Calculates a later datetime.
- **subtracts_timedelta_from_datetime** — Calculates an earlier datetime.
- **distinguishes_datetime_and_timedelta** — Chooses correctly between point-in-time and duration values.

## Core Distinction

```text
datetime
→ when?

timedelta
→ how long?
```

## Example

```python
from datetime import datetime, timedelta

today = datetime.now()

next_week = today + timedelta(days=7)
```

---

# 17.4 Date Calculations

## Primary Assessed Skills

- **subtracts_datetimes** — Calculates the duration between two datetime values.
- **calculates_future_date** — Determines a future date using a duration.
- **calculates_past_date** — Determines a previous date using a duration.
- **interprets_date_difference** — Interprets the resulting time difference.
- **selects_date_calculation** — Chooses an appropriate arithmetic operation for a time problem.
- **uses_date_calculation_in_condition** — Uses calculated time information in program logic.
- **debugs_date_calculation** — Repairs straightforward date-calculation mistakes.

## Core Patterns

```text
datetime + timedelta
→ future datetime
```

```text
datetime - timedelta
→ earlier datetime
```

```text
datetime - datetime
→ duration
```

Students should distinguish all three.

## Applied Examples

- days until an event,
- days since an event,
- unlock date,
- account age,
- time remaining,
- next scheduled reward.

---

# 17.5 `strftime`

## Primary Assessed Skills

- **uses_strftime** — Formats a datetime as text.
- **recognizes_format_code_role** — Understands that formatting codes determine displayed components.
- **formats_date_for_user** — Produces a clear human-readable date.
- **formats_time_for_user** — Produces readable time output.
- **distinguishes_datetime_and_formatted_string** — Recognizes that `strftime()` produces text.
- **selects_format_from_reference** — Uses a reference to choose appropriate formatting codes.

## Conceptual Model

A datetime contains data.

`strftime()` controls:

> how that data is shown to a person.

## Example

```python
formatted = now.strftime("%m-%d-%Y")
```

Students do not need to memorize every format code.

An important skill is:

> use a formatting reference accurately.

## UX Connection

These may represent the same underlying date:

```text
09-05-2026
September 5, 2026
Sat, Sep 5
```

Formatting is partly a usability decision.

---

# 17.6 Practical Date Programs

## Primary Assessed Skills

- **combines_datetime_tools** — Uses multiple datetime concepts in one program.
- **builds_countdown_logic** — Calculates time remaining until an event.
- **builds_elapsed_time_logic** — Calculates time since an event.
- **formats_calculated_date_output** — Makes calculated dates readable.
- **uses_date_logic_in_program** — Uses date/time values to affect program behavior.
- **selects_datetime_tool_for_problem** — Chooses `datetime`, `timedelta`, `weekday`, or `strftime` appropriately.
- **explains_time_based_program_flow** — Explains how time information affects the program.

## Synthesis

Students should increasingly see:

```text
datetime.now()
+
timedelta
+
date arithmetic
+
strftime()
+
conditionals
```

as parts of one system rather than unrelated functions.

---

# Unit 17 Recommended Skill Categories

The major mastery categories are:

1. datetime representation,
2. current date/time,
3. date vs duration,
4. timedelta,
5. date arithmetic,
6. weekday information,
7. output formatting,
8. practical time-based programs.

---

# Unit 17 Project: Event Countdown

## Project Goal

Students build a program that calculates and displays time remaining until a meaningful future event.

## Likely Required Skill Areas

Students should:

- represent a target date,
- retrieve the current date/time,
- calculate a difference,
- interpret the resulting duration,
- format output clearly,
- use at least one conditional based on the countdown,
- organize code cleanly.

## Example Output

```text
Event: Game Launch
Date: October 15, 2026
Days Remaining: 40
```

## Possible Conditional Feedback

```text
more than 30 days
→ "Still some time to go."

7–30 days
→ "Getting close!"

0–6 days
→ "Almost here!"
```

## Stretch Opportunities

Students may:

- allow user-entered dates,
- display hours/minutes,
- support multiple events,
- determine weekdays,
- add countdown information to the Unit 16 Journal Application,
- create recurring-event logic.

---

# UNIT 18: Working with the Computer — Skills Review

## Unit Scope

Unit 18 includes:

- 18.1 Introduction to `os`
- 18.2 `getcwd`
- 18.3 `listdir`
- 18.4 `exists`
- 18.5 Introduction to `sys`
- 18.6 Command-Line Arguments

Project:

- File Finder

Certification coverage also includes:

- `io`
- `os.path`
- broader `sys` behavior,
- the remaining Domain 3 command-line content.

The main conceptual progression is:

```text
Python program
↓
interact with operating system
↓
identify current location
↓
inspect files/folders
↓
construct and verify paths
↓
receive information from command line
```

This unit should feel like:

> Python can interact with the environment around the program.

Unit 18 is also the final unit containing new LearnKey workbook/video certification content.

---

# Certification Supporting Concept: `io`

The certification sequence includes the `io` module.

FoxCS does not currently give it a dedicated lesson.

It should receive explicit exposure during the Unit 18 module overview.

## Supporting Skills

- **recognizes_io_module** — Recognizes `io` as a standard-library module related to input/output streams.
- **distinguishes_memory_stream_and_physical_file** — Recognizes that some streams can operate in memory rather than on a physical file.
- **recognizes_stringio_purpose** — Recognizes `StringIO` as an in-memory text stream at certification depth.
- **uses_module_reference** — Uses reference material to interpret unfamiliar module functionality.

Do not turn `io` into a major independent FoxCS programming sequence.

---

# 18.1 Introduction to `os`

## Primary Assessed Skills

- **imports_os_module** — Imports `os`.
- **recognizes_os_module_purpose** — Recognizes that `os` provides operating-system-related tools.
- **calls_os_function** — Calls a straightforward function from the module.
- **identifies_os_use_case** — Recognizes when a program needs information about files, folders, or the operating environment.
- **distinguishes_file_content_and_file_system** — Distinguishes working with data inside files from working with the file system itself.
- **uses_os_reference** — Uses documentation/reference material for an unfamiliar `os` function.

## Important Unit Boundary

Unit 16 asked:

> What information is stored in the file?

Unit 18 asks:

> Where is the file, does it exist, and what files/folders are around it?

That distinction should be explicit.

---

# 18.2 `getcwd`

## Primary Assessed Skills

- **uses_getcwd** — Retrieves the current working directory.
- **interprets_working_directory** — Explains what the current working directory represents.
- **connects_working_directory_to_relative_path** — Recognizes why relative filenames depend on the program's current location.
- **uses_working_directory_for_debugging** — Uses the current directory to diagnose a missing-file problem.
- **predicts_getcwd_output_type** — Recognizes that the result is path information represented as text.

## Core Mental Model

The current working directory answers:

> Where is Python looking from right now?

This becomes highly useful when students say:

> But the file is right there!

and Python cannot find it.

---

# 18.3 `listdir`

## Primary Assessed Skills

- **uses_listdir** — Retrieves the contents of a directory.
- **interprets_directory_listing** — Interprets returned file/folder names.
- **loops_through_directory_items** — Iterates through directory entries.
- **searches_directory_listing** — Uses prior searching/membership skills with a directory list.
- **distinguishes_directory_and_file** — Recognizes the conceptual difference between a folder and a file.
- **uses_listdir_for_file_discovery** — Uses directory inspection to find available files.

## Strong Prior-Skill Integration

`os.listdir()` produces data students can treat like a collection.

That connects naturally to:

- lists,
- loops,
- membership,
- searching.

---

# 18.4 `exists`

## Primary Assessed Skills

- **checks_path_exists** — Determines whether a path exists.
- **uses_os_path_tools** — Uses `os.path` functionality at an introductory level.
- **interprets_exists_boolean** — Recognizes that an existence check returns Boolean information.
- **uses_exists_in_condition** — Uses an existence test to control program behavior.
- **builds_path_with_join** — Uses `os.path.join()` in a guided path-construction situation.
- **distinguishes_valid_and_invalid_path** — Determines whether a path points to an available resource.
- **prevents_missing_path_failure** — Checks before attempting an operation when appropriate.

## Core Example Pattern

```python
if os.path.exists(file_path):
    print("File found.")
else:
    print("File not found.")
```

## Defensive Programming Connection

This retrieves Unit 14:

> Check predictable problems before they become failures.

---

# 18.5 Introduction to `sys`

## Primary Assessed Skills

- **imports_sys_module** — Imports `sys`.
- **recognizes_sys_module_purpose** — Recognizes `sys` as access to interpreter/system-related functionality.
- **reads_sys_argv** — Recognizes command-line argument information in `sys.argv`.
- **recognizes_program_name_in_argv** — Understands that the script itself occupies the first argument position.
- **accesses_command_line_argument** — Retrieves a provided argument by index.
- **recognizes_missing_argument_risk** — Identifies how accessing an unavailable argument can fail.
- **uses_sys_reference** — Interprets a straightforward `sys` tool using documentation/reference material.

## Conceptual Model

When a program is run from the command line:

```text
python game.py Alex
```

the command contains information.

`sys.argv` lets the Python program inspect that information.

---

# 18.6 Command-Line Arguments

## Primary Assessed Skills

- **runs_python_from_command_line** — Runs a Python program using a command-line interface.
- **passes_command_line_argument** — Supplies an argument when launching the program.
- **accesses_command_line_argument_value** — Uses `sys.argv` to retrieve supplied input.
- **maps_argument_position_to_value** — Connects argument order to list indexes.
- **distinguishes_console_input_and_cli_argument** — Distinguishes `input()` from launch-time arguments.
- **validates_argument_count** — Checks whether expected arguments are available.
- **uses_cli_argument_in_program** — Uses the supplied value meaningfully.
- **debugs_basic_cli_execution** — Resolves straightforward issues involving launch location or missing arguments.

## Core Comparison

### Runtime Prompt

```python
name = input("Name: ")
```

The program starts first.

Then it asks the user for input.

### Command-Line Argument

```text
python game.py Alex
```

The information is supplied as the program is launched.

Students should distinguish these two input mechanisms.

## Connection to Lists

`sys.argv` behaves like an ordered collection.

Students can use their prior indexing knowledge:

```text
argv[0]
→ script/program name

argv[1]
→ first supplied argument
```

---

# Unit 18 Recommended Skill Categories

The major mastery categories are:

1. module use,
2. file system vs file contents,
3. current working directory,
4. directory listing,
5. path existence,
6. basic `os.path`,
7. `sys`,
8. command-line arguments,
9. file-system troubleshooting.

---

# Unit 18 Project: File Finder

## Project Goal

Students build a utility that helps a user inspect and locate files.

## Likely Required Skill Areas

Students should:

- import appropriate modules,
- identify the current directory,
- list directory contents,
- accept or receive a filename,
- check whether a path exists,
- clearly report whether the file was found,
- use loops/conditions appropriately,
- organize output clearly.

## Possible Core Interaction

```text
Current Folder:
...

Files:
...

Enter a filename:
notes.txt

Result:
notes.txt was found.
```

## Project Assessment

Assess:

- correct module use,
- correct path reasoning,
- appropriate Boolean checks,
- correct directory inspection,
- clear user feedback,
- integration with prior list/search skills.

## Stretch Opportunities

Students may:

- search a subfolder,
- accept a command-line filename,
- show full paths,
- filter by extension,
- count file types,
- sort results,
- create a more advanced directory search.

Do not require recursive directory traversal unless intentionally introduced as Extend.

---

# Unit 18 Certification Completion Checkpoint

Unit 18 is the **hard completion point for new certification courseware**.

Before students transition into the final certification-preparation phase, verify:

- [ ] All required LearnKey videos have been completed.
- [ ] All mapped workbook pages have been completed.
- [ ] All Fill-in-the-Blanks activities have been completed.
- [ ] All LearnKey Coding Exercises have been completed.
- [ ] All certification reviews have been completed.
- [ ] All starter-file activities have been completed.
- [ ] All six certification domains have been encountered.
- [ ] Students have access to the certification study guide.
- [ ] Students understand how to interpret domain-level practice results.

At this point:

```text
NEW CERTIFICATION CONTENT
→ complete

CERTIFICATION READINESS
→ becomes an ongoing focus
```

---

# Certification Preparation Transition After Unit 18

Beginning after Unit 18, certification preparation should shift from:

```text
LEARN NEW CERTIFICATION CONTENT
```

to:

```text
ASSESS
↓
IDENTIFY WEAK AREAS
↓
STUDY
↓
TARGET PRACTICE
↓
REASSESS
↓
CERTIFICATION EXAM
```

Students should begin completing:

- full-length certification practice exams,
- study-guide review,
- domain-specific practice,
- targeted remediation,
- repeated readiness checks.

This work runs alongside Units 19–20 rather than replacing them.

---

# Full-Length Certification Practice Exams

Beginning after Unit 18, students should regularly complete full-length IT Specialist – Python practice exams.

The first full-length practice exam should primarily function as a diagnostic.

Full-length practice exams allow students to:

- experience the complete exam format,
- practice moving between certification domains,
- develop testing endurance,
- identify concepts that have not transferred from lesson practice,
- receive overall and domain-level proficiency data,
- identify what to study next.

The primary question after a practice exam should be:

> What does this result tell me to study next?

rather than simply:

> What score did I get?

---

# Domain-Specific Practice

Students should use practice-exam results to identify their lowest-proficiency certification areas.

The six domains are:

1. Operations Using Data Types and Operators
2. Flow Control with Decisions and Loops
3. Input and Output Operations
4. Code Documentation and Structure
5. Troubleshooting and Error Handling
6. Operations Using Modules and Tools

After a practice exam:

```text
FULL PRACTICE EXAM
↓
REVIEW DOMAIN SCORES
↓
IDENTIFY LOWEST-PROFICIENCY DOMAIN
↓
USE STUDY GUIDE
↓
COMPLETE DOMAIN-SPECIFIC PRACTICE
↓
REVIEW MISSED CONCEPTS
↓
REASSESS
```

Students should not automatically receive equal review across all six domains.

---

# Using the Certification Study Guide

The study guide should now become an active diagnostic-reference tool.

Students should use it to:

- review terminology connected to missed questions,
- locate forgotten syntax,
- refresh uncommon certification functions,
- review objective-specific concepts,
- identify what they do and do not remember,
- prepare before targeted practice,
- confirm understanding after remediation.

The study guide should not simply become:

> read the entire study guide again.

Instead:

```text
practice evidence
↓
specific weakness
↓
specific study-guide section
↓
specific practice
```

---

# Certification Domain-to-Unit Review Map

| Certification Domain | Primary FoxCS Units for Review |
|---|---|
| Domain 1 — Data Types and Operators | Units 02, 04, 05, 08, 09, 10 |
| Domain 2 — Decisions and Loops | Units 05–06 |
| Domain 3 — Input and Output | Units 03, 16, 18 |
| Domain 4 — Documentation and Functions | Unit 07 |
| Domain 5 — Troubleshooting and Error Handling | Units 13–15 |
| Domain 6 — Modules and Tools | Units 11, 12, 17, 18 |

Students should increasingly move from:

```text
"My Domain 5 score is low."
```

to:

```text
"I need to review debugging, exception handling, and testing."
```

and eventually:

```text
"My weakest skills are exception-flow tracing and choosing assertion methods."
```

That level of diagnosis is the goal.

---

# UNIT 19: Classes and Objects — Skills Review

## Unit Scope

Unit 19 includes:

- 19.1 What Are Objects?
- 19.2 Creating Classes
- 19.3 Attributes
- 19.4 Methods
- 19.5 `__init__`
- 19.6 Modeling Real-World Systems
- 19.7 Introduction to Inheritance

Project:

- Employee Management System

This unit is FoxCS-original.

The IT Specialist – Python certification does not require full object-oriented programming.

The conceptual progression is:

```text
related data + behavior
↓
object
↓
class as blueprint
↓
attributes
↓
methods
↓
constructor
↓
multiple modeled entities
↓
shared structure through inheritance
```

This is one of the largest conceptual shifts in the course.

---

# Unit 19 Parallel Certification Thread

Unit 19 should not be replaced with certification review.

Instead, students now work toward two goals in parallel:

```text
FOXCS CORE
Classes and Objects

+

CERTIFICATION PREP
Diagnostic practice and targeted remediation
```

Possible certification work during Unit 19:

- first or additional full-length practice exam,
- domain-score analysis,
- study-guide review,
- domain-specific practice,
- objective-specific remediation,
- teacher-assigned practice based on proficiency,
- review of uncommon certification tools.

Students who demonstrate strong readiness may spend less time on remediation.

Students whose diagnostic evidence shows clear weaknesses should receive more targeted practice.

---

# 19.1 What Are Objects?

## Primary Assessed Skills

- **recognizes_object** — Recognizes an object as a programming entity containing related state and behavior.
- **distinguishes_class_and_object** — Distinguishes a blueprint/type from an individual instance.
- **identifies_object_state** — Identifies information an object needs to remember.
- **identifies_object_behavior** — Identifies actions an object should perform.
- **groups_state_and_behavior** — Recognizes related variables/functions that could belong together.
- **models_entity_as_object** — Determines when an entity is a useful candidate for object-oriented modeling.

## Mental Model

A class is a blueprint.

An object is one thing created from that blueprint.

Example:

```text
CLASS
Player

OBJECTS
player_one
player_two
player_three
```

Each player can follow the same structure while storing different values.

## Game Connection

Possible game objects:

- Player
- Enemy
- Item
- Weapon
- Door
- Quest
- Level

---

# 19.2 Creating Classes

## Primary Assessed Skills

- **writes_class_definition** — Writes basic Python class syntax.
- **recognizes_class_keyword** — Identifies `class`.
- **names_class_conventionally** — Uses an appropriate class-name convention.
- **creates_object_instance** — Creates an instance from a class.
- **distinguishes_class_definition_and_instantiation** — Distinguishes defining a class from creating an object.
- **predicts_multiple_instances** — Understands that one class can create multiple independent objects.

## Basic Example

```python
class Player:
    pass


player_one = Player()
player_two = Player()
```

## Core Distinction

```text
class Player:
→ define the blueprint

Player()
→ create an object from the blueprint
```

## Connection to Functions

Students have already seen:

```python
def
```

as defining reusable behavior.

Now they see:

```python
class
```

as defining a reusable entity structure.

---

# 19.3 Attributes

## Primary Assessed Skills

- **creates_instance_attribute** — Stores data on an object.
- **accesses_instance_attribute** — Retrieves an attribute using dot notation.
- **updates_instance_attribute** — Changes object state.
- **distinguishes_attributes_between_instances** — Recognizes that different objects can have different values.
- **predicts_object_state** — Traces attribute values over time.
- **selects_attribute_for_entity** — Identifies appropriate state for a modeled object.

## Conceptual Model

Variables describe program state.

Attributes describe:

> state belonging to a particular object.

Example:

```text
player_one.health
player_two.health
```

These represent separate state.

## Game Example

```text
Player
├── name
├── health
├── score
└── level
```

---

# 19.4 Methods

## Primary Assessed Skills

- **recognizes_method** — Recognizes a function belonging to a class.
- **defines_instance_method** — Writes a basic method.
- **calls_instance_method** — Calls behavior through an object.
- **uses_self_parameter** — Uses `self` in basic method definitions.
- **accesses_attribute_from_method** — Uses object state inside behavior.
- **updates_attribute_from_method** — Changes object state through a method.
- **distinguishes_function_and_method** — Distinguishes standalone functions from behavior associated with an object.
- **selects_method_for_entity_behavior** — Determines appropriate actions for an object.

## Core Comparison

```text
FUNCTION
heal_player(player)

METHOD
player.heal()
```

Both can solve problems.

The method version communicates:

> healing is behavior belonging to this Player object.

## Game Connection

Possible methods:

```text
player.jump()
player.attack()
player.heal()

enemy.take_damage()
enemy.move()

item.use()
```

This brings the Unit 07 game-ability analogy back at a more advanced level.

---

# 19.5 `__init__`

## Primary Assessed Skills

- **recognizes_init_method** — Recognizes `__init__` as initialization behavior.
- **defines_init_method** — Writes a basic constructor-style initializer.
- **initializes_instance_attributes** — Sets initial object state.
- **passes_values_during_instantiation** — Supplies values when creating an object.
- **maps_constructor_arguments_to_attributes** — Traces values into object state.
- **distinguishes_parameter_and_attribute** — Distinguishes temporary method parameters from stored object attributes.
- **predicts_initialized_object_state** — Determines state immediately after object creation.

## Core Example

```python
class Player:
    def __init__(self, name, health):
        self.name = name
        self.health = health
```

Create:

```python
player = Player("Alex", 100)
```

Resulting state:

```text
player.name
→ "Alex"

player.health
→ 100
```

## Important Distinction

Inside:

```python
def __init__(self, name):
    self.name = name
```

these two `name` references have related but distinct roles:

```text
name
→ incoming parameter

self.name
→ attribute stored on the object
```

This deserves explicit tracing.

---

# 19.6 Modeling Real-World Systems

## Primary Assessed Skills

- **identifies_entity_attributes** — Determines information an entity needs to store.
- **identifies_entity_methods** — Determines behavior an entity needs.
- **designs_class_from_requirements** — Converts requirements into a class structure.
- **creates_multiple_related_objects** — Uses one class to represent multiple entities.
- **combines_objects_with_collections** — Stores and processes objects in lists when appropriate.
- **selects_class_vs_dictionary** — Chooses between simpler structured data and a class based on problem needs.
- **explains_object_model_choice** — Justifies why a class structure is useful.
- **revises_class_design** — Improves an initial model based on requirements.

## Important Comparison to Unit 09

A dictionary may be enough for:

> named information.

A class becomes especially valuable when an entity has:

```text
STATE
+
BEHAVIOR
```

Example:

```text
dictionary
→ character data

class
→ character data + character actions
```

Neither is automatically better.

The design question is:

> What structure fits the problem?

---

# 19.7 Introduction to Inheritance

## Primary Assessed Skills

- **recognizes_inheritance_relationship** — Recognizes a parent/child class relationship.
- **creates_basic_subclass** — Creates a straightforward subclass.
- **recognizes_inherited_attributes_methods** — Understands that a subclass can use inherited behavior.
- **adds_subclass_specific_behavior** — Adds behavior unique to the child class.
- **distinguishes_parent_and_child_class** — Identifies shared and specialized responsibilities.
- **selects_reasonable_inheritance_relationship** — Recognizes when two entities genuinely have an "is-a" relationship.

## Mental Model

```text
Enemy
├── move()
├── take_damage()
└── health

Boss
inherits Enemy
+
special_attack()
```

A Boss:

> is an Enemy with additional/specialized behavior.

## Important Design Warning

Do not teach inheritance as:

> use this whenever two classes have something in common.

Use:

> Child **is a type of** Parent.

Examples:

```text
Boss is an Enemy
→ reasonable

Sword is a Player
→ not reasonable
```

## Teaching Boundary

This is an introduction.

Do not require:

- multiple inheritance,
- abstract base classes,
- deep polymorphism,
- advanced `super()` patterns,
- complex class hierarchies,
- metaclasses.

---

# Unit 19 Recommended Skill Categories

The major mastery categories are:

1. object/class distinction,
2. creating classes,
3. creating instances,
4. attributes,
5. methods,
6. `self`,
7. `__init__`,
8. object-state tracing,
9. class modeling,
10. introductory inheritance.

---

# Unit 19 Project: Employee Management System

## Project Goal

Students model multiple employees using classes and objects.

Although game examples may dominate instruction, the project deliberately tests whether students can transfer object-oriented thinking to a non-game context.

## Likely Required Skill Areas

Students should:

- define an Employee class,
- initialize employees with useful attributes,
- create multiple employee objects,
- create at least one meaningful method,
- display employee information,
- update employee state through appropriate behavior,
- store multiple employee objects,
- process those objects,
- explain their class design.

## Possible Attributes

```text
name
employee_id
department
role
salary
hours
```

Use only those appropriate to the project scope.

## Possible Methods

```text
display_info()
update_role()
calculate_pay()
give_raise()
```

## Inheritance Requirement

Inheritance can be:

- required at a modest level,
- or included as a strong extension depending on pacing.

Possible relationship:

```text
Employee
↓
Manager
```

A Manager is an Employee with additional responsibilities.

## Project Assessment

Assess:

1. class design,
2. instance creation,
3. attribute use,
4. method use,
5. `__init__`,
6. correct use of `self`,
7. modeling decisions,
8. code readability,
9. ability to explain state and behavior.

## Stretch Opportunities

Students may:

- create subclasses,
- create multiple employee types,
- build a menu interface,
- calculate payroll,
- save employee information using Unit 16 skills,
- add hire dates using Unit 17,
- search/sort employees,
- add tests from Unit 15.

---

# Unit 19 Certification Preparation

## Full-Length Practice Exam

At least one full-length practice exam should occur during this certification-preparation phase if scheduling allows.

After the exam, students should record:

- overall result,
- Domain 1 proficiency,
- Domain 2 proficiency,
- Domain 3 proficiency,
- Domain 4 proficiency,
- Domain 5 proficiency,
- Domain 6 proficiency.

## Diagnostic Analysis

Students should identify:

```text
strongest domain
lowest-proficiency domain
secondary review domain
specific concepts needing review
```

## Targeted Practice

Certification work should then prioritize:

```text
PRIMARY
lowest-proficiency domain

SECONDARY
next-lowest domain

MAINTENANCE
already-strong domains
```

Students may use:

- the certification study guide,
- domain-specific GMetrix practice,
- prior FoxCS lessons,
- targeted Moodle practice,
- prior workbook activities as references,
- focused coding exercises where needed.

The goal is individualized remediation rather than repeating all six domains equally.

---

# UNIT 20: Capstone Project — Skills Review

## Unit Scope

Unit 20 includes:

- 20.1 Project Planning
- 20.2 Feature Scoping
- 20.3 Building V1
- 20.4 Testing and Debugging
- 20.5 Reflection and Revision

Final Project:

- Capstone Project

Unit 20 does not introduce a major new Python syntax topic.

Its purpose is:

> independent synthesis.

Students should demonstrate that they can choose and combine appropriate tools from across the course.

The progression is:

```text
idea
↓
requirements
↓
scope
↓
plan
↓
build
↓
test
↓
revise
↓
explain
```

---

# Unit 20 Parallel Certification Thread

Unit 20 continues two goals in parallel:

```text
CAPSTONE DEVELOPMENT
+
TARGETED CERTIFICATION PREPARATION
```

The capstone should not be replaced by weeks of generic test preparation.

Students continue authentic programming while certification review responds to diagnostic evidence.

Possible certification work during Unit 20 includes:

- additional full-length practice exams,
- study-guide review,
- domain-specific GMetrix practice,
- objective-specific remediation,
- comparison of practice-exam results,
- certification readiness checks,
- final exam preparation.

Students demonstrating strong readiness may spend proportionally more time on capstone development.

Students with significant certification gaps should receive more focused remediation.

---

# Capstone Skill Philosophy

The capstone should not require:

> every Python feature learned during the year.

Instead students should demonstrate:

> deliberate selection of appropriate features for the problem they chose.

A smaller coherent program using six concepts well is preferable to:

> a large program containing twelve features simply because a checklist required them.

There should still be minimum technical requirements, but they should support the project rather than distort it.

---

# 20.1 Project Planning

## Primary Assessed Skills

- **defines_project_problem** — Clearly identifies what the program will do or what experience it will create.
- **identifies_target_user** — Identifies who will use the program.
- **defines_project_goal** — States a concrete desired outcome.
- **identifies_required_inputs** — Determines what information the program needs.
- **identifies_required_outputs** — Determines what the program should produce.
- **identifies_program_state** — Determines information the program must remember.
- **decomposes_project_features** — Breaks the project into smaller components.
- **identifies_prior_course_tools** — Connects planned features to Python concepts learned earlier.
- **creates_initial_project_plan** — Produces an actionable implementation plan.

## Planning Questions

Students should answer:

```text
What am I building?

Who is it for?

What can the user do?

What information must the program remember?

What decisions must the program make?

What repeats?

What data must be organized?

What could go wrong?

How will I know it works?
```

## Computational Thinking Connection

This returns directly to decomposition:

```text
large problem
↓
smaller problems
↓
implementable tasks
```

---

# 20.2 Feature Scoping

## Primary Assessed Skills

- **distinguishes_required_and_optional_features** — Separates necessary functionality from enhancements.
- **defines_minimum_viable_project** — Identifies the smallest complete version of the program.
- **prioritizes_features** — Orders features based on importance.
- **identifies_dependency_between_features** — Recognizes when one feature depends on another.
- **estimates_feature_complexity** — Makes a reasonable judgment about difficulty.
- **removes_out_of_scope_feature** — Recognizes when a feature threatens completion.
- **creates_stretch_feature_list** — Separates optional ideas from core requirements.
- **revises_scope_based_on_constraints** — Adjusts the plan based on time, skill, or technical limitations.

## Core Model

Use:

```text
REQUIRED
→ project does not work without it

IMPORTANT
→ improves the complete experience

STRETCH
→ attempt after the core works
```

## Critical Capstone Principle

Students should not attempt:

```text
all features at once
```

The capstone should reinforce:

> Finish a strong core before expanding.

---

# 20.3 Building V1

## Primary Assessed Skills

- **builds_minimum_viable_version** — Produces a functional first complete version.
- **implements_feature_incrementally** — Builds one understandable feature at a time.
- **tests_feature_after_implementation** — Checks functionality during development.
- **integrates_multiple_course_concepts** — Combines prior Python concepts coherently.
- **maintains_program_state** — Manages changing data appropriately.
- **organizes_program_structure** — Uses functions/classes/files/collections where they improve the design.
- **uses_descriptive_names** — Writes readable identifiers.
- **documents_nonobvious_code** — Uses comments/docstrings appropriately.
- **uses_troubleshooting_routine_independently** — Applies systematic debugging without immediately requesting the solution.
- **saves_working_checkpoint** — Maintains a usable version before large changes.

## Development Pattern

Encourage:

```text
build one feature
↓
run it
↓
verify
↓
save working state
↓
build next feature
```

rather than:

```text
write entire project
↓
run for first time
↓
discover dozens of interacting problems
```

## Potential Course Concepts

A capstone may appropriately use:

- variables,
- input/output,
- strings,
- arithmetic,
- conditionals,
- loops,
- functions,
- lists,
- dictionaries,
- searching/sorting,
- randomness,
- modules,
- exception handling,
- testing,
- files,
- datetime,
- classes.

Not every project needs every item.

---

# 20.4 Testing and Debugging

## Primary Assessed Skills

- **creates_capstone_test_plan** — Defines how major features will be verified.
- **tests_core_feature** — Tests required behavior.
- **tests_integration_between_features** — Checks whether connected components work together.
- **tests_edge_cases_in_project** — Identifies project-specific boundary/unusual situations.
- **records_bug** — Clearly documents a discovered problem.
- **reproduces_bug** — Determines steps that reliably trigger a problem.
- **forms_debugging_hypothesis** — Proposes a likely cause using evidence.
- **tests_debugging_change** — Makes a focused revision.
- **verifies_bug_fix** — Confirms that the original problem is resolved.
- **checks_for_regression** — Confirms that the fix did not break previously working behavior.
- **uses_user_testing_feedback** — Incorporates feedback from another user when appropriate.

## Bug Record Structure

Students can document:

```text
Expected:
...

Actual:
...

Steps to reproduce:
...

Likely cause:
...

Change tested:
...

Result:
...
```

## Integration of Units 13–15

This is where:

```text
DEBUGGING
+
EXCEPTION HANDLING
+
TESTING
```

should become part of normal development rather than isolated units.

---

# 20.5 Reflection and Revision

## Primary Assessed Skills

- **evaluates_project_against_goal** — Determines whether the project accomplishes its intended purpose.
- **evaluates_user_experience** — Considers clarity, feedback, and usability.
- **identifies_project_strength** — Identifies a concrete successful design/technical decision.
- **identifies_project_limitation** — Identifies a meaningful weakness or unfinished area.
- **uses_feedback_to_prioritize_revision** — Chooses revisions based on evidence.
- **implements_meaningful_revision** — Makes a change that improves the project.
- **explains_revision_rationale** — Explains why a change was made.
- **reflects_on_skill_growth** — Identifies programming/design growth across the course.
- **identifies_next_learning_goal** — Identifies a reasonable next technical or design skill to develop.

## Revision Principle

Revision should not mean:

> change colors or rename variables because the assignment requires a revision.

A meaningful revision should improve:

- functionality,
- reliability,
- usability,
- organization,
- clarity,
- performance at the course-appropriate level.

---

# Capstone Technical Requirements

The final project should demonstrate a meaningful subset of the course.

A reasonable baseline might require evidence of:

## Program State

Use variables and/or object attributes to track meaningful information.

## User Interaction or Program Input

The program receives information through an appropriate mechanism.

## Decision-Making

Use conditional logic for meaningful program behavior.

## Repetition

Use a loop where repetition is genuinely needed.

## Organization

Use functions and/or classes to organize nontrivial behavior.

## Structured Data

Use at least one meaningful collection such as:

- list,
- tuple where appropriate,
- dictionary,
- list of objects.

## Error Awareness

Demonstrate either:

- input validation,
- exception handling,
- defensive programming,
- another appropriate failure-handling mechanism.

## Testing

Provide evidence that core features were deliberately tested.

## Documentation

Use:

- meaningful names,
- appropriate comments,
- docstrings where useful.

---

# Optional Advanced Capstone Features

Depending on the project, students may additionally use:

- file persistence,
- datetime,
- randomness,
- searching,
- sorting,
- classes,
- inheritance,
- command-line arguments,
- automated unit tests.

These should not be included merely to increase feature count.

---

# Capstone Project Types

Students should have meaningful choice.

Possible formats include:

## Game / Game-System Project

Examples:

- text adventure,
- combat simulator,
- character system,
- probability game,
- inventory simulator,
- turn-based game,
- game-stat tracker.

## Utility / Application

Examples:

- planner,
- study tool,
- calculator,
- tracker,
- organizer,
- journal,
- file utility.

## Data-Oriented Project

Examples:

- statistics explorer,
- score tracker,
- recommendation tool,
- searchable collection,
- simulation.

## Student-Proposed Project

Allowed when the project:

- fits available Python skills,
- has a clear user/purpose,
- has an achievable scope,
- demonstrates sufficient programming complexity.

---

# Capstone Project Assessment Categories

A final rubric should likely evaluate:

## 1. Functional Completion

Does the core program work?

## 2. Computational Thinking

Did the student break the problem into manageable systems?

## 3. Programming Skill

Are Python concepts applied correctly?

## 4. Program Structure

Is code organized in a way the student can explain?

## 5. Testing and Reliability

Did the student intentionally verify behavior?

## 6. Debugging and Revision

Is there evidence of diagnosis and improvement?

## 7. User Experience / Game Design

Does the program communicate clearly and support its intended experience?

## 8. Explanation and Ownership

Can the student explain:

- what the code does,
- why they made major decisions,
- what they changed,
- what they learned?

This final category is especially important for establishing genuine mastery.

---

# Unit 20 Certification Readiness Cycle

Certification preparation should continue alongside the capstone.

Use a repeated cycle:

```text
1. FULL-LENGTH PRACTICE EXAM

2. ANALYZE RESULTS
   - overall score
   - domain scores
   - missed concepts

3. SELECT PRIORITY DOMAIN

4. STUDY
   - certification study guide
   - prior FoxCS lessons
   - prior reference materials

5. PRACTICE
   - domain-specific questions
   - GMetrix domain practice
   - targeted coding where appropriate

6. CHECK UNDERSTANDING

7. TAKE ANOTHER FULL-LENGTH PRACTICE EXAM

8. COMPARE RESULTS
```

Students should be able to answer:

```text
What is my weakest domain?

What specific concepts inside that domain are weak?

What am I doing to improve them?

Did my next practice result show improvement?
```

---

# Practice Exam Data as Adaptive Evidence

Practice-exam performance should become another source of adaptive evidence.

Example:

```text
Student A

Domain 1: 90%
Domain 2: 88%
Domain 3: 84%
Domain 4: 91%
Domain 5: 72%
Domain 6: 61%
```

The student should not receive equal review across all domains.

Instead:

```text
PRIMARY REVIEW
Domain 6

SECONDARY REVIEW
Domain 5

MAINTENANCE
Domains 1–4
```

This matches the broader FoxCS adaptive philosophy:

> Practice should respond to evidence of what the learner actually needs.

---

# Certification Readiness Reflection

Students should periodically record:

```text
Current strongest domain:
...

Current lowest-proficiency domain:
...

Specific concept I need to review:
...

Study-guide section I used:
...

Practice I completed:
...

Evidence that I improved:
...
```

This makes certification preparation a metacognitive process rather than simply repeated test-taking.

---

# Certification Boundary

Unit 20 does not introduce new LearnKey workbook or video content.

By this point:

- all LearnKey videos should already have been completed,
- all mapped workbook pages should already have been completed,
- all LearnKey Coding Exercises should already have been completed,
- all certification reviews should already have been completed.

Units 19–20 therefore focus on:

```text
FULL-LENGTH PRACTICE
+
DIAGNOSTIC ANALYSIS
+
TARGETED DOMAIN PRACTICE
+
STUDY-GUIDE USE
+
CERTIFICATION READINESS
```

while students continue authentic Python development.

---

# Unit 20 Recommended Skill Categories

The major mastery categories are:

1. project planning,
2. decomposition,
3. scope management,
4. feature prioritization,
5. incremental development,
6. integration of prior Python concepts,
7. independent troubleshooting,
8. testing,
9. debugging,
10. revision,
11. usability/design reasoning,
12. technical explanation,
13. reflection.

---

# Unit 20 Final Project: Capstone Project

## Core Expectations

Students should:

- propose an achievable project,
- define its user/purpose,
- define required features,
- separate core and stretch scope,
- build a functional V1,
- integrate multiple Python concepts,
- test intentionally,
- document discovered problems,
- revise based on evidence,
- produce a final functioning version,
- explain major technical decisions,
- reflect on their growth.

## Strong Final Evidence

The most valuable evidence is not simply:

```text
finished program
```

It is:

```text
plan
+
working code
+
testing evidence
+
revision evidence
+
student explanation
```

Together these provide much stronger evidence of actual programming mastery.

---

# Units 16–20 Conceptual Progression

## Unit 16: File Input & Output

Students learn:

> How can my program remember information after it closes?

```text
temporary state
↓
persistent data
```

---

## Unit 17: Dates, Times, and Calendars

Students learn:

> How can a program reason about when something happens and how much time passes?

```text
time
↓
duration
↓
calculation
↓
human-readable output
```

---

## Unit 18: Working with the Computer

Students learn:

> How can my Python program interact with the environment it runs inside?

```text
program
↓
file system
↓
paths
↓
operating system
↓
command line
```

Unit 18 also marks:

```text
CERTIFICATION COURSEWARE
→ complete
```

---

## Unit 19: Classes and Objects

Students learn:

> How can I model larger systems by combining related state and behavior?

```text
data
+
behavior
↓
objects
↓
systems
```

At the same time:

```text
full-length certification practice
+
targeted remediation
```

begins or continues.

---

## Unit 20: Capstone

Students learn:

> How do I independently decide which programming tools to combine to solve a larger problem?

```text
problem
↓
plan
↓
scope
↓
build
↓
test
↓
revise
↓
explain
```

Certification preparation continues in parallel:

```text
practice exam
↓
diagnose
↓
study
↓
target practice
↓
reassess
↓
certification
```

---

# Final Course Conceptual Progression

Across the full Python sequence:

```text
instructions
↓
state
↓
input
↓
calculation
↓
decision
↓
repetition
↓
reusable behavior
↓
ordered collections
↓
structured data
↓
data organization and search
↓
randomness
↓
standard-library tools
↓
understanding failure
↓
handling failure
↓
testing
↓
persistence
↓
time
↓
computer environment
↓
objects and systems
↓
independent synthesis
```

The final shift is from:

```text
"What Python feature should I use?"
```

toward:

```text
"What does this problem require, and which tools I know fit that need?"
```

At the same time, certification preparation shifts from:

```text
"Have I completed the certification content?"
```

toward:

```text
"What evidence shows I am ready for the exam, and what do I still need to strengthen?"
```

That combination of independent programming and evidence-based certification preparation is the final transfer goal of the course.
