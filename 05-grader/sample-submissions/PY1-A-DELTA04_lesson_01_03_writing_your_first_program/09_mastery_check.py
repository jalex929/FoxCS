# 1.3.7b - Mastery Check: Writing Your First Program
#
# Answer all three questions below, as comments. Once done, use File > Save
# As to save this as 09_mastery_check_completed.py. Unlock/completion times
# save automatically in 08_mastery_check.html itself -- nothing to copy here.


# 1. Predict exactly what this program displays, in order:
#    print("Setting up...")
#    print("Score: 0")
#    print("Lives: 3")
#    print("Go!")
#
#    Setting up...
#    Score: 0
#    Lives: 3
#    Go!


# 2. Write three print() statements, in the correct order, that would
#    produce this exact output:
#       Loading save file...
#       Welcome back, Player!
#       Continue where you left off? (y/n)
#    Then explain: if you swapped the order of the first two statements,
#    would the program still run without crashing? Would the output still
#    make sense to a player?
#
#    print("Loading save file...")
#    print("Welcome back, Player!")
#    print("Continue where you left off? (y/n)")
#
#    It would still run without crashing, Python doesn't care about the
#    order like that. But it would look weird to a player because it would
#    welcome them back before it even said it was loading their save, which
#    doesn't really make sense in that order.


# 3. A friend says, "Computers are fast. It doesn't really matter what
#    order you write your print() statements in, Python will figure out
#    the sensible order to show them." Do you agree or disagree? Explain
#    your reasoning:
#    I disagree with my friend. Python runs things top to bottom no matter
#    what, it doesn't rearrange your lines to make more sense, it just does
#    them in the order you wrote them even if that order is wrong. I found
#    this out the hard way on the project because I had my lines in the
#    wrong order at first and it printed things in a confusing order until
#    I fixed it myself.
