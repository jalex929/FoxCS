<?php
// build-lesson-01-04-instruction-tabbed.php
//
// Builds 01.4 Printing Output's Instruction as a native tabbed Lesson, following
// the settled 01.1/01.2 pattern directly: one tabbed Content page (4 tabs: print()
// Basics / Two Common Mistakes / Game Connection / Key Terms w/ flip-card
// flashcards, content-01-04-tabbed-instruction.html) -> Quick Check A -> Quick
// Check B -> Vocab Quiz (native Matching, 5 terms, wrong -> Breakdown -> Retry
// with rephrased definitions).
//
// Content ported from the real, already-written prose in
// courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/
// 01_instruction.html -- but the two Quick Checks are NOT restatements of the two
// worked "Common Mistakes" examples already shown verbatim in the tabs (missing
// closing quote on `print("Hello, Python!)`, missing parens on `print "Hello"`).
// Same rule 01.2's build applied: don't ask what's already been answered. Quick
// Check A uses a missing-OPENING-quote variant (`print(Level up!")`), Quick Check
// B uses a missing-CLOSING-paren-only variant (`print("Score: 100"`) -- both test
// the same underlying rules but require actually parsing new code, not recalling
// a labeled example.
//
// IMPORTANT SETTING DIFFERENCE FROM THE 01.2 SCRIPT THIS WAS COPIED FROM:
// 01.4's vocab quiz has 5 terms, not 4 -- $moduleinfo->maxanswers is set to 6
// (5 terms + 1 margin) below. Copying 01.2's script as a future template again
// and forgetting to bump this is an easy, real mistake -- Moodle's Matching
// question type caps at maxanswers rows.
//
// Run: sudo -u www-data php build-lesson-01-04-instruction-tabbed.php

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
$moduleinfo->name = '01.4 Printing Output';
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
$moduleinfo->maxanswers = 6; // 5 vocab terms + margin -- see header note, NOT 4 like 01.2's script
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
$tabhtml = file_get_contents('/tmp/content-01-04-tabbed-instruction.html');
if ($tabhtml === false) {
    fwrite(STDERR, "Could not read /tmp/content-01-04-tabbed-instruction.html -- stage it there first (www-data can't traverse /home/jay).\n");
    exit(1);
}
$tabpageid = foxcs_insert_lesson_page($DB, $lessonid, '01.4 Printing Output', $tabhtml, LESSON_PAGE_BRANCHTABLE, 0);

// ---------------------------------------------------------------------------
// 3. Quick Check A (missing opening quote) and B (missing closing paren only)
//    -- new scenarios, not in the tabs.
// ---------------------------------------------------------------------------
$qca_html = '<p>What\'s wrong with this line?</p><pre>print(Level up!")</pre>';
$qcaid = foxcs_insert_lesson_page($DB, $lessonid, '01.4 Quick Check A', $qca_html, LESSON_PAGE_MULTICHOICE, $tabpageid);

$qcb_html = '<p>What\'s wrong with this line?</p><pre>print("Score: 100"</pre>';
$qcbid = foxcs_insert_lesson_page($DB, $lessonid, '01.4 Quick Check B', $qcb_html, LESSON_PAGE_MULTICHOICE, $qcaid);

// ---------------------------------------------------------------------------
// 4. Vocab Quiz -> Breakdown -> Vocab Retry.
// ---------------------------------------------------------------------------
$vocabquiz_html = '<p>Match each term to its definition.</p>';
$vocabquizid = foxcs_insert_lesson_page($DB, $lessonid, '01.4 Vocab Quiz', $vocabquiz_html, LESSON_PAGE_MATCHING, $qcbid);

