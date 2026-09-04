<?php
// create-sandbox-unit02-pilot-mastery-check.php
//
// Deploys the Unit 02 pilot lesson's (02.1 Variables and Memory) Mastery
// Check to the sandbox course: 4 items (shortanswer/multichoice), all
// deterministically auto-graded per mastery-check-standards.md's "prefer
// deterministic validation" rule -- unlike build-lesson-01-06-mastery-check.php's
// essay-heavy pattern, this lesson's content (assignment mechanics, naming
// rules, output prediction) is a strong fit for Moodle's native shortanswer/
// multichoice types, so it uses those instead. See
// ../../courses/python/content/unit_02_variables_and_data/
// lesson_02_01_variables_and_memory/teacher-materials/mastery_check_key.md
// for the full item-by-item rationale.
//
// attempts=3, grademethod=QUIZ_GRADEAVERAGE, password-gated, no SEB.
//
// Run: sudo -u www-data php create-sandbox-unit02-pilot-mastery-check.php

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

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$sectionnum = 1;

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-u02-pilot-mc']);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; delete it first if you want to rebuild.\n";
    exit(1);
}

// ---------------------------------------------------------------------------
// 1. Question category + 4 questions.
// ---------------------------------------------------------------------------
$catname = 'Sandbox 02.1 Mastery Check - Task Pool';
$cat = $DB->get_record('question_categories', ['name' => $catname, 'contextid' => $coursecontext->id]);
if (!$cat) {
    $cat = new stdClass();
    $cat->name = $catname;
    $cat->contextid = $coursecontext->id;
    $cat->info = '';
    $cat->infoformat = FORMAT_HTML;
    $cat->stamp = make_unique_id_code();
    $cat->parent = 0;
    $cat->sortorder = 999;
    $cat->id = $DB->insert_record('question_categories', $cat);
}
echo "Question category id={$cat->id}\n";

$sa = question_bank::get_qtype('shortanswer');
$mc = question_bank::get_qtype('multichoice');
$qids = [];

