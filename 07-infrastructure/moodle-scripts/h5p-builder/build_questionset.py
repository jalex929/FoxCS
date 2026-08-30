#!/usr/bin/env python3
"""Build an H5P.QuestionSet (H5P.MultiChoice sub-questions) package from a
plain Python list of question dicts. Reusable across activities -- pass a
different QUESTIONS list / TITLE / OUT_PATH.

Each question dict:
{
  "question": "<p>...</p>",
  "answers": [
      {"text": "<div>...</div>", "correct": True/False, "feedback": "<div>...</div>"},
      ...
  ],
}

No library code is bundled -- relies on H5P.QuestionSet 1.21 and
H5P.MultiChoice 1.16 already being installed server-side (confirmed via the
H5P Content Type Hub sync, see decisions-log.md 2026-08-29).
"""
import json
import uuid
import zipfile
import os
import sys


def build(questions, title, out_path, intro_html, pass_percentage=70):
    content = {
        "introPage": {
            "showIntroPage": True,
            "startButtonText": "Start Quiz",
            "introduction": intro_html,
        },
        "progressType": "dots",
        "passPercentage": pass_percentage,
        "questions": [],
        "texts": {
            "prevButton": "Previous question",
            "previous": "Previous",
            "nextButton": "Next question",
            "next": "Next",
            "finishButton": "Finish",
            "submitButton": "Submit",
            "textualProgress": "Question: @current of @total questions",
            "jumpToQuestion": "Question %d of %total",
            "questionLabel": "Question",
            "readSpeakerProgress": "Question @current of @total",
            "unansweredText": "Unanswered",
            "answeredText": "Answered",
            "currentQuestionText": "Current question",
            "navigationLabel": "Questions",
            "questionSetInstruction": "Choose question to display",
        },
        "disableBackwardsNavigation": False,
        "randomQuestions": False,
        "endGame": {
            "showResultPage": True,
            "showSolutionButton": True,
            "showRetryButton": True,
            "noResultMessage": "Finished",
            "message": "Your Results",
            "amountCorrect": "You got @finals of @totals correct",
            "scoreBarLabel": "You got @finals out of @totals points",
            "scoreHeader": "Score",
            "solutionButtonText": "Show solution",
            "retryButtonText": "Retry",
            "finishButtonText": "Finish",
            "submitButtonText": "Submit",
            "skipButtonText": "Skip video",
        },
        "title": title,
        "metadata": {"title": title},
    }

    for q in questions:
        answers = []
        for a in q["answers"]:
            answers.append({
                "text": a["text"],
                "correct": a["correct"],
                "tipsAndFeedback": {"chosenFeedback": a["feedback"]},
            })
        content["questions"].append({
            "library": "H5P.MultiChoice 1.16",
            "params": {
                "question": q["question"],
                "answers": answers,
                "overallFeedback": [{"from": 0, "to": 100}],
                "UI": {
                    "checkAnswerButton": "Check",
                    "submitAnswerButton": "Submit",
                    "showSolutionButton": "Show solution",
                    "tryAgainButton": "Retry",
                    "tipsLabel": "Show tip",
                    "scoreBarLabel": "You got :num out of :total points",
                    "tipAvailable": "Tip available",
                    "feedbackAvailable": "Feedback available",
                    "readFeedback": "Read feedback",
                    "wrongAnswer": "Wrong answer",
                    "correctAnswer": "Correct answer",
                    "shouldCheck": "Should have been checked",
                    "shouldNotCheck": "Should not have been checked",
                    "noInput": "Please answer before viewing the solution",
                    "a11yCheck": "Check the answers. The responses will be marked as correct, incorrect, or unanswered.",
                    "a11yShowSolution": "Show the solution. The task will be marked with its correct solution.",
                    "a11yRetry": "Retry the task. Reset all responses and start the task over again.",
                },
                "confirmCheck": {
                    "header": "Finish ?",
                    "body": "Are you sure you wish to finish ?",
                    "cancelLabel": "Cancel",
                    "confirmLabel": "Finish",
                },
                "confirmRetry": {
                    "header": "Retry ?",
                    "body": "Are you sure you wish to retry ?",
                    "cancelLabel": "Cancel",
                    "confirmLabel": "Confirm",
                },
                "behaviour": {
                    "enableRetry": True,
                    "enableSolutionsButton": True,
                    "enableCheckButton": True,
                    "type": "auto",
                    "singlePoint": False,
                    "randomAnswers": True,
                    "showSolutionsRequiresInput": True,
                    "confirmCheckDialog": False,
                    "confirmRetryDialog": False,
                    "autoCheck": False,
                    "passPercentage": 100,
                    "showScorePoints": True,
                },
            },
            "subContentId": str(uuid.uuid4()),
            "metadata": {
                "contentType": "Multiple Choice",
                "license": "U",
                "title": "Untitled Multiple Choice",
            },
        })

    h5p_manifest = {
        "title": title,
        "language": "en",
        "mainLibrary": "H5P.QuestionSet",
        "embedTypes": ["div"],
        "preloadedDependencies": [
            {"machineName": "H5P.QuestionSet", "majorVersion": "1", "minorVersion": "21"}
        ],
    }

    stage = "/tmp/h5p-build/_stage_" + os.path.basename(out_path).replace(".h5p", "")
    os.makedirs(stage + "/content", exist_ok=True)
    with open(stage + "/h5p.json", "w") as f:
        json.dump(h5p_manifest, f)
    with open(stage + "/content/content.json", "w") as f:
        json.dump(content, f)

    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        z.write(stage + "/h5p.json", "h5p.json")
        z.write(stage + "/content/content.json", "content/content.json")

    print(f"Built {out_path} ({len(questions)} questions)")