$breakdown_html = <<<'HTML'
<h3>Let's Break These Down One at a Time</h3>
<p>All five of these terms describe the pieces of a print() statement and what goes wrong when one is missing.</p>
<p><strong>function</strong> is a named, reusable block of code that performs a specific task -- print() is one Python already gives you.</p>
<p><strong>string</strong> is text wrapped in quote marks -- the thing print() actually displays.</p>
<p><strong>output</strong> is what your program shows on the screen once print() runs.</p>
<p><strong>argument</strong> is the specific value you hand to a function -- the string inside print()'s parentheses.</p>
<p><strong>SyntaxError</strong> is what Python raises when a grammar rule is broken, like a missing quote or parenthesis.</p>
<p>Take another look, phrased a little differently this time.</p>
HTML;
$breakdownid = foxcs_insert_lesson_page($DB, $lessonid, '01.4 Vocab Breakdown', $breakdown_html, LESSON_PAGE_BRANCHTABLE, $vocabquizid);

$vocabretry_html = '<p>Match each term to its definition. This time the definitions are worded a little differently.</p>';
$vocabretryid = foxcs_insert_lesson_page($DB, $lessonid, '01.4 Vocab Retry', $vocabretry_html, LESSON_PAGE_MATCHING, $breakdownid);

echo "Pages: Tab={$tabpageid} QCA={$qcaid} QCB={$qcbid} VocabQuiz={$vocabquizid} Breakdown={$breakdownid} VocabRetry={$vocabretryid}\n";

// ---------------------------------------------------------------------------
// 5. Answers.
// ---------------------------------------------------------------------------
foxcs_insert_answer($DB, $lessonid, $tabpageid, 'Continue', null, $qcaid, 0);

// --- Quick Check A: correct = missing opening quote ---
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Missing the opening quote',
    "Right! Level up! has a closing quote right before the parenthesis, but nothing opens the string before it -- Python has no way to tell where the text is supposed to start.",
    $qcbid, 1);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Missing the closing quote',
    "Look again -- there IS a quote right before the closing parenthesis. The problem is at the other end of the string, not this one.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Missing the parentheses',
    "Both parentheses are actually there. Check the quote marks instead.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Nothing is wrong with this line',
    "This line would actually raise a SyntaxError if you ran it. Look closely at where the quote marks are.",
    $qcbid, 0);

// --- Quick Check B: correct = missing closing parenthesis only ---
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'Missing the closing parenthesis',
    "Right! The string \"Score: 100\" is correctly opened and closed with quotes, but the opening ( is never matched with a closing ) -- Python is still waiting for the function call to end.",
    $vocabquizid, 1);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'Missing a quote mark',
    "Look again at the quotes -- \"Score: 100\" opens and closes correctly. The issue is with the parentheses instead.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'The word print is misspelled',
    "print is spelled correctly here. Count the parentheses instead.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'Nothing is wrong with this line',
    "This line would actually raise a SyntaxError if you ran it -- Python would still be waiting for something when the line ends. Count the opening and closing parentheses.",
    $vocabquizid, 0);

// --- Vocab Quiz (Matching) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'Nice work, you matched all five correctly.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    "Not quite all five yet. Let's break these down.", null, $breakdownid, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'function', 'A named, reusable block of code that performs a specific task. print() is a built-in function.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'string', 'Text data surrounded by quote marks: \'Hello\' or "World".', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'output', 'Text or data that your program displays to the screen.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'argument', 'The value you pass into a function. In print("Hello"), "Hello" is the argument.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'SyntaxError', 'An error Python raises when your code breaks a grammar rule, like a missing quote or parenthesis.', 0, 0);

// --- Vocab Breakdown (Content page) ---
foxcs_insert_answer($DB, $lessonid, $breakdownid, 'Continue', null, $vocabretryid, 0);

// --- Vocab Retry (Matching, rephrased) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'Nice, that matches up.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    "That's okay, here's how they line up.", null, LESSON_EOL, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'function', 'Something you can call by name to run a specific, ready-made task -- print() is one you get for free.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'string', 'Any text a program treats as literal characters, not code, because it\'s wrapped in matching quotes.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'output', 'Whatever a program actually shows you once it finishes running a step.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'argument', 'The specific piece of information you hand over inside a function\'s parentheses.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'SyntaxError', 'Python\'s way of saying a line doesn\'t follow its grammar rules and can\'t even start running.', 0, 0);

echo "All answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
