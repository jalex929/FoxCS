"""Seminar III Lesson 2 -- Check: rebuild from the static printable-sheets
lesson-2-check.html (15 MC questions, answer choices were plain <li> text,
no way to select) into a real interactive H5P.Column of MultiChoice items.
Built 2026-09-08 per the FoxCS-wide "response-eliciting content must be
interactive" policy (decisions-log.md, 2026-09-08 entries). Answer key
source: Drive doc "Lesson 2 Answer Key & Rubric (Teacher)". No leading
dash / manual A/B/C/D labels -- H5P.MultiChoice renders its own selectable
options, so the static-list problem doesn't reappear here at all.
enableSolutionsButton stays False on every item (repo-wide standing rule).
Feedback text never names or implies the correct choice for a wrong pick.
"""
import json, os, zipfile
from h5p_book_builder import block_text, block_multichoice, make_column

def mc(question, options, correct_index, feedback):
    # options: list[str]; feedback: list[str] parallel to options, written so
    # NONE of them name/imply the correct answer -- point at the reasoning
    # gap instead ("recheck..."), never "the right answer is/was...".
    answers = [
        (f"<div>{opt}</div>", i == correct_index, feedback[i])
        for i, opt in enumerate(options)
    ]
    return block_multichoice(f"<p>{question}</p>", answers, "Check")

