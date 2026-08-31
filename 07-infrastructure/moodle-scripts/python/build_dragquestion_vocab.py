"""Builds a standalone H5P.DragQuestion activity: drag each term onto its
matching definition. Replaces the hand-built drag/click-to-match HTML quiz
(shared/unit_00_onboarding_level*/lesson_00_05_computational_thinking/
02_vocab_quiz.html) that saved progress via local file download -- Jay
confirmed 2026-08-30 he specifically likes THIS quiz's drag-and-drop style
better than multiple choice, so the goal here is to keep the same
interaction while getting it onto a Moodle-native, server-saved surface
(H5P.DragQuestion, installed and confirmed available on this instance).

x/y/width/height are percentages of the task's own "size" (not pixels) --
confirmed against H5P.DragQuestion 1.15's real schema, not guessed.
"""
import json, uuid, zipfile, os

TERMS = [
    ("Decomposition", "Breaking a big problem into smaller, more manageable pieces."),
    ("Pattern recognition", "Noticing similarities between a new problem and something you've seen before."),
    ("Abstraction", "Focusing on the details that actually matter for the problem you're solving, and ignoring the ones that don't."),
    ("Algorithmic thinking", "Describing a solution as a clear, ordered series of steps."),
]

def text_type(html):
    return {
        "library": "H5P.AdvancedText 1.1",
        "params": {"text": html},
        "subContentId": str(uuid.uuid4()),
        "metadata": {"contentType": "Text", "license": "U"},
    }

elements = []
dropzones = []
row_height = 20
row_gap = 2.5
for i, (term, definition) in enumerate(TERMS):
    y = 2 + i * (row_height + row_gap)
    elements.append({
        "x": 2, "y": y, "width": 26, "height": row_height,
        "dropZones": [str(i)],
        "type": text_type(f"<div style=\"display:flex;align-items:center;justify-content:center;height:100%;background:#1a5aa8;color:#fff;font-weight:bold;font-family:Verdana,Arial,sans-serif;border-radius:6px;text-align:center;padding:0.3em;\">{term}</div>"),
        "backgroundOpacity": 0,
        "multiple": False,
    })
    dropzones.append({
        "x": 32, "y": y, "width": 64, "height": row_height,
        "correctElements": [str(i)],
        "label": f"<div style=\"font-family:Georgia,serif;\">{definition}</div>",
        "showLabel": True,
        "backgroundOpacity": 5,
        "tipsAndFeedback": {"tip": "", "chosenFeedback": "", "notChosenFeedback": ""},
        "single": True,
        "autoAlign": False,
    })

content = {
    "question": {
        "settings": {
            "background": None,
            "size": {"width": 620, "height": (row_height + row_gap) * len(TERMS) + 20},
            "singlePoint": False,
            "postUserStatistics": True,
            "enableRetry": True,
            "enableSolutionsButton": False,
            "enableCheckButton": True,
            "preventResize": False,
            "displaySolutionsRequiresInput": True,
            "showScorePoints": True,
            "goodScoreFeedback": True,
            "scoreShow": "Check",
            "dropZoneHighlighting": "dragging",
            "autoAlignSpacing": 2,
            "applyPenalties": True,
        },
        "task": {"elements": elements, "dropZones": dropzones},
    },
    "overallFeedback": [{"from": 0, "to": 100, "feedback": "You matched @score of @total!"}],
    "behaviour": {"enableRetry": True},
}

h5p_manifest = {
    "title": "0.5.2 Vocab Quiz: Computational Thinking",
    "language": "en",
    "mainLibrary": "H5P.DragQuestion",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.DragQuestion", "majorVersion": "1", "minorVersion": "15"}
    ],
}

stage = "/tmp/h5p-build/_stage_dragquestion_vocab"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/dragquestion-vocab-00-05.h5p"
os.makedirs(os.path.dirname(out_path), exist_ok=True)
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
