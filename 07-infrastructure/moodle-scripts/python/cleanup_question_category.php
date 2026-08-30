<?php
// Deletes a question-bank category and everything in it (questions, their
// qtype-specific option rows, files) via Moodle's own real deletion path --
// used while iterating on create_lesson1_mastery_check_quiz.php, since
// re-running it without cleanup first accumulates duplicate categories/
// questions (each run creates a fresh category+questions before creating
// the quiz). Edit the category name below to reuse for a different lesson.
//
// Run: sudo -u www-data php cleanup_question_category.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/questionlib.php');
\core\cron::setup_user();

$cats = $DB->get_records('question_categories', ['name' => 'Lesson 01.1 Mastery Check']);
foreach ($cats as $cat) {
    question_category_delete_safe($cat);
    echo "Deleted category id={$cat->id}\n";
}
