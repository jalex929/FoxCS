"""Game of the Week Lesson 1 (Telephone), rebuilt 2026-08-31 as a 2-page H5P
Interactive Book per Jay's restructure request, replacing the old 2-module
split (a plain HTML "How to Play + Explanation" resource, cmid 173, plus a
separate H5P.Column reflection, cmid 172).

Page 1 -- How to Play ONLY. Meant to be read before playing the game live in
class; deliberately has zero concept explanation so it doesn't spoil what
students are about to notice for themselves.

Page 2 -- Understanding the Game. Meant to be read AFTER playing. A real,
accessible article (not a 2-sentence gloss) on information transfer and
breakdown points, written for students with zero game-design vocabulary yet
(same "lean, not a lecture, but not thin either" bar as the rest of Unit 0),
grounded in named, concrete game examples per Jay's request 2026-08-31,
followed immediately by the same 3 reflection questions from
build_gotw_week01_reflection.py (unchanged wording), submitted server-side
via block_essay -- reflections must never require a local save, per the
2026-08-31 standing rule.

Style rule (Jay, 2026-08-31, a repeat ask): no em dashes anywhere in
FoxCS content. Use commas, periods, colons, or parentheses instead. Checked
this whole file by hand for em dashes -- there should be none.

Deploys as one new h5pactivity, replacing cmid 184 (the first version of
this book, built before the em-dash/game-examples revision).
"""
from h5p_book_builder import block_text, block_essay, chapter, build_and_zip

# ---- Page 1: How to Play ----
ch1 = chapter([
    block_text(
        "<h2>Lesson 1: Telephone</h2>"
        "<p>Sit in a line or circle. Your teacher whispers a short message to the first person. That person "
        "whispers exactly what they heard to the next person, and so on down the line. No repeating, no asking to "
        "check. The last person says out loud what they heard. Then compare it to the original message.</p>"
        "<p>That's it. Play a round or two before you come back here.</p>"
    ),
], "1. How to Play")

# ---- Page 2: Understanding the Game (article) + Reflect ----
ch2 = chapter([
    block_text(
        "<h2>Understanding Telephone</h2>"
        "<p>You just watched a short message fall apart over a handful of whispers. That wasn't bad luck, and it "
        "wasn't someone goofing around. It's actually the whole point of the game, and it's a real thing that "
        "happens constantly in games, and everywhere else information moves between people or parts of a "
        "system.</p>"

        "<h3>What Is Information Transfer?</h3>"
        "<p><strong>Information transfer</strong> just means something, a message, an idea, an instruction, "
        "moving from one place to another. It sounds simple, but almost nothing transfers perfectly.</p>"
        "<p>Take Mario Kart. When you use an item like a shell or a banana, your console has to send that "
        "information to every other player's console: what item, thrown by who, headed where. In local "
        "multiplayer, that transfer is nearly instant. Online, it has to travel across the internet first, and "
        "that trip is where things can go wrong.</p>"
        "<p>Or take a game like Overcooked, where two players are cooking together in a tiny, chaotic kitchen. "
        "One player has to tell the other \"chop the onions, I've got the pan,\" out loud, over the sound of the "
        "game and everyone yelling. That's information transfer too, just between two people instead of two "
        "computers.</p>"

        "<h3>What Is a Breakdown Point?</h3>"
        "<p>A <strong>breakdown point</strong> is one specific step in that chain where the transfer can actually "
        "go wrong. In Telephone, every single whisper is its own breakdown point. One person mishears a word, or "
        "repeats it slightly wrong, and that small change gets passed on and often grows bigger by the time it "
        "reaches the end of the line.</p>"
        "<p>Back to Mario Kart: if your internet connection is slow, that shell's position has to be estimated "
        "for a moment instead of received in real time. Sometimes the estimate is wrong, and you'll see a kart "
        "suddenly \"jump\" or a shell hit you when it looked like it missed. That jump is a breakdown point, "
        "played out on screen in real time.</p>"
        "<p>In Overcooked, the breakdown point is usually simpler: the room is loud, your partner mishears "
        "\"chop\" as \"drop,\" and now there are onions all over the floor. Same idea as Telephone, just with a "
        "kitchen instead of a whispered sentence.</p>"
        "<p>Good designers spend real time hunting for breakdown points before players ever find them. A few more "
        "examples: an icon on screen that two different players read two different ways, or instructions that "
        "make total sense to the person who wrote them but confuse a first time player. None of these are \"the "
        "player's fault.\" They're breakdown points the designer didn't catch yet.</p>"

        "<h3>Why This Actually Matters</h3>"
        "<p>The lesson isn't \"communication is hard, oh well.\" It's that breakdown points are usually "
        "predictable if you actually look for them. The earlier one shows up in a chain, the bigger its effect "
        "tends to be by the end. Notice how one early mishearing in Telephone can leave the very last person with "
        "a sentence that shares almost nothing with the original. That's true whether you're passing a whispered "
        "message down a line, or passing a player's move through the internet to another player's screen.</p>"
    ),
    block_text(
        "<h2>Reflect: Telephone</h2>"
        "<p>Answer all three below, then click Check on each. Your answers save automatically. No need to "
        "download or save a file.</p>"
    ),
    block_essay(
        "What's the most interesting thing you noticed about how the message changed as it moved down the line?",
        "Type your answer here.",
        "Reflection 1",
    ),
    block_essay(
        "Describe a different way a breakdown point could show up in a game, a place where something could get "
        "\"lost\" between one part of the game and another. Starter: \"One breakdown point in a game could happen "
        "when ___, because ___.\"",
        "Type your answer here.",
        "Reflection 2",
    ),
    block_essay(
        "Can you think of another game, video game, board game, sport, anything, where information has to "
        "transfer from one player or one part of the system to another? What's the connection? Starter: \"___ "
        "also depends on information transfer because ___.\"",
        "Type your answer here.",
        "Reflection 3",
    ),
], "2. Understanding the Game")

build_and_zip([ch1, ch2], "Lesson 1: Telephone", "/tmp/h5p-build/gotw-lesson01-telephone-book.h5p")
