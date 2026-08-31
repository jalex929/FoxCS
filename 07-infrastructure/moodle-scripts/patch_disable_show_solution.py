"""One-off: patches every .h5p package in a directory to disable any
show-solution/reveal-answer button, matching the standing rule enforced
everywhere in the Python course (never let a student reveal a correct
answer by clicking a button). Written 2026-08-30 after an audit found all
8 graded H5P activities in Seminar III's Lesson 1 had this enabled --
never caught because they were built by a separate one-off pipeline that
didn't inherit the rule.

Patches text directly (JSON string replace) rather than fully parsing,
since content.json structures vary a lot across content types
(H5P.Column-wrapped MultiChoice/Essay, H5P.SortParagraphs, H5P.QuestionSet)
and a blind key-flip is lower-risk than reconstructing each content
type's schema by hand under time pressure. Reports every replacement made
so nothing is silently skipped.

Run: python3 patch_disable_show_solution.py /path/to/dir/with/*.h5p
"""
import sys, os, zipfile, shutil, re

REPLACEMENTS = [
    (b'"enableSolutionsButton":true', b'"enableSolutionsButton":false'),
    (b'"enableSolutionsButton": true', b'"enableSolutionsButton": false'),
    (b'"showSolutionButton":true', b'"showSolutionButton":false'),
    (b'"showSolutionButton": true', b'"showSolutionButton": false'),
]

def patch_file(path):
    tmp_dir = path + "_extracted"
    if os.path.exists(tmp_dir):
        shutil.rmtree(tmp_dir)
    os.makedirs(tmp_dir)
    with zipfile.ZipFile(path, "r") as z:
        z.extractall(tmp_dir)

    content_path = os.path.join(tmp_dir, "content", "content.json")
    if not os.path.exists(content_path):
        print(f"  SKIP (no content/content.json): {path}")
        shutil.rmtree(tmp_dir)
        return 0

    with open(content_path, "rb") as f:
        data = f.read()

    total_changes = 0
    for old, new in REPLACEMENTS:
        count = data.count(old)
        if count:
            data = data.replace(old, new)
            total_changes += count
            print(f"  {os.path.basename(path)}: replaced {count}x {old.decode()}")

    if total_changes == 0:
        print(f"  {os.path.basename(path)}: no matches found (already clean, or field absent)")
        shutil.rmtree(tmp_dir)
        return 0

    with open(content_path, "wb") as f:
        f.write(data)

    out_path = path.replace(".h5p", "_patched.h5p")
    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        for root, _, files in os.walk(tmp_dir):
            for fname in files:
                full = os.path.join(root, fname)
                arcname = os.path.relpath(full, tmp_dir)
                z.write(full, arcname)
    shutil.rmtree(tmp_dir)
    print(f"  -> wrote {out_path}")
    return total_changes

if __name__ == "__main__":
    target_dir = sys.argv[1] if len(sys.argv) > 1 else "."
    total = 0
    for fname in sorted(os.listdir(target_dir)):
        if fname.endswith(".h5p") and not fname.endswith("_patched.h5p"):
            total += patch_file(os.path.join(target_dir, fname))
    print(f"\nTotal replacements across all files: {total}")
