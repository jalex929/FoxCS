<?php
// build-lesson-02-03-mastery-check.php
//
// 02.3 (Floats) Mastery Check -- new content, no sandbox precedent. 4 items,
// DOK 2-3, each synthesizing 2+ of 02.3's 5 skill nodes (identifies_float_type,
// distinguishes_int_vs_float, recognizes_float_disguised_as_whole,
// uses_float_for_decimal_quantity, predicts_mixed_numeric_result) rather than
// repeating a Practice item verbatim. Scenarios (potion strength, character
// weight, fuel gauge, coin multiplier) are deliberately different from both
// 02.3's own live Practice items (game_speed, price/tax, lives/bonus, base)
// and from 02.1/02.2's Mastery Check scenarios (score, health, tries).
// 02.3's Instruction content stops at basic mixed-type arithmetic -- no
// str()/int() conversion syntax appears anywhere in the lesson, so none of
// these items require it either.
// See courses/python/content/unit_02_variables_and_data/lesson_02_03_floats/
// teacher-materials/mastery_check_key.md for the full rubric/answer key.
//
// Run: sudo -u www-data php build-lesson-02-03-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once('/tmp/mastery_check_builder.php'); // www-data can't traverse /home/jay (mode 750); canonical source is python/mastery_check_builder.php.

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$category = mcb_get_category($coursecontext, 'Lesson 02.3 Mastery Check');

$qids = [];

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.3 MC Item 1: predict a mixed-type potion effect',
    'questiontext' => '<p>What does this program print?</p><pre>potion_strength = 2
bonus = 0.75
print("Strength:", potion_strength + bonus)</pre>',
    'answers' => [
        ['Strength: 2.75', 1.0, ''],
    ],
]);

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.3 MC Item 2: fix the disguised-whole-number weight',
    'questiontext' => '<p>A character sheet stores every measurement as a float, even exact whole numbers. This line is supposed to store a character\'s weight as 180 pounds, using a float, but it\'s written as an integer:</p><pre>weight = 180</pre><p>Write the corrected line.</p>',
    'answers' => [
        ['weight = 180.0', 1.0, ''],
        ['weight=180.0', 1.0, ''],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.3 MC Item 3: identify the real float',
    'questiontext' => '<p>A vehicle\'s <code>fuel_level</code> should be a float. Which of these values is actually a float, not just something that looks like one?</p>',
    'options' => [
        ['<pre>3</pre>', 0.0, 'No decimal point -- this is an integer.'],
        ['<pre>3.0</pre>', 1.0, 'Correct. It has a decimal point, so it\'s a float, even though the value happens to be a whole number.'],
        ['<pre>"3.0"</pre>', 0.0, 'That has quotation marks, so it is a string, not a float.'],
        ['<pre>False</pre>', 0.0, 'That is a boolean, not a float.'],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.3 MC Item 4: predict the mixed-type multiplier result',
    'questiontext' => '<p><code>coins = 12</code> and <code>multiplier = 1.5</code> already exist. What does this print?</p><pre>print(coins * multiplier)</pre>',
    'options' => [
        ['It prints <code>18</code>', 0.0, 'Mixing an integer and a float in math produces a float, not a plain integer.'],
        ['It prints <code>18.0</code>', 1.0, 'Correct. Multiplying an integer by a float keeps the decimal precision.'],
        ['It prints <code>"18.0"</code>', 0.0, 'Neither coins nor multiplier is a string, so the result isn\'t a string either.'],
        ['It crashes', 0.0, 'Mixing an integer and a float in math never crashes.'],
    ],
]);

mcb_build_quiz([
    'course' => $course,
    'section' => 3,
    'name' => '02.3 Mastery Check',
    'intro' => '<p>4 questions checking that you can apply what 02.3 taught about floats: recognizing them (including the disguised-whole-number case), choosing one on purpose, and predicting mixed integer/float arithmetic. Ask your teacher for the password.</p>',
    'quizpassword' => 'Kiwi63#',
    'questionids' => $qids,
    'grade' => 10,
]);
