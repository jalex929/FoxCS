"""One-off: expands Seminar III 1.2 Error Types' intro text block into five
separate sections (one per error type) with two examples each, replacing the
original single dense paragraph that crammed all five types together with
one example apiece. Per Jay directly: "give some more examples of the
different error types / give each its own section."

Everything else in the activity (the diagram image, the 8 check/practice
questions, the worked "Learn From the Error" examples, the quick reference)
is left untouched -- this only replaces the opening instructional block.

Run: python3 patch_expand_error_types_intro.py /path/to/errortypes.h5p
"""
import sys, os, zipfile, shutil, json

OLD_TEXT = (
    '<h2>Why Was My Answer Wrong?</h2><p>A wrong answer does not automatically mean '
    '&quot;I don\'t know how to do this.&quot; Three learners can miss the exact same '
    'problem for three different reasons, and they do not need the same help. Use these '
    'five categories to figure out which one actually happened.</p><p><strong>Knowledge '
    'Error.</strong> &quot;There is something I need to know that I don\'t currently know '
    'or remember.&quot; Example: you don\'t remember how negative numbers behave when you '
    'multiply them. <strong>Try this:</strong> review the concept or a worked example.</p>'
    '<p><strong>Process Error.</strong> &quot;I had the right general idea, but something '
    'went wrong in my steps.&quot; Example: you use the correct formula but put values in '
    'the wrong places. <strong>Try this:</strong> compare your work to a correct example.</p>'
    '<p><strong>Execution Error.</strong> &quot;I knew how to solve it, but I made a mistake '
    'while doing the work.&quot; Example: 7 &times; 8 = 54. <strong>Try this:</strong> slow '
    'down and check against an estimate.</p><p><strong>Comprehension Error.</strong> &quot;I '
    'didn\'t correctly understand what the question was asking or telling me.&quot; Example: '
    'calculating the total when the question asked for the difference. <strong>Try this:'
    '</strong> reread the question and identify the actual task.</p><p><strong>Strategy '
    'Error.</strong> &quot;I understood the problem, but the approach I chose wasn\'t the '
    'best way to solve it.&quot; Example: a long calculation by hand when estimating would '
    'eliminate most answer choices in seconds. <strong>Try this:</strong> ask, &quot;is '
    'there an easier way?&quot;</p>'
)

NEW_TEXT = (
    '<h2>Why Was My Answer Wrong?</h2>'
    '<p>A wrong answer does not automatically mean &quot;I don\'t know how to do this.&quot; '
    'Three learners can miss the exact same problem for three different reasons, and they do '
    'not need the same help. Use these five categories to figure out which one actually '
    'happened.</p>'

    '<h3>Knowledge Error</h3>'
    '<p>&quot;There is something I need to know that I don\'t currently know or remember.&quot;</p>'
    '<p><strong>Example 1:</strong> You don\'t remember how negative numbers behave when you '
    'multiply them, so you're not sure if -3 &times; -4 is 12 or -12.</p>'
    '<p><strong>Example 2:</strong> You\'re asked what percent 3 is of 12, but you don\'t '
    'remember that "percent of" means divide, so you don\'t know where to start.</p>'
    '<p><strong>Try this:</strong> review the concept or a worked example. This is the one '
    'error type where more practice on the same kind of problem genuinely helps, since the '
    'gap is real, missing knowledge.</p>'

    '<h3>Process Error</h3>'
    '<p>&quot;I had the right general idea, but something went wrong in my steps.&quot;</p>'
    '<p><strong>Example 1:</strong> You use the correct formula but put values in the wrong '
    'places, like swapping length and width in an area formula.</p>'
    '<p><strong>Example 2:</strong> Solving a two-step equation, you subtract correctly from '
    'both sides, but then only divide one side by the next number instead of both.</p>'
    '<p><strong>Try this:</strong> compare your work, step by step, to a correct worked '
    'example, and find exactly which step diverged.</p>'

    '<h3>Execution Error</h3>'
    '<p>&quot;I knew how to solve it, but I made a mistake while doing the work.&quot;</p>'
    '<p><strong>Example 1:</strong> 7 &times; 8 = 54 -- the method was completely right, but '
    'the multiplication fact itself was recalled wrong.</p>'
    '<p><strong>Example 2:</strong> Correctly setting up 48 &divide; 6, but writing down 9 as '
    'the answer instead of 8, a simple slip while carrying it out.</p>'
    '<p><strong>Try this:</strong> slow down and check your answer against an estimate, or '
    'redo just the calculation step by itself.</p>'

    '<h3>Comprehension Error</h3>'
    '<p>&quot;I didn\'t correctly understand what the question was asking or telling me.&quot;</p>'
    '<p><strong>Example 1:</strong> Calculating the total cost when the question actually '
    'asked for the difference between two costs.</p>'
    '<p><strong>Example 2:</strong> A graph question asks which day had the lowest value, but '
    'you report the day with the highest value instead, having misread "lowest."</p>'
    '<p><strong>Try this:</strong> reread the question and identify the actual task being '
    'asked, before touching any numbers.</p>'

    '<h3>Strategy Error</h3>'
    '<p>&quot;I understood the problem, but the approach I chose wasn\'t the best way to '
    'solve it.&quot;</p>'
    '<p><strong>Example 1:</strong> A long calculation by hand when estimating would '
    'eliminate most answer choices in seconds.</p>'
    '<p><strong>Example 2:</strong> Comparing two fractions by converting both to decimals '
    'through long division, when cross-multiplying would take a few seconds.</p>'
    '<p><strong>Try this:</strong> before diving in, ask, &quot;is there an easier way?&quot; '
    'A correct answer reached the slow way still costs you time and risk on every other '
    'question.</p>'
)

def patch_file(path):
    tmp_dir = path + "_expandtmp"
    if os.path.exists(tmp_dir):
        shutil.rmtree(tmp_dir)
    os.makedirs(tmp_dir)
    with zipfile.ZipFile(path, "r") as z:
        z.extractall(tmp_dir)

    content_path = os.path.join(tmp_dir, "content", "content.json")
    with open(content_path, "r", encoding="utf-8") as f:
        raw = f.read()

    if OLD_TEXT not in raw:
        print("OLD_TEXT not found verbatim -- aborting without changes so nothing gets corrupted.")
        shutil.rmtree(tmp_dir)
        return False

    raw = raw.replace(OLD_TEXT, NEW_TEXT)

    with open(content_path, "w", encoding="utf-8") as f:
        f.write(raw)

    out_path = path.replace(".h5p", "_expanded.h5p")
    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        for root, _, files in os.walk(tmp_dir):
            for fname in files:
                full = os.path.join(root, fname)
                arcname = os.path.relpath(full, tmp_dir)
                z.write(full, arcname)
    shutil.rmtree(tmp_dir)
    print(f"Patched -> {out_path}")
    return True

if __name__ == "__main__":
    patch_file(sys.argv[1])
