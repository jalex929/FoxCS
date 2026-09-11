<?php
// create-sandbox-unit02-pilot-project.php
//
// Deploys the Unit 02 pilot lesson's (02.1 Variables and Memory) Project
// module to the sandbox course: "Character Status Tracker", native Moodle
// Assignment, file-upload-only submission restricted to .py -- the
// corrected settings from decisions-log.md's 2026-09-04 "Per-lesson module
// structure settled" entry (assignsubmission_onlinetext_enabled = 0,
// assignsubmission_file_filetypes = '.py'), not the older unrestricted
// pattern build-lesson-01-06-coding-exercise.php still uses.
//
// Intro content is plain HTML (h3/ul/pre, no custom <style> block), matching
// every other Coding Exercise/Project script in this directory -- an
// Assignment's intro field goes through Moodle's own text cleaning, so a
// custom stylesheet embedded here isn't reliable the way it is on a
// self-contained mod_resource page. Full styled instructions also live in
// the authored source at ../../courses/python/content/unit_02_variables_and_data/
// lesson_02_01_variables_and_memory/02_project.html for reference/reuse.
//
// Run: sudo -u www-data php create-sandbox-unit02-pilot-project.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$sectionnum = 1;

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-u02-pilot-project']);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; delete it first if you want to rebuild.\n";
    exit(1);
}

$intro = <<<'HTML'
<p>A short applied task after Practice. Track a game character's status using variables, print it clearly, then update part of it partway through, the way a character's state changes during real play.</p>

<h3>What This Could Look Like</h3>
<p>The <em>output</em> a finished tracker might display, just to show the shape of what you're building. Not code to copy -- your own variable names, character, and event don't have to match this at all.</p>
<pre>Character: Nia
Class: Mage
Health: 100
Lives: 3
Health: 80</pre>

<h3>Required</h3>
<ul>
<li>At least 4 variables describing your character's state. At least one is text (a string), at least one is a number.</li>
<li>Each variable printed with a clear label (print("Health:", health), not a bare number).</li>
<li>At least one variable reassigned partway through to a new value, simulating something happening in the game, then printed again so the change is visible.</li>
<li>Every variable name follows this lesson's naming rules (starts with a letter or underscore, no spaces, snake_case for multi-word names).</li>
<li>No syntax errors. Run it and fix anything Python flags.</li>
</ul>

<h3>Tier 1 Bonus (+10 XP)</h3>
<ul>
<li>2+ more state variables beyond the required 4, genuinely different kinds of information.</li>
<li>A comment above at least one variable explaining why you named it the way you did.</li>
</ul>

<h3>Tier 2 Bonus (+20 XP, on top of Tier 1)</h3>
<ul>
<li>A second reassignment at a different point in the program.</li>
<li>A short comment (2-3 sentences) explaining, in your own words, how your chosen print labels would help an actual player understand what they're looking at.</li>
</ul>

<h3>Stuck?</h3>
<p>Start by listing what your character actually needs (a name, a class, health, lives). Get one variable printing correctly before adding the next. Add the one required reassignment last, once every variable prints on its own.</p>

<h3>How to Submit</h3>
<p>Upload your saved <code>.py</code> file below. Pasted text is not accepted for this assignment.</p>
HTML;

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'assign';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '2.1 Project: Character Status Tracker (sandbox pilot)';
$moduleinfo->idnumber = 'sandbox-u02-pilot-project';
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
$moduleinfo->grade = 25; // Project, per grade-point-scale.md
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
$moduleinfo->completion = 1;
$moduleinfo->completionsubmit = 1;

// Corrected 2026-09-04 settings: file upload only, restricted to .py.
$moduleinfo->assignsubmission_onlinetext_enabled = 0;
$moduleinfo->assignsubmission_file_enabled = 1;
$moduleinfo->assignsubmission_file_maxfiles = 1;
$moduleinfo->assignsubmission_file_maxsizebytes = 1048576;
$moduleinfo->assignsubmission_file_filetypes = '.py';
$moduleinfo->assignsubmission_comments_enabled = 0;

$moduleinfo->assignfeedback_comments_enabled = 1;
$moduleinfo->assignfeedback_editpdf_enabled = 0;
$moduleinfo->assignfeedback_offline_enabled = 0;
$moduleinfo->assignfeedback_file_enabled = 0;

$result = create_module($moduleinfo);
echo "Created assign cmid={$result->coursemodule} instanceid={$result->instance} visible=1 (file-only, .py restricted)\n";
