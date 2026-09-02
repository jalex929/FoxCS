<?php
// build-lesson-01-03-mastery-check.php
//
// 01.3 Mastery Check -- kept deliberately simple per Jay's direct ask: "a simple
// validated question where we say to print some exact output and give an output for
// them to match." Unlike 01.1/01.2's essay-based task pools (which need manual
// grading), this uses shortanswer questions: the task pool gives a target output
// string, the student writes the print() statement that produces it exactly, and
// Moodle grades it automatically against several accepted quote/spacing variants. No
// manual grading step at all -- the whole quiz is auto-graded.
//
// Same proven architecture as 01.1/01.2: fixed integrity acknowledgment (reused
// question id=21, maxmark=0) always first, then a random draw of 1 from a dedicated
// task-pool category. Password-only (no SEB, removed sitewide 2026-09-01).
//
// Run: sudo -u www-data php build-lesson-01-03-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');

use mod_quiz\quiz_settings;

\core\cron::setup_user();

const REAL_PASSWORD = 'Syntax73#';

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$sectionnum = 2;

// ---------------------------------------------------------------------------
// 1. Create the quiz activity.
// ---------------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.3 Mastery Check';
$moduleinfo->introeditor = [
    'text' => '<p>Before you start: this Mastery Check only works with the password '
        . "your teacher gives you in class. If you don't have it, close this and check "
        . 'with your teacher.</p>'
        . '<p>You will answer two questions: a short acknowledgment, then one '
        . 'print()-writing task randomly assigned to you. Type your answer exactly, '
        . 'quotes and all. You get 3 attempts, and your grade is the average of all '
        . 'attempts, not just your best one, so take each attempt seriously.</p>'
        . '<p><strong>If your teacher is out and you don\'t have today\'s password:</strong> '
        . "don't wait around for it. Move on to the next lesson and come back to this "
        . 'Mastery Check the next time your teacher is here to give you the password.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->quizpassword = REAL_PASSWORD;
$moduleinfo->attempts = 3;
$moduleinfo->grademethod = 2; // QUIZ_GRADEAVERAGE
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->timelimit = 0;
$moduleinfo->overduehandling = 'autoabandon';
$moduleinfo->graceperiod = 0;
$moduleinfo->preferredbehaviour = 'deferredfeedback';
$moduleinfo->canredoquestions = 0;
$moduleinfo->attemptonlast = 0;
$moduleinfo->decimalpoints = 2;
$moduleinfo->questiondecimalpoints = -1;
$moduleinfo->reviewattempt = 65536;
$moduleinfo->reviewcorrectness = 0;
$moduleinfo->reviewmaxmarks = 0;
$moduleinfo->reviewmarks = 0;
$moduleinfo->reviewspecificfeedback = 0;
$moduleinfo->reviewgeneralfeedback = 0;
$moduleinfo->reviewrightanswer = 0;
$moduleinfo->reviewoverallfeedback = 0;
$moduleinfo->questionsperpage = 0;
$moduleinfo->navmethod = 'free';
$moduleinfo->shuffleanswers = 1;
$moduleinfo->grade = 100;
$moduleinfo->showuserpicture = 0;
$moduleinfo->showblocks = 0;
$moduleinfo->completionattemptsexhausted = 0;
$moduleinfo->completionminattempts = 0;
$moduleinfo->allowofflineattempts = 0;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$quizid = $result->id;
echo "Created quiz activity: cmid={$cmid} quizid={$quizid}\n";

// ---------------------------------------------------------------------------
// 2. Create the task-pool category and write the print-matching tasks.
// ---------------------------------------------------------------------------
$poolcatname = 'Lesson 01.3 Mastery Check - Task Pool';
$poolcat = $DB->get_record('question_categories', ['name' => $poolcatname, 'contextid' => $coursecontext->id]);
if (!$poolcat) {
    $poolcat = new stdClass();
    $poolcat->name = $poolcatname;
    $poolcat->contextid = $coursecontext->id;
    $poolcat->info = '';
    $poolcat->infoformat = FORMAT_HTML;
    $poolcat->stamp = make_unique_id_code();
    $poolcat->parent = 0;
    $poolcat->sortorder = 999;
    $poolcat->id = $DB->insert_record('question_categories', $poolcat);
}
echo "Pool category id={$poolcat->id}\n";

// Each task: a target output string. Accepted answers cover both quote styles and an
// optional space after "print", all case-sensitive (exact output text matters).
$tasks = [
    'Ready to code!',
    'Score: 100',
    'Hello, world!',
    'Level Up!',
    'Game Over',
    'Player 1 Wins!',
];

$qtype = question_bank::get_qtype('shortanswer');
foreach ($tasks as $i => $target) {
    $question = new stdClass();
    $question->qtype = 'shortanswer';
    $question->category = $poolcat->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $poolcat->id;
    $form->context = $coursecontext;
    $form->name = 'Mastery Check Print Task ' . ($i + 1);
    $form->questiontext = [
        'text' => "<p>Write a single Python <code>print()</code> statement that outputs "
            . "exactly:</p><p><strong>{$target}</strong></p>"
            . '<p>Type just the statement, nothing else. Match the text exactly, '
            . 'including capitalization and punctuation.</p>',
        'format' => FORMAT_HTML,
    ];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1;
    $form->penalty = 0.3333333;
    $form->usecase = 1; // case-sensitive: exact output text matters

    $variants = [
        "print(\"{$target}\")",
        "print('{$target}')",
        "print (\"{$target}\")",
        "print ('{$target}')",
    ];
    $form->answer = [];
    $form->fraction = [];
    $form->feedback = [];
    foreach ($variants as $v) {
        $form->answer[] = $v;
        $form->fraction[] = 1.0;
        $form->feedback[] = ['text' => '', 'format' => FORMAT_HTML];
    }

    $saved = $qtype->save_question($question, $form);
    echo "Saved task " . ($i + 1) . ": id={$saved->id}\n";
}
echo "Pool now holds " . count($tasks) . " tasks.\n";

// ---------------------------------------------------------------------------
// 3. Slot 1 = fixed integrity question (reused id=21). Slot 2 = random draw of 1.
// ---------------------------------------------------------------------------
$integrityquestionid = 21;
$integrityq = $DB->get_record('question', ['id' => $integrityquestionid]);
if (!$integrityq || $integrityq->name !== 'Mastery Check Academic Integrity Acknowledgment') {
    fwrite(STDERR, "Question id=21 is not the expected integrity question -- aborting before touching slots.\n");
    exit(1);
}
echo "Integrity question id={$integrityquestionid} confirmed: {$integrityq->name}\n";

$quiz = $DB->get_record('quiz', ['id' => $quizid], '*', MUST_EXIST);
quiz_add_quiz_question($integrityquestionid, $quiz, 0, 0);
echo "Added integrity question as slot 1 (maxmark=0).\n";

$settings = quiz_settings::create_for_cmid($cmid);
$structure = \mod_quiz\structure::create_for_quiz($settings);
$filtercondition = [
    'qpage' => 0,
    'cat' => "{$poolcat->id},{$coursecontext->id}",
    'qperpage' => 20,
    'tabname' => 'questions',
    'sortdata' => [],
    'filter' => [
        'category' => [
            'jointype' => \mod_quiz\question\bank\filter\custom_category_condition::JOINTYPE_DEFAULT,
            'values' => [$poolcat->id],
            'filteroptions' => ['includesubcategories' => false],
        ],
    ],
];
$structure->add_random_questions(1, 1, $filtercondition);
echo "Added random-draw slot 2 (1 question from the task pool).\n";

quiz_settings::create($quiz->id)->get_grade_calculator()->recompute_quiz_sumgrades();
echo "Recomputed quiz sumgrades.\n";

$DB->set_field('course_modules', 'completion', 2, ['id' => $cmid]);

rebuild_course_cache($course->id, true);
echo "Done. cmid={$cmid} quizid={$quizid} password=" . REAL_PASSWORD . "\n";
