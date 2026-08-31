"""Unit 0 (Game I / Level 1) consolidated Interactive Book.

Built 2026-08-31 per Jay's direct request to stop the Unit 0 content from
being fragmented across 3 separate Moodle modules (the combined multi-page
HTML resource + two standalone H5P activities, "0.5.2 Vocab Quiz" and
"0.8.2 Academic Integrity Check", dropped in separately). This folds all of
it into ONE H5P Interactive Book, chapter-per-lesson, using the same tested
h5p_book_builder.py blocks as lesson_01_01_instruction.py (Unit 01's real,
working book) -- not hand-authored from scratch.

Content for chapters 1-8 is reflowed from the real, already-approved lesson
prose in shared/unit_00_onboarding_level1/lesson_00_0{1-8}_*/01_instruction.html
-- substance unchanged, just stripped of the standalone-page-only chrome
(unit nav menu, decorative SVG diagrams, journal local-file-save JS, custom
CSS classes with no meaning inside H5P.AdvancedText) and reflowed into plain
semantic HTML. The 0.1 journal becomes a block_essay (matching how the
rest of this book already handles free response) instead of the old
save-to-file textarea.

CORRECTION mid-build (2026-08-31): Jay added a rule to omit any mention of
the MDA framework (Mechanics/Dynamics/Aesthetics) anywhere in Unit 0 --
introduce it starting in Unit 1 instead. The source lesson_00_01_welcome
page is documented elsewhere in this repo as giving "the full MDA framework
intro" for this Level 1 edition; that entire MDA section (the 3-part
breakdown + its journal prompt) was NOT ported here. Chapter 1 below is
rewritten to keep Welcome's real purpose (orienting a new student, setting
expectations) without naming or explaining MDA at all, and the journal
prompt was changed from an MDA-based reflection to a plain what-do-you-want-
to-understand-about-a-game-you-enjoy prompt. The 0.5 vocab quiz and 0.8 academic integrity check
are folded in as block_questionset chapters, reusing the exact terms/
questions from build_dragquestion_vocab.py and build_academic_integrity_check.py
respectively -- not rewritten.

Chapter 9 ("Your Profile Picture") is new content, per Jay: the real next
step after the kickoff avatar activity (shared/unit_00_onboarding_level1/
kickoff/01_avatar_instructions.html) is to set THIS as their Moodle profile
picture, not just leave it in a folder. Avatar file is confirmed as
`avatar.bmp`, 500x500, saved in the Kickoff folder (read directly from that
lesson's own instructions, not guessed). The real-name reminder reuses
01-privacy-and-governance/codename-policy.md's actual rule verbatim in
spirit ("Never put your real name in code comments, reflection text, or
anywhere else in your work").

NOTE (flagged for Jay): the vocab quiz here uses a "which term matches this
definition" multiple-choice format (same pattern as lesson_01_01_instruction.py's
own vocab quiz chapter), NOT the drag-and-drop H5P.DragQuestion interaction
build_dragquestion_vocab.py used standalone. h5p_book_builder.py has no
tested drag-question chapter block, and nesting an untested content type
inside a Column chapter repeats the exact blind-authoring mistake that broke
DragQuestion and Essay content earlier this project (see
foxcs-h5p-authoring-lessons). Jay previously said he specifically liked the
drag-and-drop style better than multiple choice for this quiz -- this is a
real, deliberate downgrade of that interaction in exchange for folding it
into one consolidated book, not an oversight.
"""
from h5p_book_builder import block_text, block_multichoice, block_essay, block_questionset, chapter, build_and_zip

