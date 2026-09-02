import json

with open(r"C:\Users\JAYFOX~1\AppData\Local\Temp\essay_semantics_raw.json", "rb") as f:
    raw = f.read()

PLACEHOLDER = b"\x00BACKSLASH\x00"
text = raw.replace(b"\\\\", PLACEHOLDER).replace(b"\\n", b"\n").replace(PLACEHOLDER, b"\\")
text = text.decode("utf-8").strip()

data = json.loads(text)
print("parsed OK, top-level items:", len(data))
print("TOP LEVEL fields:", [d["name"] for d in data])

def find(fields, name):
    for f in fields:
        if f.get("name") == name:
            return f

kw = find(data, "keywords")
print("\n--- keywords field ---")
print(json.dumps(kw, indent=2))
