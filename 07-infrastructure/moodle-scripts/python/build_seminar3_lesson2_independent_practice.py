"""Seminar III Lesson 2 -- Independent Practice: rebuild from the static
printable-sheets lesson-2-independent-practice.html (28 fill-in items across
5 sections, no way to enter an answer) into real interactive H5P content.
Built 2026-09-08 per the FoxCS-wide "response-eliciting content must be
interactive" policy. Uses H5P.Essay (real text-input field per item) --
the proven, already-installed content type from Lesson 1's guided/independent
practice builds -- rather than an unproven fill-in-the-blank type, per
courses/seminar-iii/CLAUDE.md's H5P Content-Type Lesson Learned rule (don't
hand-author a content type not already proven in this repo without checking
its real semantics.json first). Per the Lesson 2 Answer Key doc: Independent
Practice is formative/completion-graded, not scored against the key for
points -- matches H5P.Essay's ignoreScoring=True default in block_essay, so
no keyword-matching grading is attempted here, just a real input field per
problem.
"""
import json, os, zipfile
from h5p_book_builder import block_text, block_essay, make_column

def item(problem):
    return block_essay(f"<p>{problem}</p>", "Type your answer and work here.", "Independent Practice")

def section(title, intro, problems):
    blocks = [block_text(f"<h2>{title}</h2>" + (f"<p>{intro}</p>" if intro else ""))]
    blocks += [item(p) for p in problems]
    return blocks

blocks = [
    block_text(
        "<h2>Independent Practice: Numbers and Operations</h2>"
        "<p>Show your work where it applies. Work through these on your own.</p>"
    ),
]

blocks += section("Comparing Integers and Absolute Value", None, [
    "Compare: &minus;18 ___ &minus;25 (write &gt; or &lt;)",
    "Order from least to greatest: 4, &minus;9, &minus;2, 8, &minus;15",
    "Which is greater, &minus;6 or &minus;19?",
    "Find |&minus;22|.",
    "Find |17|.",
    "A learner says &minus;50 is less than &minus;12. Is the learner correct? Explain.",
    "Compare: |&minus;9| ___ |&minus;4| (write &gt; or &lt;)",
])

blocks += section("Adding and Subtracting Integers", None, [
    "&minus;11 + (&minus;9) = ?",
    "&minus;15 + 22 = ?",
    "9 &minus; (&minus;11) = ?",
    "&minus;18 &minus; 7 = ?",
    "25 &minus; 33 = ?",
    "&minus;4 + (&minus;8) + 15 = ?",
    "16 + (&minus;20) = ?",
])

blocks += section("Multiplying and Dividing Integers", None, [
    "&minus;6 &times; 9 = ?",
    "&minus;7 &times; &minus;8 = ?",
    "84 &divide; (&minus;7) = ?",
    "&minus;96 &divide; &minus;8 = ?",
    "&minus;3 &times; 5 &times; &minus;4 = ?",
    "&minus;45 &divide; 9 = ?",
])

blocks += section("Order of Operations", None, [
    "7 + 4 &times; 5 = ?",
    "36 &divide; 6 &times; 3 = ?",
    "18 &minus; 9 + 4 = ?",
    "(6 + 2) &times; 3 &minus; 7 = ?",
    "10 + 3 &times; (8 &minus; 5) = ?",
])

blocks += section("Estimation and Reasonableness", None, [
    "Estimate: 78 &times; 22.",
    "Estimate: 412 &divide; 41.",
    "A learner calculates 39 &times; 61 and gets 279. Is this reasonable? Explain your thinking.",
])

content = make_column(blocks, "Independent Practice")["params"]

h5p_manifest = {
    "title": "Lesson 2 Independent Practice",
    "language": "en",
    "mainLibrary": "H5P.Column",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}
    ],
}

stage = "/tmp/h5p-build/_stage_lesson2_independent"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/lesson2-independent-practice.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}, {len(blocks)} blocks")
