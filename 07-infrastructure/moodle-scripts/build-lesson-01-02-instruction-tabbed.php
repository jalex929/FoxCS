<?php
// build-lesson-01-02-instruction-tabbed.php
//
// Builds 01.2 Input-Process-Output's Instruction as a native tabbed Lesson, following
// the settled 01.1 pattern directly (no mockup round needed -- the pattern is proven):
// one tabbed Content page (4 tabs: What Is IPO / Real-World Example / Game Connection /
// Key Terms w/ flip-card flashcards) -> Quick Check A -> Quick Check B -> Vocab Quiz
// (native Matching, wrong -> Breakdown -> Retry with rephrased definitions).
//
// Content ported from the real, already-written prose in
// courses/python/content/unit_01_what_is_programming/lesson_01_02_input_process_output/
// 01_instruction.html -- but the two Quick Checks are NOT the old file's JS-based
// checks. Those directly restated the exact examples already explicitly labeled in the
// text (the quiz-app example literally says "(process)" right next to the answer,
// same for the hand dryer's "(output)"), which is exactly the "don't ask what's
// already been answered" problem Jay flagged for the IPO content specifically. Both
// Quick Checks here use brand-new scenarios (a thermostat, a smart speaker) that never
// appear in the tab content, so answering them requires actually transferring the
// concept, not recalling a label already given.
//
// Run: sudo -u www-data php build-lesson-01-02-instruction-tabbed.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_MATCHING = 5;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2;

function foxcs_insert_lesson_page($DB, $lessonid, $title, $contents, $qtype, $prevpageid) {
    $page = new stdClass();
    $page->lessonid = $lessonid;
    $page->title = $title;
    $page->contents = $contents;
    $page->contentsformat = FORMAT_HTML;
    $page->qtype = $qtype;
    $page->qoption = 0;
    $page->layout = 1;
    $page->display = 1;
    $page->timecreated = time();
    $page->timemodified = time();
    $page->prevpageid = $prevpageid;
    $page->nextpageid = 0;
    $page->id = $DB->insert_record('lesson_pages', $page);
    if ($prevpageid) {
        $DB->set_field('lesson_pages', 'nextpageid', $page->id, ['id' => $prevpageid]);
    }
    return $page->id;
}

function foxcs_insert_answer($DB, $lessonid, $pageid, $answerhtml, $responsehtml, $jumpto, $score) {
    $a = new stdClass();
    $a->lessonid = $lessonid;
    $a->pageid = $pageid;
    $a->answer = $answerhtml;
    $a->answerformat = FORMAT_HTML;
    $a->response = $responsehtml;
    $a->responseformat = FORMAT_HTML;
    $a->jumpto = $jumpto;
    $a->score = $score;
    $a->timecreated = time();
    $a->timemodified = time();
    return $DB->insert_record('lesson_answers', $a);
}

function foxcs_insert_matching_answer($DB, $lessonid, $pageid, $answer, $response, $jumpto, $score) {
    $a = new stdClass();
    $a->lessonid = $lessonid;
    $a->pageid = $pageid;
    $a->answer = $answer;
    $a->answerformat = FORMAT_HTML;
    $a->response = $response;
    $a->responseformat = 0;
    $a->jumpto = $jumpto;
    $a->score = $score;
    $a->timecreated = time();
    $a->timemodified = time();
    return $DB->insert_record('lesson_answers', $a);
}

