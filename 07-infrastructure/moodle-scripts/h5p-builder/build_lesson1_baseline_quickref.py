import sys
sys.path.insert(0, "/tmp/h5p-build")
from build_questionset import build_column

blocks = [
    ("text", "<h2>Before You Begin: Quick Reference</h2><p>The baseline covers several kinds of problems. This isn't a lesson &mdash; it's a quick reminder of the rules, in case you've seen them before but they've gotten a little fuzzy. If a rule here is completely new to you, that's useful information too: it just means that skill is a good candidate for a Priority Skill once you see your results.</p>"),
    ("text", "<h3>Order of Operations</h3><p>Work in this order: <strong>Parentheses</strong> first, then <strong>Exponents</strong>, then <strong>Multiplication and Division</strong> (left to right), then <strong>Addition and Subtraction</strong> (left to right). Common mnemonic: <strong>PEMDAS</strong>.</p>"),
    ("text", "<h3>Signed (Positive/Negative) Numbers</h3><p>Subtracting a negative number is the same as adding a positive number: 5 &minus; (&minus;3) = 5 + 3. When multiplying or dividing, same signs give a positive result; different signs give a negative result.</p>"),
    ("text", "<h3>Fractions</h3><p>To <strong>add or subtract</strong> fractions, first rewrite them with a common denominator. To <strong>multiply</strong> fractions, multiply straight across (numerator &times; numerator, denominator &times; denominator). To <strong>divide</strong> by a fraction, multiply by its reciprocal (flip the second fraction, then multiply).</p>"),
    ("text", "<h3>Percent</h3><p>To find a percent of a number, convert the percent to a decimal and multiply (30% of 150 = 0.30 &times; 150). To find a percent change, divide the amount of change by the <strong>original</strong> (starting) amount, not the new amount.</p>"),
    ("text", "<h3>Ratios, Rates &amp; Proportions</h3><p>A rate compares two different units (like miles per hour) by dividing. A proportion sets two ratios equal to each other; solve it by cross multiplying, then dividing.</p>"),
    ("text", "<h3>Variables &amp; Expressions</h3><p>To evaluate an expression, substitute the given value in for the variable, then follow order of operations. To combine like terms, add or subtract the coefficients of matching variable terms and the constant terms separately.</p>"),
    ("text", "<h3>Equations</h3><p>If there are parentheses, distribute first. Then undo addition or subtraction before undoing multiplication or division &mdash; work backward through the order of operations to isolate the variable.</p>"),
    ("text", "<h3>Remember</h3><p>This baseline is diagnostic, not a grade. If a question uses a rule you don't remember, do your best with what you do know, and move on. That's useful information too.</p>"),
]

build_column(blocks, "Lesson 1: ACT Math Baseline Quick Reference (Interactive)", "/tmp/h5p-build/lesson-1-baseline-quickref.h5p")
