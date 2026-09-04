<?php
// build-lesson-01-06-instruction-tabbed.php
//
// Builds 01.6 Common Syntax Mistakes' Instruction as a native tabbed Lesson,
// following the settled 01.4/01.5 pattern exactly: one tabbed Content page (4
// tabs: This Is a Review / The Big Four / How to Debug / Key Terms w/ flip-card
// flashcards, content-01-06-tabbed-instruction.html) -> Quick Check A -> Quick
// Check B -> Vocab Quiz (native Matching, 5 terms, wrong -> Breakdown -> Retry
// with rephrased definitions).
//
// Content ported from the real, already-written prose in
// courses/python/content/unit_01_what_is_programming/lesson_01_06_common_syntax_mistakes/
// 01_instruction.html -- but the two Quick Checks are NEW scenarios, distinct
// from every broken-line example already used anywhere else in this lesson
// (the tabs' Big Four table: Hello missing quote/parens, Print("Hi"), print(Hello);
// the source page's own embedded quick check: print(Score); the Mastery Check
// pool: New Record!/Paused/Continue; the Coding Exercise: Welcome to the arena/
// Choose your character/Good luck out there!/Battle Start).
//
// NOTE: maxanswers is 6 (5 vocab terms + margin), matching 01.4's setting since
// 01.6 also has 5 terms (SyntaxError, NameError, EOL, syntax, parenthesis).
//
// Run: sudo -u www-data php build-lesson-01-06-instruction-tabbed.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_MATCHING = 5;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2; // "Unit 01: What Is Programming?" -- literal section NUMBER create_module() expects, verified 2026-09-03 after a wrong dynamic lookup misplaced 01.5's modules into "Unit 02".

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
$moduleinfo->name = '01.6 Common Syntax Mistakes';
$moduleinfo->introeditor = [
    'text' => '<p>Work through this at your own pace using the Continue button. A couple of quick questions are mixed in along the way, just to check your understanding as you go (they don\'t affect whether you move forward). Everything saves automatically.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->grade = 100;
$moduleinfo->custom = 1;
$moduleinfo->retake = 1;
$moduleinfo->modattempts = 1;
$moduleinfo->review = 0;
$moduleinfo->feedback = 1;
$moduleinfo->practice = 0;
$moduleinfo->usepassword = 0;
$moduleinfo->maxanswers = 6;
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
$tabhtml = file_get_contents('/tmp/content-01-06-tabbed-instruction.html');
if ($tabhtml === false) {
    fwrite(STDERR, "Could not read /tmp/content-01-06-tabbed-instruction.html -- stage it there first.\n");
    exit(1);
}
$tabpageid = foxcs_insert_lesson_page($DB, $lessonid, '01.6 Common Syntax Mistakes', $tabhtml, LESSON_PAGE_BRANCHTABLE, 0);

// ---------------------------------------------------------------------------
// 3. Quick Check A and B -- new scenarios, not in the tabs or source page.
// ---------------------------------------------------------------------------
$qca_html = '<p>What error does this line raise?</p><pre>print(Victory)</pre>';
$qcaid = foxcs_insert_lesson_page($DB, $lessonid, '01.6 Quick Check A', $qca_html, LESSON_PAGE_MULTICHOICE, $tabpageid);

$qcb_html = '<p>What error does this line raise?</p><pre>print "Level Up"</pre>';
$qcbid = foxcs_insert_lesson_page($DB, $lessonid, '01.6 Quick Check B', $qcb_html, LESSON_PAGE_MULTICHOICE, $qcaid);

// ---------------------------------------------------------------------------
// 4. Vocab Quiz -> Breakdown -> Vocab Retry.
// ---------------------------------------------------------------------------
$vocabquiz_html = '<p>Match each term to its definition.</p>';
$vocabquizid = foxcs_insert_lesson_page($DB, $lessonid, '01.6 Vocab Quiz', $vocabquiz_html, LESSON_PAGE_MATCHING, $qcbid);

$breakdown_html = <<<'HTML'
<h3>Let's Break These Down One at a Time</h3>
<p>All five of these terms show up when Python has a problem with your code, but not always the same kind of problem.</p>
<p><strong>SyntaxError</strong> means Python couldn't even parse the grammar of the line, like a missing quote or parenthesis.</p>
<p><strong>NameError</strong> means the grammar was fine, but Python looked for something by an exact name and didn't find it.</p>
<p><strong>EOL</strong> stands for "End Of Line" -- it shows up inside a SyntaxError message when Python runs out of line before finding what it expected, often a missing closing quote.</p>
<p><strong>syntax</strong> is the general term for a language's grammar rules.</p>
<p><strong>parenthesis</strong> is the ( or ) symbol print() and every other function call needs.</p>
<p>Take another look, phrased a little differently this time.</p>
HTML;
$breakdownid = foxcs_insert_lesson_page($DB, $lessonid, '01.6 Vocab Breakdown', $breakdown_html, LESSON_PAGE_BRANCHTABLE, $vocabquizid);

$vocabretry_html = '<p>Match each term to its definition. This time the definitions are worded a little differently.</p>';
$vocabretryid = foxcs_insert_lesson_page($DB, $lessonid, '01.6 Vocab Retry', $vocabretry_html, LESSON_PAGE_MATCHING, $breakdownid);

echo "Pages: Tab={$tabpageid} QCA={$qcaid} QCB={$qcbid} VocabQuiz={$vocabquizid} Breakdown={$breakdownid} VocabRetry={$vocabretryid}\n";

// ---------------------------------------------------------------------------
// 5. Answers.
// ---------------------------------------------------------------------------
foxcs_insert_answer($DB, $lessonid, $tabpageid, 'Continue', null, $qcaid, 0);

// --- Quick Check A: correct = NameError (missing quotes) ---
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'NameError',
    "Right! Victory has no quotes around it, so Python treats it as a variable name, looks for one called Victory, and doesn't find it.",
    $qcbid, 1);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'SyntaxError',
    "The grammar of this line is actually fine: print, matching parentheses, one thing inside. The problem is what's inside, not the structure.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'No error, this line is correct',
    "This line would actually raise an error when run. Look at what's inside the parentheses.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'IndentationError',
    "Nothing here involves spacing or indentation. Look at whether Victory is wrapped in quotes.",
    $qcbid, 0);

