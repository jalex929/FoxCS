<?php
// One-off utility: hides (not deletes) course modules by cmid.
// Run: sudo -u www-data php hide-modules.php <cmid> [<cmid> ...]

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

$cmids = array_slice($argv, 1);
foreach ($cmids as $cmid) {
    set_coursemodule_visible((int) $cmid, 0);
    $courseid = $DB->get_field('course_modules', 'course', ['id' => (int) $cmid]);
    rebuild_course_cache($courseid, true);
    echo "hidden {$cmid}\n";
}
