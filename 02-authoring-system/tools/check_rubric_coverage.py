#!/usr/bin/env python3
"""
Every item a student can submit for feedback has a rubric. Standard library only.

Per Jay (2026-11-04): "We need to make sure every assignment and thing that
students can submit for feedback has a rubric." This reads a course's
submittables.json and checks each entry:

  - a LIVE item must point at a rubric file that exists, has real criteria
    (at least 2 checklist items, table rows, or numbered criteria), and has
    no unresolved TODO/TBD placeholder. Any failure exits 1.
  - an item not live yet with the same problems is reported as a warning, so
    the gap is visible before it ships.
  - an item that needs no rubric must say why in "exempt". An empty reason fails.

Usage:
    python 02-authoring-system/tools/check_rubric_coverage.py courses/python/submittables.json
"""

from __future__ import annotations

import json
import re
import sys
from pathlib import Path

REPO_ROOT = Path(__file__).resolve().parents[2]
# A checklist item, a table row, a numbered criterion, or an "## Item N" heading
# (the format the Mastery Check answer keys use: one accepted answer per item).
CRITERION = re.compile(r"^\s*(?:[-*] \[[ xX]\]|\|(?!\s*-)[^|\n]*\||(?:\*\*)?\d+[.)]|#{2,4} (?:Item|Criterion|Question) \d+)", re.M)
TABLE_HEADER_RULE = re.compile(r"^\s*\|[\s:|-]+\|\s*$", re.M)
PLACEHOLDER = re.compile(r"\b(?:TODO|TBD|FIXME)\b")
MIN_CRITERIA = 2


def criteria_count(text: str) -> int:
    """Checklist items, numbered criteria, and table rows (header rows and the
    |---| rule excluded) that could each be one gradable criterion."""
    lines = text.splitlines()
    count = 0
    for i, line in enumerate(lines):
        if not CRITERION.match(line) or TABLE_HEADER_RULE.match(line):
            continue
        is_table_header = line.lstrip().startswith("|") and i + 1 < len(lines) and TABLE_HEADER_RULE.match(lines[i + 1])
        if not is_table_header:
            count += 1
    return count


def check_rubric(path: Path) -> list[str]:
    """Problems with one rubric file. Empty means it passes."""
    if not path.is_file():
        return ["rubric file is missing"]
    text = path.read_text(encoding="utf-8")
    if not text.strip():
        return ["rubric file is empty"]
    problems = []
    n = criteria_count(text)
    if n < MIN_CRITERIA:
        problems.append(f"rubric has {n} criteria, needs at least {MIN_CRITERIA} (checklist items, table rows, numbered criteria, or Item headings)")
    placeholders = sorted(set(PLACEHOLDER.findall(text)))
    if placeholders:
        problems.append(f"rubric still has a placeholder: {', '.join(placeholders)}")
    return problems


def check_manifest(manifest: dict, root: Path = REPO_ROOT) -> tuple[list[str], list[str]]:
    """(errors, warnings) for a whole submittables.json."""
    errors: list[str] = []
    warnings: list[str] = []
    seen: set[str] = set()
    for item in manifest["items"]:
        label = f"{item['id']} ({item['name']})"
        if item["id"] in seen:
            errors.append(f"{label}: duplicate id")
        seen.add(item["id"])
        if "exempt" in item:
            if not str(item["exempt"]).strip():
                errors.append(f"{label}: exempt with no reason")
            continue
        if not item.get("rubric"):
            (errors if item["live"] else warnings).append(f"{label}: no rubric listed")
            continue
        for problem in check_rubric(root / item["rubric"]):
            (errors if item["live"] else warnings).append(f"{label}: {problem} ({item['rubric']})")
    return errors, warnings


def main(argv: list[str] | None = None) -> int:
    args = sys.argv[1:] if argv is None else argv
    if len(args) != 1:
        print(__doc__.strip().splitlines()[-1].strip())
        return 2
    manifest = json.loads(Path(args[0]).read_text(encoding="utf-8"))
    errors, warnings = check_manifest(manifest)
    total = len(manifest["items"])
    for w in warnings:
        print(f"WARNING (not live yet): {w}")
    for e in errors:
        print(f"MISSING RUBRIC: {e}")
    exempt = sum("exempt" in i for i in manifest["items"])
    if errors:
        print(f"\n{len(errors)} live item(s) without a usable rubric, out of {total}. Write the rubric before anything else ships.")
        return 1
    print(f"All live items have a rubric ({total} items, {exempt} exempt with a reason, {len(warnings)} warning(s)).")
    return 0


if __name__ == "__main__":  # pragma: no cover
    sys.exit(main())
