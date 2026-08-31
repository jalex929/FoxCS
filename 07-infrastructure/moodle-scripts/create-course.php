<?php
// Generic course creator -- creates one new course shell in the FoxCS
// category (idnumber "foxcs"). Idempotent: does nothing if a course with
// this shortname already exists.
//
// Run: sudo -u www-data php create-course.php <shortname> "<fullname>" <numsections>
// Example: sudo -u www-data php create-course.php foxcs-onboarding-l2 "FoxCS: Onboarding (Game II / Web II)" 3

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

[, $shortname, $fullname, $numsections] = $argv + [null, null, null, null];
if (!$shortname || !$fullname || !is_numeric($numsections)) {
    fwrite(STDERR, "Usage: create-course.php <shortname> \"<fullname>\" <numsections>\n");
    exit(1);
}

$existing = $DB->get_record('course', ['shortname' => $shortname]);
if ($existing) {
    echo "Course already exists: id={$existing->id}\n";
    exit(0);
}

$category = $DB->get_record('course_categories', ['idnumber' => 'foxcs'], '*', MUST_EXIST);

$course = new stdClass();
$course->fullname = $fullname;
$course->shortname = $shortname;
$course->idnumber = $shortname;
$course->category = $category->id;
$course->format = 'topics';
$course->numsections = (int) $numsections;
$course->visible = 1;
$course->startdate = time();

$newcourse = create_course($course);
echo "Created course id={$newcourse->id} shortname={$shortname}\n";
