<?php
// One-off setup script: creates the top-level "FoxCS" course category.
// Run: sudo -u www-data php create-category.php
// Idempotent: does nothing if a category with idnumber "foxcs" already exists.

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

$existing = $DB->get_record('course_categories', ['idnumber' => 'foxcs']);
if ($existing) {
    echo "Category already exists: id={$existing->id}\n";
    exit(0);
}

$category = core_course_category::create([
    'name' => 'FoxCS',
    'idnumber' => 'foxcs',
    'description' => 'FoxCS course catalog — Python, Game Programming II, Web Dev, Seminar III.',
]);

echo "Created category id={$category->id}\n";
