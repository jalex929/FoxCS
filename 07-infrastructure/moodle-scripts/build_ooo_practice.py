"""Seminar III Lesson 1: "1.4 Order of Operations Practice" -- rebuild
2026-08-30 per Jay, replacing the old single sequencing exercise (1.4) and
folding the old standalone "1.5 Sequence a Real-World Problem" activity in
as one of five practice questions instead of its own activity. 1.2's
five-question-routine sequencing exercise was removed outright per Jay
("let's go ahead and remove the sequence problems for five questions").

Difficulty progresses across the 5 fixed questions (simple -> real-world
application -> harder), rather than true response-reactive branching --
Jay asked for genuinely adaptive branching (harder/easier based on live
answers), and this is NOT that. FoxCS's own established architecture for
real adaptive routing is Moodle's native Lesson activity (mod_lesson), not
a fixed H5P question set -- see 02-authoring-system/objectives-and-skills-
proficiency.md's Reinforce/Core/Extend Ladder section. Building that
properly (branch pages, per-answer jump targets) is a real, separate build
this file does not attempt, flagged directly rather than faked with a
non-adaptive set dressed up as adaptive.

The two easiest questions carry an H5P "tip" (shown on request, before
checking, never revealing the answer) giving process guidance for students
who are stuck -- per Jay's explicit "more guidance about how to approach
solving without giving answers... intended to help people get unstuck."
"""
import json, os, zipfile, uuid

def mc_with_tip(question, answers, tip=None):
    # answers: list of (text, correct_bool, feedback)
    params = {
        "question": question,
        "answers": [
            {
                "text": f"<div>{text}</div>",
                "correct": correct,
                "tipsAndFeedback": {"chosenFeedback": f"<div>{feedback}</div>"},
            }
            for (text, correct, feedback) in answers
        ],
        "overallFeedback": [{"from": 0, "to": 100}],
        "behaviour": {
            "enableRetry": True, "enableSolutionsButton": False, "enableCheckButton": True,
            "type": "auto", "singlePoint": False, "randomAnswers": True,
            "showSolutionsRequiresInput": True, "confirmCheckDialog": False,
            "confirmRetryDialog": False, "autoCheck": False, "passPercentage": 100,
            "showScorePoints": True,
        },
        "UI": {
            "checkAnswerButton": "Check", "submitAnswerButton": "Submit",
            "showSolutionButton": "Show solution", "tryAgainButton": "Retry",
            "tipsLabel": "Show tip", "scoreBarLabel": "You got :num out of :total points",
            "tipAvailable": "Tip available", "feedbackAvailable": "Feedback available",
            "readFeedback": "Read feedback", "wrongAnswer": "Wrong answer",
            "correctAnswer": "Correct answer", "shouldCheck": "Should have been checked",
            "shouldNotCheck": "Should not have been checked",
            "noInput": "Please answer before viewing the solution",
            "a11yCheck": "Check the answers.", "a11yShowSolution": "Show the solution.",
            "a11yRetry": "Retry the task.",
        },
        "confirmCheck": {"header": "Finish ?", "body": "Are you sure?", "cancelLabel": "Cancel", "confirmLabel": "Finish"},
        "confirmRetry": {"header": "Retry ?", "body": "Are you sure?", "cancelLabel": "Cancel", "confirmLabel": "Confirm"},
    }
    if tip:
        for a in params["answers"]:
            a["tipsAndFeedback"]["tip"] = f"<div>{tip}</div>"
    return {
        "library": "H5P.MultiChoice 1.16",
        "params": params,
        "subContentId": str(uuid.uuid4()),
        "metadata": {"contentType": "Multiple Choice", "license": "U", "title": "Question"},
    }

