"""Unit 00 Lesson 0.5.2 Vocab Quiz -- REPLACES the broken H5P.DragQuestion
attempt (build_dragquestion_vocab.py), which rendered empty in the real
Moodle player. That content type's exact schema couldn't be verified without
live browser testing, which isn't available here, so guessing further at it
risked shipping another broken activity. Falls back to the same
term-matches-definition MultiChoice format already proven working end-to-end
for Python's own vocab quiz (see lesson_01_01_instruction.py) -- not true
drag-and-drop, but reliable. Revisit H5P.DragQuestion later with real visual
testing if the drag-and-drop interaction specifically matters enough to
debug properly.
"""
from h5p_book_builder import block_questionset, build_and_zip
import json, os, zipfile

TERMS = [
    ("Decomposition", "Breaking a big problem into smaller, more manageable pieces."),
    ("Pattern recognition", "Noticing similarities between a new problem and something you've seen before."),
    ("Abstraction", "Focusing on the details that actually matter for the problem you're solving, and ignoring the ones that don't."),
    ("Algorithmic thinking", "Describing a solution as a clear, ordered series of steps."),
]

questions = []
for correct_term, definition in TERMS:
    options = [
        (f"<div>{t}</div>", t == correct_term,
         "<div>Correct!</div>" if t == correct_term else "<div>Check the definitions again.</div>")
        for t, _ in TERMS
    ]
    questions.append((f"<p>Which term matches: &quot;{definition}&quot;</p>", options))

content_block = block_questionset(questions, "Vocab Quiz: Computational Thinking")
content = content_block["content"]["params"]

h5p_manifest = {
    "title": "0.5.2 Vocab Quiz: Computational Thinking",
    "language": "en",
    "mainLibrary": "H5P.QuestionSet",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.QuestionSet", "majorVersion": "1", "minorVersion": "21"}
    ],
}

stage = "/tmp/h5p-build/_stage_vocab_matching_00_05"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/vocab-matching-00-05.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
