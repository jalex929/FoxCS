#!/usr/bin/env python3
"""
Every question's expected answer is what Python actually does, and its
wording says what is true. Standard library only.

Per Jay (2026-11-04): "We need to put in some content checks and tests for
when we put in questions to make sure the expected answer(s) are correct,
the question is worded properly, and that the logic is solid for all of it."

Reads a question-checks file (courses/python/question-checks/*.json) and,
for each item:

  predict_output  the code runs and prints exactly the expected output
  fix_line        the broken line fails with the named error; the fix runs
                  and prints the expected output; "N mistakes" in the task
                  text matches the mistakes listed; "displays: X" / displays
                  "X" in the task text matches the expected output

and for both kinds:
  - the task text in the live build script is the one the item describes
    (its code, or its broken line, appears in the task's <pre> block)
  - the teacher key's section for that item states the same answer

Then, for every task in the listed build scripts (whether or not it has an
item), wording checks: balanced tags, no doubled spaces, ends in
punctuation. A task that claims a count of mistakes, asks for a prediction,
or asks for a line to be fixed must have an item, so no checkable claim
goes unchecked.

Usage:
    python 02-authoring-system/tools/check_question_bank.py courses/python/question-checks/unit_01.json
"""

from __future__ import annotations

import html
import json
import re
import subprocess
import sys
from pathlib import Path

REPO_ROOT = Path(__file__).resolve().parents[2]
NUMBER_WORDS = {"one": 1, "two": 2, "three": 3, "four": 4, "five": 5}
TASK_LIST = re.compile(r"\$(?:new)?tasks\s*=\s*\[(.*?)\n\];", re.S)
TASK_STRING = re.compile(r"""^\s*(?:'((?:[^'\\]|\\.)*)'|"((?:[^"\\]|\\.)*)"),?\s*$""", re.M)
TAGS = ("p", "pre", "code", "strong", "em")
COUNT_CLAIM = re.compile(r"\bhas (one|two|three|four|five) mistakes?\b", re.I)
NEEDS_ITEM = re.compile(r"\bhas (?:one|two|three|four|five) mistakes?\b|\bpredict\b|\bfix this line\b|\brewrite it correctly\b", re.I)


def run_python(code: str, timeout: float = 10.0) -> tuple[int, str, str]:
    """Runs code in an isolated Python process. (exit code, stdout, stderr)"""
    proc = subprocess.run([sys.executable, "-I", "-c", code], capture_output=True, encoding="utf-8",
                          timeout=timeout, env={"PYTHONIOENCODING": "utf-8"}, check=False)
    return proc.returncode, proc.stdout, proc.stderr


def load_tasks(script: Path) -> list[str]:
    """The task strings in a Mastery Check build script, in order (1-based in items)."""
    match = TASK_LIST.search(script.read_text(encoding="utf-8"))
    if not match:
        return []
    out = []
    for single, double in TASK_STRING.findall(match.group(1)):
        raw = single if single else double
        out.append(raw.replace("\\'", "'").replace('\\"', '"'))
    return out


def pre_blocks(task: str) -> list[str]:
    return [html.unescape(b) for b in re.findall(r"<pre>(.*?)</pre>", task, re.S)]


def plain(task: str) -> str:
    return html.unescape(re.sub(r"<[^>]+>", " ", task))


def wording_problems(task: str) -> list[str]:
    problems = []
    for tag in TAGS:
        opened, closed = len(re.findall(rf"<{tag}\b", task)), task.count(f"</{tag}>")
        if opened != closed:
            problems.append(f"<{tag}> opened {opened} times, closed {closed}")
    text = plain(task)
    outside_code = re.sub(r"<pre>.*?</pre>|<code>.*?</code>", "CODE", task, flags=re.S)
    if "  " in re.sub(r"<[^>]+>", "", outside_code).strip():
        problems.append("doubled space in the task text")
    if not re.search(r"[.?!:)]\s*$", text.strip()) and "</pre>" not in task[-12:]:
        problems.append("task text doesn't end in punctuation")
    return problems


def key_section(key_text: str, index: int) -> str:
    match = re.search(rf"^## Item {index}\b.*?(?=^## |\Z)", key_text, re.M | re.S)
    return match.group(0) if match else ""


