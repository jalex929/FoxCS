<?php
// check-module-visibility.php
//
// Diagnostic: for a given course + user, dump each course module's real
// student-facing visibility (uservisible, availableinfo, and any completion-
// based "unlock" requirement expressed elsewhere in the course) using Moodle's
// own get_fast_modinfo() / cm_info API -- the same logic the course page uses
// to decide whether to show a link. Read-only, makes no changes.
//
// Run: sudo -u www-data php check-module-visibility.php <courseid> <username>

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/modinfolib.php');

$courseid = (int)($argv[1] ?? 0);
$username = $argv[2] ?? '';
if (!$courseid || !$username) {
    fwrite(STDERR, "Usage: check-module-visibility.php <courseid> <username>\n");
    exit(1);
}

$course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
$user = $DB->get_record('user', ['username' => $username], '*', MUST_EXIST);

$modinfo = get_fast_modinfo($course, $user->id);
foreach ($modinfo->get_cms() as $cm) {
    if (!$cm->uservisible || $cm->availableinfo) {
        echo "cmid={$cm->id}\tname={$cm->name}\tsection={$cm->sectionnum}\tuservisible=" . ($cm->uservisible ? '1' : '0')
            . "\tvisible={$cm->visible}\tvisibleoncoursepage={$cm->visibleoncoursepage}\tavailableinfo="
            . strip_tags($cm->availableinfo ?? '') . "\n";
    }
}
echo "Done. (only rows the student would NOT see cleanly are printed above)\n";
