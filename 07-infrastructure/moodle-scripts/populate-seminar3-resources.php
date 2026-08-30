<?php
// One-off setup script: uploads Seminar III's existing HTML content
// (teacher-materials, instructional-content, printable-sheets) as File
// resources into the matching unit section of the foxcs-seminar3 course.
// Filenames use "unit-NN-..." (NN = unit number, 00-38); Moodle section
// number = unit number + 1 (section 1 holds Unit 00, etc. -- see
// rename-seminar3-sections.php).
//
// Teacher-materials (decks, answer keys) are created HIDDEN (visible=0) so
// only teacher/manager roles can see them -- students should never see the
// presenter's speaker notes or an answer key. Everything else is visible.
//
// Source files must be staged in a world-readable location first (this repo
// lives under /home/jay, which www-data can't traverse) -- see the README in
// this directory for the staging command. Safe to re-run: skips a (course,
// section, filename) combo that's already been created.
//
// Run: sudo -u www-data php populate-seminar3-resources.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user(); // Gives $USER full site capabilities for create_module().

$srcroot = '/tmp/seminar-iii-src';

$sources = [
    // [subdir, glob pattern, hidden?, human label prefix]
    ['teacher-materials', '/^unit-(\d{2})-presentation\.html$/', true, 'Unit %02d Presentation (Teacher)'],
    ['teacher-materials', '/^unit-(\d{2})-answer-keys\.html$/', true, 'Unit %02d Answer Keys (Teacher)'],
    ['instructional-content', '/^unit-(\d{2})-(.+)\.html$/', false, null], // label built from slug
    ['printable-sheets', '/^unit-(\d{2})-(.+)\.html$/', false, null],
];

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$usercontext = context_user::instance($USER->id);
$fs = get_file_storage();

function slug_to_title($slug) {
    $words = explode('-', $slug);
    return ucwords(implode(' ', $words));
}

$created = 0;
$skipped = 0;

foreach ($sources as [$subdir, $pattern, $hidden, $labeltemplate]) {
    $dir = "$srcroot/$subdir";
    if (!is_dir($dir)) {
        echo "Missing source dir: $dir\n";
        continue;
    }
    foreach (scandir($dir) as $filename) {
        if (!preg_match($pattern, $filename, $m)) {
            continue;
        }
        $unitnum = (int) $m[1];
        $sectionnum = $unitnum + 1; // Section 1 = Unit 00, section 2 = Unit 01, etc.
        $section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum]);
        if (!$section) {
            echo "No section $sectionnum (Unit $unitnum) for $filename, skipping\n";
            continue;
        }

        if ($labeltemplate) {
            $name = sprintf($labeltemplate, $unitnum);
        } else {
            $slug = $m[2];
            $name = sprintf('Unit %02d ', $unitnum) . slug_to_title($slug);
        }

        // Skip if a resource with this exact name already exists in this section.
        $existing = $DB->record_exists_sql(
            "SELECT 1 FROM {course_modules} cm
               JOIN {modules} md ON md.id = cm.module
               JOIN {resource} r ON r.id = cm.instance
              WHERE cm.course = ? AND cm.section = ? AND md.name = 'resource' AND r.name = ?",
            [$course->id, $section->id, $name]
        );
        if ($existing) {
            $skipped++;
            continue;
        }

        $filepath = "$dir/$filename";
        $draftitemid = file_get_unused_draft_itemid();
        $fs->create_file_from_pathname([
            'contextid' => $usercontext->id,
            'component' => 'user',
            'filearea' => 'draft',
            'itemid' => $draftitemid,
            'filepath' => '/',
            'filename' => $filename,
        ], $filepath);

        $moduleinfo = new stdClass();
        $moduleinfo->modulename = 'resource';
        $moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
        $moduleinfo->course = $course->id;
        $moduleinfo->section = $sectionnum;
        $moduleinfo->visible = $hidden ? 0 : 1;
        $moduleinfo->name = $name;
        $moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
        $moduleinfo->files = $draftitemid;
        $moduleinfo->display = 0; // "Automatic" display option.

        create_module($moduleinfo);
        $created++;
        echo ($hidden ? '[hidden] ' : '[visible] ') . "$name (section $sectionnum)\n";
    }
}

echo "\nCreated: $created, skipped (already existed): $skipped\n";