// ---------------------------------------------------------------------------
// 1. Create the lesson activity.
// ---------------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'lesson';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'lesson']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.2 Input-Process-Output';
$moduleinfo->introeditor = [
    'text' => '<p>Work through this at your own pace using the Continue button. A couple of quick questions are mixed in along the way, just to check your understanding as you go (they don\'t affect whether you move forward). Everything saves automatically.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->grade = 100;
$moduleinfo->custom = 1;
$moduleinfo->retake = 0;
$moduleinfo->modattempts = 1;
$moduleinfo->review = 0;
$moduleinfo->feedback = 1;
$moduleinfo->practice = 0;
$moduleinfo->usepassword = 0;
$moduleinfo->maxanswers = 4;
$moduleinfo->displayleft = 0;
$moduleinfo->displayleftif = 0;
$moduleinfo->mediafile = 0;

require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$lessonid = $result->id;
echo "Created lesson: cmid={$cmid} lessonid={$lessonid}\n";

// ---------------------------------------------------------------------------
// 2. Tabbed content page.
// ---------------------------------------------------------------------------
$tabhtml = file_get_contents('/tmp/content-01-02-tabbed-instruction.html');
if ($tabhtml === false) {
    fwrite(STDERR, "Could not read /tmp/content-01-02-tabbed-instruction.html\n");
    exit(1);
}
$tabpageid = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Input-Process-Output', $tabhtml, LESSON_PAGE_BRANCHTABLE, 0);

// ---------------------------------------------------------------------------
// 3. Quick Check A (Process) and B (Input) -- new scenarios, not in the tabs.
// ---------------------------------------------------------------------------
$qca_html = '<p>A thermostat checks the room\'s current temperature against the temperature you set, then decides whether to turn the heater on or off. Which stage is "deciding whether to turn the heater on or off"?</p>';
$qcaid = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Quick Check A', $qca_html, LESSON_PAGE_MULTICHOICE, $tabpageid);

$qcb_html = '<p>A smart speaker\'s microphone picking up your voice saying "turn on the lights" is which stage of Input-Process-Output?</p>';
$qcbid = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Quick Check B', $qcb_html, LESSON_PAGE_MULTICHOICE, $qcaid);

// ---------------------------------------------------------------------------
// 4. Vocab Quiz -> Breakdown -> Vocab Retry.
// ---------------------------------------------------------------------------
$vocabquiz_html = '<p>Match each term to its definition.</p>';
$vocabquizid = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Vocab Quiz', $vocabquiz_html, LESSON_PAGE_MATCHING, $qcbid);

$breakdown_html = <<<'HTML'
<h3>Let's Break These Down One at a Time</h3>
<p>All four of these terms describe one pattern: something comes in, something happens with it, something comes back out.</p>
<p><strong>input</strong> is whatever comes into the program from outside -- a typed answer, a button press, a sensor reading.</p>
<p><strong>process</strong> is the actual work: checking, comparing, deciding what to do with that input.</p>
<p><strong>output</strong> is what the program hands back once that work is done.</p>
<p><strong>system</strong> is the whole thing, all three stages together, thought of as one unit.</p>
<p>Take another look, phrased a little differently this time.</p>
HTML;
$breakdownid = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Vocab Breakdown', $breakdown_html, LESSON_PAGE_BRANCHTABLE, $vocabquizid);

$vocabretry_html = '<p>Match each term to its definition. This time the definitions are worded a little differently.</p>';
$vocabretryid = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Vocab Retry', $vocabretry_html, LESSON_PAGE_MATCHING, $breakdownid);

echo "Pages: Tab={$tabpageid} QCA={$qcaid} QCB={$qcbid} VocabQuiz={$vocabquizid} Breakdown={$breakdownid} VocabRetry={$vocabretryid}\n";

// ---------------------------------------------------------------------------
// 5. Answers.
// ---------------------------------------------------------------------------
foxcs_insert_answer($DB, $lessonid, $tabpageid, 'Continue', null, $qcaid, 0);

// --- Quick Check A: correct=Process ---
foxcs_insert_answer($DB, $lessonid, $qcaid,
    "That's the Input stage, not this one.",
    "Look again -- the room's current temperature being checked IS an input, but \"deciding whether to turn the heater on or off\" is a separate step that happens after that input is received.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Process',
    "Right! Checking the temperature against your setting and deciding what to do next is the actual \"thinking\" work happening between what came in and what happens next. That's Process.",
    $qcbid, 1);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    "That's the Output stage, not this one.",
    "The heater actually turning on or off would be the Output. \"Deciding\" is the step that happens right before that, not the result itself.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'System',
    "System describes the whole thermostat as one unit, not a specific step in Input-Process-Output. Think about which of the three actual stages this decision fits into.",
    $qcbid, 0);

// --- Quick Check B: correct=Input ---
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'Input',
    "Right! The microphone picking up your voice is data coming INTO the program from outside itself -- that's Input.",
    $vocabquizid, 1);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    "That's the Process stage, not this one.",
    "The microphone picking up your voice hasn't been acted on yet -- nothing has been decided or worked out. That happens at the next stage, not this one.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    "That's the Output stage, not this one.",
    "Output is what the smart speaker delivers back, like the lights actually turning on. Picking up your voice happens before any of that.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'System',
    "System describes the whole smart speaker as one unit, not a specific step. Think about which of the three actual stages picking up your voice fits into.",
    $vocabquizid, 0);

// --- Vocab Quiz (Matching) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'Nice work, you matched all four correctly.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    "Not quite all four yet. Let's break these down.", null, $breakdownid, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'input', 'Data a program receives from outside itself.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'process', 'The work a program does with input. Calculating, comparing, deciding.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'output', 'What a program delivers back as a result. Text, sound, an image, anything the outside world can perceive.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'system', 'Any program or machine considered as a whole, made of input/process/output working together.', 0, 0);

// --- Vocab Breakdown (Content page) ---
foxcs_insert_answer($DB, $lessonid, $breakdownid, 'Continue', null, $vocabretryid, 0);

// --- Vocab Retry (Matching, rephrased) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'Nice, that matches up.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    "That's okay, here's how they line up.", null, LESSON_EOL, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'input', 'Something the program takes in from outside, like a typed answer or a button press.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'process', 'The actual decision-making or calculating step, using whatever came in.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'output', 'What finally gets shown, played, or delivered back as the result.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'system', 'The complete program or machine, thought of as one whole thing.', 0, 0);

echo "All answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
