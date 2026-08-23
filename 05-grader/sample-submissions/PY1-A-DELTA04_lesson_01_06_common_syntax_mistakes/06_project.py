# 1.6.5b - Project: Bug Hunt Challenge
# Every line below has exactly one mistake. Fix all four, running the file
# after each fix. No renaming needed. Just save this file.

# fixed: print was capitalized (Print), which raises NameError since Python
# doesn't know any name called Print
print("Welcome to the arena")
# should display: Welcome to the arena

# fixed: the text wasn't wrapped in quotes at all, which raises NameError
# since Python tried to read Choose, your, and character as three separate
# undefined names
print("Choose your character")
# should display: Choose your character

# fixed: the closing quote was missing, which raises a SyntaxError (EOL
# while scanning string literal) since Python never found where the text
# was supposed to end
print("Good luck out there!")
# should display: Good luck out there!

# fixed: missing quotes around the text, same NameError pattern as line 2
print("Battle Start")
# should display: Battle Start

# bonus: one more line, intentionally broken the same two-mistake way as
# practice Drill 5 (Print + missing quotes at once), then fixed
# print(Final Boss) -> two mistakes: Print should be print, and the text
# needs quotes around it
print("Final Boss")
# should display: Final Boss

# bonus (Tier 1b): the difference between SyntaxError and NameError, in my
# own words: a SyntaxError means Python can't even finish reading the line
# because something breaks its grammar rules, like a quote that never
# closes. A NameError means the line IS valid grammar, Python just can't
# find anything with that exact name, like Print or an unquoted word.
