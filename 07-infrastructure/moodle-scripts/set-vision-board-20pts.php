<?php
// set-vision-board-20pts.php
//
// Changes "1.2 Vision Board" (FoxCS: Onboarding / Game II-Web II, assign
// id=1, cmid=200) from a 100-point scale to 20 points, per Jay's direct
// instruction 2026-09-09. Confirmed first that no grades have been entered
// yet (10 real submissions exist, 0 grades) -- safe to change the max
// directly with no rescaling needed. Uses the real grade_item API (not a
// raw grademax UPDATE) so the gradebook stays internally consistent.
//
// Run: sudo -u www-data php set-vision-board-20pts.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/gradelib.php');

\core\cron::setup_user();

$assignid = 1;
$assign = $DB->get_record('assign', ['id' => $assignid], '*', MUST_EXIST);
if ($assign->name !== '1.2 Vision Board') {
    fwrite(STDERR, "Unexpected assign name: {$assign->name}\n");
    exit(1);
}

$existinggrades = $DB->count_records_select('assign_grades', 'assignment = ? AND grade >= 0', [$assignid]);
if ($existinggrades > 0) {
    fwrite(STDERR, "Refusing to change scale: {$existinggrades} real grades already exist.\n");
    exit(1);
}

$DB->set_field('assign', 'grade', 20, ['id' => $assignid]);

$gradeitem = grade_item::fetch(['itemtype' => 'mod', 'itemmodule' => 'assign', 'iteminstance' => $assignid, 'courseid' => $assign->course]);
$gradeitem->grademax = 20;
$gradeitem->grademin = 0;
$gradeitem->update('assign_update_grades');

$gradeitem = grade_item::fetch(['id' => $gradeitem->id]);
echo "1.2 Vision Board now out of 20 points. grade_item id={$gradeitem->id}, grademax={$gradeitem->grademax}\n";