// --- Quick Check B: correct = SyntaxError (missing parentheses) ---
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'SyntaxError',
    "Right! Python 3 requires parentheses around every function call's arguments. Without them, Python can't parse the line's grammar at all.",
    $vocabquizid, 1);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'NameError',
    "A NameError happens when the grammar is fine but a name can't be found. Here, the grammar itself is broken. Count the parentheses.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'No error, this line is correct',
    "This line would actually raise an error when run. Compare it against the required print() structure: print, then (), then the string.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'EOL error only',
    "EOL errors come from an unclosed quote reaching the end of the line. This line's quotes are matched. The missing piece is the parentheses.",
    $vocabquizid, 0);

// --- Vocab Quiz (Matching) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'Nice work, you matched all five correctly.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    "Not quite all five yet. Let's break these down.", null, $breakdownid, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'SyntaxError', 'An error Python raises when code breaks its grammar rules.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'NameError', 'An error Python raises when it looks for something by an exact name and can\'t find it.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'EOL', '"End Of Line". Appears in error messages when Python reaches the end of a line unexpectedly, often from a missing closing quote.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'syntax', 'The grammar rules for writing valid code.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'parenthesis', 'The ( or ) symbol used to call a function in Python.', 0, 0);

// --- Vocab Breakdown (Content page) ---
foxcs_insert_answer($DB, $lessonid, $breakdownid, 'Continue', null, $vocabretryid, 0);

// --- Vocab Retry (Matching, rephrased) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'Nice, that matches up.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    "That's okay, here's how they line up.", null, LESSON_EOL, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'SyntaxError', 'Python\'s way of saying a line doesn\'t follow its grammar rules and can\'t even start running.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'NameError', 'Python understood the grammar just fine, but couldn\'t find whatever it was looking for by that exact name.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'EOL', 'What Python hit when it ran out of characters on a line before a string or statement was properly closed.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'syntax', 'The set of rules that decide whether a line of code is even structured correctly.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'parenthesis', 'One of the two matching marks, ( and ), that wrap what you\'re handing into a function call.', 0, 0);

echo "All answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
