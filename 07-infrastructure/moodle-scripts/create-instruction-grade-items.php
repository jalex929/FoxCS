<?php
// create-instruction-grade-items.php
//
// Per grade-point-scale.md and Jay's 2026-09-10 instruction ("as long as
// they have gone through and responded to the different interactive
// elements in the instruction page, they will get the credit"): Instruction
// pages get a real Moodle grade (5 points), full credit on genuine
// completion, no partial credit for getting items wrong.
//
// Instruction pages are self-contained-HTML mod_resource modules -- no
// native grade field exists on a resource. This creates one manual grade_item
// per lesson's Instruction cmid, with a predictable idnumber
// ('instruction-grade-cmid-<cmid>') that log.php's lesson_complete handler
// looks up directly (see that file's matching 2026-09-10 change) to award
// the grade in real time, the moment a student's lesson_complete telemetry
// event fires -- no separate batch/regrade script, no delay, no student
// left wondering whether it registered.
//
// Safe to re-run: skips any cmid that already has a matching grade_item.
//
// Run: sudo -u www-data php create-instruction-grade-items.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/gradelib.php');

\core\cron::setup_user();

const GRADE_MAX = 5.0;

// cmid => display name, confirmed live via direct DB query 2026-09-10.
$lessons = [
    245 => '2.1 Variables and Memory: Instruction',
    259 => '2.2 Integers: Instruction',
    260 => '2.3 Floats: Instruction',
    261 => '2.4 Strings: Instruction',
    262 => '2.5 Booleans: Instruction',
];

$courseid = 2; // foxcs-python

foreach ($lessons as $cmid => $name) {
    $idnumber = 'instruction-grade-cmid-' . $cmid;

    $existing = $DB->get_record('grade_items', ['courseid' => $courseid, 'idnumber' => $idnumber]);
    if ($existing) {
        echo "cmid={$cmid} ({$name}): grade_item already exists (id={$existing->id}), skipped.\n";
        continue;
    }

    $gradeitem = new grade_item(['courseid' => $courseid], false);
    $gradeitem->itemtype = 'manual';
    $gradeitem->itemname = $name . ' (completion credit)';
    $gradeitem->idnumber = $idnumber;
    $gradeitem->gradetype = GRADE_TYPE_VALUE;
    $gradeitem->grademax = GRADE_MAX;
    $gradeitem->grademin = 0;
    $gradeitem->insert('foxcs');

    echo "cmid={$cmid} ({$name}): created grade_item id={$gradeitem->id}, idnumber={$idnumber}, max=" . GRADE_MAX . "\n";
}

echo "Done.\n";
