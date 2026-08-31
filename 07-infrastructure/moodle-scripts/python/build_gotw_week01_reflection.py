"""Game of the Week Lesson 1 (Telephone) -- Reflect section, rebuilt as a
server-saved H5P activity. Originally shipped as client-side
showSaveFilePicker textareas (carried over from _TEMPLATE_reference.html's
now-superseded distribution model) -- Jay added a standing rule 2026-08-31
that reflections must be submittable without a local save. Same 3 questions
as the original HTML page, unchanged, just re-platformed onto H5P.Essay via
h5p_book_builder's proven block_essay (same pattern already used for Game
I's onboarding-book journal entry this session).
"""
from h5p_book_builder import block_text, block_essay, make_column, build_and_zip

blocks = [
    block_text("<h2>Reflect: Telephone</h2><p>Answer all three below, then click Submit on each. Your answers save automatically -- no need to download or save a file.</p>"),
    block_essay(
        "What's the most interesting thing you noticed about how the message changed as it moved down the line?",
        "Type your answer here.",
        "Reflection 1",
    ),
    block_essay(
        "Describe a different way a breakdown point could show up in a game -- a place where something could get \"lost\" between one part of the game and another. Starter: \"One breakdown point in a game could happen when ___, because ___.\"",
        "Type your answer here.",
        "Reflection 2",
    ),
    block_essay(
        "Can you think of another game -- video game, board game, sport, anything -- where information has to transfer from one player or one part of the system to another? What's the connection? Starter: \"___ also depends on information transfer because ___.\"",
        "Type your answer here.",
        "Reflection 3",
    ),
]

column = make_column(blocks, "Reflect: Telephone")
content = column["params"]

h5p_manifest = {
    "title": "Reflect: Telephone (Lesson 1)",
    "language": "en",
    "mainLibrary": "H5P.Column",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}
    ],
}

import json, os, zipfile
stage = "/tmp/h5p-build/_stage_gotw_week01_reflection"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/gotw-week01-reflection.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
