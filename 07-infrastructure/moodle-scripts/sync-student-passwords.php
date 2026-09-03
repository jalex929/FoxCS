<?php
// sync-student-passwords.php
//
// Forces every real student's Moodle account password to match the roster
// spreadsheet's "initial_password" column (the sheet is titled "Corrected
// Passwords" -- this script is what actually applies that correction to
// Moodle, which a prior pass evidently only recorded in the sheet for a
// handful of accounts). Read-only for enrollment: reports mismatches against
// the codename-prefix -> course mapping, never changes enrollment itself.
// Never creates accounts -- missing codenames are reported, not created.
//
// Input: /tmp/roster-password-sync.csv, two columns "codename,password",
// no header, codenames already lowercased to match real Moodle usernames.
// Must live under /tmp -- see the repo's moodle-live-infrastructure memory
// on the /home/jay vs /tmp www-data traversal gotcha.
//
// Run: sudo -u www-data php sync-student-passwords.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/user/lib.php');

$prefixcourse = [
    'g1-' => 'foxcs-python',
    'g8-' => 'foxcs-python',
    'g21-' => 'foxcs-game2',
    'g7-' => 'foxcs-game2',
    'w7-' => 'foxcs-webdev',
    's4-' => 'foxcs-seminar3',
    's5-' => 'foxcs-seminar3',
];

$coursecache = [];
function get_course_by_shortname($shortname) {
    global $DB, $coursecache;
    if (!isset($coursecache[$shortname])) {
        $coursecache[$shortname] = $DB->get_record('course', ['shortname' => $shortname]);
    }
    return $coursecache[$shortname];
}

$rows = array_map('str_getcsv', file('/tmp/roster-password-sync.csv'));

$processed = 0;
$synced = 0;
$missing = [];
$mismatched = [];

foreach ($rows as $row) {
    if (count($row) < 2) {
        continue;
    }
    [$codename, $password] = $row;
    $codename = trim($codename);
    $password = trim($password);
    $processed++;

    $user = $DB->get_record('user', ['username' => $codename, 'deleted' => 0]);
    if (!$user) {
        $missing[] = $codename;
        continue;
    }

    update_internal_user_password($user, $password);
    $synced++;

    $expectedshortname = null;
    foreach ($prefixcourse as $prefix => $shortname) {
        if (strpos($codename, $prefix) === 0) {
            $expectedshortname = $shortname;
            break;
        }
    }
    if ($expectedshortname === null) {
        continue; // no known mapping (e.g. foxcstest) -- skip enrollment check
    }
    $course = get_course_by_shortname($expectedshortname);
    if (!$course) {
        $mismatched[] = "{$codename}: expected course '{$expectedshortname}' not found in Moodle";
        continue;
    }
    $sql = "SELECT COUNT(*) FROM {user_enrolments} ue
            JOIN {enrol} e ON e.id = ue.enrolid AND e.courseid = ?
            WHERE ue.userid = ?";
    $enrolled = $DB->count_records_sql($sql, [$course->id, $user->id]);
    if (!$enrolled) {
        $mismatched[] = "{$codename}: not enrolled in {$expectedshortname} (course id {$course->id})";
    }
}

echo "Processed: {$processed}\n";
echo "Passwords synced: {$synced}\n";
echo "Missing Moodle accounts (" . count($missing) . "):\n";
foreach ($missing as $m) {
    echo "  {$m}\n";
}
echo "Enrollment mismatches (" . count($mismatched) . "):\n";
foreach ($mismatched as $m) {
    echo "  {$m}\n";
}
echo "Done.\n";
