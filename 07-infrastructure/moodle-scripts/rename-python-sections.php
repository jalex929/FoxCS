<?php
// One-off setup script: renames course_sections 1-21 in the FoxCS: Python
// Moodle course (shortname foxcs-python) to match the 21 units (00-20) in
// courses/python/course-plan.md. Section 1 = Unit 00, ... Section 21 = Unit 20.
// Safe to re-run.
// Run: sudo -u www-data php rename-python-sections.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

$units = [
    1 => 'Unit 00: Course Onboarding',
    2 => 'Unit 01: What Is Programming?',
    3 => 'Unit 02: Variables & Data',
    4 => 'Unit 03: User Input & Strings',
    5 => 'Unit 04: Math for Programmers',
    6 => 'Unit 05: Making Decisions',
    7 => 'Unit 06: Loops & Repetition',
    8 => 'Unit 07: Functions',
    9 => 'Unit 08: Lists',
    10 => 'Unit 09: Working with Data Collections',
    11 => 'Unit 10: Sorting, Searching, and Patterns',
    12 => 'Unit 11: Randomness and Simulation',
    13 => 'Unit 12: Useful Python Tools',
    14 => 'Unit 13: Debugging and Errors',
    15 => 'Unit 14: Exception Handling',
    16 => 'Unit 15: Testing Your Code',
    17 => 'Unit 16: File Input & Output',
    18 => 'Unit 17: Dates, Times, and Calendars',
    19 => 'Unit 18: Working with the Computer',
    20 => 'Unit 19: Classes and Objects',
    21 => 'Unit 20: Capstone Project',
];

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);

$updated = 0;
foreach ($units as $sectionnum => $name) {
    $section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum]);
    if (!$section) {
        echo "Section $sectionnum missing, skipping\n";
        continue;
    }
    course_update_section($course, $section, ['name' => $name]);
    $updated++;
}

echo "Renamed $updated sections in course id={$course->id}\n";
