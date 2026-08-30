import sys
sys.path.insert(0, "/tmp/h5p-build")
from build_questionset import build_column

# ---- Day 4: ACT Math Baseline Reflection & Analysis ----

day4_blocks = [
    ("text", "<h2>What Does My Baseline Tell Me?</h2><p>A baseline score is not the point. The point is figuring out what to do next. Two learners can get the same score for very different reasons, and they need different kinds of support. Use this reflection to turn your results into a real starting plan.</p>"),
    ("text", "<h3>Reading Your Results</h3><p><strong>Current Strengths</strong> are skills you currently demonstrate consistently. <strong>Developing Skills</strong> are skills you partially demonstrate or seem to remember. <strong>Priority Skills</strong> are skills that need real instruction or review. A low score on one question does not automatically mean a skill is a Priority &mdash; look for a pattern across similar questions before deciding.</p>"),
    ("essay", "<p>Which questions or skills on the baseline felt easiest? Which felt hardest?</p>", "Type your answer here."),
    ("essay", "<p>Were there questions involving something you remember learning before but don't remember clearly now? Were there questions involving something you didn't recognize at all?</p>", "Type your answer here."),
    ("essay", "<p>Think back to Unit 01's error types. Did you notice any mistakes where you knew what to do but made an Execution Error? Did any questions feel hard mainly because you didn't understand what they were asking (a Comprehension Error)?</p>", "Type your answer here."),
    ("essay", "<p>Did you use any strategies besides directly calculating &mdash; for example, estimating, eliminating answer choices, or working backward? Which ones, and on which questions?</p>", "Type your answer here."),
    ("essay", "<p>What is one skill you think you should practice first? What is one result from the baseline that surprised you?</p>", "Type your answer here."),
    ("text", "<h3>Confidence Check-In</h3><p>Look back at your answers to these six baseline questions: the order-of-operations problem, the percent-of-a-number problem, the proportion (3/8 = x/40) problem, the two-step equation (2x + 5 = 17), the rectangle perimeter word problem, and the store-sales reverse-reasoning problem.</p>"),
    ("essay", "<p>For those six questions, rate your confidence on each using this scale, and explain briefly: 1 &ndash; Guessing (I did not know how to solve this), 2 &ndash; Unsure (I had an idea, but wasn't confident), 3 &ndash; Mostly Sure (I thought I knew how to solve it), 4 &ndash; Confident (I understood the skill and expected to be correct).</p>", "Type your ratings and explanation here."),
    ("essay", "<p><strong>Current Strength:</strong> Name one skill from the baseline you currently do well.</p>", "Type your answer here."),
    ("essay", "<p><strong>Developing Skill:</strong> Name one skill you partially know or are starting to understand.</p>", "Type your answer here."),
    ("essay", "<p><strong>Priority Skill:</strong> Name one skill that needs real practice or review.</p>", "Type your answer here."),
]

build_column(day4_blocks, "Unit 01: ACT Math Baseline Reflection (Interactive)", "/tmp/h5p-build/unit-01-baseline-reflection.h5p")

# ---- Day 5: Unit 01 Reflection -- Build Your Starting Strategy ----

day5_blocks = [
    ("text", "<h2>Build Your Starting Strategy</h2><p>Unit 01 gave you two tools you'll use all year: the five-question problem-solving routine (STOP &rarr; FIND &rarr; CONNECT &rarr; TRY &rarr; CHECK) and the five error types (Knowledge, Process, Execution, Comprehension, Strategy). Use them to set your starting point for Quarter 1.</p>"),
    ("essay", "<p><strong>One Strength:</strong> Something you currently do reasonably well.</p>", "Type your answer here."),
    ("essay", "<p><strong>One Priority:</strong> Something you want to improve.</p>", "Type your answer here."),
    ("essay", "<p><strong>One Strategy:</strong> Something you will try when you get stuck. (Consider one of the five questions, or a specific strategy like estimating or drawing a diagram.)</p>", "Type your answer here."),
    ("essay", "<p><strong>One Checking Habit:</strong> Something you will do before submitting an answer.</p>", "Type your answer here."),
]

build_column(day5_blocks, "Unit 01: Reflection -- Build Your Starting Strategy (Interactive)", "/tmp/h5p-build/unit-01-final-reflection.h5p")