# ---- Chapter 1: 0.1 Welcome ----
ch1 = chapter([
    block_text(
        "<h2>0.1 — Welcome to Game Programming I</h2>"
        "<p><strong>Your Path This Year:</strong> Welcome to Game Programming I. Everyone in this course learns "
        "<strong>Python</strong> this year, the whole way through. There's no pathway choice to make here, this is "
        "your path, and it's a genuinely deep one: by the end of the year, you'll be able to build real, working "
        "programs and games from scratch, and you'll be prepared for an industry certification exam.</p>"
        "<p>This isn't just a Python-syntax class. It's a game design class that happens to use Python as the tool "
        "for actually building things. Every unit this year connects the code you're learning to a real idea about "
        "how games work and how they're designed to feel a certain way to play — you'll build up a real vocabulary "
        "for talking about game design as the year goes on, starting with the very first real unit.</p>"
        "<h3>What This Class Actually Looks Like</h3>"
        "<p>You'll spend real time both writing code and thinking like a designer — not two separate things, but "
        "one connected skill. You don't need any prior experience with either one. Everyone in this room is "
        "starting from the same place today.</p>"
        "<h3>What's Coming This Year</h3>"
        "<p>You'll build real programs starting with simple output and working all the way up to a full capstone "
        "game project of your own design. Along the way, you'll work toward the <strong>IT Specialist – Python</strong> "
        "certification, a real industry credential. Once that's done, later in the year you'll also get to build 2D "
        "games in a tool called MakeCode Arcade, putting everything you've learned to the test in a new way.</p>"
    ),
    block_essay(
        "<p>Pick a game you enjoy playing. What's one specific thing about it you'd love to actually understand "
        "how the creators built? You'll revisit this answer later in the year.</p>",
        "Write your answer here (50-75 words).",
        "Welcome Journal",
    ),
], "0.1 Welcome")

# ---- Chapter 2: 0.2 How Learning Works ----
ch2 = chapter([
    block_text(
        "<h2>0.2 — How Learning Works</h2>"
        "<p>Here's something worth saying out loud before you write a single line of code or design a single pixel: "
        "you are not expected to get things right on the first try. Nobody in this class is.</p>"
        "<p>Learning something genuinely new follows a predictable shape. You try something. It doesn't quite work. "
        "You figure out why. You try again, a little differently. Eventually you understand it. That loop is not a "
        "sign you're behind. It's what learning actually looks like, for everyone, every time.</p>"
        "<p><strong>What mastery actually means:</strong> mastery isn't perfect first-attempt performance, "
        "memorizing everything, or being fast. Mastery is being able to solve a new problem using what you've "
        "practiced, even if you have to revise your first attempt to get there. Debugging, revising, and trying "
        "something a second or third way are part of mastery, not evidence that you failed.</p>"
        "<h3>Practice Adjusts to What You Need</h3>"
        "<p>Not everyone in this class works through practice the same way, and that's on purpose, not a sign that "
        "anyone's ahead or behind. Some practice will feel easy and move quickly for you. Some will take longer and "
        "need more repetition before it makes sense. What matters is paying attention to your own understanding, "
        "not comparing your pace to anyone else's.</p>"
        "<h3>What This Means Day to Day</h3>"
        "<p>You'll get instruction and examples first, before you're asked to do something on your own. Practice "
        "comes in small pieces with fast feedback, not one big test at the end of everything. Projects let you "
        "apply what you've learned to something bigger, with room to make real choices. Mastery checks are where "
        "you show what you actually know, on your own, in your own words or code.</p>"
        "<p>None of this works if you skip the struggle part and copy someone else's answer, or have an AI tool do "
        "it for you. That's covered fully in an upcoming lesson (Academic Integrity), but the short version is: the "
        "struggle is the point. It's literally where the learning happens.</p>"
    ),
], "0.2 How Learning Works")

# ---- Chapter 3: 0.3 Using Your Tools ----
ch3 = chapter([
    block_text(
        "<h2>0.3 — Using Your Tools</h2>"
        "<p>Everything you build in this course happens in <strong>Python</strong>, a real programming language "
        "used by professional developers. You'll get set up with the actual editor and tools you'll be writing "
        "code in once Lesson 1 starts — that's hands-on setup, not something to walk through here in onboarding.</p>"
        "<p><strong>Save often:</strong> whatever tool you end up writing code in, get in the habit now: save your "
        "work constantly, not just when you're done. It costs nothing and it means you never lose more than a "
        "minute or two of work if something goes wrong.</p>"
    ),
], "0.3 Using Your Tools")

