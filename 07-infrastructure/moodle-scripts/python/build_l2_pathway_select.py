"""Shared Game II/Web II onboarding course "Choose Your Pathway" -- a real,
single, server-submitted selection question (Web Dev / Game Design/Unity /
Software Dev / Undecided), separate from the informal pathway_quiz.html
page. Same pattern as build_seminar3_pathway_select.py -- standalone
H5P.MultiChoice so Jay can pull results from Moodle directly. All 4 answers
are marked correct -- this is a self-report survey question, not a graded
assessment, so no option should read as "wrong."
"""
from h5p_book_builder import block_multichoice
import json, os, zipfile

content_block = block_multichoice(
    "<p><strong>Which pathway are you choosing right now?</strong> This isn't locked in -- you can revisit it with your teacher any time this year.</p>",
    [
        ("<div>Web Dev</div>", True, "<div>Got it -- thanks for letting your teacher know.</div>"),
        ("<div>Game Design/Unity</div>", True, "<div>Got it -- thanks for letting your teacher know.</div>"),
        ("<div>Software Dev</div>", True, "<div>Got it -- thanks for letting your teacher know. Remember Software Dev builds on Web Dev's foundation, so you'll start there.</div>"),
        ("<div>Undecided -- I need more time</div>", True, "<div>That's okay -- you can choose later. Talk to your teacher about your timeline.</div>"),
    ],
    "Choose Your Pathway",
)
content = content_block["content"]["params"]
content["behaviour"]["enableRetry"] = False
content["behaviour"]["singlePoint"] = True

h5p_manifest = {
    "title": "Choose Your Pathway",
    "language": "en",
    "mainLibrary": "H5P.MultiChoice",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.MultiChoice", "majorVersion": "1", "minorVersion": "16"}
    ],
}

stage = "/tmp/h5p-build/_stage_l2_pathway_select"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/l2-pathway-select.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
