<?php
// build-unit02-checkpoint-coding-exercise.php
//
// Builds the "Unit 02 Checkpoint: Mixed Data Types" Coding Exercise --
// GMetrix Workbook p.12 "Review 1.1" (114-analyze.py), plus a FoxCS-original
// Part 2 covering skills-map.md's seven-value confusion set (12/12.0/"12"/
// True/"True"/score/"score"). Sits between 02.5 and 02.6 in Unit 02's
// sequence. See ../../courses/python/content/unit_02_variables_and_data/
// checkpoint_mixed_data_types/checkpoint_mixed_data_types.md for the full
// build record and open items (video not picked, grade value unconfirmed).
//
// Settings mirror cmid=264-267 (2.2-2.5 Coding Exercises) EXACTLY, read
// directly from mdl_course_modules/mdl_assign/mdl_assign_plugin_config,
// except grade (5, not 10 -- see the .md's Scope Decisions section for why).
//
// Run: sudo -u www-data php build-unit02-checkpoint-coding-exercise.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);

$intro = <<<'HTML'
<p>You've now met all four core data types: integers (2.2), floats (2.3), strings (2.4), and booleans (2.5). Before 2.6 teaches you how to convert between them, this short checkpoint makes sure you can tell them apart when they're mixed together -- including the two trickiest cases most people mix up.</p>

<h3>Part 1: The Real GMetrix Review 1.1</h3>
<p>Open <code>GMETRIX-114-analyze.py</code>. It has 5 <code>print(type(...))</code> statements. For each one, write your prediction as a comment above the line BEFORE you run anything, then run the file and check yourself against the real output.</p>

<h3>Part 2: The Trickiest Cases</h3>
<p>Seven more values, including two pairs that look nearly identical but are not the same type. Predict each one's type as a comment, then uncomment the check block at the bottom and run it to see if you were right.</p>

<h3>How to Submit</h3>
<p>Save this file as <code>GMETRIX-114-analyze-completed.py</code>, then upload it below. If you can't upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>
HTML;

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'assign';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 3; // Unit 02's section number, matches 259-267.
$moduleinfo->visible = 1;
$moduleinfo->name = 'Unit 02 Checkpoint: Mixed Data Types';
$moduleinfo->introeditor = ['text' => $intro, 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->alwaysshowdescription = 0;
$moduleinfo->nosubmissions = 0;
$moduleinfo->submissiondrafts = 0;
$moduleinfo->sendnotifications = 0;
$moduleinfo->sendlatenotifications = 0;
$moduleinfo->sendstudentnotifications = 1;
$moduleinfo->duedate = 0;
$moduleinfo->allowsubmissionsfromdate = 0;
$moduleinfo->cutoffdate = 0;
$moduleinfo->gradingduedate = 0;
$moduleinfo->grade = 5; // lighter review task, not a full GMetrix Coding Exercise -- see .md Scope Decisions.
$moduleinfo->requiresubmissionstatement = 0;
$moduleinfo->teamsubmission = 0;
$moduleinfo->requireallteammemberssubmit = 0;
$moduleinfo->teamsubmissiongroupingid = 0;
$moduleinfo->blindmarking = 0;
$moduleinfo->hidegrader = 0;
$moduleinfo->revealidentities = 0;
$moduleinfo->attemptreopenmethod = 'none';
$moduleinfo->maxattempts = -1;
$moduleinfo->markingworkflow = 0;
$moduleinfo->markingallocation = 0;
$moduleinfo->completion = 1; // manual, matches 264-267.
$moduleinfo->completionsubmit = 0;

// Submission plugins: file (.py only) + onlinetext (backup-link-only),
// matching cmid=264's real config exactly.
$moduleinfo->assignsubmission_onlinetext_enabled = 1;
$moduleinfo->assignsubmission_onlinetext_wordlimit = 0;
$moduleinfo->assignsubmission_onlinetext_wordlimitenabled = 0;
$moduleinfo->assignsubmission_file_enabled = 1;
$moduleinfo->assignsubmission_file_maxfiles = 1;
$moduleinfo->assignsubmission_file_maxsizebytes = 1048576;
$moduleinfo->assignsubmission_file_filetypes = '.py';
$moduleinfo->assignsubmission_comments_enabled = 0;

// Feedback plugins: all disabled, matching cmid=264.
$moduleinfo->assignfeedback_comments_enabled = 0;
$moduleinfo->assignfeedback_editpdf_enabled = 0;
$moduleinfo->assignfeedback_offline_enabled = 0;
$moduleinfo->assignfeedback_file_enabled = 0;

$result = create_module($moduleinfo);
echo "Created assign cmid={$result->coursemodule} instanceid={$result->id} visible=1\n";

// Attach the real starter file as a downloadable "Additional file", matching
// how 264-267 attach their GMETRIX-*.py starter files.
$fs = get_file_storage();
$context = context_module::instance($result->coursemodule);
$sourcepath = '/home/jay/FoxCS/courses/python/content/unit_02_variables_and_data/checkpoint_mixed_data_types/coding-exercise/GMETRIX-114-analyze.py';
$filerecord = [
    'contextid' => $context->id,
    'component' => 'mod_assign',
    'filearea'  => 'introattachment',
    'itemid'    => 0,
    'filepath'  => '/',
    'filename'  => 'GMETRIX-114-analyze.py',
];
if (!$fs->file_exists($filerecord['contextid'], $filerecord['component'], $filerecord['filearea'], $filerecord['itemid'], $filerecord['filepath'], $filerecord['filename'])) {
    $fs->create_file_from_pathname($filerecord, $sourcepath);
    echo "Attached GMETRIX-114-analyze.py as an intro attachment.\n";
} else {
    echo "GMETRIX-114-analyze.py already attached, skipped.\n";
}

rebuild_course_cache($course->id, true);
echo "Course cache rebuilt.\n";
