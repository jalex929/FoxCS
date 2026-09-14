"""
check-submission-windows.py

Cross-references Moodle Mastery Check attempt finish times against the real
Von Steuben bell schedule (https://www.vonsteuben.org/apps/bell_schedules/,
SY2025-2026) to flag whether each attempt happened during the student's
actual class period, as a post-hoc differentiator -- not a live access gate.
Per Jay directly (2026-09-14): no password/time-lock on the quiz itself
(students, and any substitute covering the class, should never be blocked
by a gate), but every graded attempt's timestamp gets checked against the
real schedule so an out-of-window attempt is visible during grading.

Currently scoped to Game I (Python), whose students are only ever 1st or
8th period. Extend WINDOWS/PERIODS_BY_COURSE if this needs to cover a
course with other periods.

Usage:
    python3 check-submission-windows.py <attempts.json> <roster.csv>

<attempts.json>: array of objects with at least "codename" and "timefinish"
  (Unix timestamp, as produced by 07-infrastructure/moodle-scripts export
  scripts -- see e.g. the Unit 01 essay-response export from 2026-09-11).
<roster.csv>: the FoxCS private roster CSV (course, class_period, codename
  columns) -- e.g. "FoxCS Private Roster ... - Corrected Passwords ....csv".
Both are private/local files, never committed to this repo.
"""
import json
import csv
import sys
from datetime import datetime
from zoneinfo import ZoneInfo

TZ = ZoneInfo("America/Chicago")

# Real bell schedule, Von Steuben, SY2025-2026. Friday is shorter and has a
# Div block; Monday-Thursday is the standard 51-min-period day.
WINDOWS = {
    "mon_thu": {
        "1st": ("08:00", "08:51"),
        "8th": ("14:27", "15:18"),
    },
    "fri": {
        "1st": ("08:00", "08:41"),
        "8th": ("13:34", "14:15"),
    },
}


def in_window(dt, period):
    if dt.weekday() not in (0, 1, 2, 3, 4):
        return False, "weekend"
    sched = WINDOWS["fri"] if dt.weekday() == 4 else WINDOWS["mon_thu"]
    if period not in sched:
        return None, f"no known window for period '{period}'"
    start_s, end_s = sched[period]
    start = dt.replace(hour=int(start_s[:2]), minute=int(start_s[3:]), second=0, microsecond=0)
    end = dt.replace(hour=int(end_s[:2]), minute=int(end_s[3:]), second=59, microsecond=0)
    return (start <= dt <= end), None


def load_codename_periods(roster_csv_path, course_filter="Game I"):
    codename_period = {}
    with open(roster_csv_path, encoding="utf-8-sig", newline="") as f:
        for row in csv.DictReader(f):
            if row.get("course", "").strip() == course_filter and row.get("codename", "").strip():
                codename_period[row["codename"].strip().lower()] = row["class_period"].strip()
    return codename_period


def main():
    if len(sys.argv) != 3:
        print(__doc__)
        sys.exit(1)
    attempts_path, roster_path = sys.argv[1], sys.argv[2]

    codename_period = load_codename_periods(roster_path)
    with open(attempts_path, encoding="utf-8") as f:
        attempts = json.load(f)

    in_count = out_count = unknown = 0
    out_examples = []
    for a in attempts:
        period = codename_period.get(a["codename"].strip().lower())
        if not period:
            unknown += 1
            continue
        dt = datetime.fromtimestamp(int(a["timefinish"]), tz=TZ)
        ok, reason = in_window(dt, period)
        if ok:
            in_count += 1
        else:
            out_count += 1
            out_examples.append((a["codename"], a.get("lesson", "?"), period,
                                  dt.strftime("%a %Y-%m-%d %I:%M %p"), reason or "outside window"))

    total = in_count + out_count
    print(f"Total attempts checked: {total} (unmatched codename: {unknown})")
    if total:
        print(f"In class-period window: {in_count} ({in_count/total*100:.1f}%)")
        print(f"Outside class-period window: {out_count} ({out_count/total*100:.1f}%)")
    if out_examples:
        print("\nOut-of-window attempts:")
        for codename, lesson, period, when, reason in out_examples:
            print(f"  {codename:14s} lesson={lesson:6s} period={period:4s} finished={when:22s} {reason}")


if __name__ == "__main__":
    main()
