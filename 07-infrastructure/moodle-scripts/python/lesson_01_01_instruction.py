"""Lesson 01.1 "What Programs Do" -- Instruction module only.

Trimmed 2026-08-30 from build_lesson1_interactivebook_pilot.py, per Jay's
decision: the pilot bundled Instruction + Flashcards + Vocab Quiz + Practice
+ Project + Mastery Check + Feedback into one H5P Interactive Book, which
predates and doesn't match the locked 4-module architecture (see root
CLAUDE.md). This script keeps only the book's real job -- concept, vocab,
vocab quiz, guided examples -- and drops Practice/Project/Mastery
Check/Feedback content entirely, since those are now built as their own
separate activities (BranchingScenario, mod_assign, mod_quiz).

Content itself (chapters 1-3) is unchanged from the pilot -- it was screened
for accuracy 2026-08-30 and came back clean (see decisions-log.md).
"""
from h5p_book_builder import block_text, block_multichoice, block_dialogcards, block_questionset, chapter, build_and_zip

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
        "Question 1",
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
        "Question 2",
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
    block_questionset([
        (f"<p>Which term matches: &quot;{d}&quot;</p>", [
            (f"<div>{t}</div>", t == correct_term, "<div>Check the definitions again.</div>" if t != correct_term else "<div>Correct!</div>")
            for t in ["program", "instruction", "programmer", "Python"]
        ])
        for (correct_term, d) in [
            ("program", "A set of step-by-step instructions a computer follows, in order."),
            ("instruction", "A single step in a program that tells the computer exactly what to do."),
            ("programmer", "A person who writes the instructions that make up a program."),
            ("Python", "A programming language, a tool for writing instructions in a form a computer can carry out."),
        ]
    ], "Vocab Quiz"),
], "Vocab Quiz")

build_and_zip([ch1, ch2, ch3], "01.1 What Programs Do", "/tmp/h5p-build/lesson-01-01-instruction.h5p")
