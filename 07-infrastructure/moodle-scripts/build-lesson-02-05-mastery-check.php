<?php
// build-lesson-02-05-mastery-check.php
//
// 02.5 (Booleans) Mastery Check -- new content, no sandbox precedent. 4 items,
// DOK 2-3, each synthesizing 2+ of 02.5's 5 skill nodes (identifies_boolean_type,
// applies_boolean_casing, distinguishes_boolean_from_string,
// interprets_true_false_as_program_state, selects_boolean_for_two_state_information)
// rather than repeating a Practice item verbatim. Scenarios (boss defeated,
// save-slot full, email verified) are deliberately different from 02.5's own
// live Practice items (game_paused, is_alive, door_locked, sound_enabled,
// assignment_submitted, level_complete, quest_complete, game_over) and from
// 02.1/02.2/02.3/02.4's Mastery Check scenarios.
// 02.5's Instruction content stops at plain True/False assignment and
// reassignment -- no comparison operators (==, !=) or conditional logic
// appear anywhere in the lesson (that's later, in the conditionals unit), so
// none of these items require them.
// See courses/python/content/unit_02_variables_and_data/lesson_02_05_booleans/
// teacher-materials/mastery_check_key.md for the full rubric/answer key.
//
// Run: sudo -u www-data php build-lesson-02-05-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once('/tmp/mastery_check_builder.php'); // www-data can't traverse /home/jay (mode 750); canonical source is python/mastery_check_builder.php.

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$category = mcb_get_category($coursecontext, 'Lesson 02.5 Mastery Check');

$qids = [];

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.5 MC Item 1: fix the boolean casing',
    'questiontext' => '<p>This line is supposed to create a boolean named <code>boss_defeated</code> set to <code>False</code>, but it has a mistake:</p><pre>boss_defeated = false</pre><p>Write the corrected line.</p>',
    'answers' => [
        ['boss_defeated = False', 1.0, ''],
        ['boss_defeated=False', 1.0, ''],
    ],
]);

$qids[] = mcb_create_shortanswer($category, $coursecontext, [
    'name' => '02.5 MC Item 2: fix the string-disguised boolean',
    'questiontext' => '<p>This line is supposed to set <code>save_slot_full</code> to the real Python boolean <code>True</code>, but it has two mistakes:</p><pre>save_slot_full = "true"</pre><p>Write the corrected line.</p>',
    'answers' => [
        ['save_slot_full = True', 1.0, ''],
        ['save_slot_full=True', 1.0, ''],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.5 MC Item 3: write the real boolean correctly',
    'questiontext' => '<p>A variable <code>email_verified</code> needs to hold the real Python boolean value <code>False</code>. Which of these is written correctly?</p>',
    'options' => [
        ['<pre>email_verified = False</pre>', 1.0, 'Correct. No quotes, and capitalized exactly as Python requires.'],
        ['<pre>email_verified = "False"</pre>', 0.0, 'The quotation marks make this a string, not the real boolean.'],
        ['<pre>email_verified = FALSE</pre>', 0.0, 'Python\'s boolean is capitalized in exactly one way: False, not FALSE.'],
        ['<pre>email_verified = 0</pre>', 0.0, 'That is an integer, not a boolean, even though it can act like one behind the scenes.'],
    ],
]);

$qids[] = mcb_create_multichoice($category, $coursecontext, [
    'name' => '02.5 MC Item 4: choose a boolean on purpose',
    'questiontext' => '<p>A game needs to track several things about a boss fight. Which of these should be stored as a boolean?</p>',
    'options' => [
        ['whether the player has beaten the final boss', 1.0, 'Correct. The boss fight either happened or it didn\'t -- exactly the two-state fact a boolean flips between.'],
        ['the number of enemies defeated', 0.0, 'That can be many different values, so it\'s an integer, not a boolean.'],
        ['the name of the current level', 0.0, 'A name is text, so it\'s a string.'],
        ['the exact time remaining (45.2 seconds)', 0.0, 'That needs decimal precision, so it\'s a float.'],
    ],
]);

mcb_build_quiz([
    'course' => $course,
    'section' => 3,
    'name' => '02.5 Mastery Check',
    'intro' => '<p>4 questions checking that you can apply what 02.5 taught about booleans: exact True/False casing, telling a boolean apart from a string that looks like one, and choosing a boolean on purpose for two-state information. Ask your teacher for the password.</p>',
    'quizpassword' => 'Lychee58!',
    'questionids' => $qids,
    'grade' => 10,
]);