QUESTIONS = [
    # Q1 -- simple, with a process tip (no answer given away)
    mc_with_tip(
        "<p>(4 + 2) &times; 3 = ?</p>",
        [
            ("18", True, "Right! Parentheses first: 4 + 2 = 6, then 6 &times; 3 = 18."),
            ("14", False, "This is what you'd get by doing 4 + (2 &times; 3) instead -- check which operation the parentheses actually group."),
            ("9", False, "This mixes up the order somewhere -- redo it one step at a time."),
            ("20", False, "Double check each step separately before combining them."),
        ],
        tip="Whatever is inside the parentheses always gets solved completely first, before anything outside them.",
    ),
    # Q2 -- simple, with a process tip
    mc_with_tip(
        "<p>10 &minus; 2 &times; 3 = ?</p>",
        [
            ("4", True, "Right! Multiplication before subtraction: 2 &times; 3 = 6, then 10 - 6 = 4."),
            ("24", False, "This is what you'd get working strictly left to right -- order of operations doesn't always mean left to right."),
            ("8", False, "Check which operation should actually happen first here."),
            ("1", False, "Redo the multiplication step by itself first, then come back to the subtraction."),
        ],
        tip="Multiplication and division always happen before addition and subtraction, even if the subtraction is written first.",
    ),
    # Q3 -- the former standalone "sequence a real-world problem" activity,
    # now folded in as one question in this set, per Jay directly.
    mc_with_tip(
        "<p>A recipe calls for 4 cups of flour per batch. You're making 2 batches, and you want to split all of the flour evenly between 4 storage containers. How much flour goes in each container?</p>",
        [
            ("2 cups", True, "Right! Total flour: 4 &times; 2 = 8 cups. Split into 4 containers: 8 &divide; 4 = 2 cups each."),
            ("4 cups", False, "This is the flour for one batch, not the total split across all 4 containers -- find the total first, then divide."),
            ("8 cups", False, "This is the total flour before splitting it into containers -- the question asks for the amount per container."),
            ("1 cup", False, "Check both steps separately: total flour first (batches &times; cups per batch), then divide by the number of containers."),
        ],
    ),
    # Q4 -- harder, exponents mixed in
    mc_with_tip(
        "<p>3 + 2<sup>2</sup> &times; (5 &minus; 1) = ?</p>",
        [
            ("19", True, "Right! Parentheses: 5 - 1 = 4. Exponent: 2² = 4. Then 4 &times; 4 = 16, and 3 + 16 = 19."),
            ("35", False, "Check the order: parentheses, then the exponent, then multiplication, then addition -- one step at a time."),
            ("13", False, "Something got skipped or done out of order -- work through parentheses, exponent, multiplication, addition, in that order."),
            ("22", False, "Redo the exponent step by itself before combining it with anything else."),
        ],
    ),
    # Q5 -- hardest, multi-step nested
    mc_with_tip(
        "<p>(6 + 2) &divide; 2<sup>2</sup> &times; 3 &minus; 1 = ?</p>",
        [
            ("5", True, "Right! (6+2)=8, 2²=4, 8&divide;4=2, 2&times;3=6, 6-1=5."),
            ("11", False, "Check the order carefully: parentheses, then exponent, then division and multiplication left to right, then subtraction last."),
            ("2", False, "This stops partway through -- there are more steps after the division."),
            ("47", False, "This looks like the subtraction happened before the division/multiplication -- redo it step by step."),
        ],
    ),
]

content = {
    "introPage": {"showIntroPage": False, "startButtonText": "Start", "introduction": ""},
    "progressType": "dots", "passPercentage": 70,
    "questions": QUESTIONS,
    "texts": {
        "prevButton": "Previous question", "previous": "Previous", "nextButton": "Next question",
        "next": "Next", "finishButton": "Finish", "submitButton": "Submit",
        "textualProgress": "Question: @current of @total questions", "jumpToQuestion": "Question %d of %total",
        "questionLabel": "Question", "readSpeakerProgress": "Question @current of @total",
        "unansweredText": "Unanswered", "answeredText": "Answered", "currentQuestionText": "Current question",
        "navigationLabel": "Questions", "questionSetInstruction": "Choose question to display",
    },
    "disableBackwardsNavigation": False, "randomQuestions": False,
    "endGame": {
        "showResultPage": True, "showSolutionButton": False, "showRetryButton": True,
        "noResultMessage": "Finished", "message": "Your Results", "amountCorrect": "You got @finals of @totals correct",
        "scoreBarLabel": "You got @finals out of @totals points", "scoreHeader": "Score",
        "solutionButtonText": "Show solution", "retryButtonText": "Retry", "finishButtonText": "Finish",
        "submitButtonText": "Submit", "skipButtonText": "Skip video",
    },
    "title": "Order of Operations Practice",
}

h5p_manifest = {
    "title": "1.4 -- Order of Operations Practice",
    "language": "en",
    "mainLibrary": "H5P.QuestionSet",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.QuestionSet", "majorVersion": "1", "minorVersion": "21"}
    ],
}

stage = "/tmp/h5p-build/_stage_ooo_practice"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/ooo-practice-1-4.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print(f"Built {out_path}")
