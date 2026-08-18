# Data and Spreadsheets (not yet built)

Placeholder. The dashboard is what makes the 1-hour/week grading budget (see `../05-grader/README.md`) actually achievable — it's not just a report, it's the interface the weekly review happens through.

## Two Sheets, Never Merged

- **Private roster tab** — codename ↔ real name ↔ email ↔ guardian email ↔ section. Teacher-only. See `../01-privacy-and-governance/data-boundaries.md`.
- **Grading/results tab** — codename-only. Safe to hand to any AI tool.

## Required Output: Focus Groups, Not Just Scores

Every weekly pass must surface, without extra teacher work:

- Students behind / missing submissions
- Students ready to reassess or extend
- Misconception groupings (which students share a misconception code, ready-made for small-group intervention)
- Low-confidence grades needing closer review
- Similarity and proficiency-consistency flags needing review

This is the same data as the results tab, just viewed differently — dashboard views, not a separate report to generate.

## Expected Structure (from the handoff doc, not yet created)

```
06-data-and-spreadsheets/
  dashboard-schema.md
  roster-schema.md
  grading-export-schema.md
  misconception-codes.md
  small-group-rules.md
  communication-workflow.md
  templates/
    roster-template.xlsx
    grading-dashboard-template.xlsx
    misconception-template.xlsx
  apps-script/
    generate-student-drafts.gs
    generate-guardian-drafts.gs
    generate-html-reports.gs
    approval-controls.gs
```

No email (student feedback or guardian update) sends automatically — every draft waits for explicit teacher approval, per `../01-privacy-and-governance/data-boundaries.md`.