def check_item(item: dict, root: Path = REPO_ROOT) -> list[str]:
    """Every problem with one item. Empty means its answer and wording hold."""
    problems: list[str] = []
    tasks = load_tasks(root / item["source"]["script"])
    index = item["source"]["index"]
    if not 1 <= index <= len(tasks):
        return [f"no task {index} in {item['source']['script']} (it has {len(tasks)})"]
    task = tasks[index - 1]
    blocks = pre_blocks(task)
    shown = item["code"] if item["kind"] == "predict_output" else item["broken"]
    if shown not in blocks:
        problems.append("the task's <pre> block doesn't match this item's code: the bank and the live task have drifted apart")

    if item["kind"] == "predict_output":
        code, out, err = run_python(item["code"])
        if code != 0:
            problems.append(f"the code doesn't run: {err.strip().splitlines()[-1] if err.strip() else 'exit ' + str(code)}")
        elif out != item["expected_output"]:
            problems.append(f"expected output {item['expected_output']!r}, but Python prints {out!r}")
        answer_lines = item["expected_output"].splitlines()
    else:
        code, _, err = run_python(item["broken"])
        if code == 0:
            problems.append("the broken line actually runs without an error")
        elif item["broken_error"] not in err:
            problems.append(f"the broken line raises {err.strip().splitlines()[-1]!r}, not {item['broken_error']}")
        code, out, err = run_python(item["fixed"])
        if code != 0:
            problems.append(f"the fix doesn't run: {err.strip().splitlines()[-1]}")
        elif out != item["expected_output"]:
            problems.append(f"the fix prints {out!r}, not {item['expected_output']!r}")
        text = plain(task)
        claimed = COUNT_CLAIM.search(text)
        if claimed and NUMBER_WORDS[claimed.group(1).lower()] != len(item["mistakes"]):
            problems.append(f"the task says {claimed.group(0)!r}, but {len(item['mistakes'])} are listed: {', '.join(item['mistakes'])}")
        if not claimed and len(item["mistakes"]) > 1:
            problems.append(f"{len(item['mistakes'])} mistakes are listed, but the task doesn't say how many there are")
        prose = plain(re.sub(r"<pre>.*?</pre>", " ", task, flags=re.S)).strip()
        target = re.search(r"displays?:?\s*\"([^\"]+)\"|displays?:\s*(.+?)\s*$", prose)
        if target:
            said = (target.group(1) or target.group(2)).strip()
            if said + "\n" != item["expected_output"]:
                problems.append(f"the task says it displays {said!r}, but the expected output is {item['expected_output']!r}")
        answer_lines = [item["fixed"]]

    section = key_section((root / item["key"]).read_text(encoding="utf-8"), index)
    if not section:
        problems.append(f"the key has no '## Item {index}' section")
    else:
        missing = [line for line in answer_lines if line and line not in section]
        if missing:
            problems.append(f"the key's Item {index} doesn't state: {', '.join(repr(m) for m in missing)}")
    return problems


def check_bank(bank: dict, root: Path = REPO_ROOT) -> list[str]:
    errors = []
    covered: set[tuple[str, int]] = set()
    for item in bank["items"]:
        covered.add((item["source"]["script"], item["source"]["index"]))
        errors += [f"{item['id']}: {p}" for p in check_item(item, root)]
    for script in bank.get("scripts", []):
        for i, task in enumerate(load_tasks(root / script), 1):
            label = f"{Path(script).name} task {i}"
            errors += [f"{label}: {p}" for p in wording_problems(task)]
            if NEEDS_ITEM.search(plain(task)) and (script, i) not in covered:
                errors.append(f"{label}: makes a checkable claim (a prediction, a fix, or a count of mistakes) but has no item in the bank")
    return errors


def main(argv: list[str] | None = None) -> int:
    args = sys.argv[1:] if argv is None else argv
    if len(args) != 1:
        print(__doc__.strip().splitlines()[-1].strip())
        return 2
    bank = json.loads(Path(args[0]).read_text(encoding="utf-8"))
    errors = check_bank(bank)
    for e in errors:
        print(f"PROBLEM: {e}")
    if errors:
        print(f"\n{len(errors)} problem(s) in {args[0]}.")
        return 1
    print(f"All {len(bank['items'])} items verified by running them; wording checked on every task in {len(bank.get('scripts', []))} script(s).")
    return 0


if __name__ == "__main__":  # pragma: no cover
    sys.exit(main())
