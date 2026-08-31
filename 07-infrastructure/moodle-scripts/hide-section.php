<?php
// Hides (or shows) an entire course section by sectionnum, using Moodle's
// own section-visibility API so child modules' visibleoncoursepage state is
// handled correctly (not just a raw mdl_course_sections.visible flip).
//
// Run: sudo -u www-data php hide-section.php <course-shortname> <sectionnum> <0|1>
// Example: sudo -u www-data php hide-section.php foxcs-python 2 0

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

[, $shortname, $sectionnum, $visible] = $argv + [null, null, null, null];
if (!$shortname || !is_numeric($sectionnum) || ($visible !== '0' && $visible !== '1')) {
    fwrite(STDERR, "Usage: hide-section.php <course-shortname> <sectionnum> <0|1>\n");
    exit(1);
}

$course = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => (int) $sectionnum], '*', MUST_EXIST);

course_update_section($course, $section, ['visible' => (int) $visible]);

echo ($visible === '1' ? "Shown" : "Hidden") . " section {$sectionnum} (\"{$section->name}\") in {$shortname}\n";
