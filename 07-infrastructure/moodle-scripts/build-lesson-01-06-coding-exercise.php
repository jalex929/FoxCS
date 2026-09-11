<?php
// build-lesson-01-06-coding-exercise.php
//
// Builds Lesson 01.6's (Common Syntax Mistakes) "01.6 Coding Exercise" Assignment,
// matching 01.4/01.5's per-lesson pattern. Content ported from the real authored
// 05_project.html ("Bug Hunt Challenge") / 06_project.py -- fix four broken lines,
// each with exactly one of the unit's Big Four mistakes.
//
// Settings mirror cmid=215/222 (01.4/01.5 Coding Exercise) exactly.
//
// Run: sudo -u www-data php build-lesson-01-06-coding-exercise.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2; // "Unit 01: What Is Programming?"

$intro = <<<'HTML'
<p>A short applied task before the Mastery Check. This one is your first real QA pass: a whole small program, broken in several places, that you have to fix line by line.</p>

<h3>The Task</h3>
<p>Start from this program, which is supposed to print a short game intro. Every line has exactly one mistake from this unit's Big Four (missing quote, missing parentheses, wrong capitalization, missing quotes entirely):</p>
<pre>print(Welcome to the arena)
# should display: Welcome to the arena

Print("Choose your character")
# should display: Choose your character

print("Good luck out there!
# should display: Good luck out there!

print(Battle Start)
# should display: Battle Start</pre>
<p>Fix every line so the program runs and produces the intended output shown in each comment.</p>

<h3>Requirements</h3>
<ul>
<li>Fix every broken line. Don't just fix the first one and stop.</li>
<li>Run the file after each fix, so a new error appearing tells you what to fix next.</li>
<li>Add a short comment above each line you fixed, naming which mistake it was.</li>
</ul>

<h3>Tier 1 Bonus (+10 XP)</h3>
<ul>
<li>Add one new print() line of your own that is intentionally broken, with a comment naming the mistake, then fix it too.</li>
<li>Write a one-sentence comment explaining the actual difference between SyntaxError and NameError, in your own words.</li>
</ul>

<h3>Tier 2 Bonus (+20 XP, on top of Tier 1)</h3>
<ul>
<li>For each of the four fixes, write a comment naming BOTH the error Python would raise and why (not just which mistake it was).</li>
<li>Add a fifth, intentionally broken line that combines two mistakes at once (like a compound error from this lesson's practice), then fix it and comment on both mistakes.</li>
</ul>

<p>Use VS Code if it's available. If you're on a Chromebook or a computer without VS Code, use the CodeHS sandbox instead, see the guide linked in 01.3's Instruction.</p>

<h3>How to Submit</h3>
<p>Either paste your fixed code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.</p>
HTML;

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'assign';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.6 Coding Exercise';
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
$moduleinfo->grade = 10; // Coding Exercise, per grade-point-scale.md
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
$moduleinfo->completionsubmit = 0;

$moduleinfo->assignsubmission_onlinetext_enabled = 1;
$moduleinfo->assignsubmission_onlinetext_wordlimit = 0;
$moduleinfo->assignsubmission_onlinetext_wordlimitenabled = 0;
$moduleinfo->assignsubmission_file_enabled = 1;
$moduleinfo->assignsubmission_file_maxfiles = 1;
$moduleinfo->assignsubmission_file_maxsizebytes = 1048576;
$moduleinfo->assignsubmission_file_filetypes = '';
$moduleinfo->assignsubmission_comments_enabled = 0;

$moduleinfo->assignfeedback_comments_enabled = 0;
$moduleinfo->assignfeedback_editpdf_enabled = 0;
$moduleinfo->assignfeedback_offline_enabled = 0;
$moduleinfo->assignfeedback_file_enabled = 0;

$result = create_module($moduleinfo);
echo "Created assign cmid={$result->coursemodule} instanceid={$result->instance} visible=1\n";