# ---- Chapter 4: 0.4 Troubleshooting Is Learning ----
ch4 = chapter([
    block_text(
        "<h2>0.4 — Troubleshooting Is Learning</h2>"
        "<p>At some point this year, something you build is going to break. Your code will show an error message. "
        "Something will not work the way you expected. This isn't a maybe, it's a certainty, and it's true for "
        "every single person in this class, including the adults who do this professionally.</p>"
        "<p><strong>Reframe: this is part of the job.</strong> Professional software developers, web developers, "
        "and game developers spend a large part of their actual working time fixing things that don't work yet. "
        "It's not a side effect of the job, it's a core part of it.</p>"
        "<h3>A Simple Process, Not a Guessing Game</h3>"
        "<p>When something breaks, it's tempting to change random things until it works. That sometimes works by "
        "accident, but it teaches you nothing and often creates new problems. Try this instead.</p>"
        "<p><strong>1. Notice exactly what happened.</strong> What did you expect to happen? What actually happened "
        "instead? Read any error message carefully, word for word, instead of skimming past it.</p>"
        "<p><strong>2. Find what changed.</strong> If it worked a minute ago and doesn't now, what did you just "
        "change? That's usually where the problem is.</p>"
        "<p><strong>3. Make one change at a time.</strong> Fix one thing, then check whether the problem is gone "
        "before fixing anything else.</p>"
        "<p><strong>4. Ask for help the right way.</strong> If you're stuck after trying the steps above, that's "
        "exactly when to ask for help, not a sign you should have figured it out alone.</p>"
    ),
], "0.4 Troubleshooting Is Learning")

# ---- Chapter 5: 0.5 Computational Thinking + Vocab Quiz ----
ch5 = chapter([
    block_text(
        "<h2>0.5 — Introduction to Computational Thinking</h2>"
        "<p>Computational thinking isn't the same thing as coding. It's the thinking that happens before and during "
        "coding (or building a web page, or designing a game system). It's how you break a big, messy problem into "
        "something you can actually solve, one piece at a time. You already do a version of this in everyday life. "
        "This class just gives it names and makes it deliberate.</p>"
        "<h3>The Four Parts</h3>"
        "<p><strong>Decomposition</strong> — breaking a big problem into smaller, more manageable pieces.</p>"
        "<p><strong>Pattern recognition</strong> — noticing similarities between a new problem and something you've "
        "seen before. Example: once you've fixed one &quot;my button doesn't respond to clicks&quot; bug, you'll "
        "recognize the shape of that problem the next time it shows up somewhere else.</p>"
        "<p><strong>Abstraction</strong> — focusing on the details that actually matter for the problem you're "
        "solving, and ignoring the ones that don't. Example: when you use a function someone else wrote, you don't "
        "need to know exactly how it works inside, just what it needs from you and what it gives back.</p>"
        "<p><strong>Algorithmic thinking</strong> — describing a solution as a clear, ordered series of steps. "
        "Example: a recipe is an algorithm. So is a set of directions to a friend's house.</p>"
        "<p><strong>Why this matters before you've written any code:</strong> every project you build this year is "
        "really a large problem made out of many small ones. Students who struggle the most usually aren't "
        "struggling with the basic building blocks, they're trying to solve the whole big problem at once instead "
        "of breaking it down first. When you get stuck later this year, one of the first useful questions to ask "
        "yourself is: what's the smallest piece of this I could try to solve first? That question is decomposition.</p>"
    ),
    block_multichoice(
        "<p>You're planning a birthday party and you write a list: decorations, food, music, invitations, then "
        "handle each one separately. Which part of computational thinking is this closest to?</p>",
        [
            ("<div>Decomposition</div>", True, "<div>Right — breaking the big task (the party) into smaller, separately-handled pieces.</div>"),
            ("<div>Pattern recognition</div>", False, "<div>Think about what's actually happening: one big task being split into pieces.</div>"),
            ("<div>Abstraction</div>", False, "<div>Think about what's actually happening: one big task being split into pieces.</div>"),
        ],
        "Quick Check",
    ),
    block_text("<h3>Vocab Quiz</h3><p>Match each term to its correct definition.</p>"),
    block_questionset([
        (f"<p>Which term matches: &quot;{d}&quot;</p>", [
            (f"<div>{t}</div>", t == correct_term, "<div>Correct!</div>" if t == correct_term else "<div>Check the definitions again.</div>")
            for t in ["Decomposition", "Pattern recognition", "Abstraction", "Algorithmic thinking"]
        ])
        for (correct_term, d) in [
            ("Decomposition", "Breaking a big problem into smaller, more manageable pieces."),
            ("Pattern recognition", "Noticing similarities between a new problem and something you've seen before."),
            ("Abstraction", "Focusing on the details that actually matter for the problem you're solving, and ignoring the ones that don't."),
            ("Algorithmic thinking", "Describing a solution as a clear, ordered series of steps."),
        ]
    ], "Vocab Quiz: Computational Thinking"),
], "0.5 Computational Thinking")

