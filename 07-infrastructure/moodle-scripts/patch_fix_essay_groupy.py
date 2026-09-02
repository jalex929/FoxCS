"""One-off: fixes a pre-existing content bug in Seminar III's Guided/
Independent Practice activities -- every H5P.Essay's "keywords" array entry
was wrapped in an erroneous extra "groupy" key (e.g.
{"groupy": {"keyword": "432", ...}} instead of the correct flat
{"keyword": "432", ...}), which throws inside H5P's Essay constructor
("Cannot read properties of undefined (reading 'occurrences')") and takes
down the ENTIRE H5P.Column with it -- the whole activity renders as
completely empty, not just the broken Essay. Found live by Jay ("1.4 guided
practice is empty. same with independent practice"), confirmed pre-existing
by inspecting the original package (not introduced by this session's
enableSolutionsButton/answer-leak patches, which never touch keywords).

Run: python3 patch_fix_essay_groupy.py /path/to/file.h5p
"""
import sys, os, zipfile, shutil, json

def unwrap_groupy(obj):
    if isinstance(obj, dict):
        if "keywords" in obj and isinstance(obj["keywords"], list):
            fixed = []
            for kw in obj["keywords"]:
                if isinstance(kw, dict) and "groupy" in kw and len(kw) == 1:
                    fixed.append(kw["groupy"])
                else:
                    fixed.append(kw)
            obj["keywords"] = fixed
        for v in obj.values():
            unwrap_groupy(v)
    elif isinstance(obj, list):
        for item in obj:
            unwrap_groupy(item)

def patch_file(path):
    tmp_dir = path + "_groupyfix"
    if os.path.exists(tmp_dir):
        shutil.rmtree(tmp_dir)
    os.makedirs(tmp_dir)
    with zipfile.ZipFile(path, "r") as z:
        z.extractall(tmp_dir)

    content_path = os.path.join(tmp_dir, "content", "content.json")
    with open(content_path, "r", encoding="utf-8") as f:
        data = json.load(f)

    before = json.dumps(data)
    unwrap_groupy(data)
    after = json.dumps(data)

    if before == after:
        print(f"  {os.path.basename(path)}: no groupy wrapper found, nothing changed")
        shutil.rmtree(tmp_dir)
        return False

    with open(content_path, "w", encoding="utf-8") as f:
        json.dump(data, f)

    out_path = path.replace(".h5p", "_fixed.h5p")
    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        for root, _, files in os.walk(tmp_dir):
            for fname in files:
                full = os.path.join(root, fname)
                arcname = os.path.relpath(full, tmp_dir)
                z.write(full, arcname)
    shutil.rmtree(tmp_dir)
    print(f"  {os.path.basename(path)}: fixed -> {out_path}")
    return True

if __name__ == "__main__":
    patch_file(sys.argv[1])
