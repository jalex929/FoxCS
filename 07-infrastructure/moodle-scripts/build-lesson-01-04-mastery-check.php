<?php
// build-lesson-01-04-mastery-check.php
//
// Builds Lesson 01.4's (Printing Output) Mastery Check as a native Moodle Quiz,
// matching the CURRENT live pattern verified against the DB for 01.1/01.3 (NOT
// the stale "4 fixed essays" spec in lesson-01-04-build-plan.md, written before
// the 2026-09-01 pool redesign got checked against live state):
//   - Slot 1: the SAME shared academic-integrity acknowledgment question (id=21,
//     category "Lesson 01.1 Mastery Check") reused across 01.1/01.2/01.3 as a
//     fixed maxmark=0 first question -- reused here too, not recreated.
//   - Slot 2: a random draw of 1 question from a new 10-item pool category
//     "Lesson 01.4 Mastery Check - Task Pool" (4 questions ported verbatim from
//     09_mastery_check.html/the teacher KEY + 6 new questions written tonight
//     to cover facets 01.4's real objectives that the original 4 didn't touch,
//     most notably terminology: none of the original 4 test function/string/
//     argument, 01.4's actual language objective).
//   - attempts=3, grademethod=QUIZ_GRADEAVERAGE (average across 3 draws, so a
//     bomb-out-to-peek first attempt still hurts), password-gated, no SEB
//     (Jay's call tonight: skip for 01.4, matches 01.1's own still-unresolved
//     status), no due date (Jay's call: defer like 01.2/01.3).
//   - Built VISIBLE=0 (hidden) on purpose -- verify against the DB first, flip
//     visible in a short follow-up once confirmed, same as every prior lesson's
//     Mastery Check in this course.
//
// Run: sudo -u www-data php build-lesson-01-04-mastery-check.php

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

// ---------------------------------------------------------------------------
// 1. Create the pool category and its 10 questions.
// ---------------------------------------------------------------------------
$poolcatname = 'Lesson 01.4 Mastery Check - Task Pool';
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
    // 1-4: ported verbatim from 09_mastery_check.html / the teacher KEY.
    '<p>Predict exactly what this displays:</p><pre>print("Welcome back!")
print("You have 3 lives remaining.")</pre>',
    '<p>This line is broken. Rewrite it correctly, and name the specific mistake:</p><pre>print("Inventory Full)</pre>',
    '<p>This line is broken. Rewrite it correctly, and name the specific mistake:</p><pre>print "Quest Complete"</pre>',
    '<p>Write a single <code>print()</code> statement that could appear in a real game telling the player they don\'t have enough coins to buy something. Then explain, in a sentence or two, what makes your message good feedback rather than just technically-valid output.</p>',
    // 5-10: new, written tonight to cover facets the original 4 don't touch.
    '<p>In the statement <code>print("Game paused.")</code>, identify what <code>print</code> is called, what <code>"Game paused."</code> is called, and what role <code>"Game paused."</code> plays in the statement. Use the three vocabulary terms from this lesson: function, string, and argument.</p>',
    '<p>A classmate says: "In <code>print("Level up!")</code>, the whole thing including the word print is called the argument." Explain what\'s wrong with that statement, and give the correct term for each part instead.</p>',
    '<p>Predict exactly what this program displays, line by line:</p><pre>print("Starting game...")
print("Player joined.")
print("Score: 0")</pre><p>Then explain what would change about the output if the second and third lines were swapped.</p>',
    '<p>Think of a moment in a video game when text appears on screen, like a loading message, a pop-up, or a menu option. Write one <code>print()</code> statement a programmer might have used to create that specific piece of text. Then explain what makes the text inside the parentheses a string, and what makes <code>print()</code> a function rather than just a word.</p>',
    '<p>A friend learning Python asks: "Why does Python care so much about quotation marks and parentheses in a <code>print()</code> statement?" Using what you know about what <code>print()</code> actually is (a function) and what a string is, explain in your own words why both parts matter.</p>',
    '<p>This line is broken. Rewrite it correctly, and name the specific mistake:</p><pre>PRINT("Level Complete!")</pre>',
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
// 2. Create the quiz module itself, hidden.
// ---------------------------------------------------------------------------
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 2], '*', MUST_EXIST);

$intro = <<<'HTML'
<p>This is a scored test attempt, not practice. Once you start, it counts.</p>
<p>Before you begin, make sure you have already completed 01.4's Practice and Coding Exercise -- this Mastery Check assumes you've already applied these skills, not that you're seeing them for the first time.</p>
<p>Don't start until you're actually ready. Ask your teacher for the password when you are.</p>
HTML;

$password = 'M8VNQY'; // new, distinct from T4WPR8 (01.1) / other lessons' passwords.

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2;
$moduleinfo->visible = 0; // hidden until verified against the DB and reviewed.
$moduleinfo->name = '01.4 Mastery Check';
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
echo "Created quiz cmid={$result->coursemodule} quizid={$quiz->id} visible=0 password={$password}\n";

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
