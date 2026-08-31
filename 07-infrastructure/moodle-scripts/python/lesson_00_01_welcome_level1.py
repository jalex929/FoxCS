"""Unit 00 Lesson 0.1 "Welcome to Game Programming I" -- converted 2026-08-30
from shared/unit_00_onboarding_level1/lesson_00_01_welcome/01_instruction.html,
whose journal box used the local-file-download save mechanism. Per Jay:
static HTML can't save to Moodle, so this becomes an H5P Interactive Book
(same pattern as courses/python's Lesson 01.1), with the journal as an
H5P.Essay block that saves server-side instead of downloading a file.
"""
from h5p_book_builder import block_text, block_essay, chapter, build_and_zip

ch1 = chapter([
    block_text("<h2>Your Path This Year</h2><p>Welcome to Game Programming I. Everyone in this course learns <strong>Python</strong> this year, the whole way through. There's no pathway choice to make here, this is your path, and it's a genuinely deep one: by the end of the year, you'll be able to build real, working programs and games from scratch, and you'll be prepared for an industry certification exam.</p><p>This isn't just a Python-syntax class. It's a game design class that happens to use Python as the tool for actually building things. Every unit this year connects the code you're learning to a real idea about how games work and how they're designed to feel a certain way to play.</p>"),
    block_text(
        "<h2>The MDA Framework</h2>"
        "<p>Here's a lens you'll use all year, starting today, well before you've written any real code. It's called <strong>MDA</strong>, and it comes from real game design theory (Hunicke, LeBlanc, and Zubek). It breaks a game down into three connected parts.</p>"
        "<p><strong>Mechanics:</strong> The actual rules and systems of the game. What's literally coded or built. Example: &quot;The player loses 10 health when hit by an enemy&quot; is a Mechanic.</p>"
        "<p><strong>Dynamics:</strong> What actually happens when the Mechanics run and a player interacts with them over time. Example: Because of that health-loss Mechanic, players start playing cautiously near enemies. That cautious behavior is a Dynamic.</p>"
        "<p><strong>Aesthetics:</strong> The emotional experience the player actually has as a result. Example: That cautious behavior might create tension, or a sense of real risk. That feeling is an Aesthetic.</p>"
    ),
    block_text("<h2>Why Learn This Before Any Code</h2><p>You don't need to know how to program yet to start noticing Mechanics, Dynamics, and Aesthetics in games you already play. In fact, that's the point of starting here. By the time you're writing real code later this year, you'll already have language for talking about why a design choice matters, not just how to type it.</p>"),
    block_text("<h2>What's Coming This Year</h2><p>You'll build real programs starting with simple output and working all the way up to a full capstone game project of your own design. Along the way, you'll work toward the <strong>IT Specialist &ndash; Python</strong> certification, a real industry credential. Once that's done, later in the year you'll also get to build 2D games in a tool called MakeCode Arcade, putting everything you've learned to the test in a new way.</p>"),
], "Welcome")

ch2 = chapter([
    block_text("<h2>Journal</h2><p>Pick a game you enjoy. Name one Mechanic (a rule), one Dynamic (something that happens because of that rule), and one Aesthetic (a feeling the game gives you). You'll revisit this answer later in the year. Aim for 50-75 words.</p>"),
    block_essay(
        "<p>Name one Mechanic, one Dynamic, and one Aesthetic from a game you enjoy (50-75 words).</p>",
        "Write your answer here.",
        "Journal: MDA in a Game You Know",
    ),
], "Journal")

build_and_zip([ch1, ch2], "0.1 Welcome to Game Programming I", "/tmp/h5p-build/lesson-00-01-welcome-level1.h5p")
