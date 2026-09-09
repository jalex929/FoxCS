<?php
// build-lesson-02-04-mastery-check.php
//
// 02.4 (Strings) Mastery Check -- new content, no sandbox precedent. 4 items,
// DOK 2-3, each synthesizing 2+ of 02.4's 5 skill nodes (identifies_string_type,
// recognizes_quotes_override_appearance, distinguishes_string_from_variable,
// recognizes_numeric_looking_string, recognizes_boolean_looking_string) rather
// than repeating a Practice item verbatim. Scenarios (quest item name, ticket
// number, save-file flag) are deliberately different from 02.4's own live
// Practice items (player_name/Rowan, room/kitchen, id_code/100, count="5",
// status/door_locked="True"/"False", location/cave, zip_code) and from
// 02.1/02.2/02.3's Mastery Check scenarios.
// 02.4's Instruction content stops at + concatenation on two strings -- no
// string methods or indexing appear anywhere in the lesson (indexing is
// scoped to Unit 08 per course-plan.md), so none of these items require them.
// See courses/python/content/unit_02_variables_and_data/lesson_02_04_strings/
// teacher-materials/mastery_check_key.md for the full rubric/answer key.
//
// Run: sudo -u www-data php build-lesson-02-04-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once('/tmp/mastery_check_builder.php'); // www-data can't traverse /home/jay (mode 750); canonical source is python/mastery_check_builder.php.

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$category = mcb_get_category($coursecontext, 'Lesson 02.4 Mastery Check');

$qids = [];

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.4 MC Item 1: variable vs. quoted word',
    'questiontext' => '<p><code>item_name = "Silver Key"</code> already exists. What does this print?</p><pre>print("item_name")</pre>',
    'answers' => [
        ['item_name', 1.0, ''],
    ],
]);

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.4 MC Item 2: fix the missing quotes on a numeric-looking string',
    'questiontext' => '<p>A player\'s ticket number will never be used in math, so it should be stored as text. This line is supposed to store ticket number 4521 as a string, but it\'s missing something:</p><pre>ticket_number = 4521</pre><p>Write the corrected line.</p>',
    'answers' => [
        ['ticket_number = "4521"', 1.0, ''],
        ['ticket_number="4521"', 1.0, ''],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.4 MC Item 3: identify the real string',
    'questiontext' => '<p>Which of these is a real Python string?</p>',
    'options' => [
        ['<pre>200</pre>', 0.0, 'No quotation marks -- this is an integer.'],
        ['<pre>"200"</pre>', 1.0, 'Correct. Quotation marks make this a string, even though it\'s made of digits.'],
        ['<pre>200.0</pre>', 0.0, 'That has a decimal point and no quotes, so it\'s a float.'],
        ['<pre>True</pre>', 0.0, 'That is a boolean, not a string.'],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.4 MC Item 4: boolean-looking string from a save file',
    'questiontext' => '<p>A save file stores a variable this way:</p><pre>unlocked = "True"</pre><p>What type is <code>unlocked</code>?</p>',
    'options' => [
        ['Boolean', 0.0, 'It has quotation marks around it, so it isn\'t the real boolean.'],
        ['String', 1.0, 'Correct. The quotation marks make this a string, no matter what word is inside them.'],
        ['Integer', 0.0, '"True" isn\'t made of digits, and even if it were, the quotes would still make it a string.'],
        ['It depends on how it\'s used later in the program', 0.0, 'Type is decided by how a value is written, not by how it\'s used afterward.'],
    ],
]);

mcb_build_quiz([
    'course' => $course,
    'section' => 3,
    'name' => '02.4 Mastery Check',
    'intro' => '<p>4 questions checking that you can apply what 02.4 taught about strings: recognizing them, telling a variable apart from a quoted word, and spotting numbers and booleans in disguise. Ask your teacher for the password.</p>',
    'quizpassword' => 'Guava91&',
    'questionids' => $qids,
    'grade' => 10,
]);
