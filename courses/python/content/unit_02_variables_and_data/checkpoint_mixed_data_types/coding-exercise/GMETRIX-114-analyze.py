# GMETRIX-114-analyze.py
# Unit 02 Checkpoint: Mixed Data Types (GMetrix Workbook p.12, "Review 1.1")
#
# PART 1 is the real GMetrix review file, unchanged. For each line, write
# your prediction as a comment ABOVE it before you run anything, then run
# the file and check yourself against the real output.
#
# When you're done with both parts, save this file as
# GMETRIX-114-analyze-completed.py, then upload it to this Checkpoint.

# ----- PART 1: Identify the Data Types (the real GMetrix Review 1.1 task) -----

# a. Predict the type printed by the line below:


print(type("This is a quiz on data types"))

# b. Predict the type printed by the line below:


print(type(True))

# c. Predict the type printed by the line below:


print(type("20000"))

# d. Predict the type printed by the line below:


print(type(2.22))

# e. Predict the type printed by the line below:


print(type(20000))

# ----- PART 2: The Trickiest Cases (FoxCS-original, added for 02.6) -----
# These seven values are the ones people mix up most. For EACH one below,
# add a comment saying whether it is an int, a float, a str, a bool, OR
# "not a value at all" (a bare variable name refers to whatever is stored
# in that variable, it isn't a value by itself). Then check yourself by
# printing type() on each one, the same way Part 1 did.
#
# Hint: two of these look almost identical to each other but are not the
# same type. Find that pair before you decide.

score = 12

# 1. 12          ->
# 2. 12.0        ->
# 3. "12"        ->
# 4. True        ->
# 5. "True"      ->
# 6. score       ->
# 7. "score"     ->

# Now check your predictions. Uncomment the block below (remove the triple
# quotes) and run the file.

"""
print(type(12))
print(type(12.0))
print(type("12"))
print(type(True))
print(type("True"))
print(type(score))
print(type("score"))
"""
