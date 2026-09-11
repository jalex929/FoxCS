"""Seminar III Lesson 2 -- Guided Practice: rebuild from the static
printable-sheets lesson-2-guided-practice.html into real interactive H5P
content. Built 2026-09-08 per the FoxCS-wide "response-eliciting content
must be interactive" policy. Each section's worked example stays as
view-only text (it's instructional, not response-eliciting -- students
watch it worked through as a class); each "Now try these" problem gets a
real H5P.Essay input field. Same formative/completion-graded rationale as
Independent Practice -- see that script's docstring and the Lesson 2
Answer Key doc.
"""
import json, os, zipfile
from h5p_book_builder import block_text, block_essay, make_column

def item(problem):
    return block_essay(f"<p>{problem}</p>", "Type your answer and work here.", "Guided Practice")

def section(title, worked_html, problems):
    blocks = [
        block_text(f"<h2>{title}</h2>"),
        block_text(
            "<div style='background:#eaf3f6;border-left:6px solid #1f6f8b;padding:0.9rem 1.2rem;margin-bottom:1rem;'>"
            "<strong style='display:block;font-size:0.8rem;letter-spacing:0.05em;text-transform:uppercase;color:#144d61;margin-bottom:0.4rem;'>Worked Example</strong>"
            f"{worked_html}</div>"
        ),
        block_text("<p><strong>Now try these:</strong> work through the same steps as the example above.</p>"),
    ]
    blocks += [item(p) for p in problems]
    return blocks

blocks = [
    block_text(
        "<h2>Guided Practice: Numbers and Operations</h2>"
        "<p>Work through the worked example in each section together first. Then try the remaining problems using the same steps.</p>"
    ),
]

blocks += section(
    "Comparing Integers and Absolute Value",
    "<strong>Compare &minus;14 and &minus;9</strong>"
    "<ol>"
    "<li>Picture both numbers on a number line. &minus;14 is farther to the left than &minus;9.</li>"
    "<li>Numbers farther to the right on the number line are greater.</li>"
    "<li>&minus;9 is farther right, so &minus;9 is greater: &minus;14 &lt; &minus;9.</li>"
    "</ol>",
    [
        "Order from least to greatest: &minus;6, 3, &minus;11, 0, 5.",
        "Which is greater, &minus;20 or &minus;3?",
        "Find |&minus;15|.",
        "Find |9|.",
        "A learner says &minus;30 is greater than &minus;8 because 30 is a bigger number. Is the learner correct? Explain.",
    ],
)

blocks += section(
    "Adding and Subtracting Integers",
    "<strong>&minus;7 + (&minus;5)</strong>"
    "<ol>"
    "<li>Both numbers are negative, so you are moving in the same direction on the number line.</li>"
    "<li>Start at &minus;7 and move 5 more in the negative direction.</li>"
    "<li>&minus;7 + (&minus;5) = &minus;12.</li>"
    "</ol>",
    [
        "&minus;9 + 14 = ?",
        "6 &minus; (&minus;8) = ?",
        "&minus;12 &minus; 5 = ?",
        "20 &minus; 27 = ?",
        "&minus;3 + (&minus;6) + 10 = ?",
    ],
)

blocks += section(
    "Multiplying and Dividing Integers",
    "<strong>&minus;8 &times; 7</strong>"
    "<ol>"
    "<li>The signs are different (negative times positive).</li>"
    "<li>Different signs give a negative result.</li>"
    "<li>8 &times; 7 = 56, so &minus;8 &times; 7 = &minus;56.</li>"
    "</ol>",
    [
        "&minus;9 &times; &minus;6 = ?",
        "63 &divide; (&minus;9) = ?",
        "&minus;72 &divide; &minus;8 = ?",
        "&minus;5 &times; 4 &times; &minus;2 = ?",
    ],
)

blocks += section(
    "Order of Operations",
    "<strong>5 + 6 &times; 3</strong>"
    "<ol>"
    "<li>Multiplication happens before addition.</li>"
    "<li>6 &times; 3 = 18.</li>"
    "<li>5 + 18 = 23.</li>"
    "</ol>",
    [
        "30 &divide; 5 &times; 3 = ?",
        "14 &minus; 8 + 2 = ?",
        "(4 + 3) &times; 2 &minus; 5 = ?",
        "9 + 2 &times; (7 &minus; 4) = ?",
    ],
)

blocks += section(
    "Estimation",
    "<strong>Estimate 62 &times; 19</strong>"
    "<ol>"
    "<li>Round each number to a friendly value: 62 rounds to 60, 19 rounds to 20.</li>"
    "<li>60 &times; 20 = 1,200.</li>"
    "<li>The exact answer should land close to 1,200.</li>"
    "</ol>",
    [
        "Estimate: 288 &divide; 29.",
        "A learner calculates 51 &times; 48 and gets 244. Is this reasonable? Explain your thinking.",
    ],
)

content = make_column(blocks, "Guided Practice")["params"]

h5p_manifest = {
    "title": "Lesson 2 Guided Practice",
    "language": "en",
    "mainLibrary": "H5P.Column",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}
    ],
}

stage = "/tmp/h5p-build/_stage_lesson2_guided"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/lesson2-guided-practice.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}, {len(blocks)} blocks")
