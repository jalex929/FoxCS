<?php
// Creates Lesson 01.1's Mastery Check as a real Moodle Quiz (4 essay
// questions, manually graded, matching the real open-ended questions from
// 07_mastery_check.html) with a native "require password" setting -- the
// real Moodle-native alternative to H5P's total lack of any password-gate
// mechanism, per Jay's 2026-08-30 request for password-protected mastery
// checks going forward.
//
// Uses the actual production question-save code path
// (question_type::save_question(), the same method mod/question/question.php's
// edit form calls), NOT the PHPUnit test generators (mod_quiz_generator /
// core_question_generator) -- those have a hard PHPUnit\Framework\TestCase
// dependency and are not usable standalone outside a real test run, confirmed
// the hard way, not assumed.
//
// Two real gotchas hit and fixed building this, both from mismatches between
// what the quiz *edit form* submits and what a hand-built $moduleinfo/$form
// object needs to supply directly:
//   - create_module() for a quiz expects $moduleinfo->quizpassword, NOT
//     ->password (mod/quiz/lib.php remaps quizpassword -> password
//     internally before the DB insert; the raw column is named password,
//     the form field name is quizpassword, and create_module() expects the
//     form-field name).
//   - quiz_update_sumgrades() was removed/renamed to
//     \mod_quiz\grade_calculator::recompute_quiz_sumgrades() (an instance
//     method, not a standalone function) -- get one via
//     \mod_quiz\quiz_settings::create($quizid)->get_grade_calculator().
//
// Run: sudo -u www-data php create_lesson1_mastery_check_quiz.php
// (uses $CFG->debug/debugdisplay to surface DB/exception detail while
// iterating -- safe to leave on for a one-off CLI script like this one)

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);

// Question category, scoped to this course.
$existingcat = $DB->get_record('question_categories', ['name' => 'Lesson 01.1 Mastery Check', 'contextid' => $coursecontext->id]);
if ($existingcat) {
    $category = $existingcat;
} else {
    $category = new stdClass();
    $category->name = 'Lesson 01.1 Mastery Check';
    $category->contextid = $coursecontext->id;
    $category->info = '';
    $category->infoformat = FORMAT_HTML;
    $category->stamp = make_unique_id_code();
    $category->parent = 0;
    $category->sortorder = 999;
    $category->id = $DB->insert_record('question_categories', $category);
}

$questions = [
    "Explain, in your own words, what a program is. Use an example from everyday life that is <em>not</em> a video game and <em>not</em> a calculator app.",
    "A vending machine takes your money, checks whether you inserted enough, and then either gives you the item or shows an error. Describe at least one specific instruction you think must exist somewhere inside the vending machine's program for this to work.",
    "A friend tells you, \"Computers are smart. They figure things out on their own.\" Based on what you learned in this lesson, do you agree or disagree? Explain your answer using the word <em>instruction</em>.",
    "Explain what a programming language like Python is for, and why a programmer needs one to make a computer do something.",
];

$qtype = question_bank::get_qtype('essay');
$questionids = [];

foreach ($questions as $i => $qtext) {
    $question = new stdClass();
    $question->qtype = 'essay';
    $question->category = $category->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $category->id;
    $form->context = $coursecontext;
    $form->name = 'Mastery Check Question ' . ($i + 1);
    $form->questiontext = ['text' => "<p>{$qtext}</p>", 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1;
    $form->penalty = 0;
    $form->responseformat = 'editor';
    $form->responserequired = 1;
    $form->responsefieldlines = 15;
    $form->attachments = 0;
    $form->attachmentsrequired = 0;
    $form->maxbytes = 0;
    $form->graderinfo = ['text' => '', 'format' => FORMAT_HTML];
    $form->responsetemplate = ['text' => '', 'format' => FORMAT_HTML];

    $saved = $qtype->save_question($question, $form);
    $questionids[] = $saved->id;
    echo "Saved question " . ($i + 1) . ": id={$saved->id}\n";
}

// Create the quiz itself via create_module(), same pattern as every other
// activity created this session.
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 2], '*', MUST_EXIST);

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.1 Mastery Check (Quiz)';
$moduleinfo->introeditor = ['text' => '<p>4 questions checking your understanding of this lesson. Ask your teacher for the password.</p>', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->quizpassword = 'T4WPR8';
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->timelimit = 0;
$moduleinfo->attempts = 3; // capped, not unlimited -- prevents unbounded manual-grading load on essay questions
$moduleinfo->grademethod = QUIZ_GRADEAVERAGE; // average of all attempts, so a deliberate first-attempt bomb-out to peek at questions still hurts the grade
$moduleinfo->preferredbehaviour = 'manualgraded';
$moduleinfo->questionsperpage = 0;
$moduleinfo->shuffleanswers = 1;
$moduleinfo->navmethod = 'free';
$moduleinfo->grade = 100;

$result = create_module($moduleinfo);
$quiz = $DB->get_record('quiz', ['id' => $result->instance], '*', MUST_EXIST);

foreach ($questionids as $qid) {
    quiz_add_quiz_question($qid, $quiz, 0, 1);
}
$quizobj = \mod_quiz\quiz_settings::create($quiz->id);
$quizobj->get_grade_calculator()->recompute_quiz_sumgrades();

echo "Created quiz cmid={$result->coursemodule} quizid={$quiz->id}, " . count($questionids) . " questions added, password set.\n";
