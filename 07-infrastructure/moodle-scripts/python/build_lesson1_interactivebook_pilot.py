import sys, json, uuid, zipfile, os

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
                    "enableRetry": True, "enableSolutionsButton": True, "enableCheckButton": True,
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

def block_essay(task_desc, placeholder, title):
    return {
        "content": {
            "library": "H5P.Essay 1.5",
            "params": {
                "taskDescription": task_desc,
                "placeholderText": placeholder,
                "solution": {"introduction": "", "sample": ""},
                "keywords": [],
                "overallFeedback": [{"from": 0, "to": 100}],
                "behaviour": {"inputFieldSize": "10", "enableRetry": False, "ignoreScoring": True, "pointsHost": 1, "linebreakReplacement": " "},
                "checkAnswer": "Check", "submitAnswer": "Submit", "tryAgain": "Retry",
                "showSolution": "Show sample solution", "feedbackHeader": "Feedback",
                "solutionTitle": "Sample Solution", "remainingChars": "Remaining characters: @chars",
                "notEnoughChars": "You must enter at least @chars characters!", "messageSave": "saved",
                "ariaYourResult": "You got @score out of @total points",
                "ariaNavigatedToSolution": "Navigated to solution.", "ariaCheck": "Check.",
                "ariaShowSolution": "Show the solution.", "ariaRetry": "Retry.",
            },
            "subContentId": str(uuid.uuid4()),
            "metadata": {"contentType": "Essay", "license": "U", "title": title},
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
    # group with exactly one field (here, "chapters"'s single "chapter" field),
    # so the list item must be the bare Column library object directly.
    # Confirmed by reading h5p.classes.php's validateGroup() after a silent
    # content-stripping bug, not guessed. The title is what shows in the
    # book's table of contents / chapter nav -- give every chapter a real
    # one, "Column" is H5P's own generic class-name fallback and looks
    # broken to a viewer (Jay flagged this directly, 2026-08-30).
    return make_column(blocks, title)


# ---- Chapter 1: Instruction ----
ch1 = chapter([
    block_text("<h2>What Is a Program?</h2><p>A <strong>program</strong> is a set of step-by-step instructions that a computer follows, exactly, in order. That's the whole idea. Everything else you learn this year is really just learning more powerful ways to write those instructions.</p><p>Think about a recipe. A recipe doesn't just say &quot;make dinner.&quot; It breaks the task into exact steps: preheat the oven, chop the onion, add two cups of water. A cook who has never seen the dish before can still follow it, step by step, and produce the same result every time. A program does the same thing for a computer: it breaks a task into exact steps the computer can follow without needing to understand why, only what.</p>"),
    block_multichoice(
        "<p>A recipe and a computer program are similar because they are both ___.</p>",
        [
            ("<div>a set of exact, ordered steps</div>", True, "<div>Right! Both a recipe and a program are exact, ordered steps that produce the same result every time they're followed.</div>"),
            ("<div>something only an expert can understand</div>", False, "<div>Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.</div>"),
            ("<div>a list of ingredients or tools</div>", False, "<div>Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.</div>"),
            ("<div>a finished result, like a meal or a working app</div>", False, "<div>Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.</div>"),
        ],
        "Quick Check: What Is a Program?",
    ),
    block_text("<h2>Computers Are Very Literal</h2><p>This matters because computers are extremely literal. A computer does not guess what you probably meant. It does exactly what the instructions say, no more, no less. That's not a limitation to work around, it's the whole reason programs are useful. If a computer improvised, you couldn't trust it to do the same thing twice.</p><p><strong>Real-World Example: a vending machine is a program too.</strong> A vending machine takes your money, checks whether you inserted enough, then either releases the item or shows an error. Every one of those checks and decisions was written ahead of time by a programmer as an exact instruction: &quot;if the amount inserted is less than the price, do not release the item.&quot; The machine isn't deciding anything in the moment. It's following instructions someone else already wrote, the same way a program running on any computer does.</p>"),
    block_multichoice(
        "<p>A program's instructions say to add two numbers, but the programmer wrote the wrong numbers by mistake. What will the computer display when the program runs?</p>",
        [
            ("<div>The result of the instructions exactly as written, mistake included</div>", True, "<div>Right! The computer follows the instructions exactly as written. It has no way to know what the programmer &quot;really&quot; meant, only what was actually written down.</div>"),
            ("<div>The result the programmer actually meant to get</div>", False, "<div>Remember the vending machine example: the machine doesn't decide anything on its own.</div>"),
            ("<div>An automatic correction of the mistake</div>", False, "<div>Remember the vending machine example: the machine doesn't decide anything on its own.</div>"),
            ("<div>Nothing, because the computer will notice the mistake and stop on its own</div>", False, "<div>Remember the vending machine example: the machine doesn't decide anything on its own.</div>"),
        ],
        "Quick Check: Computers Are Literal",
    ),
    block_text("<h2>Where Python Fits In</h2><p><strong>Python</strong> is a programming language: a tool humans use to write instructions in a form a computer can actually carry out. There are many programming languages, the same way there are many spoken languages. They're different ways of writing the same kind of thing: precise, step-by-step instructions.</p><p><strong>Game Connection: every game you've ever played is a program.</strong> A game is a (very large) set of instructions: when the player presses this button, move the character that direction; when health reaches zero, show the game-over screen. Nothing in a game happens by magic or by the game &quot;wanting&quot; something to happen. Somewhere, a programmer wrote the exact instruction for it. This whole course is about learning to write those instructions yourself, starting from the smallest possible piece.</p>"),
    block_text("<h2>Key Terms</h2><p><strong>program:</strong> A set of step-by-step instructions a computer follows, in order. Think of it like a recipe.</p><p><strong>instruction:</strong> A single step in a program that tells the computer exactly what to do. Think of it like one line in a recipe.</p><p><strong>programmer:</strong> A person who writes the instructions that make up a program. Think of it like the person who writes a recipe.</p><p><strong>Python:</strong> A programming language, a tool for writing instructions in a form a computer can carry out. The one this course uses.</p>"),
], "Instruction")

# ---- Chapter 2: Flashcards ----
ch2 = chapter([
    block_text("<h2>Flashcards</h2><p>Click each card to flip it and check your answer. Review these before the vocab quiz.</p>"),
    block_dialogcards("Unit 01.1 Key Terms", [
        ("program", "A set of step-by-step instructions a computer follows, in order. Example: a calculator app, a video game, a weather app."),
        ("instruction", "A single step in a program that tells the computer exactly what to do. Example: &quot;display this message.&quot;"),
        ("programmer", "A person who writes the instructions that make up a program."),
        ("Python", "A programming language: a tool for writing instructions in a form a computer can carry out. The one this course uses."),
    ]),
], "Flashcards")

# ---- Chapter 3: Vocab Quiz ----
ch3 = chapter([
    block_text("<h2>Vocab Quiz</h2><p>Match each term to its correct definition.</p>"),
    {
        "content": {
            "library": "H5P.QuestionSet 1.21",
            "params": {
                "introPage": {"showIntroPage": False, "startButtonText": "Start", "introduction": ""},
                "progressType": "dots", "passPercentage": 70,
                "questions": [
                    block_multichoice(f"<p>Which term matches: &quot;{d}&quot;</p>", [
                        (f"<div>{t}</div>", t == correct_term, "<div>Check the definitions again.</div>" if t != correct_term else "<div>Correct!</div>")
                        for t in ["program", "instruction", "programmer", "Python"]
                    ], f"Vocab: {correct_term}")["content"]
                    for (correct_term, d) in [
                        ("program", "A set of step-by-step instructions a computer follows, in order."),
                        ("instruction", "A single step in a program that tells the computer exactly what to do."),
                        ("programmer", "A person who writes the instructions that make up a program."),
                        ("Python", "A programming language, a tool for writing instructions in a form a computer can carry out."),
                    ]
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
                    "showResultPage": True, "showSolutionButton": True, "showRetryButton": True,
                    "noResultMessage": "Finished", "message": "Your Results", "amountCorrect": "You got @finals of @totals correct",
                    "scoreBarLabel": "You got @finals out of @totals points", "scoreHeader": "Score",
                    "solutionButtonText": "Show solution", "retryButtonText": "Retry", "finishButtonText": "Finish",
                    "submitButtonText": "Submit", "skipButtonText": "Skip video",
                },
                "title": "Vocab Quiz",
            },
            "subContentId": str(uuid.uuid4()),
            "metadata": {"contentType": "Question Set", "license": "U", "title": "Vocab Quiz"},
        },
        "useSeparator": "auto",
    },
], "Vocab Quiz")

# ---- Chapter 4: Practice ----
practice_qs = [
    ("Practice: What Is a Program?", "<p>Which of these best describes what a program is?</p>", [
        ("<div>A set of step-by-step instructions a computer follows in order</div>", True, "<div>Right! A program is a set of exact, ordered instructions a computer follows.</div>"),
        ("<div>A device that thinks for itself</div>", False, "<div>Not quite. A computer doesn't think for itself. It follows instructions someone else wrote.</div>"),
        ("<div>Any file stored on a computer</div>", False, "<div>Not quite. Some files (like a photo) aren't programs. A program specifically runs instructions.</div>"),
        ("<div>A description of what a computer looks like</div>", False, "<div>Not quite. That describes hardware, not what a program actually does.</div>"),
    ]),
    ("Practice: The Programmer", "<p>The person who writes the instructions that make up a program is called a ______.</p>", [
        ("<div>programmer</div>", True, "<div>Right!</div>"),
        ("<div>user</div>", False, "<div>A user runs a program. The person who writes it is the programmer.</div>"),
        ("<div>computer</div>", False, "<div>The computer follows the instructions, it doesn't write them.</div>"),
        ("<div>operator</div>", False, "<div>Look again at this lesson's Key Terms.</div>"),
    ]),
    ("Practice: An Instruction", "<p>A single step in a program that tells the computer exactly what to do is called an ______.</p>", [
        ("<div>instruction</div>", True, "<div>Right!</div>"),
        ("<div>output</div>", False, "<div>Output is what a program displays. Look again at this lesson's Key Terms.</div>"),
        ("<div>error</div>", False, "<div>An error means something went wrong, not a normal step.</div>"),
        ("<div>program</div>", False, "<div>A program is the whole set of steps. This question asks about just one step.</div>"),
    ]),
    ("Practice: How Programs Run", "<p>When a computer runs a program, it ___.</p>", [
        ("<div>follows the instructions exactly as written</div>", True, "<div>Right! The computer follows the instructions exactly as written, every time.</div>"),
        ("<div>thinks about what the programmer probably meant</div>", False, "<div>Remember: computers are very literal. Re-read that section above.</div>"),
        ("<div>randomly chooses what to do next</div>", False, "<div>Remember: computers are very literal. Re-read that section above.</div>"),
        ("<div>asks the programmer for help</div>", False, "<div>Remember: computers are very literal. Re-read that section above.</div>"),
    ]),
    ("Practice: The Vending Machine", "<p>A vending machine's program includes this instruction: &quot;If the amount inserted is less than the price, do not release the item.&quot; A student inserts less than the price. What will the machine do?</p>", [
        ("<div>Follow its instructions and not release the item</div>", True, "<div>Right! The machine just follows its instructions, exactly as written.</div>"),
        ("<div>Release the item anyway, since it can tell what the student wants</div>", False, "<div>The machine can't tell what anyone &quot;wants.&quot; It only follows its instructions.</div>"),
        ("<div>Guess how much more money is needed and release the item halfway</div>", False, "<div>The machine can't tell what anyone &quot;wants.&quot; It only follows its instructions.</div>"),
        ("<div>Ignore the instruction if it seems unfair</div>", False, "<div>The machine can't tell what anyone &quot;wants.&quot; It only follows its instructions.</div>"),
    ]),
    ("Practice: Programming Languages", "<p>Python is an example of a programming ______.</p>", [
        ("<div>language</div>", True, "<div>Right!</div>"),
        ("<div>computer</div>", False, "<div>Python isn't a computer, it's a tool for writing instructions.</div>"),
        ("<div>program</div>", False, "<div>Python isn't itself a program, it's the language programs get written in.</div>"),
        ("<div>company</div>", False, "<div>Look again at this lesson's Key Terms.</div>"),
    ]),
    ("Practice: Not a Program", "<p>Which of these is the best reason a printed book is not a computer program?</p>", [
        ("<div>A book doesn't run or follow instructions on a computer</div>", True, "<div>Right! A program is something a computer runs. A book isn't run by anything.</div>"),
        ("<div>A book is too long to be a program</div>", False, "<div>Length has nothing to do with whether something is a program.</div>"),
        ("<div>A book doesn't have page numbers</div>", False, "<div>Length has nothing to do with whether something is a program.</div>"),
        ("<div>A book was written by an author, not a programmer</div>", False, "<div>The real reason is about what a book actually does (or doesn't do), not who wrote it.</div>"),
    ]),
]

ch4 = chapter([
    block_text("<h2>Practice</h2><p>Answer each question, checking your understanding of this lesson's key ideas.</p>"),
    {
        "content": {
            "library": "H5P.QuestionSet 1.21",
            "params": {
                "introPage": {"showIntroPage": False, "startButtonText": "Start", "introduction": ""},
                "progressType": "dots", "passPercentage": 70,
                "questions": [block_multichoice(q, a, t)["content"] for (t, q, a) in practice_qs],
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
                    "showResultPage": True, "showSolutionButton": True, "showRetryButton": True,
                    "noResultMessage": "Finished", "message": "Your Results", "amountCorrect": "You got @finals of @totals correct",
                    "scoreBarLabel": "You got @finals out of @totals points", "scoreHeader": "Score",
                    "solutionButtonText": "Show solution", "retryButtonText": "Retry", "finishButtonText": "Finish",
                    "submitButtonText": "Submit", "skipButtonText": "Skip video",
                },
                "title": "Practice",
            },
            "subContentId": str(uuid.uuid4()),
            "metadata": {"contentType": "Question Set", "license": "U", "title": "Practice"},
        },
        "useSeparator": "auto",
    },
], "Practice")

# ---- Chapter 5: Project ----
ch5 = chapter([
    block_text("<h2>Project: Design a Program</h2><p>A short applied task. You haven't learned real Python syntax yet (that starts in Lesson 01.3), so this project applies this lesson's big idea directly: a program is an exact, ordered set of instructions. You'll write that set of instructions yourself, in plain English, for a system of your choice.</p><p>Pick <strong>one</strong> real-world system that runs on a program, other than the vending machine from this lesson (an ATM, a microwave, a traffic light, an alarm clock, or a simple game mechanic like a jump button are all good choices). Write out the exact, numbered instructions a computer would need to follow to run it.</p><p><strong>Requirements:</strong> name your system in one sentence; write at least 5 numbered instructions, each exact enough that someone unfamiliar with your system could follow it without guessing; include at least one instruction that checks something and behaves differently depending on the answer (an &quot;if this, then that&quot; moment); no vague steps like &quot;do the right thing.&quot;</p>"),
    block_essay(
        "<p>Write your numbered instruction list here (at least 5 steps, including one &quot;if this, then that&quot; check). Name your system in your first line.</p>",
        "Type your numbered instructions here.",
        "Design a Program: Your Instructions",
    ),
], "Project")

# ---- Chapter 6: What's Next ----
ch6 = chapter([
    block_text("<h2>What's Next</h2><p>Nice work finishing this lesson's reading and practice. Two more things to do, outside this book:</p><p><strong>Mastery Check:</strong> a short password-gated check your teacher will unlock, with your answers written in a paired file. Ask your teacher for the current password.</p><p><strong>Feedback:</strong> a quick 2-3 minute form about how this lesson went for you.</p>"),
], "What's Next")

content = {
    "showCoverPage": False,
    "chapters": [ch1, ch2, ch3, ch4, ch5, ch6],
    "behaviour": {
        "baseColor": "#1a5aa8",
        "defaultTableOfContents": True,
        "progressIndicators": True,
        "progressAuto": True,
        "displaySummary": True,
        "enableRetry": True,
    },
}

h5p_manifest = {
    "title": "01.1 What Programs Do (Interactive Book Pilot)",
    "language": "en",
    "mainLibrary": "H5P.InteractiveBook",
    "embedTypes": ["div"],
    "preloadedDependencies": [
        {"machineName": "H5P.InteractiveBook", "majorVersion": "1", "minorVersion": "15"}
    ],
}

stage = "/tmp/h5p-build/_stage_lesson1_ibook_pilot"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(content, f)

out_path = "/tmp/h5p-build/lesson1-interactivebook-pilot.h5p"
with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")

print(f"Built {out_path}, {len(content['chapters'])} chapters")
