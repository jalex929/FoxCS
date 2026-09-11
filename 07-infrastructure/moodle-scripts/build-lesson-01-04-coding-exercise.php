<?php
// build-lesson-01-04-coding-exercise.php
//
// Builds Lesson 01.4's (Printing Output) "01.4 Coding Exercise" Assignment,
// per lesson-01-04-build-plan.md section 4: 01.4 gets its own per-lesson
// Assignment (resolved 2026-09-03), content ported from the real authored
// 07_project.html ("Status Message Board") / 08_project.py.
//
// Settings mirror cmid=206 (01.3 Coding Exercise) EXACTLY, read directly from
// mdl_assign/mdl_assign_plugin_config rather than guessed -- per the build
// plan's own instruction. Notably: simple point grading (grade=100), NOT a
// Moodle rubric -- 01.3's real precedent isn't rubric-based, so 01.4's tiered
// XP structure (Required / Tier 1 +10 / Tier 2 +20) is documented in the
// intro text for the student/teacher, same as every other lesson's tiered
// project, not built as a formal Moodle grading rubric. Only onlinetext +
// file submission plugins enabled; all feedback plugins disabled (matches
// 01.3 exactly, not a deliberate new choice made here).
//
// Run: sudo -u www-data php build-lesson-01-04-coding-exercise.php

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
<p>Time to write a real program. This one applies the usability idea from 01.4's Instruction: specific, readable output beats vague output, even when both are valid Python.</p>

<h3>The Task</h3>
<p>Write a short program that acts like a game's status board: a few <code>print()</code> statements showing things like health, score, and level. Then add one more piece of output that reports a problem (out of moves, low health, item not available) using a clear, specific message, not a bare code or number.</p>

<h3>What This Could Look Like</h3>
<p>Here's the <em>output</em> a finished status board might display, just to show the shape of what you're building. This isn't code to copy, and yours doesn't have to look anything like this one.</p>
<pre>Health: 85/100
Score: 1,240
Level: 3
Not enough gold. You need 20 more to buy that.</pre>

<h3>Requirements</h3>
<ul>
<li>At least 3 real <code>print()</code> statements showing normal status information.</li>
<li>At least 1 <code>print()</code> statement reporting a problem, written as a clear sentence a player would actually understand, not a code like <code>print("ERR_02")</code>.</li>
<li>No syntax errors. Run it and fix anything Python flags.</li>
</ul>

<h3>Tier 1 Bonus (+10 XP)</h3>
<ul>
<li>Add at least 2 more status lines beyond the required 3, covering different kinds of information (not just more of the same thing).</li>
<li>Add a comment above at least one line explaining why that specific message was worded the way it was.</li>
</ul>

<h3>Tier 2 Bonus (+20 XP, on top of Tier 1)</h3>
<ul>
<li>Write a short comment (2-3 sentences) at the top of your file explaining, in your own words, how your problem message follows the "specific and readable" usability idea from this lesson.</li>
<li>Include at least one status line and one problem message that could believably belong to the same real game (a consistent theme, not two unrelated examples stitched together).</li>
</ul>

<p>Use VS Code if it's available. If you're on a Chromebook or a computer without VS Code, use the CodeHS sandbox instead, see the guide linked in 01.3's Instruction.</p>

<h3>How to Submit</h3>
<p>Either paste your code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.</p>
HTML;

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'assign';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2;
$moduleinfo->visible = 0; // hidden until verified/reviewed, same as the Mastery Check.
$moduleinfo->name = '01.4 Coding Exercise';
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
$moduleinfo->completion = 1; // manual, matches 01.3.
$moduleinfo->completionsubmit = 0;

// Submission plugins: onlinetext + file, matching cmid=206 exactly.
$moduleinfo->assignsubmission_onlinetext_enabled = 1;
$moduleinfo->assignsubmission_onlinetext_wordlimit = 0;
$moduleinfo->assignsubmission_onlinetext_wordlimitenabled = 0;
$moduleinfo->assignsubmission_file_enabled = 1;
$moduleinfo->assignsubmission_file_maxfiles = 1;
$moduleinfo->assignsubmission_file_maxsizebytes = 1048576;
$moduleinfo->assignsubmission_file_filetypes = '';
$moduleinfo->assignsubmission_comments_enabled = 0;

// Feedback plugins: all disabled, matching cmid=206 exactly.
$moduleinfo->assignfeedback_comments_enabled = 0;
$moduleinfo->assignfeedback_editpdf_enabled = 0;
$moduleinfo->assignfeedback_offline_enabled = 0;
$moduleinfo->assignfeedback_file_enabled = 0;

$result = create_module($moduleinfo);
echo "Created assign cmid={$result->coursemodule} instanceid={$result->id} visible=0\n";
