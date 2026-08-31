<?php
// Renames h5pactivity modules by cmid, without touching content/enrolment/
// completion state. Reads pairs from a simple "cmid|new name" text file, one
// per line. Written 2026-08-30 for the Seminar III Lesson 1 renumbering pass.
// Run: sudo -u www-data php rename-h5p-activities.php /path/to/renames.txt

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$path = $argv[1] ?? null;
if (!$path || !file_exists($path)) {
    fwrite(STDERR, "Usage: rename-h5p-activities.php /path/to/renames.txt\n");
    exit(1);
}

foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    [$cmid, $newname] = array_map('trim', explode('|', $line, 2));
    $cm = $DB->get_record('course_modules', ['id' => (int) $cmid], '*', MUST_EXIST);
    $DB->set_field('h5pactivity', 'name', $newname, ['id' => $cm->instance]);
    echo "Renamed cmid {$cmid} -> {$newname}\n";
}
