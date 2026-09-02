<?php
// unhide-module.php
//
// Small reusable utility: makes a single course module visible via Moodle's
// own API (set_coursemodule_visible), then rebuilds that course's cache.
// Run: sudo -u www-data php unhide-module.php <cmid> <courseid>

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

$cmid = (int)($argv[1] ?? 0);
$courseid = (int)($argv[2] ?? 0);
if (!$cmid || !$courseid) {
    fwrite(STDERR, "Usage: unhide-module.php <cmid> <courseid>\n");
    exit(1);
}

set_coursemodule_visible($cmid, 1);
rebuild_course_cache($courseid, true);
echo "cmid={$cmid} now visible, course {$courseid} cache rebuilt\n";
