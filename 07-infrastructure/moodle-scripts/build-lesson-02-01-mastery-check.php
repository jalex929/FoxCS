<?php
// build-lesson-02-01-mastery-check.php
//
// Promotes 02.1 (Variables and Memory)'s Mastery Check from the sandbox pilot
// (course id=9 "sandbox-adaptive-demo", quizid=11, cmid=240 -- built
// 2026-09-04, see decisions-log.md/chat-log.md's matching entries) to a real
// quiz on foxcs-python. Content transcribed exactly from the live sandbox DB
// (mdl_question/mdl_question_answers via mdl_quiz_slots for quizid=11), not
// rewritten -- same 4 questions, same answer variants/feedback.
//
// Built as part of reinstating per-lesson Mastery Checks as the standard for
// Unit 02 (reversing the 2026-09-08 unit-level-only scoping) -- see
// decisions-log.md's 2026-09-09 entry. Grade=10, per
// feedback_lesson_point_scale.md (not the older 100-point convention 01.1-01.6
// still use).
//
// Run: sudo -u www-data php build-lesson-02-01-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once('/tmp/mastery_check_builder.php'); // www-data can't traverse /home/jay (mode 750); canonical source is python/mastery_check_builder.php, this is a deploy-time copy.

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$category = mcb_get_category($coursecontext, 'Lesson 02.1 Mastery Check');

$qids = [];

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.1 MC Item 1: predict reassignment output',
    'questiontext' => '<p>What does this program print?</p><pre>score = 0
score = 15
print("Score:", score)</pre>',
    'answers' => [
        ['Score: 15', 1.0, ''],
    ],
]);

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.1 MC Item 2: fix the broken assignment',
    'questiontext' => '<p>This line is supposed to create a variable named <code>lives</code> set to <code>3</code>, but it has a mistake:</p><pre>3 = lives</pre><p>Write the corrected line.</p>',
    'answers' => [
        ['lives = 3', 1.0, ''],
        ['lives=3', 1.0, ''],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.1 MC Item 3: valid naming',
    'questiontext' => '<p>Which of these variable names is valid in Python?</p>',
    'options' => [
        ['<pre>1st_place</pre>', 0.0, 'Names cannot start with a digit.'],
        ['<pre>player class</pre>', 0.0, 'Names cannot contain spaces.'],
        ['<pre>player_class</pre>', 1.0, 'Correct.'],
        ['<pre>def</pre>', 0.0, 'def is a reserved Python word.'],
    ],
]);

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.1 MC Item 4: fix the concatenation error',
    'questiontext' => '<p>This line is supposed to print <code>Total: 12</code>, using <code>+</code>, but it crashes:</p><pre>total = 12
print("Total: " + total)</pre><p>Write the corrected line.</p>',
    'answers' => [
        ['print("Total: " + str(total))', 1.0, ''],
        ['print("Total: "+str(total))', 1.0, ''],
    ],
]);

mcb_build_quiz([
    'course' => $course,
    'section' => 3, // Unit 02, matches the Checkpoint's section number.
    'name' => '02.1 Mastery Check',
    'intro' => '<p>4 questions checking that you can apply what 02.1 taught: creating and reassigning variables, valid naming rules, and combining a variable with text using <code>+</code>. Ask your teacher for the password.</p>',
    'quizpassword' => 'Mango47$',
    'questionids' => $qids,
    'grade' => 10,
]);
