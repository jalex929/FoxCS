<?php
// One-off setup script: renames course_sections 1-39 in the FoxCS: Seminar III
// Moodle course (shortname foxcs-seminar3) to the Unit-numbered titles (Unit 00
// through Unit 38), matching the 2026-08-29 renumbering documented in
// decisions-log.md. Section NUMBER stays 1-39 (unchanged) -- only the display
// NAME changes; content already sits in the correct section. Safe to re-run.
// Run: sudo -u www-data php rename-seminar3-sections.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

// Keyed by Moodle section NUMBER (1-39). Section N holds what the course plan
// now calls "Unit (N-1)".
$units = [
    1 => 'Unit 00: Welcome to Seminar III',
    2 => 'Unit 01: Academic Problem-Solving',
    3 => 'Unit 02: Numbers & Operations',
    4 => 'Unit 03: Fractions & Decimals',
    5 => 'Unit 04: Percent',
    6 => 'Unit 05: Ratios, Rates & Proportions',
    7 => 'Unit 06: Variables & Expressions',
    8 => 'Unit 07: Equations',
    9 => 'Unit 08: Quarter 1 Consolidation',
    10 => 'Unit 09: Inequalities & Constraints',
    11 => 'Unit 10: Academic Reset',
    12 => 'Unit 11: Coordinate Plane & Graphs',
    13 => 'Unit 12: Slope & Linear Relationships',
    14 => 'Unit 13: Measurement, Perimeter & Area',
    15 => 'Unit 14: Angles, Triangles & Right Triangles',
    16 => 'Unit 15: Practical Financial Math',
    17 => 'Unit 16: Retrieval & Skill Recovery',
    18 => 'Unit 17: Statistics',
    19 => 'Unit 18: Probability + Semester Review',
    20 => 'Unit 19: ACT Math Strategy',
    21 => 'Unit 20: Tables, Charts & Data',
    22 => 'Unit 21: Experiments & Scientific Reasoning',
    23 => 'Unit 22: Claims, Evidence & Information Literacy',
    24 => 'Unit 23: Reading for Main Ideas & Details',
    25 => 'Unit 24: Evidence & Inference',
    26 => 'Unit 25: Reading Efficiently',
    27 => 'Unit 26: Complete & Clear Sentences',
    28 => 'Unit 27: Grammar, Usage & Punctuation',
    29 => 'Unit 28: Organization, Precision & Tone',
    30 => 'Unit 29: Integrated ACT Review I — Math & Science/Data',
    31 => 'Unit 30: Integrated ACT Review II — Reading & English',
    32 => 'Unit 31: ACT Exam Week',
    33 => 'Unit 32: Postsecondary Options',
    34 => 'Unit 33: Financial Readiness',
    35 => 'Unit 34: Applications & Qualifications',
    36 => 'Unit 35: Professional & Academic Communication',
    37 => 'Unit 36: My Postsecondary Plan',
    38 => 'Unit 37: Practical Skills Application',
    39 => 'Unit 38: Final Reflection & Transition',
];

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);

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
