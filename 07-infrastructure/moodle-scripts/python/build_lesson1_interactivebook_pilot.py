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
    block_text("<h2>Computers Are Very Literal</h2><p>This matters because computers are extremely literal. A computer does not guess what you probably meant. It does exactly what the instructions say, no more, no less. That's not a limitation to work around, it's the whole reason programs are useful. If a computer improvised, you couldn't trust it to do the same thing twice.</p><p><strong>Real-World Example: a vending machine is a program too.</strong> A vending machine takes your money, checks whether you inserted enough, then either releases the item or shows an error. Every one of those checks and decisions was written ahead of time by a programmer as an exact instruction: &quot;<strong>if</strong> the amount inserted is less than the price, <strong>then</strong> do not release the item.&quot; The machine isn't deciding anything in the moment. It's following instructions someone else already wrote, the same way a program running on any computer does.</p>"),
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
    ("Practice: The Game Connection", "<p>In a video game, a player's health reaches zero and a &quot;Game Over&quot; screen appears. Who decided that this exact thing should happen?</p>", [
        ("<div>A programmer wrote that exact instruction ahead of time</div>", True, "<div>Right! Nothing in a game happens by magic or by the game &quot;wanting&quot; something. A programmer wrote the instruction for it, the same way the vending machine's instructions were written ahead of time.</div>"),
        ("<div>The game decides on its own, in the moment</div>", False, "<div>Games don't decide anything on their own. Re-read the Game Connection section above.</div>"),
        ("<div>The player caused it by losing</div>", False, "<div>Losing triggers the instruction, but a programmer is the one who wrote what happens when it's triggered.</div>"),
        ("<div>It happens automatically, without anyone writing it</div>", False, "<div>Nothing in a program happens without someone writing the instruction for it first.</div>"),
    ]),
    ("Practice: Applying What You Know", "<p>A classmate says, &quot;A recipe and a computer program aren't really that similar, a recipe is just words on paper.&quot; What's the best response, based on this lesson?</p>", [
        ("<div>They're similar in the way that matters: both are exact, ordered steps that produce the same result every time they're followed.</div>", True, "<div>Right! The comparison isn't about paper vs. computer, it's about the structure: exact, ordered steps.</div>"),
        ("<div>Your classmate is right, they have nothing in common.</div>", False, "<div>Think back to the very first section of this lesson. What did it say a recipe and a program actually share?</div>"),
        ("<div>They're similar because both take a long time to make.</div>", False, "<div>Time has nothing to do with why a recipe and a program were compared in this lesson.</div>"),
        ("<div>They're similar because both are written by professionals.</div>", False, "<div>Who wrote them isn't the point of the comparison in this lesson.</div>"),
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
    block_text("<h2>Project: Design a Program</h2><p>A short applied task. You haven't learned real Python syntax yet (that starts in Lesson 01.3), so this project applies this lesson's big idea directly: a program is an exact, ordered set of instructions. You'll write that set of instructions yourself, in plain English, for a system of your choice.</p><p>Pick <strong>one</strong> real-world system that runs on a program, other than the vending machine from this lesson (an ATM, a microwave, a traffic light, an alarm clock, or a simple game mechanic like a jump button are all good choices). Write out the exact, numbered instructions a computer would need to follow to run it.</p>"),
    block_text(
        "<h2>How to Write an &quot;If This, Then That&quot; Instruction</h2>"
        "<p>Some instructions only happen when something is true. These are called <strong>conditional instructions</strong>, and every one of them has exactly two parts:</p>"
        "<p><strong>IF</strong> part: name the exact thing being checked.</p>"
        "<p><strong>THEN</strong> part: say exactly what happens as a result.</p>"
        "<p>Put together, the pattern reads: <strong>If</strong> [something is true], <strong>then</strong> [this happens].</p>"
        "<h3>Example You've Already Seen</h3>"
        "<p>The vending machine instruction from earlier in this lesson uses this exact pattern: &quot;<strong>If</strong> the amount inserted is less than the price, <strong>then</strong> do not release the item.&quot; The <strong>IF</strong> part is &quot;the amount inserted is less than the price.&quot; The <strong>THEN</strong> part is &quot;do not release the item.&quot;</p>"
        "<h3>A New Example</h3>"
        "<p>Here's the same pattern for a different system, an alarm clock: &quot;<strong>If</strong> the current time matches the alarm time, <strong>then</strong> sound the alarm.&quot; Same two parts: one specific thing to check, one specific thing that happens.</p>"
        "<p>Your project needs at least one instruction shaped exactly like this, for whatever system you choose.</p>"
    ),
    block_text("<h2>Requirements</h2><ul><li>Name the system you chose in one sentence. It cannot be the vending machine from this lesson.</li><li>Write at least 5 numbered instructions, each exact enough that someone unfamiliar with your system could follow it without guessing.</li><li>Include at least one &quot;if this, then that&quot; instruction (see above), naming one specific thing to check and one specific thing that happens as a result.</li><li>No vague steps like &quot;do the right thing&quot; or &quot;handle it&quot;. Every instruction says exactly what happens.</li></ul>"),
    block_essay(
        "<p>Write your numbered instruction list here (at least 5 steps, including one &quot;if this, then that&quot; instruction). Name your system in your first line.</p>",
        "Type your numbered instructions here.",
        "Design a Program: Your Instructions",
    ),
], "Project")

