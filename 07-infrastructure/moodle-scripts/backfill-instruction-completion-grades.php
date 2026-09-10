<?php
// backfill-instruction-completion-grades.php
//
// The real-time grade-on-completion hook added to log.php today (2026-09-10)
// only fires for NEW lesson_complete events going forward. Students who
// already finished 2.1-2.5's Instruction pages before this mechanism
// existed have a real completion event on record but never got graded for
// it -- this closes that gap so nobody who already did the work is left
// showing 0/5 for something they genuinely completed.
//
// For each lesson_complete row already in local_foxcstelemetry_log for a
// wired-up Instruction cmid, sets that student's grade to full credit,
// same as the live hook would have. Safe to re-run (update_final_grade is
// idempotent for an unchanged grade).
//
// Run: sudo -u www-data php backfill-instruction-completion-grades.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/gradelib.php');

\core\cron::setup_user();

$courseid = 2; // foxcs-python
$cmids = [245, 259, 260, 261, 262];

$total = 0;
foreach ($cmids as $cmid) {
    $idnumber = 'instruction-grade-cmid-' . $cmid;
    $gradeitem = grade_item::fetch(['courseid' => $courseid, 'idnumber' => $idnumber]);
    if (!$gradeitem) {
        fwrite(STDERR, "No grade_item for cmid={$cmid} (idnumber={$idnumber}) -- run create-instruction-grade-items.php first.\n");
        continue;
    }

    $userids = $DB->get_fieldset_sql(
        "SELECT DISTINCT userid FROM {local_foxcstelemetry_log} WHERE cmid = ? AND eventtype = 'lesson_complete'",
        [$cmid]
    );

    foreach ($userids as $userid) {
        $gradeitem->update_final_grade($userid, $gradeitem->grademax, 'foxcstelemetry_backfill');
        $total++;
    }

    echo "cmid={$cmid}: backfilled " . count($userids) . " students.\n";
}

echo "Done. {$total} grades set.\n";
