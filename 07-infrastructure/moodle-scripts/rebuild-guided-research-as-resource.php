<?php
// rebuild-guided-research-as-resource.php
//
// Replaces the native-Lesson "Guided Research" activity (cmid=199, zero real student
// attempts confirmed) with a self-contained HTML resource matching the existing
// Pathway Placement Quiz pattern (pathway_quiz.html): category chosen up front reveals
// only that category's questions, ends in ONE synthesized results page instead of
// per-question inline feedback. Jay's explicit correction 2026-09-01. File-upload
// pattern proven in upload-folder-as-resource.php.
//
// Run: sudo -u www-data php rebuild-guided-research-as-resource.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['id' => 6], '*', MUST_EXIST); // foxcs-onboarding-l2
$sectionnum = 2;

// 1. Delete the old native-Lesson version.
course_delete_module(199);
echo "Deleted old cmid=199 (native Lesson).\n";

// 2. Upload the new HTML file into a draft area, then create the resource.
$usercontext = context_user::instance($USER->id);
$fs = get_file_storage();
$draftitemid = file_get_unused_draft_itemid();
$fs->create_file_from_pathname([
    'contextid' => $usercontext->id,
    'component' => 'user',
    'filearea' => 'draft',
    'itemid' => $draftitemid,
    'filepath' => '/',
    'filename' => 'guided_research_quiz.html',
], '/tmp/guided_research_quiz.html');

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '1.1 Guided Research';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
echo "Created resource: cmid={$cmid}\n";

// 3. Insert it at the front of the section (it was the first item before Vision Board
//    and Reflection).
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum], '*', MUST_EXIST);
$existing = array_filter(explode(',', $section->sequence), fn($id) => $id != $cmid);
$neworder = array_merge([$cmid], $existing);
$section->sequence = implode(',', $neworder);
$DB->update_record('course_sections', $section);
echo "New sequence: {$section->sequence}\n";

$DB->set_field('course_modules', 'completion', 1, ['id' => $cmid]);

$duedt = new DateTime('2026-09-02 15:30:00', new DateTimeZone('America/Chicago'));
$DB->set_field('course_modules', 'completionexpected', $duedt->getTimestamp(), ['id' => $cmid]);

rebuild_course_cache($course->id, true);
echo "Done. cmid={$cmid}\n";