# ---- Chapter 6: 0.6 How Problem-Solving Works ----
ch6 = chapter([
    block_text(
        "<h2>0.6 — How Problem-Solving Works</h2>"
        "<p>The last lesson introduced computational thinking, the mental habits behind breaking problems apart. "
        "This lesson is about what to actually do, step by step, when you're facing a problem you don't yet know "
        "how to solve. This process works no matter what you're building.</p>"
        "<p><strong>1. Understand the problem.</strong> Before doing anything, be able to say, in your own words, "
        "what you're actually trying to accomplish.</p>"
        "<p><strong>2. Plan before you build.</strong> Sketch out your approach, even roughly, before diving in.</p>"
        "<p><strong>3. Try the smallest useful version first.</strong> Don't try to build the whole thing at once.</p>"
        "<p><strong>4. Check your work against what you expected.</strong> If it doesn't match, that's not "
        "failure, that's information. Go back to troubleshooting (Lesson 0.4) to figure out why.</p>"
        "<p><strong>5. Revise.</strong> Adjust your approach based on what you learned, and try again. Most real "
        "solutions go through more than one version before they're right.</p>"
        "<p>This isn't just for code. It's the same process you'd use to figure out why a recipe didn't turn out "
        "right, or why directions to a friend's house led somewhere wrong. The tools are different every time, the "
        "process is the same.</p>"
    ),
], "0.6 How Problem-Solving Works")

# ---- Chapter 7: 0.7 Getting Unstuck ----
ch7 = chapter([
    block_text(
        "<h2>0.7 — Getting Unstuck</h2>"
        "<p>Everyone gets stuck this year. That's not a problem to avoid, it's a normal part of learning something "
        "new. This lesson is about what to actually do about it.</p>"
        "<h3>Try These Before You Ask Anyone</h3>"
        "<p><strong>Re-read what you wrote.</strong> Slowly, out loud if it helps. A surprising number of problems "
        "are visible the second time you actually look closely.</p>"
        "<p><strong>Re-read the error or symptom.</strong> What is it actually telling you? Not what you assume it "
        "means, what it literally says.</p>"
        "<p><strong>Check the instructions or documentation again.</strong> It's easy to misremember a detail.</p>"
        "<p><strong>Try isolating the problem.</strong> Comment out or remove pieces until you find the smallest "
        "version that still breaks.</p>"
        "<p>If you've genuinely tried these and you're still stuck, that's exactly when to ask for help. Asking "
        "isn't a last resort you should feel bad about.</p>"
        "<h3>How to Ask for Help Well</h3>"
        "<p><strong>Less helpful:</strong> &quot;It's not working.&quot; (No detail. Whoever's helping you has to "
        "start from zero.)</p>"
        "<p><strong>More helpful:</strong> &quot;I expected X to happen, but Y happened instead. Here's what I "
        "tried already. Here's the exact error message I'm seeing.&quot;</p>"
        "<p><strong>Who to ask:</strong> asking a classmate is a great first option, often the fastest one, and "
        "it's genuinely encouraged in this class. Your teacher is always available too, especially for anything a "
        "classmate can't resolve. There's an important line about what &quot;helping&quot; actually means when it "
        "comes to someone else's code or work — the next lesson covers that boundary directly.</p>"
    ),
], "0.7 Getting Unstuck")

