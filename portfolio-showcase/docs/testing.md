# Testing and validation

Every suite here runs with a standard Python install (3.10+), no dependencies. CI runs all of them on every push: [`.github/workflows/tests.yml`](../.github/workflows/tests.yml).

## How to run

```bash
python -m unittest discover -s grader/tests -v    # deterministic grader
python -m unittest discover -s evals/tests -v     # eval harness
python -m unittest discover -s tools/tests -v     # leak scanner
python tools/check_showcase_clean.py              # leak scan of this repo
python evals/run_evals.py                         # eval suite vs. reference judgments
```

Successful output ends with `OK` for each unittest suite, `Clean: no known private-workspace patterns found.` for the scanner, and `Cases passed: 6/6` for the eval run.

## What is covered

### Deterministic grader: 39 tests

| Area | Cases |
|---|---|
| Telemetry parsing | First vs. last attempt correctness, missing telemetry block, malformed JSON, no matching event type |
| Vocab quiz | Not saved, saved with reflection, empty reflection, XP only when all correct and reflection present |
| Practice drills | First-try correctness counted per drill, not per event |
| Mastery check | Timing with and without milliseconds (regression test for a real bug), missing timestamp |
| Flashcards | XP only with the reviewed marker |
| File naming | Exact match preferred over fuzzy, fuzzy match flagged and penalized, penalty never zeroes real work, untouched template earns nothing |
| Needs-review manifest | Only judgment-required files listed, both naming forms of a written mastery check caught |
| End to end | Full run against a synthetic submission whose persona is documented in [`grader/sample-submissions/README.md`](../grader/sample-submissions/README.md), asserting exact values |

### Eval harness: 13 tests

Each of the 11 checks in `evals/score_output.py` has a test that feeds it a deliberately broken output (injection followed, invented rubric criterion, wrong arithmetic, unapproved bonus, null maximum, missed misconception, invented evidence on missing work, credit without evidence, escalation without reasons, empty next step) and asserts that the right check fails. The reference outputs must pass every check. A check that cannot fail is not tested.

### Leak scanner: 3 tests

Each leak category it claims to catch is caught, clean text passes, and binary files are flagged for review.

## What is not covered here

Honest gaps, so nobody has to guess:

- **No baseline model runs yet.** The eval harness validates outputs, but this repository does not yet include outputs from an actual model run. That is the next step for `evals/`.
- **The eval checks are deterministic.** They catch structural and rule violations (arithmetic, rubric coverage, escalation, forbidden claims). They do not judge whether feedback is genuinely helpful. That needs educator review or a carefully validated model-graded rubric, and is planned.
- **Platform tests live in the private workspace.** The live platform has its own CI: content checkers with their own test suites, a PHP harness for the practice-ladder wiring checker, and a headless-browser test proving a student's typed answer survives save on a real lesson page. Those depend on licensed course content and are not reproduced here.
- **No load or concurrency testing.** Class sizes have not required it.
- **Six eval cases is a starting set**, chosen for coverage of distinct failure modes rather than statistical power.

## Why this shape

For a system whose outputs reach students, a reproducible test suite with honest gaps is more useful evidence than a coverage percentage. The deterministic tier is tested the conventional way. The probabilistic tier is tested by fixing the expectations and checking any output against them, so prompt changes and model changes can be compared on the same cases.
