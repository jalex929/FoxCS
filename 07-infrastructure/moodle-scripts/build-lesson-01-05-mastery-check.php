<?php
// build-lesson-01-05-mastery-check.php
//
// Builds Lesson 01.5's (Comments and Documentation) Mastery Check as a native
// Moodle Quiz, matching the live pattern verified against the DB for 01.1/01.3/01.4:
//   - Slot 1: the SAME shared academic-integrity acknowledgment question (id=21,
//     category "Lesson 01.1 Mastery Check") reused across every lesson so far.
//   - Slot 2: a random draw of 1 question from a new 10-item pool category
//     "Lesson 01.5 Mastery Check - Task Pool" (3 questions ported verbatim from
//     09_mastery_check.py/the teacher KEY + 7 new questions covering facets the
//     original 3 didn't touch: the "documentation" term itself, commenting-out
//     mechanics, multi-line prediction with more comments, weak-vs-strong beyond
//     the one worked example, wrong-capitalization-style misreadings).
//   - attempts=3, grademethod=QUIZ_GRADEAVERAGE, password-gated, no SEB (matches
//     01.4's still-unresolved status), no due date (deferred, matches 01.2-01.4).
//   - Built VISIBLE=1 (per Jay's 2026-09-03 standing instruction: the quiz
//     password is the real access gate, module visibility doesn't need to
//     double as one -- students should see all of a lesson's content together).
//
// Run: sudo -u www-data php build-lesson-01-05-mastery-check.php

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
$sectionnum = $DB->get_field('course_modules', 'section', ['id' => 214]); // 01.4 Mastery Check's live section

// ---------------------------------------------------------------------------
// 1. Create the pool category and its 10 questions.
// ---------------------------------------------------------------------------
$poolcatname = 'Lesson 01.5 Mastery Check - Task Pool';
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
    // 1-3: ported verbatim from 09_mastery_check.py / the teacher KEY.
    '<p>Predict exactly what this displays:</p><pre># Show the player\'s current level
print("Level 5")
# print("Level 6 - not unlocked yet")
print("Keep going!")</pre>',
    '<p>This comment is weak, it just restates the code:</p><pre># print the message
print("Game paused")</pre><p>Rewrite the comment so it explains WHY this line might exist in a real game, not just what it does.</p>',
    '<p>A classmate says, "Comments are a waste of time. Python ignores them anyway, so they don\'t actually do anything." Do you agree or disagree? Explain your reasoning.</p>',
    // 4-10: new, written to cover facets the original 3 don't touch.
    '<p>Predict exactly what this displays, line by line:</p><pre>print("Wave 1 incoming")
# print("Wave 1 - test spawn rate x2")
print("Defend the base!")
# Reward the player after surviving
print("Wave cleared. +50 XP")</pre>',
    '<p>Explain the difference between a <strong>comment</strong> and <strong>documentation</strong>. Are they the same thing? Use both terms correctly in your answer.</p>',
    '<p>You\'re testing a game and want to temporarily stop one line from running, without deleting it, so you can put it back later. What specific action do you take, and what is that action called?</p>',
    '<p>This comment is weak:</p><pre># set score to 0
score = 0</pre><p>Rewrite it so it explains WHY the score is being set at this point in a real game (for example, at the start of a new round), not just what the line does.</p>',
    '<p>A teammate removes a line of code entirely instead of commenting it out, saying "same result, right?" Explain one real difference between deleting a line and commenting it out, from a programmer\'s point of view.</p>',
    '<p>Predict exactly what this displays:</p><pre># print("Boss defeated!")
print("Boss defeated!")
# End of battle</pre>',
    '<p>Think of a piece of code you might write for a game (you don\'t need to write real code, just describe it in a sentence). Write one strong comment for it that explains WHY that code exists, and explain what makes your comment strong rather than weak.</p>',
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
<p>Before you begin, make sure you have already completed 01.5's Practice and Coding Exercise -- this Mastery Check assumes you've already applied these skills, not that you're seeing them for the first time.</p>
<p>Don't start until you're actually ready. Ask your teacher for the password when you are.</p>
HTML;

$password = 'N7KQWD'; // new, distinct from every other lesson's password on this course.

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1; // visible immediately -- the password is the real gate, per Jay's standing instruction.
$moduleinfo->name = '01.5 Mastery Check';
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
