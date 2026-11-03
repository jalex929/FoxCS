# Security and Licensing Audit: Public Exposure of jalex929/FoxCS

**Date:** 2026-11-03. **Scope:** working tree of `claude/foxcs-portfolio-prep-r9udyq` (branched from current main), plus a light look at git history. Pattern-based scan plus targeted reads, not a line-by-line legal or security review. Treat this as a starting list, not a certification that anything is safe.

## Headline

**`jalex929/FoxCS` is a public repository right now** (confirmed 2026-11-03: the unauthenticated GitHub API returns it). That matters well beyond portfolio prep. Everything below can be read today by anyone, students included, and this repo's own `CLAUDE.md` ("Protecting Assessment Content") assumes students will never see assessment content.

**Update, same day, per Jay:** FoxCS needs to stay public for now, and can go private "at some point." So the plan has two phases:

**While FoxCS is still public (mitigations that work without changing visibility):**

1. **Rotate every live quiz password and the Moodle test-account password** (item 2). This is the highest-value step: those passwords protect live assessments today, and rotating them makes the copies in source and git history worthless. Do it before the next Mastery Check opens.
2. **Stop committing new secrets.** Have new build scripts read quiz passwords from a git-ignored config file or environment variable on the droplet, not a literal in the script. A session can make this change on request. It's a scripts-only change.
3. **Decide about answer keys** (item 3). Options: (a) accept the risk until private, (b) move `teacher-materials/` and `*_KEY.md` files to a private location (they stay in git history, but are no longer one click away), or (c) rely on the Mastery Check password plus the 3-attempt average to limit the damage. Jay's call.
4. **Decide about licensed files** (item 1). Same trade-off: deleting them from the current tip makes them much less discoverable, but they stay in history. Only Jay can weigh that against whatever currently depends on them being in the repo.

**When it can go private:** GitHub, FoxCS repo, Settings, General, Danger Zone, **Change visibility to Private**. That closes the remaining exposure for every category below. A history rewrite is only needed if FoxCS is ever made public again after that.

Neither phase undoes past exposure (forks, clones, caches, anything already indexed), which is why rotation (step 1) comes first.

## Findings

### 1. Licensed certification-prep material (high)

`01-privacy-and-governance/licensing-boundaries.md` records that this material was obtained under an educational license. Nothing in the repo shows that license permits public redistribution.

| Path | Contents |
|---|---|
| `Python_v2_Student_Workbook.pdf` (11 MB) | GMetrix/Certiport Python workbook |
| `Python v2 Support Files/` | GMetrix Domain 1-6 starter files |
| `starter context/` (451 MB) | HTML5 App Dev, HTML & CSS, JavaScript INF-302, Software Development workbooks; HTML5, JavaScript, Java INF-304 support files; ITS OD 302/306 objective PDFs; Unity exam objective PDFs |
| `courses/python/python-certification-workbook-map.md`, `gmetrix-content-mapping.md`, video-resources and many lesson files | Derived references (workbook page/domain/subtopic labels, video titles). Lower risk than the files themselves, but tied to the same license |

Also in `Sample Content/`: third-party or colleague-authored PDFs, including `Unit 1 Exam_ Python Basics (V2) SY26.pdf` and `previous lesson content/KEY U1L2 + U1L3 Mastery Check.pdf` (an answer key).

### 2. Live credentials and assessment passwords (high)

Deliberately listed by folder, not file, while the repo is still public. To get the exact list once it's private, run `grep -rniE "password|quizpassword" --include=*.php --include=*.html --include=*.mjs .`

| Location | What |
|---|---|
| `07-infrastructure/moodle-scripts/` (several build/deploy scripts) | Live Moodle quiz passwords for Python Mastery Checks and a Seminar III quiz |
| `courses/python/content/unit_01_*/` | Mastery-check unlock passwords embedded in pages from the older folder-delivery format |
| `05-grader/sample-submissions/` | Copies of some of the same passwords |
| `02-authoring-system/tools/` | A Moodle test-account password plus a quiz password |
| Git history | A deleted passwords template CSV |

**Action regardless of visibility:** rotate every live quiz password and the test-account password. Then move them out of source and into the droplet's environment or Moodle itself, so scripts read them at run time.

### 3. Assessment answer keys (high, given the repo is public)

`courses/python/teacher-materials/**/lesson_01_0*_mastery_check_KEY.md`, `courses/python/content/unit_02_*/**/teacher-materials/mastery_check_key.md`, `courses/seminar-iii/teacher-materials/*answer-key*.html`, plus the `Sample Content` key PDF. Making the repo private resolves this.

### 4. Real-format pseudonyms and staff contact details (medium)

- Pseudonyms in the real roster format (`PY1-A-ALPHA01`, `PY1-A-DELTA04`, and others) appear in policy docs, source material, and grader fixtures. They're described as examples, not real students, but they match the live format and may coincide with assigned slots. The format itself is also a recon aid.
- District email addresses: Jay's and one other staff member's (`jjreid1@...`), in docs. The second one is someone else's contact detail and shouldn't be public without their OK.

### 5. Infrastructure details (medium)

Server IP addresses in `decisions-log.md` and `worklog.md`, the live domain, absolute server paths, DB table names, the backup location, and the cron schedule. Each is low risk alone. Together they're a map of the live student system.

### 6. Student-data handling claims (interview risk, not a leak)

The docs are careful (good), but say so precisely in interviews: pseudonymous usernames reduce risk but are not anonymity. Real submissions have gone to an AI tool during grading passes. `codename-policy.md` already flags that SOPPA compliance hasn't been confirmed with the district privacy officer. Don't describe the system as "compliant" until that's done.

## What was done this session

- Built `portfolio-showcase/`: a sanitized, self-contained public version with synthetic data only. It shares no files with the categories above.
- Added `portfolio-showcase/tools/check_showcase_clean.py`, which fails CI if any category above shows up in the showcase. Run against this repo's `05-grader/` as a sanity check, it flags 45 findings (as expected).
- Added `export_showcase.sh`, which creates the new repo with **fresh history**, so nothing above can be recovered from the showcase's git log.
- **Not done (needs Jay):** changing FoxCS visibility (it stays public for now, per Jay), rotating passwords, any history rewrite, and any deletion from this repo. None of these were attempted.

## If FoxCS must ever become public again

Make it private first, then run a full history rewrite (e.g. `git filter-repo`) that removes `starter context/`, `Python v2 Support Files/`, `Python_v2_Student_Workbook.pdf`, `Sample Content/`, every `teacher-materials/` path, and the password-bearing scripts. Force-push, ask GitHub support to purge cached views, and rotate everything in item 2 anyway. This is destructive and invalidates every clone, so it's a deliberate decision, not a default. The fresh-history showcase is the recommended alternative.
