<?php
// build-lesson-02-02-mastery-check.php
//
// 02.2 (Integers) Mastery Check -- new content, no sandbox precedent existed
// for this one (unlike 02.1). 4 items, DOK 2-3, each synthesizing 2+ of
// 02.2's 5 skill nodes (identifies_integer_type, distinguishes_integer_from_
// string, recognizes_negative_integer, uses_integer_for_countable_quantity,
// predicts_basic_integer_arithmetic) rather than repeating a Practice item.
// Deliberately does NOT require str()/int() conversion syntax -- 02.2's own
// Instruction scope note says conversion is Lesson 2.6's job, so a Mastery
// Check item testing it here would be testing something not yet taught.
// See courses/python/content/unit_02_variables_and_data/lesson_02_02_integers/
// teacher-materials/mastery_check_key.md for the full rubric/answer key.
//
// Run: sudo -u www-data php build-lesson-02-02-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once('/tmp/mastery_check_builder.php'); // www-data can't traverse /home/jay (mode 750); canonical source is python/mastery_check_builder.php.

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$category = mcb_get_category($coursecontext, 'Lesson 02.2 Mastery Check');

$qids = [];

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.2 MC Item 1: precedence in a countable-quantity context',
    'questiontext' => '<p>What does this program print?</p><pre>score = 4
score = score + 3 * 2
print("Score:", score)</pre>',
    'answers' => [
        ['Score: 10', 1.0, ''],
    ],
]);

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.2 MC Item 2: negative integer via subtraction',
    'questiontext' => '<p>What does this program print?</p><pre>health = 8
health = health - 20
print("Health:", health)</pre>',
    'answers' => [
        ['Health: -12', 1.0, ''],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.2 MC Item 3: identify the real integer',
    'questiontext' => '<p>Which of these is a real integer, not just something that looks like one?</p>',
    'options' => [
        ['<pre>"9"</pre>', 0.0, 'That has quotation marks, so it is a string, not an integer.'],
        ['<pre>9.0</pre>', 0.0, 'That has a decimal point, so it is a float, not an integer.'],
        ['<pre>-9</pre>', 1.0, 'Correct. No quotes, no decimal point -- a real negative integer.'],
        ['<pre>True</pre>', 0.0, 'That is a boolean, not an integer, even though it can act like one behind the scenes.'],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.2 MC Item 4: predict the TypeError',
    'questiontext' => '<p>What happens when this program runs?</p><pre>tries = "5"
print(tries + 2)</pre>',
    'options' => [
        ['It prints <code>7</code>', 0.0, 'tries is a string, so this is not doing math.'],
        ['It prints <code>"52"</code>', 0.0, 'That would be the result of <code>*</code>, not <code>+</code>. <code>+</code> works differently between a string and an integer.'],
        ['It crashes with a TypeError', 1.0, 'Correct. Python will not automatically combine a string and an integer with <code>+</code>.'],
        ['It prints <code>5</code>', 0.0, 'The +2 does not just disappear -- think about what Python actually does when it hits this line.'],
    ],
]);

mcb_build_quiz([
    'course' => $course,
    'section' => 3,
    'name' => '02.2 Mastery Check',
    'intro' => '<p>4 questions checking that you can apply what 02.2 taught about integers: recognizing them, telling them apart from lookalikes, and predicting arithmetic including precedence and crossing zero. Ask your teacher for the password.</p>',
    'quizpassword' => 'Papaya82%',
    'questionids' => $qids,
    'grade' => 10,
]);
