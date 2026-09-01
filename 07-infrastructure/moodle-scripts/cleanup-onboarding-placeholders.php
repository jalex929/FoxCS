<?php
// cleanup-onboarding-placeholders.php
//
// Unenrolls placeholder codename accounts (bulk-created ahead of the real roster
// filling in) from the onboarding course and Game of the Week, keeping only accounts
// confirmed as real students via the roster's login_email_sent column. See the
// foxcs_real_student_signal memory note for the full reasoning: Moodle itself has no
// field distinguishing real vs. placeholder accounts (every account uses the same
// synthetic @foxcs.local-style email), so the real signal only exists in the roster
// spreadsheet, not in Moodle.
//
// Run 2026-09-01 for 7th period Game II/Web II specifically (g7-/w7- prefixes) plus
// the known real g21-andromeda (1st period Game II). Confirmed via a QUERY() formula
// on the Roster tab (SELECT codename, login_email_sent WHERE ... = 'SENT') that only
// touched the codename and login_email_sent columns, never student emails. Also
// confirmed zero of the removed accounts had 'RESENT' or any other non-blank status,
// so nothing real was dropped.
//
// NOT YET RUN for Game I (g1-/g8-) or Seminar III (s4-/s5-) -- Jay explicitly deferred
// that broader cleanup ("for now I just want to make sure I have what I need to start
// the day tomorrow"). If extending this to those courses, regenerate $realusernames
// from a fresh roster query for that course's periods first -- don't reuse this list.
//
// Run: sudo -u www-data php cleanup-onboarding-placeholders.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/enrol/manual/lib.php');
require_once($CFG->libdir . '/enrollib.php');

\core\cron::setup_user();

// Real students confirmed via roster login_email_sent='SENT' (7th period Game II/Web II)
// plus the known real g21 (1st period Game II) account.
$realusernames = [
    'g7-nova', 'g7-orion', 'g7-comet', 'g7-quasar', 'g7-nebula', 'g7-lunar', 'g7-solar', 'g7-meteor',
    'w7-nova', 'w7-orion', 'w7-comet', 'w7-quasar', 'w7-nebula', 'w7-lunar', 'w7-solar', 'w7-meteor',
    'g21-andromeda',
];

$courses = ['onboarding' => 6, 'gotw' => 7];
foreach ($courses as $name => $courseid) {
    $enrolinstances = enrol_get_instances($courseid, true);
    $manualinstance = null;
    foreach ($enrolinstances as $inst) {
        if ($inst->enrol === 'manual') { $manualinstance = $inst; break; }
    }
    $manualplugin = enrol_get_plugin('manual');

    $sql = "SELECT u.id, u.username FROM {user} u
            JOIN {user_enrolments} ue ON ue.userid = u.id
            JOIN {enrol} e ON e.id = ue.enrolid AND e.courseid = ?
            WHERE u.deleted = 0 AND (u.username LIKE 'g7-%' OR u.username LIKE 'w7-%' OR u.username LIKE 'g21-%')";
    $enrolled = $DB->get_records_sql($sql, [$courseid]);

    $removed = 0;
    foreach ($enrolled as $u) {
        if (!in_array($u->username, $realusernames)) {
            $manualplugin->unenrol_user($manualinstance, $u->id);
            $removed++;
        }
    }
    echo "{$name} (id={$courseid}): removed {$removed} placeholder accounts\n";
}
echo "Done.\n";
