"""Shared H5P Interactive Book building blocks, extracted from
build_lesson1_interactivebook_pilot.py (2026-08-30) so every lesson's real,
trimmed Instruction-only book (concept + vocab + vocab quiz, per the locked
4-module architecture -- see root CLAUDE.md) reuses the same tested block
functions instead of copy-pasting them per lesson.

Practice, Project, and Mastery Check + Feedback are NOT built here -- those
are a separate BranchingScenario, a native mod_assign, and a native mod_quiz
respectively, per the architecture decision. This module only builds the
Instruction module's Interactive Book.
"""
import json, uuid, zipfile, os


def block_text(html):
    return {
        "content": {
            "library": "H5P.AdvancedText 1.1",
            "params": {"text": html},
            "subContentId": str(uuid.uuid4()),
            "metadata": {"contentType": "Text", "license": "U", "title": "Text"},
        },
        "useSeparator": "auto",
    }


def block_multichoice(question, answers, title):
    # answers: list of (text_html, correct_bool, feedback_html)
    return {
        "content": {
            "library": "H5P.MultiChoice 1.16",
            "params": {
                "question": question,
                "answers": [
                    {"text": t, "correct": c, "tipsAndFeedback": {"chosenFeedback": f}}
                    for (t, c, f) in answers
                ],
                "overallFeedback": [{"from": 0, "to": 100}],
                "behaviour": {
                    # enableSolutionsButton stays False everywhere -- Jay
                    # decided students should not be able to reveal the
                    # correct answer without actually reasoning it out
                    # (see decisions-log.md / commit history on the
                    # original Show-Solution-button removal).
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
            },
            "subContentId": str(uuid.uuid4()),
            "metadata": {"contentType": "Multiple Choice", "license": "U", "title": title},
        },
        "useSeparator": "auto",
    }


def block_dialogcards(title, dialogs):
    return {
        "content": {
            "library": "H5P.Dialogcards 1.9",
            "params": {
                "title": title,
                "mode": "normal",
                "description": "Click a card to flip it and see the answer.",
                "dialogs": [{"text": q, "answer": a} for (q, a) in dialogs],
                "behaviour": {"scaleTextNotCard": False, "randomCards": False, "disableBackwardsNavigation": False},
                "answer": "Turn", "next": "Next", "prev": "Previous", "retry": "Retry",
                "correctAnswer": "Correct", "incorrectAnswer": "Incorrect",
                "round": "Round @round", "cardsLeft": "Cards left: @number",
                "nextRound": "Next round", "startOver": "Start over",
                "showSummary": "Show summary", "summary": "Summary",
                "summaryCardsRight": "Cards you got right:", "summaryCardsWrong": "Cards you got wrong:",
                "summaryCardsNotShown": "Cards in pool not shown:", "summaryOverallScore": "Overall Score",
                "summaryCardsCompleted": "Cards you have completed learning:",
                "summaryCompletedRounds": "Completed rounds:", "summaryAllDone": "Well done! You have mastered all cards!",
                "progressText": "Card @card of @total", "cardFrontLabel": "Card front",
                "cardBackLabel": "Card back", "tipButtonLabel": "Show tip",
                "audioNotSupported": "Your browser does not support this audio",
            },
            "subContentId": str(uuid.uuid4()),
            "metadata": {"contentType": "Dialog Cards", "license": "U", "title": title},
        },
        "useSeparator": "auto",
    }


def block_questionset(questions, title, pass_percentage=70):
    # questions: list of (question_html, answers) tuples, answers as in block_multichoice
    return {
        "content": {
            "library": "H5P.QuestionSet 1.21",
            "params": {
                "introPage": {"showIntroPage": False, "startButtonText": "Start", "introduction": ""},
                "progressType": "dots", "passPercentage": pass_percentage,
                "questions": [
                    block_multichoice(q, a, f"Question {i}")["content"]
                    for i, (q, a) in enumerate(questions, 1)
                ],
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
                "title": title,
            },
            "subContentId": str(uuid.uuid4()),
            "metadata": {"contentType": "Question Set", "license": "U", "title": title},
        },
        "useSeparator": "auto",
    }


def make_column(blocks, title):
    return {
        "library": "H5P.Column 1.22",
        "params": {"content": blocks},
        "subContentId": str(uuid.uuid4()),
        "metadata": {"contentType": "Column", "license": "U", "title": title},
    }


def chapter(blocks, title):
    # NOTE: no "chapter" wrapper key -- H5P's validateGroup() auto-flattens a
    # group with exactly one field (here, "chapters"'s single "chapter"
    # field), so the list item must be the bare Column library object
    # directly. Confirmed by reading h5p.classes.php's validateGroup() after
    # a silent content-stripping bug, not guessed. Give every chapter a real
    # title -- it shows in the book's table of contents / chapter nav, and
    # H5P's generic "Column" fallback looks broken to a viewer.
    return make_column(blocks, title)


def build_and_zip(chapters, book_title, out_path, base_color="#1a5aa8"):
    content = {
        "showCoverPage": False,
        "chapters": chapters,
        # "page" is the counter-label word shown with the chapter position
        # (e.g. "X of Y"). Left at its H5P default ("Page") this duplicated
        # each chapter's own on-page title in the counter -- Jay flagged
        # this as confusing (2026-08-30) -- a distinct, generic label reads
        # more clearly than the chapter's own name repeated back at it.
        "page": "Learning Activities",
        "behaviour": {
            "baseColor": base_color,
            "defaultTableOfContents": True,
            "progressIndicators": True,
            "progressAuto": True,
            "displaySummary": True,
            "enableRetry": True,
        },
    }
    h5p_manifest = {
        "title": book_title,
        "language": "en",
        "mainLibrary": "H5P.InteractiveBook",
        "embedTypes": ["div"],
        "preloadedDependencies": [
            {"machineName": "H5P.InteractiveBook", "majorVersion": "1", "minorVersion": "15"}
        ],
    }
    stage = "/tmp/h5p-build/_stage_" + os.path.basename(out_path).replace(".h5p", "")
    os.makedirs(stage + "/content", exist_ok=True)
    with open(stage + "/h5p.json", "w") as f:
        json.dump(h5p_manifest, f)
    with open(stage + "/content/content.json", "w") as f:
        json.dump(content, f)
    os.makedirs(os.path.dirname(out_path), exist_ok=True)
    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        z.write(stage + "/h5p.json", "h5p.json")
        z.write(stage + "/content/content.json", "content/content.json")
    print(f"Built {out_path}, {len(content['chapters'])} chapters")
