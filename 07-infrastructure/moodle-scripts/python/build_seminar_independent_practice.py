"""Seminar III 1.5 -- Independent Practice: full rebuild 2026-08-30, same
reason and pattern as build_seminar_guided_practice.py (original "-merged"
package had the groupy-wrapper Essay bug). Content preserved from original.
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
    block = block_essay(task, SENTENCE_FRAME_PLACEHOLDER, "Independent Practice")
    # Deliberately NOT setting solution.introduction/solution.sample -- see
    # the matching comment in build_seminar_guided_practice.py. Populating it
    # shows a student-facing "Show sample solution" button with no way to
    # disable just the button while keeping the text, which conflicts with
    # the no-solution-reveal policy already applied everywhere else.
    # feedbackIncludedWord/feedbackMissedWord are required select fields;
    # "" is not a valid option (valid: keyword/alternative/answer/none and
    # keyword/none respectively) -- empty string caused "Invalid selected
    # option in select" and crashed the whole H5P.Column silently.
    #
    # CORRECTED 2026-09-01: do NOT wrap keywords entries in "groupy" -- that
    # was wrong, confirmed by reading this instance's actual compiled H5P
    # runtime JS (toPoints() in the cached H5P.Essay bundle), which reads
    # keyword.options.occurrences directly with no wrapper. "groupy" is only
    # the installed semantics.json's internal name for the list's field
    # definition, not a key that belongs in stored content JSON. See the
    # matching comment in build_seminar_guided_practice.py for the full story.
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

blocks = [
    block_text("<h2>Apply the Five-Question Routine</h2><p>Type out your answer to each scenario, working through all five questions in your response. No worked example this time, this is independent practice.</p>"),
    essay_with_keyword(
        "<p>A jacket costs $64 and is on sale for 20% off. You have $55. Can you afford it? Work through all five questions in your answer.</p>",
        "<p>STOP: jacket $64, 20% off, you have $55. FIND: whether $55 covers the sale price. CONNECT: percent discount, then subtraction. TRY: discount = 0.20 &times; 64 = 12.80, sale price = 64 &minus; 12.80 = 51.20. CHECK: $51.20 is less than $55, so yes, you can afford it, with $3.80 to spare.</p>",
        "51.20",
    ),
    essay_with_keyword(
        "<p>Your teacher assigns a project with 4 parts, due in 6 days. You can work on it about 45 minutes a day, and the whole project takes about 4 hours. Is that enough time? Work through all five questions in your answer.</p>",
        "<p>STOP: 4 parts, 6 days, 45 minutes a day available, 4 hours (240 minutes) total needed. FIND: whether available time covers the total time needed. CONNECT: multiplication, then comparison. TRY: 45 &times; 6 = 270 minutes available. CHECK: 270 minutes is more than the 240 minutes needed, so yes, there's enough time, with about 30 minutes to spare, as long as all six days are actually used.</p>",
        "270",
    ),
    essay_with_keyword(
        "<p>Station A sells gas for $3.29 a gallon. Station B sells it for $3.15 a gallon but is farther out of your way. For a 10-gallon fill-up, which station saves you more money? Work through all five questions in your answer.</p>",
        "<p>STOP: Station A $3.29/gal, Station B $3.15/gal, 10-gallon fill-up. FIND: which station costs less for the gas itself. CONNECT: multiplication. TRY: Station A = 3.29 &times; 10 = $32.90, Station B = 3.15 &times; 10 = $31.50. CHECK: Station B saves $1.40 on the gas itself. The problem doesn't give enough information (extra distance, exact mileage cost) to factor in the detour precisely, so a complete answer should note that limitation rather than ignore it.</p>",
        "31.50",
    ),
    block_text("<h2>Classify the Error</h2><p>Now practice identifying error types independently.</p>"),
    error_type_question('Asked to compare &minus;12 and &minus;5, a learner says, "I don\'t know which negative number is bigger."', "Knowledge"),
    error_type_question('Asked what the median of a data set is, a learner says, "I\'m not sure what that word means."', "Knowledge"),
    error_type_question("Solving 2 &times; (3 + 4), a learner multiplies 2 &times; 3 = 6 first, then adds 4, getting 10.", "Process"),
    error_type_question("Solving a multi-step equation, a learner subtracts before dividing when division should have come first.", "Process"),
    error_type_question("A learner correctly sets up 15% of 60 as 0.15 &times; 60, then types it into a calculator as 0.15 &times; 6, getting 0.9.", "Execution"),
    error_type_question("Copying an answer from scratch work onto the final response, a learner writes 72 instead of 27.", "Execution"),
    error_type_question("A word problem asks how much change is left from a $20 bill after a purchase. A learner answers with the cost of the purchase itself.", "Comprehension"),
    error_type_question("Reading a bar graph, a learner reports the value for the wrong category because they misread the label.", "Comprehension"),
    error_type_question("A learner redoes a long division problem three times by hand instead of estimating first to check whether the answer is even reasonable.", "Strategy"),
    error_type_question("Given four answer choices, a learner sets up and solves a full equation instead of testing which choice actually works.", "Strategy"),
]

content = make_column(blocks, "Independent Practice")["params"]

h5p_manifest = {
    "title": "1.5 -- Independent Practice",
    "language": "en",
    "mainLibrary": "H5P.Column",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}
    ],
}

stage = "/tmp/h5p-build/_stage_independent_practice"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/independent-practice-1-5.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