// --- Item 1: shortanswer, predicts reassignment + print output ---
$q = new stdClass();
$q->qtype = 'shortanswer';
$q->category = $cat->id;
$q->contextid = $coursecontext->id;
$q->createdby = $USER->id;
$q->modifiedby = $USER->id;
$form = new stdClass();
$form->category = $cat->id;
$form->context = $coursecontext;
$form->name = 'MC Item 1: predict reassignment output';
$form->questiontext = ['text' => '<p>What does this program print?</p><pre>score = 0
score = 15
print("Score:", score)</pre>', 'format' => FORMAT_HTML];
$form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->defaultmark = 1;
$form->penalty = 0.3333333;
$form->usecase = 1;
$form->answer = ['Score: 15'];
$form->fraction = [1.0];
$form->feedback = [['text' => '', 'format' => FORMAT_HTML]];
$saved = $sa->save_question($q, $form);
$qids[] = $saved->id;
echo "Saved item 1: id={$saved->id}\n";

// --- Item 2: shortanswer, fix the broken assignment line ---
$q = new stdClass();
$q->qtype = 'shortanswer';
$q->category = $cat->id;
$q->contextid = $coursecontext->id;
$q->createdby = $USER->id;
$q->modifiedby = $USER->id;
$form = new stdClass();
$form->category = $cat->id;
$form->context = $coursecontext;
$form->name = 'MC Item 2: fix the broken assignment';
$form->questiontext = ['text' => '<p>This line is supposed to create a variable named <code>lives</code> set to <code>3</code>, but it has a mistake:</p><pre>3 = lives</pre><p>Write the corrected line.</p>', 'format' => FORMAT_HTML];
$form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->defaultmark = 1;
$form->penalty = 0.3333333;
$form->usecase = 0;
$form->answer = ['lives = 3', 'lives=3'];
$form->fraction = [1.0, 1.0];
$form->feedback = [['text' => '', 'format' => FORMAT_HTML], ['text' => '', 'format' => FORMAT_HTML]];
$saved = $sa->save_question($q, $form);
$qids[] = $saved->id;
echo "Saved item 2: id={$saved->id}\n";

// --- Item 3: multichoice, valid naming ---
$q = new stdClass();
$q->qtype = 'multichoice';
$q->category = $cat->id;
$q->contextid = $coursecontext->id;
$q->createdby = $USER->id;
$q->modifiedby = $USER->id;
$form = new stdClass();
$form->category = $cat->id;
$form->context = $coursecontext;
$form->name = 'MC Item 3: valid naming';
$form->questiontext = ['text' => '<p>Which of these variable names is valid in Python?</p>', 'format' => FORMAT_HTML];
$form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->defaultmark = 1;
$form->penalty = 0.3333333;
$form->single = 1;
$form->shuffleanswers = 1;
$form->answernumbering = 'abc';
$form->correctfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->partiallycorrectfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->incorrectfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->answer = [
    ['text' => '<pre>1st_place</pre>', 'format' => FORMAT_HTML],
    ['text' => '<pre>player class</pre>', 'format' => FORMAT_HTML],
    ['text' => '<pre>player_class</pre>', 'format' => FORMAT_HTML],
    ['text' => '<pre>def</pre>', 'format' => FORMAT_HTML],
];
$form->fraction = [0, 0, 1.0, 0];
$form->feedback = [
    ['text' => 'Names cannot start with a digit.', 'format' => FORMAT_HTML],
    ['text' => 'Names cannot contain spaces.', 'format' => FORMAT_HTML],
    ['text' => 'Correct.', 'format' => FORMAT_HTML],
    ['text' => 'def is a reserved Python word.', 'format' => FORMAT_HTML],
];
$saved = $mc->save_question($q, $form);
$qids[] = $saved->id;
echo "Saved item 3: id={$saved->id}\n";

// --- Item 4: shortanswer, predicts multi-piece print output ---
$q = new stdClass();
$q->qtype = 'shortanswer';
$q->category = $cat->id;
$q->contextid = $coursecontext->id;
$q->createdby = $USER->id;
$q->modifiedby = $USER->id;
$form = new stdClass();
$form->category = $cat->id;
$form->context = $coursecontext;
$form->name = 'MC Item 4: predict multi-piece print output';
$form->questiontext = ['text' => '<p>What does this program print?</p><pre>player = "Nia"
room = "the vault"
print(player, "entered", room)</pre>', 'format' => FORMAT_HTML];
$form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->defaultmark = 1;
$form->penalty = 0.3333333;
$form->usecase = 0;
$form->answer = ['Nia entered the vault'];
$form->fraction = [1.0];
$form->feedback = [['text' => '', 'format' => FORMAT_HTML]];
$saved = $sa->save_question($q, $form);
$qids[] = $saved->id;
echo "Saved item 4: id={$saved->id}\n";

// ---------------------------------------------------------------------------
// 2. Create the quiz and add all 4 questions as fixed slots.
// ---------------------------------------------------------------------------
$intro = <<<'HTML'
<p>This is a scored test attempt, not practice. Once you start, it counts.</p>
<p>Make sure you've already completed 02.1's Practice and Project before starting this Mastery Check.</p>
HTML;

$password = 'U2P1LOT'; // sandbox-only password, distinct from any real course.

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '2.1 Mastery Check (sandbox pilot)';
$moduleinfo->idnumber = 'sandbox-u02-pilot-mc';
$moduleinfo->introeditor = ['text' => $intro, 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->quizpassword = $password;
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->timelimit = 0;
$moduleinfo->attempts = 3;
$moduleinfo->grademethod = QUIZ_GRADEAVERAGE;
$moduleinfo->preferredbehaviour = 'adaptivenopenalty';
$moduleinfo->questionsperpage = 0;
$moduleinfo->shuffleanswers = 1;
$moduleinfo->navmethod = 'free';
$moduleinfo->grade = 100;

$result = create_module($moduleinfo);
$quiz = $DB->get_record('quiz', ['id' => $result->instance], '*', MUST_EXIST);
echo "Created quiz cmid={$result->coursemodule} quizid={$quiz->id} password={$password}\n";

foreach ($qids as $qid) {
    quiz_add_quiz_question($qid, $quiz, 0, 1);
}
echo "Added all 4 items as fixed slots.\n";

$settings = \mod_quiz\quiz_settings::create($quiz->id);
$settings->get_grade_calculator()->recompute_quiz_sumgrades();
echo "Recomputed quiz sumgrades.\n";

echo "Done. cmid={$result->coursemodule} quizid={$quiz->id}\n";
