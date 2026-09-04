<?php
// build-lesson-01-05-coding-exercise.php
//
// Builds Lesson 01.5's (Comments and Documentation) "01.5 Coding Exercise"
// Assignment, matching 01.4's per-lesson pattern. Content ported from the real
// authored 06_project.html ("Documented Mini-Program") / 07_project.py -- add a
// WHY comment above each print() line in the given starter program.
//
// Settings mirror cmid=215 (01.4 Coding Exercise) exactly: simple point grading
// (grade=100), not a Moodle rubric -- the tiered XP structure lives in the intro
// text, same as every other lesson's tiered project. Only onlinetext + file
// submission enabled; all feedback plugins disabled.
//
// Run: sudo -u www-data php build-lesson-01-05-coding-exercise.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = $DB->get_field('course_modules', 'section', ['id' => 215]); // 01.4 Coding Exercise's live section

$intro = <<<'HTML'
<p>A short applied task before the Mastery Check. This one is about writing comments that explain WHY, not just restating WHAT.</p>

<h3>The Task</h3>
<p>Start from this short working program, which has no comments at all:</p>
<pre>print("Welcome back, Player!")
print("Level 3")
print("Time remaining: 02:45")
print("Warning: low health!")</pre>
<p>Add a comment above each <code>print()</code> statement explaining WHY that line exists, as if you were leaving notes for a teammate who will read this code next week. Don't just restate what each line obviously does. Don't change what the program actually does, only add comments.</p>

<h3>What This Could Look Like</h3>
<p>Here's the kind of comment quality this is asking for, applied to a line that isn't in your actual file:</p>
<pre># remind the player of their goal before the timer starts
print("Find the exit before time runs out!")</pre>

<h3>Requirements</h3>
<ul>
<li>Every print() statement gets a comment above it.</li>
<li>Each comment explains a reason, not just a description.</li>
<li>The program's actual behavior is unchanged, only comments were added.</li>
</ul>

<h3>Tier 1 Bonus (+10 XP)</h3>
<ul>
<li>Add one more print() with its own well-reasoned comment above it, continuing the same scenario.</li>
<li>Comment out one line temporarily (using #) and add a comment explaining why you'd disable it while testing.</li>
</ul>

<h3>Tier 2 Bonus (+20 XP, on top of Tier 1)</h3>
<ul>
<li>Write a short comment (2-3 sentences) at the top of your file explaining, in your own words, the difference between a weak comment and a strong one.</li>
<li>Rewrite one of your own comments to be intentionally weak (just restating the code), directly above the strong version, so both are visible for comparison.</li>
</ul>

<p>Use VS Code if it's available. If you're on a Chromebook or a computer without VS Code, use the CodeHS sandbox instead, see the guide linked in 01.3's Instruction.</p>

<h3>How to Submit</h3>
<p>Either paste your code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.</p>
HTML;

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'assign';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1; // visible together with the rest of the lesson's content.
$moduleinfo->name = '01.5 Coding Exercise';
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
$moduleinfo->grade = 100;
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
echo "Created assign cmid={$result->coursemodule} instanceid={$result->id} visible=1\n";
