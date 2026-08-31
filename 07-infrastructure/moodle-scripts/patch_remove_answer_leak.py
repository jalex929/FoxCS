"""One-off: fixes a systemic hint-leak in Seminar III's Lesson 1 error-type
questions. Every wrong-answer feedback ended with "Try: review the <X> Error
definition again" -- naming the CORRECT category outright, so a student
never actually has to reason it out; they just try again pointed straight at
the answer. Found by Jay reviewing 1.3 Error Types live. Replaces every such
trailing clause with a generic, non-revealing redirect that still tells the
student to go back and think, without naming which category is correct.

Run: python3 patch_remove_answer_leak.py /path/to/dir/with/*.h5p
"""
import sys, os, zipfile, shutil, re

# Matches "Try: review the <Category> (Error )?definition again." (any case
# on Try/review, with or without "Error", with or without trailing period)
PATTERN = re.compile(
    rb"Try:\s*[Rr]eview the [A-Za-z]+(?: Error)? definition again\.?",
)
GENERIC_REPLACEMENT = b"Try: reread the five error types above and compare this scenario to each one carefully."

def patch_file(path):
    tmp_dir = path + "_extracted2"
    if os.path.exists(tmp_dir):
        shutil.rmtree(tmp_dir)
    os.makedirs(tmp_dir)
    with zipfile.ZipFile(path, "r") as z:
        z.extractall(tmp_dir)

    content_path = os.path.join(tmp_dir, "content", "content.json")
    if not os.path.exists(content_path):
        shutil.rmtree(tmp_dir)
        return 0

    with open(content_path, "rb") as f:
        data = f.read()

    matches = PATTERN.findall(data)
    if not matches:
        shutil.rmtree(tmp_dir)
        print(f"  {os.path.basename(path)}: no matches")
        return 0

    data = PATTERN.sub(GENERIC_REPLACEMENT, data)

    with open(content_path, "wb") as f:
        f.write(data)

    out_path = path.replace(".h5p", "_v2.h5p")
    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        for root, _, files in os.walk(tmp_dir):
            for fname in files:
                full = os.path.join(root, fname)
                arcname = os.path.relpath(full, tmp_dir)
                z.write(full, arcname)
    shutil.rmtree(tmp_dir)
    print(f"  {os.path.basename(path)}: replaced {len(matches)} answer-leaking hints -> {out_path}")
    return len(matches)

if __name__ == "__main__":
    target_dir = sys.argv[1] if len(sys.argv) > 1 else "."
    total = 0
    for fname in sorted(os.listdir(target_dir)):
        if fname.endswith("_patched.h5p"):
            total += patch_file(os.path.join(target_dir, fname))
    print(f"\nTotal answer-leaking hints fixed: {total}")
