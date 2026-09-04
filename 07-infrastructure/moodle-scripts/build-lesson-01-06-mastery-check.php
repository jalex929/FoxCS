<?php
// build-lesson-01-06-mastery-check.php
//
// Builds Lesson 01.6's (Common Syntax Mistakes) Mastery Check as a native Moodle
// Quiz, matching the live pattern verified against the DB for 01.1/01.3/01.4/01.5:
//   - Slot 1: the SAME shared academic-integrity acknowledgment question (id=21).
//   - Slot 2: a random draw of 1 question from a new 10-item pool category
//     "Lesson 01.6 Mastery Check - Task Pool" (4 questions ported verbatim from
//     08_mastery_check.py/the teacher KEY + 6 new questions covering facets the
//     original 4 didn't touch: the EOL/syntax/parenthesis terms, a fresh
//     multi-error diagnosis, and reading a debugging sequence).
//   - attempts=3, grademethod=QUIZ_GRADEAVERAGE, password-gated, no SEB, no due date.
//   - Built VISIBLE=1 (the quiz password is the real access gate).
//
// Run: sudo -u www-data php build-lesson-01-06-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$sectionnum = 2; // "Unit 01: What Is Programming?"

// ---------------------------------------------------------------------------
// 1. Create the pool category and its 10 questions.
// ---------------------------------------------------------------------------
$poolcatname = 'Lesson 01.6 Mastery Check - Task Pool';
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

$tasks = [
    // 1-4: ported verbatim from 08_mastery_check.py / the teacher KEY.
    '<p>Fix this line so it displays "New Record!", and name the mistake:</p><pre>print("New Record!</pre>',
    '<p>Fix this line so it displays "Paused", and name the mistake:</p><pre>print(Paused)</pre>',
    '<p>This line has two mistakes at once. Fix both, and name each one. It should display: Continue</p><pre>Print(Continue</pre>',
    '<p>Explain, in your own words, how you can tell the difference between a mistake that causes a SyntaxError and one that causes a NameError. What is Python actually confused about in each case?</p>',
    // 5-10: new, written to cover facets the original 4 don't touch.
    '<p>Fix this line so it displays "Game Saved", and name the mistake:</p><pre>print(Game Saved)</pre>',
    '<p>What does <strong>EOL</strong> stand for, and what kind of mistake usually causes an error message to mention it? Give an example broken line that would cause it.</p>',
    '<p>Define <strong>syntax</strong> and <strong>parenthesis</strong> in your own words, and explain how they relate to each other using a <code>print()</code> example.</p>',
    '<p>You run your program and see <code>NameError: name \'Score\' is not defined</code>. Your teammate says "that means you have a typo somewhere, like a missing letter." Is your teammate right? Explain what a NameError actually means, using this example.</p>',
    '<p>This line has two mistakes at once. Fix both, and name each one. It should display: Try Again</p><pre>print(Try Again</pre>',
    '<p>Describe the 4-step debugging process from this lesson (read the error message\'s last line, find the line number, compare against the rules, fix one thing and run again) in your own words, and explain why fixing one mistake at a time matters even when a line has more than one problem.</p>',
];

$qtype = question_bank::get_qtype('essay');
$taskids = [];
foreach ($tasks as $i => $qtext) {
    $question = new stdClass();
    $question->qtype = 'essay';
    $question->category = $poolcat->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $poolcat->id;
    $form->context = $coursecontext;
    $form->name = 'Mastery Check Task Pool ' . ($i + 1);
    $form->questiontext = ['text' => $qtext, 'format' => FORMAT_HTML];
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
    $taskids[] = $saved->id;
    echo "Saved task " . ($i + 1) . ": id={$saved->id}\n";
}
echo "Pool now holds " . count($taskids) . " tasks.\n";

// ---------------------------------------------------------------------------
// 2. Create the quiz module itself.
// ---------------------------------------------------------------------------
$intro = <<<'HTML'
<p>This is a scored test attempt, not practice. Once you start, it counts.</p>
<p>Before you begin, make sure you have already completed 01.6's Practice and Coding Exercise -- this Mastery Check assumes you've already applied these skills, not that you're seeing them for the first time.</p>
<p>Don't start until you're actually ready. Ask your teacher for the password when you are.</p>
HTML;

$password = 'B3RTHX'; // new, distinct from every other lesson's password on this course.

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.6 Mastery Check';
$moduleinfo->introeditor = ['text' => $intro, 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->quizpassword = $password;
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->timelimit = 0;
$moduleinfo->attempts = 3;
$moduleinfo->grademethod = QUIZ_GRADEAVERAGE;
$moduleinfo->preferredbehaviour = 'manualgraded';
$moduleinfo->questionsperpage = 0;
$moduleinfo->shuffleanswers = 1;
$moduleinfo->navmethod = 'free';
$moduleinfo->grade = 100;

$result = create_module($moduleinfo);
$quiz = $DB->get_record('quiz', ['id' => $result->instance], '*', MUST_EXIST);
echo "Created quiz cmid={$result->coursemodule} quizid={$quiz->id} visible=1 password={$password}\n";

// ---------------------------------------------------------------------------
// 3. Wire slots: 1 = shared integrity question (maxmark=0), 2 = random draw of
//    1 from the new pool.
// ---------------------------------------------------------------------------
$integrityquestionid = $DB->get_field('question', 'id', ['name' => 'Mastery Check Academic Integrity Acknowledgment'], MUST_EXIST);
quiz_add_quiz_question($integrityquestionid, $quiz, 0, 0);
echo "Added shared integrity question (id={$integrityquestionid}) as slot 1, maxmark=0.\n";

$settings = \mod_quiz\quiz_settings::create($quiz->id);
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
echo "Added random-draw slot 2 (1 question from the 10-task pool).\n";

$settings->get_grade_calculator()->recompute_quiz_sumgrades();
echo "Recomputed quiz sumgrades.\n";

echo "Done. cmid={$result->coursemodule} quizid={$quiz->id}\n";
