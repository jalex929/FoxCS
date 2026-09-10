<?php
// rebuild-lesson1-guided-practice.php
//
// Replaces the live H5P "1.5 -- Guided Practice" (h5pactivity id=88,
// cmid=210, foxcs-seminar3 course id=5, section id=29) with a self-
// contained HTML resource on FoxCS: Python's proven local_foxcstelemetry
// pattern. Real bug being fixed: every H5P.Essay field in the old version
// had `enableRetry: false` -- once a student clicked Submit, that field
// locked, the same trap as the documented mod_lesson essay-lock bug, just
// in a different content type. Per Jay directly, 2026-09-10: "let's
// definitely fix the essay field pages and make sure they have protection
// here."
//
// The old h5pactivity is HIDDEN, not deleted -- its real response data
// (30 students' worth) stays on record. The new resource is inserted at
// the exact spot in the section sequence the old one occupied.
//
// Run: sudo -u www-data php rebuild-lesson1-guided-practice.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

$courseid = 5; // foxcs-seminar3
$oldcmid = 210; // old H5P "1.5 -- Guided Practice"
$oldh5pactivityid = 88;
$sectionnum = 2;

$course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
if ($course->shortname !== 'foxcs-seminar3') {
    fwrite(STDERR, "Unexpected course shortname: {$course->shortname}\n");
    exit(1);
}

$oldh5p = $DB->get_record('h5pactivity', ['id' => $oldh5pactivityid], '*', MUST_EXIST);
if ($oldh5p->name !== '1.5 -- Guided Practice') {
    fwrite(STDERR, "Unexpected h5pactivity name: {$oldh5p->name}\n");
    exit(1);
}

$existing = $DB->get_record('course_modules', ['course' => $courseid, 'idnumber' => 'seminar3-lesson1-guided-practice-v2']);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; delete it first if you want to rebuild.\n";
    exit(1);
}

// /home/jay is 750 (jay:jay) -- www-data can't traverse into it, so the
// source is staged to /tmp first (world-readable), matching the pattern
// already used by deploy-live-unit02-01-instruction-resume.php.
$sourcefile = '/tmp/foxcs-deploy-stage/seminar3-lesson1-guided-practice/01_guided_practice.html';
$html = file_get_contents($sourcefile);
if ($html === false) {
    fwrite(STDERR, "Could not read {$sourcefile}\n");
    exit(1);
}

// Placeholder gets substituted after create_module() returns the real cmid.
$fs = get_file_storage();
$usercontext = context_user::instance($USER->id);
$draftitemid = file_get_unused_draft_itemid();
$fs->create_file_from_string([
    'contextid' => $usercontext->id,
    'component' => 'user',
    'filearea' => 'draft',
    'itemid' => $draftitemid,
    'filepath' => '/',
    'filename' => 'index.html',
], '<html><body>placeholder</body></html>');

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $courseid;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '1.5 -- Guided Practice';
$moduleinfo->idnumber = 'seminar3-lesson1-guided-practice-v2';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
$moduleinfo->completion = COMPLETION_TRACKING_MANUAL;
$moduleinfo->beforemod = 211; // insert right where cmid=210 used to sit, before 1.6 Independent Practice.

$result = create_module($moduleinfo);
$newcmid = $result->coursemodule;
$modcontext = context_module::instance($newcmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$finalhtml = str_replace('__CMID__', (string) $newcmid, $html);
$fs->create_file_from_string([
    'contextid' => $modcontext->id,
    'component' => 'mod_resource',
    'filearea' => 'content',
    'itemid' => 0,
    'filepath' => '/',
    'filename' => 'index.html',
], $finalhtml);
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);

// Hide the old H5P version -- data preserved, just no longer shown to students.
$DB->set_field('course_modules', 'visible', 0, ['id' => $oldcmid]);
set_coursemodule_visible($oldcmid, 0);

rebuild_course_cache($courseid, true);

echo "New resource created: cmid={$newcmid}, idnumber=seminar3-lesson1-guided-practice-v2\n";
echo "Old H5P activity cmid={$oldcmid} hidden (data preserved).\n";
