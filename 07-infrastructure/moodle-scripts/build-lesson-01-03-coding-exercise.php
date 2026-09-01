<?php
// build-lesson-01-03-coding-exercise.php
//
// 01.3 Coding Exercise -- the real hands-on "write your first program" moment. A
// native Assignment, not a branching activity: students pick ONE of 5 themes and
// write a short real Python program using print() statements, tying directly back to
// 01.3's core idea (statements run top to bottom, in order). Chosen theme is a free
// choice, not enforced by any branching mechanism -- just presented as 5 real options,
// same as how a real assignment sheet would offer choice.
//
// Submission accepts either pasted code (online text) or an uploaded .py file, since
// students may be working in VS Code (real .py file) or the CodeHS sandbox backup
// (more likely to copy/paste).
//
// Run: sudo -u www-data php build-lesson-01-03-coding-exercise.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/assign/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2;

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'assign';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.3 Coding Exercise';
$moduleinfo->introeditor = [
    'text' => <<<'HTML'
<p>Time to write a real program. Pick <strong>one</strong> of the five options below, then write a Python program that uses <code>print()</code> statements to bring it to life.</p>

<h3>Pick One</h3>
<ol>
<li><strong>Short Story:</strong> Tell a very short story, a beginning, a middle, and an end.</li>
<li><strong>Hero's Adventure:</strong> A hero faces a challenge. What happens?</li>
<li><strong>Recipe:</strong> Walk someone through a simple recipe, step by step.</li>
<li><strong>Boss Battle Announcer:</strong> Hype up an arcade-style boss battle intro.</li>
<li><strong>Character Bio Card:</strong> Reveal a character: name, class, key stats, catchphrase.</li>
</ol>

<h3>Requirements</h3>
<ul>
<li>At least <strong>5 real <code>print()</code> statements</strong>, each one doing real work, not just one word.</li>
<li><strong>Order matters.</strong> Write them in the order they should actually appear when someone runs your program, top to bottom.</li>
<li><strong>Actually run it.</strong> Make sure it works before you submit, this is the same "writing isn't running" idea from 01.3.</li>
</ul>

<p>Use VS Code if it's available. If you're on a Chromebook or a computer without VS Code, use the CodeHS sandbox instead, see the guide linked in 01.3's Instruction.</p>

<h3>How to Submit</h3>
<p>Either paste your code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.</p>
HTML,
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->duedate = 0;
$moduleinfo->allowsubmissionsfromdate = 0;
$moduleinfo->cutoffdate = 0;
$moduleinfo->gradingduedate = 0;
$moduleinfo->grade = 100;
$moduleinfo->assignsubmission_onlinetext_enabled = 1;
$moduleinfo->assignsubmission_file_enabled = 1;
$moduleinfo->assignsubmission_file_maxfiles = 1;
$moduleinfo->assignsubmission_file_maxsizebytes = 1048576;
$moduleinfo->submissiondrafts = 0;
$moduleinfo->requiresubmissionstatement = 0;
$moduleinfo->sendnotifications = 0;
$moduleinfo->sendlatenotifications = 0;
$moduleinfo->sendstudentnotifications = 1;
$moduleinfo->teamsubmission = 0;
$moduleinfo->requireallteammemberssubmit = 0;
$moduleinfo->blindmarking = 0;
$moduleinfo->attemptreopenmethod = 'none';
$moduleinfo->maxattempts = -1;
$moduleinfo->markingworkflow = 0;
$moduleinfo->markinganonymous = 0;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
echo "Created Coding Exercise assignment: cmid={$cmid}\n";

$DB->set_field('course_modules', 'completion', 1, ['id' => $cmid]);

rebuild_course_cache($course->id, true);
echo "Done. cmid={$cmid}\n";
