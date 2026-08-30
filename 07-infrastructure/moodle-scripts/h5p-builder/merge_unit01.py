import json
import uuid
import zipfile
import os

def load(id_):
    with open(f"/tmp/merge_h5p_{id_}.json") as f:
        return json.load(f)

def write_column_package(content_dict, title, out_path):
    h5p_manifest = {
        "title": title, "language": "en", "mainLibrary": "H5P.Column",
        "embedTypes": ["div"],
        "preloadedDependencies": [{"machineName": "H5P.Column", "majorVersion": "1", "minorVersion": "22"}],
    }
    content_dict["metadata"] = {"title": title}
    stage = "/tmp/h5p-build/_stage_" + os.path.basename(out_path).replace(".h5p", "")
    os.makedirs(stage + "/content", exist_ok=True)
    with open(stage + "/h5p.json", "w") as f:
        json.dump(h5p_manifest, f)
    with open(stage + "/content/content.json", "w") as f:
        json.dump(content_dict, f)
    with zipfile.ZipFile(out_path, "w", zipfile.ZIP_DEFLATED) as z:
        z.write(stage + "/h5p.json", "h5p.json")
        z.write(stage + "/content/content.json", "content/content.json")
    print(f"Built {out_path}")


def question_to_column_block(q):
    """Convert a QuestionSet's MultiChoice question entry into a Column content block."""
    return {
        "content": {
            "library": q["library"],
            "params": q["params"],
            "subContentId": str(uuid.uuid4()),
            "metadata": q.get("metadata", {"contentType": "Multiple Choice", "license": "U", "title": "Untitled Multiple Choice"}),
        },
        "useSeparator": "auto",
    }


# ---- Merge 1: Guided Practice (24, Column/Essay) + Classify the Error (22, QuestionSet) ----
guided = load(24)
classify_g = load(22)
merged_guided = {"content": list(guided["content"])}
merged_guided["content"].append({
    "content": {
        "library": "H5P.AdvancedText 1.1",
        "params": {"text": "<h2>Classify the Error</h2><p>Now practice identifying error types.</p>"},
        "subContentId": str(uuid.uuid4()),
        "metadata": {"contentType": "Text", "license": "U", "title": "Text"},
    },
    "useSeparator": "auto",
})
for q in classify_g["questions"]:
    merged_guided["content"].append(question_to_column_block(q))
write_column_package(merged_guided, "01.6 -- Guided Practice", "/tmp/h5p-build/unit-01-guided-merged.h5p")

# ---- Merge 2: Independent Practice (25, Column/Essay) + Classify the Error (23, QuestionSet) ----
indep = load(25)
classify_i = load(23)
merged_indep = {"content": list(indep["content"])}
merged_indep["content"].append({
    "content": {
        "library": "H5P.AdvancedText 1.1",
        "params": {"text": "<h2>Classify the Error</h2><p>Now practice identifying error types independently.</p>"},
        "subContentId": str(uuid.uuid4()),
        "metadata": {"contentType": "Text", "license": "U", "title": "Text"},
    },
    "useSeparator": "auto",
})
for q in classify_i["questions"]:
    merged_indep["content"].append(question_to_column_block(q))
write_column_package(merged_indep, "01.7 -- Independent Practice", "/tmp/h5p-build/unit-01-independent-merged.h5p")

# ---- Merge 3: fold Quick Reference (27, Column of text blocks) into Baseline's (26, QuestionSet) intro page ----
quickref = load(27)
baseline = load(26)
quickref_html = ""
for block in quickref["content"]:
    quickref_html += block["content"]["params"]["text"]
baseline["introPage"]["introduction"] = quickref_html + baseline["introPage"]["introduction"]
h5p_manifest = {
    "title": "01.12 -- ACT Math Baseline", "language": "en", "mainLibrary": "H5P.QuestionSet",
    "embedTypes": ["div"],
    "preloadedDependencies": [{"machineName": "H5P.QuestionSet", "majorVersion": "1", "minorVersion": "21"}],
}
baseline["title"] = "01.12 -- ACT Math Baseline"
baseline["metadata"] = {"title": "01.12 -- ACT Math Baseline"}
stage = "/tmp/h5p-build/_stage_unit-01-baseline-merged"
os.makedirs(stage + "/content", exist_ok=True)
with open(stage + "/h5p.json", "w") as f:
    json.dump(h5p_manifest, f)
with open(stage + "/content/content.json", "w") as f:
    json.dump(baseline, f)
with zipfile.ZipFile("/tmp/h5p-build/unit-01-baseline-merged.h5p", "w", zipfile.ZIP_DEFLATED) as z:
    z.write(stage + "/h5p.json", "h5p.json")
    z.write(stage + "/content/content.json", "content/content.json")
print("Built /tmp/h5p-build/unit-01-baseline-merged.h5p")

# ---- Merge 4: Baseline Reflection (28) + Final Reflection (29) into one two-part Column ----
refl_a = load(28)
refl_b = load(29)
merged_refl = {"content": []}
merged_refl["content"].append({
    "content": {
        "library": "H5P.AdvancedText 1.1",
        "params": {"text": "<h2>Part 1: Baseline Reflection</h2>"},
        "subContentId": str(uuid.uuid4()),
        "metadata": {"contentType": "Text", "license": "U", "title": "Text"},
    },
    "useSeparator": "auto",
})
merged_refl["content"].extend(refl_a["content"])
merged_refl["content"].append({
    "content": {
        "library": "H5P.AdvancedText 1.1",
        "params": {"text": "<h2>Part 2: Build Your Starting Strategy</h2>"},
        "subContentId": str(uuid.uuid4()),
        "metadata": {"contentType": "Text", "license": "U", "title": "Text"},
    },
    "useSeparator": "auto",
})
merged_refl["content"].extend(refl_b["content"])
write_column_package(merged_refl, "01.13 -- Unit 01 Reflection", "/tmp/h5p-build/unit-01-reflection-merged.h5p")

print("\nAll merges built. Block/question counts:")
print("guided:", len(merged_guided["content"]))
print("independent:", len(merged_indep["content"]))
print("reflection:", len(merged_refl["content"]))
