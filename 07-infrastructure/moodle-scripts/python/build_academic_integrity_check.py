"""Unit 00 Lesson 0.8.2 "Check: Academic Integrity" -- converted 2026-08-30
from the shared local-save HTML practice page (fully shared across both Unit
0 editions, per that file's own header comment) into a standalone
H5P.QuestionSet, matching Python's own Practice-as-QuestionSet pattern.
Every question/answer is unchanged from the original -- content is high-
stakes (academic integrity policy), not rewritten, only re-platformed.
"""
from h5p_book_builder import block_questionset, build_and_zip

def mc(prompt, options, correct_idx):
    return (
        f"<p>{prompt}</p>",
        [
            (f"<div>{text}</div>", i == correct_idx,
             "<div>Right — that's the actual policy.</div>" if i == correct_idx else
             "<div>Not quite. Think again about what the lesson actually said about this.</div>")
            for i, text in enumerate(options)
        ],
    )

QUESTIONS = [
    mc(
        "You and your partner are assigned partner work. Your partner ends up doing almost all of the work while you watch. What actually happens?",
        [
            "Both partners get credit, since it was assigned as partner work.",
            "Only the partner who did the work gets credit. You don't, and you restart the assignment on your own.",
            "Neither partner gets credit, since the partnership broke down.",
            "The teacher splits the credit evenly between both partners.",
        ], 1,
    ),
    mc(
        "A classmate is stuck and asks you for help. What's the right way to help them?",
        [
            "Send them your file so they can see exactly how you did it.",
            "Do the problem for them so they don't fall behind.",
            "Explain how to think through the problem and help them find their own mistake.",
            "Tell them you can't help at all, since any help risks crossing a line.",
        ], 2,
    ),
    mc(
        "If you hand a classmate your code so they can copy it and submit it as their own, what happens to you?",
        [
            "Nothing — you didn't submit anyone else's work as your own.",
            "A warning, the first time it happens.",
            "You get the same consequence as cheating does, since you enabled it.",
            "A small point deduction on your next assignment.",
        ], 2,
    ),
    mc(
        "To start this school year, when are you allowed to use AI tools to help write your code or your written responses for this class?",
        [
            "Anytime, as long as you understand what it produced.",
            "Only for written responses, not code.",
            "Whenever you're stuck and have run out of other options.",
            "Not at all right now — the class starts the year without using AI in your work.",
        ], 3,
    ),
    mc(
        "A student attempts a problem honestly but gets it wrong. Another student uses AI to submit a perfect answer. Which one earns more credit?",
        [
            "The AI-assisted answer, since it's correct.",
            "Both earn the same amount, since only the final answer is graded.",
            "The honest attempt — effort is part of what's graded, and AI-generated work earns none.",
        ], 2,
    ),
]

content_block = block_questionset(QUESTIONS, "Check: Academic Integrity")
content = content_block["content"]["params"]

h5p_manifest = {
    "title": "0.8.2 Check: Academic Integrity",
    "language": "en",
    "mainLibrary": "H5P.QuestionSet",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.QuestionSet", "majorVersion": "1", "minorVersion": "21"}
    ],
}

import json, os, zipfile
stage = "/tmp/h5p-build/_stage_academic_integrity_check"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/academic-integrity-check-00-08.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
