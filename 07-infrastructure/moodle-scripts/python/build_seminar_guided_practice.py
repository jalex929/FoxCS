"""Seminar III 1.4 -- Guided Practice: full rebuild 2026-08-30 using the
proven h5p_book_builder helpers, replacing the original "-merged" package
which had a real structural bug (each Essay's "keywords" array wrapped in an
erroneous extra "groupy" key) that crashed H5P.Column's constructor and
rendered the ENTIRE activity empty. Content itself (tasks, sample answers,
keywords, questions, feedback) is preserved from the original -- only the
JSON structure is rebuilt clean.
"""
import json, os, zipfile
from h5p_book_builder import block_text, block_essay, block_multichoice, make_column

SENTENCE_FRAME_PLACEHOLDER = (
    "STOP: I know...\n"
    "FIND: I'm solving for...\n"
    "CONNECT: I'll use...\n"
    "TRY: (show your work)\n"
    "CHECK: ...so my answer makes sense because..."
)

def essay_with_keyword(task, sample, keyword):
    block = block_essay(task, SENTENCE_FRAME_PLACEHOLDER, "Guided Practice")
    # Deliberately NOT setting solution.introduction/solution.sample here.
    # H5P.Essay's "Show sample solution" button is gated purely on
    # solution.sample being non-empty (confirmed in the compiled runtime:
    # handleButtons() does `if (this.params.solution.sample && !this.solution)
    # this.showButton('show-solution')` -- no separate enable/disable flag
    # exists). Populating it reveals the answer on demand, which conflicts
    # with the same no-solution-reveal policy already applied to MultiChoice
    # everywhere else in this content (enableSolutionsButton: False, see
    # decisions-log). `sample` stays a parameter so call sites don't need to
    # change, it's just unused now.
    # "groupy" is H5P.Essay's real (oddly-named) list-item field per its
    # installed semantics.json -- not an authoring error, do not strip it.
    # feedbackIncludedWord/feedbackMissedWord are required select fields;
    # "" is not a valid option (valid: keyword/alternative/answer/none and
    # keyword/none respectively) -- empty string caused "Invalid selected
    # option in select" and crashed the whole H5P.Column silently.
    #
    # CORRECTED 2026-09-01: the "groupy" wrapper above was wrong -- confirmed
    # by reading this instance's actual compiled H5P runtime JS (toPoints()
    # in the cached H5P.Essay bundle), which reads keyword.options.occurrences
    # directly with NO wrapper. The installed semantics.json names the list's
    # "field" definition "groupy", but that's the editor schema's internal
    # name for the field type, not a key that belongs in the stored content
    # JSON. Wrapping in "groupy" passed CLI-level JSON/H5P-import validation
    # but crashed the real player ("Cannot read properties of undefined
    # (reading 'occurrences')"), taking down the whole Column with it -- an
    # empty activity with no error shown to the student. Caught live in
    # Chrome via console errors, not by any server-side check. This same
    # unwrap was already identified once before in patch_fix_essay_groupy.py
    # -- this rebuild had regressed it back in.
    block["content"]["params"]["keywords"] = [{
        "keyword": keyword, "alternatives": [],
        "options": {"points": 1, "occurrences": 1, "caseSensitive": False, "feedbackIncludedWord": "none", "feedbackMissedWord": "none"},
    }]
    return block

ERROR_TYPES = ["Knowledge", "Process", "Execution", "Comprehension", "Strategy"]
ERROR_DEFS = {
    "Knowledge": "not knowing or remembering something needed",
    "Process": "the right idea, but steps done wrong or out of order",
    "Execution": "the right idea and steps, with a small slip carrying it out",
    "Comprehension": "misunderstanding what the question was actually asking",
    "Strategy": "understanding it, but picking an inefficient approach",
}

def error_type_question(scenario, correct_type):
    answers = []
    for t in ERROR_TYPES:
        if t == correct_type:
            fb = f"This is {ERROR_DEFS[t]}, which is exactly a {t} Error."
        else:
            fb = f"Not this one. {t} Error means {ERROR_DEFS[t]}. Try: reread the five error types above and compare this scenario to each one carefully."
        answers.append((f"<div>{t}</div>", t == correct_type, fb))
    return block_multichoice(f"<p>{scenario} Which error type BEST describes this?</p>", answers, "Classify the Error")

FIVE_QUESTION_REFERENCE = (
    '<div style="border:2px solid #0f6cbf;border-radius:8px;padding:0.9rem 1.1rem;'
    'background:#eaf3fb;margin-bottom:1rem;">'
    '<h3 style="margin-top:0;">Reference: The Five-Question Routine</h3>'
    '<p style="margin-bottom:0.5rem;">Keep this open while you work. You do not need to memorize it.</p>'
    '<ol style="margin:0;padding-left:1.2rem;">'
    '<li><strong>STOP</strong> &mdash; What do I know?</li>'
    '<li><strong>FIND</strong> &mdash; What am I solving for?</li>'
    '<li><strong>CONNECT</strong> &mdash; What tool fits?</li>'
    '<li><strong>TRY</strong> &mdash; Do the math.</li>'
    '<li><strong>CHECK</strong> &mdash; Does it make sense?</li>'
    '</ol></div>'
)

