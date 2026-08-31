<?php
// One-off utility: properly deletes course modules by cmid via Moodle's own
// API (unlike a raw SQL DELETE, this cleans up context/files/gradebook rows
// too). Run: sudo -u www-data php delete-modules.php <cmid> [<cmid> ...]

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

$cmids = array_slice($argv, 1);
foreach ($cmids as $cmid) {
    try {
        course_delete_module((int) $cmid);
        echo "deleted {$cmid}\n";
    } catch (Exception $e) {
        echo "skip {$cmid}: " . $e->getMessage() . "\n";
    }
}
