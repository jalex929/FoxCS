# 1.6.6b - Mastery Check: Common Syntax Mistakes
#
# Answer all four questions below, as comments. Once done, use File > Save
# As to save this as 08_mastery_check_completed.py. Unlock/completion times
# save automatically in 07_mastery_check.html itself -- nothing to copy here.


# 1. Fix this line so it displays "New Record!", and name the mistake:
#    print("New Record!
#
#    print("New Record!")
#    Mistake: missing closing quote AND missing closing parenthesis, this
#    would raise a SyntaxError because the string never closes.


# 2. Fix this line so it displays "Paused", and name the mistake:
#    print(Paused)
#
#    print("Paused")
#    Mistake: Paused isn't wrapped in quotes, so Python reads it as an
#    undefined variable name instead of text. That's a NameError.


# 3. This line has two mistakes at once. Fix both, and name each one.
#    It should display: Continue
#    Print(Continue
#
#    print("Continue")
#    Mistake 1: Print is capitalized, which is a different name than print
#    and would raise NameError on its own.
#    Mistake 2: there's no closing quote or closing parenthesis around
#    Continue, which is a SyntaxError. Since the SyntaxError happens first
#    (Python checks grammar before it even tries to run anything), that's
#    actually the one Python would report, even though both problems exist.


# 4. Explain, in your own words, how you can tell the difference between a
#    mistake that causes a SyntaxError and one that causes a NameError.
#    What is Python actually confused about in each case?
#    A SyntaxError means Python is confused about the GRAMMAR of the line
#    itself, it can't even finish parsing it because something like a quote
#    or parenthesis never closes. A NameError means the grammar is totally
#    fine, Python successfully read the whole line, it's just confused
#    about WHAT the word refers to, because nothing with that exact name
#    (like Print instead of print, or an unquoted word) actually exists.
#    The quickest way I check now is: does the line at least look like
#    complete, closed-up Python? If yes but it still fails, it's probably a
#    NameError. If something's obviously unclosed, it's a SyntaxError.