blocks = [
    block_text(FIVE_QUESTION_REFERENCE),
    block_text("<h2>Using the Five-Question Routine</h2><p>Work through the worked example below together first. Then type out your own answer to each problem, working through all five questions in your response.</p>"),
    block_text(
        "<div class='worked'><strong>Worked Example: Do I have enough time?</strong> You have 3 chores left, taking about 30, 45, and 20 minutes. Practice starts in 2 hours."
        "<ol>"
        "<li><strong>STOP: What information do I have?</strong> Three chores: 30, 45, 20 minutes. Two hours (120 minutes) until practice.</li>"
        "<li><strong>FIND: What am I actually solving for?</strong> Whether the total chore time fits inside the available time.</li>"
        "<li><strong>CONNECT: What tool applies?</strong> Addition, then comparison.</li>"
        "<li><strong>TRY: Do the math.</strong> 30 + 45 + 20 = 95 minutes.</li>"
        "<li><strong>CHECK: Does the answer make sense?</strong> 95 minutes is less than 120 minutes, so yes, there's enough time, with 25 minutes to spare.</li>"
        "</ol></div>"
    ),
    essay_with_keyword(
        "<p>A school trip costs $18 per learner. 24 learners are going. The school has a $350 budget. Is the budget enough? Work through all five questions in your answer.</p>",
        "<p>STOP: $18 per learner, 24 learners, $350 budget. FIND: whether the total cost fits the budget. CONNECT: multiplication to find the total cost. TRY: 18 &times; 24 = 432. CHECK: $432 is more than the $350 budget, so it is NOT enough. The trip costs $82 more than the budget.</p>",
        "432",
    ),
    essay_with_keyword(
        "<p>A recipe calls for 3/4 cup of sugar per batch. You want to make 2 batches. How much sugar do you need? Work through all five questions in your answer.</p>",
        "<p>STOP: 3/4 cup per batch, 2 batches. FIND: total sugar needed. CONNECT: multiplication. TRY: 3/4 &times; 2 = 6/4 = 1 1/2. CHECK: doubling a little more than half a cup should land a little over a cup, which matches.</p>",
        "1 1/2",
    ),
    essay_with_keyword(
        "<p>You need to be at work by 5:00 PM. It takes 25 minutes to get ready and 15 minutes to drive there. What time should you start getting ready? Work through all five questions in your answer.</p>",
        "<p>STOP: 25 minutes to get ready, 15 minutes to drive, need to arrive by 5:00 PM. FIND: what time to start getting ready. CONNECT: addition, then subtracting from the arrival time. TRY: 25 + 15 = 40 minutes total, 5:00 minus 40 minutes = 4:20 PM. CHECK: starting at 4:20 and using 40 minutes lands right at 5:00.</p>",
        "4:20",
    ),
    block_text(
        "<h2>Classifying the Error</h2>"
        "<div class='worked'><strong>Worked Example:</strong> A learner solves 9 &minus; 4 + 2 and answers 3, working it as: 4 + 2 = 6, then 9 &minus; 6 = 3."
        "<ol><li>The learner added before subtracting, which changed the order of operations. Addition and subtraction have equal priority and should be done left to right: 9 - 4 = 5, then 5 + 2 = 7.</li>"
        "<li>The idea (combine the numbers using the operations shown) wasn't wrong, but the order the steps were done in was wrong.</li>"
        "<li>This is a <strong>Process Error</strong>: the right general idea, with the steps done out of order.</li></ol></div>"
    ),
    block_text("<h2>Classify the Error</h2><p>Now practice identifying error types.</p>"),
    error_type_question("A question asks how many more books Group A read than Group B. A learner reports the combined total read by both groups instead.", "Comprehension"),
    error_type_question('Asked to find 10% of 150, a learner says, "I don\'t remember how to find a percent of a number."', "Knowledge"),
    error_type_question("A learner correctly sets up 6 &times; 7, then writes the answer as 48.", "Execution"),
    error_type_question("On a multiple-choice problem, a learner spends 8 minutes solving a complicated equation by hand when testing the four answer choices would take under a minute.", "Strategy"),
    error_type_question("A learner adds &minus;6 + 9 and answers &minus;15.", "Knowledge"),
]

content = make_column(blocks, "Guided Practice")["params"]

h5p_manifest = {
    "title": "1.4 -- Guided Practice",
    "language": "en",
    "mainLibrary": "H5P.Column",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}
    ],
}

stage = "/tmp/h5p-build/_stage_guided_practice"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/guided-practice-1-4.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
