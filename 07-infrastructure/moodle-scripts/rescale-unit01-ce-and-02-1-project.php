<?php
// rescale-unit01-ce-and-02-1-project.php
//
// Applies 02-authoring-system/grade-point-scale.md's settled scale to the
// live foxcs-python course, per Jay's direct 2026-09-10 go-ahead ("rescale
// everything"). Confirmed live via direct DB query first (not assumed):
//
//   Unit 01 Coding Exercises (01.3-01.6, assign ids 3-6) -- grade=100,
//   ZERO real submitted+graded rows in mdl_assign_grades. Safe to change
//   grademax directly, no rescaling of existing grades needed.
//
//   02.1 Project (assign id=8, cmid=248) -- grade=100, ZERO real graded
//   rows. Safe to change directly to the new nominal 25.
//
// Deliberately NOT touched here: Unit 01's 6 Mastery Check quizzes
// (ids 2,3,5,6,7,8). Those DO have real recorded grades (up to 54
// students on 01.1), but mdl_quiz_grades (the per-attempt cache
// quiz_update_grades() reads from) is empty for 5 of the 6 quizzes even
// though mdl_grade_grades has real finalgrade values -- a real, not-yet-
// understood mismatch. Rescaling those needs that resolved first, not a
// blind regrade against possibly-stale/absent cache data. Flagged in
// worklog.md/decisions-log.md, not done in this script.
//
// Run: sudo -u www-data php rescale-unit01-ce-and-02-1-project.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/gradelib.php');

\core\cron::setup_user();

function set_assign_grade(int $assignid, string $expectedname, float $newgrade): void {
    global $DB;

    $assign = $DB->get_record('assign', ['id' => $assignid], '*', MUST_EXIST);
    if ($assign->name !== $expectedname) {
        fwrite(STDERR, "Unexpected assign name for id={$assignid}: {$assign->name} (expected {$expectedname})\n");
        exit(1);
    }

    $existinggrades = $DB->count_records_select('assign_grades', 'assignment = ? AND grade >= 0', [$assignid]);
    if ($existinggrades > 0) {
        fwrite(STDERR, "Refusing to change scale for assign id={$assignid} ({$expectedname}): {$existinggrades} real grades already exist.\n");
        exit(1);
    }

    $DB->set_field('assign', 'grade', $newgrade, ['id' => $assignid]);

    $gradeitem = grade_item::fetch([
        'itemtype' => 'mod',
        'itemmodule' => 'assign',
        'iteminstance' => $assignid,
        'courseid' => $assign->course,
    ]);
    $gradeitem->grademax = $newgrade;
    $gradeitem->grademin = 0;
    $gradeitem->update('assign_update_grades');

    echo "assign id={$assignid} ({$expectedname}) now grade={$newgrade}\n";
}

// Unit 01 Coding Exercises: grade=100 -> grade=10, per grade-point-scale.md.
set_assign_grade(3, '01.3 Coding Exercise', 10);
set_assign_grade(4, '01.4 Coding Exercise', 10);
set_assign_grade(5, '01.5 Coding Exercise', 10);
set_assign_grade(6, '01.6 Coding Exercise', 10);

// 02.1 Project: grade=100 -> grade=25 (nominal, Skilled/on-level tier).
// The XP-to-percent bonus mechanism is wired separately -- see
// wire-project-xp-bonus.php.
set_assign_grade(8, '2.1 Project: Character Status Tracker', 25);

echo "Done.\n";