# ---- Chapter 6: Mastery Check ----
# NOTE: the real (repo) mastery check is password-gated by the teacher and
# auto-timestamps unlock/completion (see 07_mastery_check.html) -- H5P has no
# equivalent mechanism for either (no way to run a password gate or write a
# timestamp inside a content package), so this book version is the same 4
# questions with neither. This is a real, known gap in this format, not an
# oversight -- flagged for Jay's decision, not silently dropped.
ch6 = chapter([
    block_text("<h2>Mastery Check</h2><p>Four questions checking your understanding of this lesson. Answer each one in your own words.</p>"),
    block_essay(
        "<p>1. Explain, in your own words, what a program is. Use an example from everyday life that is <em>not</em> a video game and <em>not</em> a calculator app.</p>",
        "Type your answer here.",
        "Mastery Check: What Is a Program?",
    ),
    block_essay(
        "<p>2. A vending machine takes your money, checks whether you inserted enough, and then either gives you the item or shows an error. Describe at least one specific instruction you think must exist somewhere inside the vending machine's program for this to work.</p>",
        "Type your answer here.",
        "Mastery Check: The Vending Machine's Instructions",
    ),
    block_essay(
        "<p>3. A friend tells you, &quot;Computers are smart. They figure things out on their own.&quot; Based on what you learned in this lesson, do you agree or disagree? Explain your answer using the word <em>instruction</em>.</p>",
        "Type your answer here.",
        "Mastery Check: Are Computers Smart?",
    ),
    block_essay(
        "<p>4. Explain what a programming language like Python is for, and why a programmer needs one to make a computer do something.</p>",
        "Type your answer here.",
        "Mastery Check: What Python Is For",
    ),
], "Mastery Check")

# ---- Chapter 7: Feedback ----
ch7 = chapter([
    block_text("<h2>Feedback</h2><p>2-3 minutes. This is about the lesson, not about grading you. Your honest answers help decide what changes for next time.</p>"),
    block_essay(
        "<p>1. How clear was it what you were being asked to do in this lesson? Rate 1-5 (1 = confusing, 5 = totally clear), then explain. If any part was unclear, describe what it was.</p>",
        "Type your rating and answer here.",
        "Feedback: Clarity",
    ),
    block_essay(
        "<p>2. How difficult was this lesson for you? Rate 1-5 (1 = too easy, 5 = too difficult), then explain. What part felt the most difficult, if any?</p>",
        "Type your rating and answer here.",
        "Feedback: Difficulty",
    ),
    block_essay(
        "<p>3. How interesting did this lesson feel to you? Rate 1-5 (1 = not interesting, 5 = very interesting).</p>",
        "Type your rating here.",
        "Feedback: Interest",
    ),
    block_essay(
        "<p>4. This lesson taught 4 words: <code>program</code>, <code>instruction</code>, <code>programmer</code>, <code>Python</code>. Name any that you still find hard to explain in your own words, or write &quot;none&quot; if you can explain all 4.</p>",
        "Type your answer here.",
        "Feedback: Which Terms Are Still Hard?",
    ),
    block_essay(
        "<p>5. What part of this lesson felt the most rewarding, or helped you learn the most? Give a specific example.</p>",
        "Type your answer here.",
        "Feedback: What Helped Most",
    ),
], "Feedback")

content = {
    "showCoverPage": False,
    "chapters": [ch1, ch2, ch3, ch4, ch5, ch6, ch7],
    # "page" is the counter-label word shown with the chapter position (e.g.
    # "X of Y" / "X/Y" depending on theme). Left at its H5P default ("Page")
    # this duplicated each chapter's own on-page title in the counter, which
    # Jay flagged as confusing (2026-08-30) -- a distinct, generic label reads
    # more clearly than the chapter's own name repeated back at it.
    "page": "Learning Activities",
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