blocks = [
    block_text(
        "<h2>Lesson 2 Check: Numbers and Operations</h2>"
        "<p>Answer each question. You can retry a question after checking it, "
        "and you'll get a similar retry question after class if you miss any.</p>"
    ),

    mc("A hiking trail's lowest point is described as &minus;85 feet. What does the negative sign represent?",
       ["The trail is 85 feet long", "The point is 85 feet below sea level",
        "The point is 85 feet above sea level", "The trail has 85 turns"],
       1,
       ["Length isn't what a negative elevation is describing here -- reread what the number is measuring.",
        "Right -- a negative elevation means below the reference point (sea level).",
        "A positive sign would mean above sea level, not negative -- recheck what the sign means in this context.",
        "The number of turns isn't related to elevation at all -- reread what's being measured."]),

    mc("Which value is greatest?",
       ["&minus;19", "&minus;3", "&minus;27", "&minus;11"],
       1,
       ["On a number line, is this farther left or right than the other choices? Compare positions, not digit size.",
        "Right -- of these, this is closest to zero, so it's the greatest.",
        "This is the farthest left on the number line of the four choices -- it's actually the least, not the greatest.",
        "Compare number-line position to the other three choices before deciding."]),

    mc("What is |&minus;24|?",
       ["&minus;24", "0", "24", "48"],
       2,
       ["Absolute value is never negative -- it's a distance, so it can't come out negative.",
        "Distance from zero for &minus;24 isn't zero -- recheck how far &minus;24 actually is from 0.",
        "Right -- distance from zero, and distance is never negative.",
        "Absolute value doesn't double the number -- it's just the distance from zero."]),

    mc("Evaluate: &minus;9 + 16",
       ["&minus;25", "&minus;7", "7", "25"],
       2,
       ["Check the direction you moved on the number line from &minus;9 -- this treats it like both numbers were negative.",
        "Recheck your subtraction -- try modeling it on a number line starting at &minus;9.",
        "Right.",
        "Recheck the arithmetic -- this adds the absolute values instead of finding the actual sum."]),

    mc("Evaluate: &minus;14 &minus; 8",
       ["&minus;22", "&minus;6", "6", "22"],
       0,
       ["Right.",
        "Subtracting a positive from a negative moves further negative, not closer to zero -- recheck the direction.",
        "The result of subtracting a positive number from a negative number can't be positive here -- recheck the sign.",
        "Recheck the magnitude -- this doesn't match &minus;14 minus 8."]),

    mc("Evaluate: &minus;7 &times; 9",
       ["&minus;63", "&minus;16", "16", "63"],
       0,
       ["Right -- different signs give a negative result.",
        "This looks like addition, not multiplication -- recheck the operation.",
        "Different signs (negative &times; positive) should give a negative result, and the magnitude is off too.",
        "Different signs give a negative result -- recheck the sign of your answer."]),

    mc("Evaluate: &minus;56 &divide; &minus;8",
       ["&minus;7", "&minus;48", "7", "48"],
       2,
       ["Same signs (negative &divide; negative) give a positive result -- recheck the sign.",
        "Recheck the magnitude of the division, not just the sign.",
        "Right -- same signs give a positive result.",
        "Recheck the magnitude -- this doesn't match 56 &divide; 8."]),

    mc("A worker earns $19 per hour and works 6 hours. Which operation finds the total earnings?",
       ["Addition", "Subtraction", "Multiplication", "Division"],
       2,
       ["Combining a rate with a quantity of hours isn't the same as adding two amounts -- reread what's being combined.",
        "Nothing is being taken away here -- reread the situation.",
        "Right -- a rate (per hour) times a quantity (hours) gives a total.",
        "Nothing is being split into groups here -- reread the situation."]),

    mc("A tank starts with 400 gallons and loses 25 gallons per hour. Which calculation finds how many gallons remain after 3 hours?",
       ["400 + 25 &times; 3", "400 &minus; 25 &times; 3", "400 &times; 25 &times; 3", "400 &divide; 25 &divide; 3"],
       1,
       ["The tank is losing water, not gaining it -- recheck which operation matches \"loses.\"",
        "Right -- the total lost (25 per hour &times; 3 hours) gets subtracted from the starting amount.",
        "This would multiply the starting amount by the loss rate and time, which isn't what \"loses\" means here.",
        "This doesn't match a starting amount minus a rate of loss over time -- reread the situation."]),

    mc("Evaluate: 9 + 3 &times; 4",
       ["21", "24", "48", "12"],
       0,
       ["Right -- multiplication before addition.",
        "Recheck the order -- multiplication happens before addition, not after.",
        "This looks like addition was done first and then everything multiplied -- recheck the order of operations.",
        "This looks like a left-to-right read ignoring order of operations -- multiplication comes first."]),

    mc("Evaluate: 40 &divide; 8 &times; 2",
       ["2.5", "10", "20", "320"],
       1,
       ["Multiplication and division have equal priority and go left to right -- recheck which operation you did first.",
        "Right -- left to right: 40 &divide; 8 = 5, then 5 &times; 2 = 10.",
        "Recheck the order -- multiplication and division are done left to right, not multiplication first.",
        "Recheck the operations -- this doesn't match dividing then multiplying left to right."]),

    mc("Which is the best estimate of 68 &times; 31?",
       ["210", "2,100", "21,000", "210,000"],
       1,
       ["This is off by a factor of 10 from a reasonable rounding of 68&times;31 -- recheck your rounding.",
        "Right -- 70 &times; 30 = 2,100.",
        "This is too large by a factor of 10 -- recheck your rounding.",
        "This is far too large -- recheck your rounding and place value."]),

    mc("A learner calculates 32 &times; 19 and gets 6,080. Which statement is best?",
       ["Reasonable, multiplication makes big numbers", "Unreasonable, 30 &times; 20 = 600, so the answer should be close to 600",
        "Unreasonable, the answer must be negative", "There is no way to check without a calculator"],
       1,
       ["\"Multiplication makes big numbers\" isn't a real reasonableness check -- try estimating first.",
        "Right -- estimating first (30&times;20=600) shows 6,080 is off by roughly a factor of 10.",
        "Both factors here are positive, so a negative result was never in question -- that's not the actual problem with 6,080.",
        "Estimation is exactly a way to check without a calculator -- try rounding both factors first."]),

    mc("A checking account has $85. A charge of $102 is processed. What is the new balance?",
       ["&minus;$187", "&minus;$17", "$17", "$187"],
       1,
       ["This adds the two amounts instead of finding the difference -- recheck the operation.",
        "Right -- $85 &minus; $102 = &minus;$17.",
        "The charge is larger than the balance, so the result should be negative -- recheck the sign.",
        "Recheck the operation -- a charge larger than the balance shouldn't give a positive result."]),

    mc("A learner solves 15 &minus; 6 + 4 by adding 6 and 4 first, then subtracting the result from 15, getting 5. What type of error occurred?",
       ["Knowledge", "Process", "Execution", "Comprehension"],
       1,
       ["This isn't about not knowing a rule -- the learner knew addition and subtraction, just not the right order to do them in.",
        "Right -- addition and subtraction have equal priority, left to right; grouping 6+4 first is a procedure/order error.",
        "The arithmetic itself (6+4=10, 15&minus;10=5) was done correctly -- the mistake is in the order of steps, not a calculation slip.",
        "This isn't a misreading of the question -- the learner understood what to compute, just did the steps in the wrong order."]),
]

content = make_column(blocks, "Lesson 2 Check")["params"]

h5p_manifest = {
    "title": "Lesson 2 Check",
    "language": "en",
    "mainLibrary": "H5P.Column",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}
    ],
}

stage = "/tmp/h5p-build/_stage_lesson2_check"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/lesson2-check.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}, {len(blocks)} blocks")
