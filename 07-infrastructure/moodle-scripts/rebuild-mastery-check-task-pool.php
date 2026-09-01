<?php
// rebuild-mastery-check-task-pool.php
//
// Pivots 01.1 Mastery Check (cmid=114, quizid=2) from "answer all 4 essay tasks" to
// Jay's simplified 2026-09-01 design: one static password (already set separately),
// and one randomly-drawn task per student out of a pool of 10 -- replacing the earlier
// noon/6pm password-rotation approach (removed) as the anti-cheating mechanism. A pool
// of 10 (vs. the original 4) meaningfully reduces same-task collisions between nearby
// students in the same period, and cuts grading load from 4 responses/student to 1 --
// both real wins given the upcoming 6-week substitute-coverage window Jay flagged
// (this whole setup needs to run itself with zero system knowledge).
//
// The 4 original essay tasks (ids 17-20) are kept and reused, not discarded -- moved
// into a new dedicated question category alongside 6 new ones written to cover facets
// of 01.1 the original 4 didn't touch (order/sequence tracing with different numbers
// than Practice's own Core B question, program-vs-instruction-vs-programmer precision,
// a new real-world literalness scenario distinct from the vending machine, personal
// game-example transfer, and the "why do languages exist at all" angle on task 4's
// "what is Python for").
//
// Real architecture reason for a SEPARATE pool category, not just adding the 6 new
// tasks to the existing "Lesson 01.1 Mastery Check" category: that category still
// holds the academic-integrity acknowledgment question (id 21), which must always be
// the fixed first task and must NEVER be eligible for random draw. A category-level
// filter is the only condition Moodle's random-slot mechanism actually supports here
// (no per-question exclude), so separating categories is what makes "the integrity
// question can never be the random draw" structurally guaranteed rather than
// hoped-for.
//
// Uses \mod_quiz\structure::add_random_questions() -- the same internal API the real
// quiz editor UI calls -- rather than hand-rolling question_set_reference rows, since
// that table's filter-condition JSON shape is genuinely easy to get subtly wrong by
// hand and this needs to actually work unattended for six weeks.
//
// Run: sudo -u www-data php rebuild-mastery-check-task-pool.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');

use mod_quiz\question\bank\filter\custom_category_condition;
use mod_quiz\quiz_settings;
use mod_quiz\structure;

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);

$cm = $DB->get_record('course_modules', ['id' => 114], '*', MUST_EXIST);
$quizid = $cm->instance;

// ---------------------------------------------------------------------------
// 1. Create the dedicated task-pool category (integrity question stays out of it).
// ---------------------------------------------------------------------------
$poolcatname = 'Lesson 01.1 Mastery Check - Task Pool';
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

// ---------------------------------------------------------------------------
// 2. Move the 4 existing essay questions into the pool category.
// ---------------------------------------------------------------------------
foreach ([17, 18, 19, 20] as $questionbankentryid) {
    $DB->set_field('question_bank_entries', 'questioncategoryid', $poolcat->id, ['id' => $questionbankentryid]);
}
echo "Moved 4 existing tasks into the pool category.\n";

// ---------------------------------------------------------------------------
// 3. Write 6 new essay tasks directly into the pool category.
// ---------------------------------------------------------------------------
$newtasks = [
    "A program is supposed to: set score to 0, add 20 to score, add 20 to score again, then display score. A programmer accidentally writes the display step right after the *first* \"add 20\" instead of after the second one. What will the program actually display, and why?",
    "Explain the difference between a <em>programmer</em> and a <em>program</em>. Give an example that shows you understand both words.",
    "What is the difference between a program and a single instruction? Use the recipe idea from this lesson to explain your answer.",
    "Think of an automatic door at a store. It's programmed to open when it detects motion within 3 feet. Using what you learned about computers being literal, explain what would happen if someone stood exactly 4 feet away and waved.",
    "Pick a video game you've played. Describe one specific instruction you think a programmer had to write for that game to work the way it does.",
    "If programming languages didn't exist, how would a person try to give a computer instructions directly? Why do you think programming languages like Python were invented?",
];

$qtype = question_bank::get_qtype('essay');
$newids = [];

foreach ($newtasks as $i => $qtext) {
    $question = new stdClass();
    $question->qtype = 'essay';
    $question->category = $poolcat->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $poolcat->id;
    $form->context = $coursecontext;
    $form->name = 'Mastery Check Task Pool ' . ($i + 5); // continues numbering after the original 4
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
    $newids[] = $saved->id;
    echo "Saved new task " . ($i + 5) . ": id={$saved->id}\n";
}

echo "Pool now holds 10 tasks total (4 original + 6 new).\n";

// ---------------------------------------------------------------------------
// 4. Rebuild quiz_slots: slot 1 = fixed integrity question, slot 2 = random draw
//    of 1 from the pool category.
// ---------------------------------------------------------------------------
$oldslots = $DB->get_records('quiz_slots', ['quizid' => $quizid], 'slot');
$integrityquestionid = null;
foreach ($oldslots as $slot) {
    $qr = $DB->get_record('question_references', ['itemid' => $slot->id, 'component' => 'mod_quiz', 'questionarea' => 'slot']);
    if ($qr) {
        $qbe = $DB->get_record('question_bank_entries', ['id' => $qr->questionbankentryid]);
        $qv = $DB->get_record('question_versions', ['questionbankentryid' => $qbe->id]);
        $q = $DB->get_record('question', ['id' => $qv->questionid]);
        if ($q->name === 'Mastery Check Academic Integrity Acknowledgment') {
            $integrityquestionid = $q->id;
        }
    }
}
if (!$integrityquestionid) {
    fwrite(STDERR, "Could not find the integrity question among existing slots -- aborting before touching slots.\n");
    exit(1);
}
echo "Integrity question id={$integrityquestionid} confirmed.\n";

$DB->delete_records('quiz_slots', ['quizid' => $quizid]);
echo "Cleared old slots.\n";

$quiz = $DB->get_record('quiz', ['id' => $quizid], '*', MUST_EXIST);
quiz_add_quiz_question($integrityquestionid, $quiz, 0, 0);
echo "Re-added integrity question as slot 1 (maxmark=0).\n";

$settings = quiz_settings::create_for_cmid(114);
$structure = structure::create_for_quiz($settings);
$filtercondition = [
    'qpage' => 0,
    'cat' => "{$poolcat->id},{$coursecontext->id}",
    'qperpage' => 20,
    'tabname' => 'questions',
    'sortdata' => [],
    'filter' => [
        'category' => [
            'jointype' => custom_category_condition::JOINTYPE_DEFAULT,
            'values' => [$poolcat->id],
            'filteroptions' => ['includesubcategories' => false],
        ],
    ],
];
$structure->add_random_questions(1, 1, $filtercondition);
echo "Added random-draw slot 2 (1 question from the 10-task pool).\n";

quiz_settings::create($quiz->id)->get_grade_calculator()->recompute_quiz_sumgrades();
echo "Recomputed quiz sumgrades.\n";

echo "Done.\n";
