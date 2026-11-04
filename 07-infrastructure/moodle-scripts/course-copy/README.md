# Course copy: a working version of a live course

`duplicate-course.php` makes a hidden copy of a live course (default: `foxcs-python` -> `foxcs-python-dev`) to build and test changes in without touching student grades. **Not run yet.** It needs a session on the droplet.

## What comes across, and what never does

- **Copied:** every section, activity, resource and file, quizzes and their questions, rubrics, settings, and gradebook *structure*.
- **Never copied:** users, enrolments, role assignments, grades, grade history, submissions, quiz attempts, completion state, comments, badge awards, or logs.
  - The backup's user-data settings are unlocked and then forced off, so a site default can't turn them back on.
  - The script checks the finished copy and stops loudly if it holds a single enrolment or grade.

## The part a plain Moodle copy gets wrong

The deploy scripts stamp each Instruction page's real `cmid` into its HTML (`var CMID = "..."`), and pages link to other activities by ID. Moodle's restore fixes links in activity descriptions, but **not inside uploaded files**. So a plain copy's pages would log progress, mark completion, and award the Instruction grade on the **live** activities.

After restoring, the script fixes that:

1. **Pair modules.** It pairs every live module with its copy: same section, type and name, in order. It stops if anything doesn't line up.
2. **Rewrite page files.** It rewrites every copied page file:
   - the telemetry `CMID`;
   - `/mod/<type>/view.php?id=` links;
   - `/course/view.php?id=` links.
3. **Report leftovers.** It lists any IDs it couldn't map, so they can be checked by hand.

The pairing and rewriting are plain PHP in `copy_lib.php`, tested by `tests/test_copy_lib.php` (CI: `.github/workflows/course-copy-tests.yml`).

## Run it

```bash
/home/jay/moodle-backups/backup_moodle.sh          # backup first, always (CLAUDE.md "Data Safety")
cd /opt/foxcs/07-infrastructure/moodle-scripts/course-copy   # or wherever this repo is checked out on the droplet
sudo -u www-data php duplicate-course.php                            # read the plan
sudo -u www-data php duplicate-course.php --apply                    # make the copy
sudo -u www-data php ../enrol-admin-as-teacher.php                   # enrols the admin in every foxcs-* course, the copy included
```

Then enrol the test student account in the copy, and work there.

## Things to know about the copy

- **Mastery Check passwords** come across as they are. The daily class-code rotation only touches the courses it's pointed at. In the copy, set them yourself or run `apply-mastery-check-access.php --course=foxcs-python-dev`.
- **Activity ID numbers come across too**, so if the grading queue plugin allowlists a Coding Exercise, test submissions in the copy are queued as well. That's useful for testing the worker. Their submission IDs can't collide with live ones, and nothing is ever released without approval.
- **Promoting changes back to the live course** is a separate, deliberate step: the same deploy scripts, pointed at `foxcs-python`, after the publish checklist in CLAUDE.md. The copy is never synced back automatically.
