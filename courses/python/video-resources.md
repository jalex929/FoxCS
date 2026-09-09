# FoxCS: Python — External Video Resources

Tracks third-party instructional videos assigned to specific lessons, so the decision survives even though most of the lessons below aren't authored yet (only 02.0 and 02.1 exist as real content as of 2026-09-08 — see `course-plan.md`'s checklist). When a lesson below actually gets built, pull its video straight from here rather than re-deciding. See `../../02-authoring-system/content-authoring-standards.md`'s "Embedded External Video Content" section for the standing rules every entry here should already follow (headphones note, stated length, creator attribution, backup hyperlink, interpreter-vs-VS-Code caveat when it applies).

| Lesson | Video | Creator | Length | YouTube link | Status |
|---|---|---|---|---|---|
| 02.1 Variables and Memory | Python Variables — Python Tutorial for Beginners with Examples \| Mosh | Programming with Mosh | 6:35 | https://www.youtube.com/watch?v=cQT33yu9pY8 | **Live** — embedded in `content/unit_02_variables_and_data/lesson_02_01_variables_and_memory/01_instruction.html` |
| 02.2 Integers | Python Tutorial for Beginners 3: Integers and Floats - Working with Numeric Data | Corey Schafer | **still not independently confirmed** — title/creator verified live via YouTube oEmbed 2026-09-09, but automated length lookup failed (YouTube served a stripped page to this droplet's fetches); confirm the runtime by eye before a class watches it | https://www.youtube.com/watch?v=khKv-8q7YmY | **Live** 2026-09-09 — embedded in both the Instruction page (`content/unit_02_variables_and_data/lesson_02_02_integers/01_instruction.html`, real course cmid=259) and the new Coding Exercise (cmid=264) |
| 02.3 Floats | Python Integers vs Floats - Visually Explained | Visually Explained | **still not independently confirmed**, same caveat as 02.2's row | https://www.youtube.com/watch?v=1lGXcaK6vqs | **Live** 2026-09-09 — Instruction cmid=260, Coding Exercise cmid=265 |
| 02.4 Strings | Python Strings \|\| Python Tutorial \|\| Python Programming | Socratica | **still not independently confirmed**, same caveat as 02.2's row | https://www.youtube.com/watch?v=iAzShkKzpJo | **Live** 2026-09-09 — Instruction cmid=261, Coding Exercise cmid=266 |
| 02.5 Booleans | Python Booleans \|\| Python Tutorial \|\| Learn Python Programming | Socratica | 4:39 (Jay-confirmed, used as-is) | https://www.youtube.com/watch?v=9OK32jb_TdI | **Live** 2026-09-09 — Instruction cmid=262, Coding Exercise cmid=267 |

## Why the Corey Schafer video landed on 02.2, not 02.3

Jay's call to make (his own words: "your call if it goes with the int lesson or float lesson"). The video covers integers and floats together, so either lesson would work. Placed at **02.2 Integers** because it's the first exposure to Python's numeric types generally, and Integers comes first in the unit sequence. **02.3 Floats** gets the Visually Explained video instead, which is specifically an int-vs-float comparison — a better fit for what's actually new in 02.3 (how floats differ from the integers just covered), rather than re-showing the same combined video twice. Revisit this split if either lesson's real authored content ends up not matching this framing.

## Declined for now: Socratica's Numbers video

Jay also named **Numbers in Python Version 3 || Python Tutorial || Learn Python** (Socratica) as a candidate for 02.2/02.3, then decided against it — his own words: "this video about numbers may be out of scope for that actually so let's not show that for int/float." Not used anywhere below. **Keep Socratica in mind for future lessons regardless** — per Jay, she has videos at an appropriate length for students, explained in a way that's supportive for a high-school audience. Worth checking her channel first when a future lesson needs a video, alongside Corey Schafer/Mosh/Visually Explained (see the "Preferred external channels" note in `content-authoring-standards.md`).

## Before actually embedding one of the "not yet embedded" rows above

1. Confirm the video is still live at that URL and re-check its exact length (durations above are marked unconfirmed where Jay didn't state one directly).
2. Follow `content-authoring-standards.md`'s Embedded External Video Content rules: state the length next to the embed, attribute the creator, add the headphones-at-your-station reminder, add a backup hyperlink to the YouTube page, and add the interpreter-vs-VS-Code note if (and only if) that specific video shows the plain Python interpreter/IDLE rather than an editor.
3. Update this table's Status column once it's live, matching 02.1's row above as the pattern.
