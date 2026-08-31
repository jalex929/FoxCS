"""Seminar III "Choose Your Pathway" -- a real, single, server-submitted
selection question (Workforce Readiness / College Prep / Dual Enrollment /
Undecided), separate from the informal personality-style pathway_quiz.html
page. Built as a standalone H5P.MultiChoice so Jay can pull results from
Moodle directly instead of relying on a client-side page. All 4 answers are
marked correct -- this is a self-report survey question, not a graded
assessment, so no option should read as "wrong."
"""
from h5p_book_builder import block_multichoice
import json, os, zipfile

content_block = block_multichoice(
    "<p><strong>Which pathway are you choosing right now?</strong> This isn't locked in -- you can revisit it with your teacher any time this year.</p>",
    [
        ("<div>Workforce Readiness</div>", True, "<div>Got it -- thanks for letting your teacher know.</div>"),
        ("<div>College Prep</div>", True, "<div>Got it -- thanks for letting your teacher know.</div>"),
        ("<div>Dual Enrollment (with College Prep as backup)</div>", True, "<div>Got it -- remember Dual Enrollment doesn't run the whole period every day, so College Prep covers the rest of that time.</div>"),
        ("<div>Undecided -- I need more time</div>", True, "<div>That's okay -- you can choose later. Talk to your teacher about your timeline.</div>"),
    ],
    "Choose Your Pathway",
)
content = content_block["content"]["params"]
# Not a real quiz -- disable retry/check chrome that implies right/wrong scoring.
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

stage = "/tmp/h5p-build/_stage_seminar3_pathway_select"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/seminar3-pathway-select.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