# ---- Chapter 8: 0.8 Academic Integrity + Check ----
ACADEMIC_INTEGRITY_QUESTIONS = [
    (
        "<p>You and your partner are assigned partner work. Your partner ends up doing almost all of the work while "
        "you watch. What actually happens?</p>",
        [
            ("<div>Both partners get credit, since it was assigned as partner work.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>Only the partner who did the work gets credit. You don't, and you restart the assignment on your own.</div>", True, "<div>Right — that's the actual policy.</div>"),
            ("<div>Neither partner gets credit, since the partnership broke down.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>The teacher splits the credit evenly between both partners.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
        ],
    ),
    (
        "<p>A classmate is stuck and asks you for help. What's the right way to help them?</p>",
        [
            ("<div>Send them your file so they can see exactly how you did it.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>Do the problem for them so they don't fall behind.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>Explain how to think through the problem and help them find their own mistake.</div>", True, "<div>Right — that's the actual policy.</div>"),
            ("<div>Tell them you can't help at all, since any help risks crossing a line.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
        ],
    ),
    (
        "<p>If you hand a classmate your code so they can copy it and submit it as their own, what happens to you?</p>",
        [
            ("<div>Nothing — you didn't submit anyone else's work as your own.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>A warning, the first time it happens.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>You get the same consequence as cheating does, since you enabled it.</div>", True, "<div>Right — that's the actual policy.</div>"),
            ("<div>A small point deduction on your next assignment.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
        ],
    ),
    (
        "<p>To start this school year, when are you allowed to use AI tools to help write your code or your written "
        "responses for this class?</p>",
        [
            ("<div>Anytime, as long as you understand what it produced.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>Only for written responses, not code.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>Whenever you're stuck and have run out of other options.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>Not at all right now — the class starts the year without using AI in your work.</div>", True, "<div>Right — that's the actual policy.</div>"),
        ],
    ),
    (
        "<p>A student attempts a problem honestly but gets it wrong. Another student uses AI to submit a perfect "
        "answer. Which one earns more credit?</p>",
        [
            ("<div>The AI-assisted answer, since it's correct.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>Both earn the same amount, since only the final answer is graded.</div>", False, "<div>Not quite. Think again about what the lesson actually said about this.</div>"),
            ("<div>The honest attempt — effort is part of what's graded, and AI-generated work earns none.</div>", True, "<div>Right — that's the actual policy.</div>"),
        ],
    ),
]

ch8 = chapter([
    block_text(
        "<h2>0.8 — Academic Integrity: Doing Your Own Work</h2>"
        "<p>This lesson gets its own space in the course, not just a quick mention, because it matters that much. "
        "Read it carefully. All of it applies to this class, no matter what you're building.</p>"
        "<p><strong>Why this actually matters:</strong> you will not learn if you do not attempt the work yourself. "
        "That's not a rule, it's just true. This material will be genuinely challenging at times. That difficulty "
        "is expected — it's not a sign something has gone wrong, it's what learning something real looks like.</p>"
        "<h3>Partner Work</h3>"
        "<p>When an assignment is partner work, partners work together. Both people actually doing the work, not "
        "one person doing it while the other watches. If a partnership breaks down and one person ends up doing "
        "all or almost all of the work alone: only the partner who did the work gets credit for it. The other "
        "partner doesn't receive credit for work they didn't do, and will be expected to restart the assignment on "
        "their own.</p>"
        "<h3>Helping a Classmate the Right Way</h3>"
        "<p>There should never be a situation where you ask a classmate for their code, or any other work, to copy "
        "and paste. Not &quot;just to see it,&quot; not &quot;just this once.&quot; That line doesn't move.</p>"
        "<p><strong>Not helping:</strong> handing over your code or your answer so they can submit it as their own. "
        "<strong>Actually helping:</strong> explaining how to think through the problem, pointing at the concept or "
        "the specific line that's off, helping them find their own mistake.</p>"
        "<p>If you hand someone your work to copy, you're not being generous, you're helping them cheat, and it "
        "carries the same consequence as cheating does. This applies to both people involved, not just the one who "
        "copied.</p>"
        "<h3>Using AI Tools</h3>"
        "<p><strong>To start the year, we will not be using AI in our work.</strong> AI does not do your work for "
        "you. Not your code, not your written responses, not any part of an assignment you submit as your own. "
        "Later in the year, once you've built real foundational skills without AI, there may be specific situations "
        "where using it is allowed — your teacher will state exactly when and exactly what you're allowed to use it "
        "for. Until you hear that explicitly, for a specific assignment, the answer is no.</p>"
        "<p><strong>If this line gets crossed</strong> (submitting AI-generated work as your own, copying a "
        "classmate's code or written work, or enabling someone else to do the same, for every person involved): a "
        "call or email home; a written record of the incident, logged in Aspen, which leads to a conversation with "
        "a member of the school's Disciplinary Team; a 0% on the assignment, which cannot be made up.</p>"
        "<p><strong>Why trying honestly is always the better choice:</strong> genuine effort always earns credit, "
        "even when the work is incomplete or wrong. Even when you don't get it right, trying it yourself will "
        "always earn you more points than cheating would. That's true on purpose.</p>"
    ),
    block_text("<h3>Check: Academic Integrity</h3><p>Make sure this policy is actually clear.</p>"),
    block_questionset(ACADEMIC_INTEGRITY_QUESTIONS, "Check: Academic Integrity"),
], "0.8 Academic Integrity")

# ---- Chapter 9: Your Profile Picture (new content) ----
ch9 = chapter([
    block_text(
        "<h2>Your Profile Picture</h2>"
        "<p>Before you move on, there's one more quick step. In the Kickoff activity, you already made a pixel-art "
        "avatar in MakeCode Arcade and saved it as <strong>avatar.bmp</strong>. Now let's actually use it: set it as "
        "your profile picture here on Moodle, so it's the image everyone in this class sees next to your name.</p>"
        "<h3>How to Set Your Profile Picture</h3>"
        "<p><strong>1.</strong> Click your account icon in the top right corner of any Moodle page, then choose "
        "<strong>Preferences</strong>.</p>"
        "<p><strong>2.</strong> Under &quot;User account,&quot; click <strong>Edit profile</strong>.</p>"
        "<p><strong>3.</strong> Scroll down to the <strong>User picture</strong> section.</p>"
        "<p><strong>4.</strong> Drag your saved <code>avatar.bmp</code> file into the upload box (or click the "
        "upload icon and browse to find it — it's saved in your Kickoff folder from that earlier activity).</p>"
        "<p><strong>5.</strong> Scroll to the bottom and click <strong>Update profile</strong>.</p>"
        "<p>That's it — your avatar now shows up as your profile picture everywhere on Moodle.</p>"
        "<p><strong>One important reminder:</strong> never put your real name anywhere on your Moodle profile — "
        "not your display name, not your &quot;About me&quot; text, not anywhere else. This is the same rule that "
        "already applies to everything else you submit in this class: your codename is how you're identified here, "
        "on purpose, and that includes your profile.</p>"
    ),
], "Your Profile Picture")

build_and_zip(
    [ch1, ch2, ch3, ch4, ch5, ch6, ch7, ch8, ch9],
    "Unit 0: Getting Started",
    "/tmp/h5p-build/unit-00-onboarding-l1-book.h5p",
)