def build_column(blocks, title, out_path):
    """blocks: list of ("text", html) or ("essay", task_description_html, placeholder)."""
    content = {"content": []}
    for block in blocks:
        if block[0] == "text":
            content["content"].append({
                "content": {
                    "library": "H5P.AdvancedText 1.1",
                    "params": {"text": block[1]},
                    "subContentId": str(uuid.uuid4()),
                    "metadata": {"contentType": "Text", "license": "U", "title": "Text"},
                },
                "useSeparator": "auto",
            })
        elif block[0] == "essay":
            _, task_desc, placeholder = block
            content["content"].append({
                "content": {
                    "library": "H5P.Essay 1.5",
                    "params": {
                        "taskDescription": task_desc,
                        "placeholderText": placeholder,
                        "solution": {"introduction": "", "sample": ""},
                        "keywords": [],
                        "overallFeedback": [{"from": 0, "to": 100}],
                        "behaviour": {
                            "inputFieldSize": "10",
                            "enableRetry": False,
                            "ignoreScoring": True,
                            "pointsHost": 1,
                            "linebreakReplacement": " ",
                        },
                        "checkAnswer": "Check",
                        "submitAnswer": "Submit",
                        "tryAgain": "Retry",
                        "showSolution": "Show sample solution",
                        "feedbackHeader": "Feedback",
                        "solutionTitle": "Sample Solution",
                        "remainingChars": "Remaining characters: @chars",
                        "notEnoughChars": "You must enter at least @chars characters!",
                        "messageSave": "saved",
                        "ariaYourResult": "You got @score out of @total points",
                        "ariaNavigatedToSolution": "Navigated to newly included sample solution after textarea.",
                        "ariaCheck": "Check the answers.",
                        "ariaShowSolution": "Show the solution. You will be provided with a sample solution.",
                        "ariaRetry": "Retry the task. You can improve your previous answer if the author allowed that.",
                    },
                    "subContentId": str(uuid.uuid4()),
                    "metadata": {"contentType": "Essay", "license": "U", "title": "Untitled Essay"},
                },
                "useSeparator": "auto",
            })
        else:
            raise ValueError(block[0])

    h5p_manifest = {
        "title": title,
        "language": "en",
        "mainLibrary": "H5P.Column",
        "embedTypes": ["div"],
        "preloadedDependencies": [
            {"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}
        ],
    }

    stage = "/tmp/h5p-build/_stage_" + os.path.basename(out_path).replace(".h5p", "")
    os.makedirs(stage + "/content", exist_ok=True)
    with open(stage + "/h5p.json", "w") as f:
        json.dump(h5p_manifest, f)
    with open(stage + "/content/content.json", "w") as f:
        json.dump(content, f)

    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        z.write(stage + "/h5p.json", "h5p.json")
        z.write(stage + "/content/content.json", "content/content.json")

    print(f"Built {out_path} ({len(blocks)} blocks)")


if __name__ == "__main__":
    print("Import this module and call build(...) or build_column(...)")
