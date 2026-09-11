<?php
// build-lesson-01-03-instruction-tabbed.php
//
// 01.3 Writing Your First Program -- Instruction. Same proven native-Lesson tabbed
// pattern as 01.1/01.2: one tabbed Content page -> 2 Quick Checks (new scenarios,
// never verbatim from the tab content) -> a native Matching Vocab Quiz with real
// branching (wrong -> Breakdown reteach -> Retry Matching using rephrased, not
// verbatim-repeated, definitions).
//
// Run: sudo -u www-data php build-lesson-01-03-instruction-tabbed.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_MATCHING = 5;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2;

$tabhtml = file_get_contents('/tmp/content-01-03-tabbed-instruction.html');
if ($tabhtml === false) {
    fwrite(STDERR, "Could not read content-01-03-tabbed-instruction.html from /tmp\n");
    exit(1);
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
$moduleinfo->name = '01.3 Writing Your First Program';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->grade = 5; // Instruction, per grade-point-scale.md
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

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$lessonid = $result->id;
echo "Created lesson: cmid={$cmid} lessonid={$lessonid}\n";

// ---------------------------------------------------------------------------
// 2. Pages.
// ---------------------------------------------------------------------------
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

$tabpageid = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Writing Your First Program', $tabhtml, LESSON_PAGE_BRANCHTABLE, 0);

$qcahtml = <<<'HTML'
<p>A program has three lines:</p>
<div style="background:#1e1e1e;color:#d4d4d4;font-family:Consolas,Monaco,monospace;padding:0.8rem 1rem;border-radius:8px;margin:0.6rem 0;">print("Step 1")<br>print("Step 2")<br>print("Step 3")</div>
<p>A programmer accidentally swaps lines 2 and 3. What changes about what happens when the program runs?</p>
HTML;
$qcaid = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Quick Check A', $qcahtml, LESSON_PAGE_MULTICHOICE, $tabpageid);

$qcbhtml = <<<'HTML'
<p>A new student writes exactly one line in a file and saves it:</p>
<div style="background:#1e1e1e;color:#d4d4d4;font-family:Consolas,Monaco,monospace;padding:0.8rem 1rem;border-radius:8px;margin:0.6rem 0;">print("Ready to code!")</div>
<p>Their friend says, "That's not a real program, it's just one line." Are they right?</p>
HTML;
$qcbid = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Quick Check B', $qcbhtml, LESSON_PAGE_MULTICHOICE, $qcaid);

$vocabintro = '<p>Match each term to its definition.</p>';
$vocabquizid = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Vocab Quiz', $vocabintro, LESSON_PAGE_MATCHING, $qcbid);

$breakdownhtml = <<<'HTML'
<h3>Let's Break These Down</h3>
<p><strong>Program</strong> is the whole file: a saved set of statements a computer can run from top to bottom.</p>
<p><strong>Statement</strong> is one single instruction inside that file. A program is usually made of many statements.</p>
<p><strong>Run / execute</strong> means actually carrying out those statements, not just writing or looking at them.</p>
<p><strong>Syntax</strong> is the exact spelling and structure the language requires. A program with broken syntax won't run at all, no matter how good the idea behind it is.</p>
<p>Try the matching again with these terms rephrased a little differently.</p>
HTML;
$breakdownid = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Vocab Breakdown', $breakdownhtml, LESSON_PAGE_BRANCHTABLE, $vocabquizid);

$vocabretryintro = '<p>Match each term to its definition.</p>';
$vocabretryid = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Vocab Retry', $vocabretryintro, LESSON_PAGE_MATCHING, $breakdownid);

echo "Pages: Tab={$tabpageid} QCA={$qcaid} QCB={$qcbid} VocabQuiz={$vocabquizid} Breakdown={$breakdownid} VocabRetry={$vocabretryid}\n";

// ---------------------------------------------------------------------------
// 3. Answers.
// ---------------------------------------------------------------------------

// --- Quick Check A ---
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'The order the messages appear on screen changes',
    "That's right. Python runs statements in the exact order they're written. Swap two lines and the output order swaps too, that's the whole point of \"order matters.\"",
    $qcbid, 1);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Nothing changes',
    "<p><strong>What happened:</strong> this treats the three lines as interchangeable.</p><p><strong>Why:</strong> Python runs top to bottom, in the exact order written. Swapping two print statements swaps the order they appear.</p><p><strong>Next step:</strong> read the next question carefully, it revisits this same idea.</p>",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    "The program won't run at all",
    "<p><strong>What happened:</strong> this assumes reordering valid statements breaks the program.</p><p><strong>Why:</strong> each line is still a valid, complete statement. Reordering them doesn't cause an error, it just changes what happens when.</p><p><strong>Next step:</strong> read the next question carefully, it revisits this same idea.</p>",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Only "Step 1" will print',
    "<p><strong>What happened:</strong> this assumes the swap somehow blocks the later lines from running.</p><p><strong>Why:</strong> all three statements still run, in order, they've just been reordered, not removed.</p><p><strong>Next step:</strong> read the next question carefully, it revisits this same idea.</p>",
    $qcbid, 0);

// --- Quick Check B ---
foxcs_insert_answer($DB, $lessonid, $qcbid,
    "No, even one real statement, saved and run, is a complete program",
    "That's right. A program isn't defined by length, it's defined by being a real, saved, runnable set of statements. One line can absolutely be a complete program.",
    $vocabquizid, 1);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'Yes, a program needs many lines to count',
    "<p><strong>What happened:</strong> this ties \"program\" to length instead of to what it actually is.</p><p><strong>Why:</strong> a program is any saved, runnable set of statements, even just one. The Hello World example from this lesson was exactly one line.</p><p><strong>Next step:</strong> a couple of matching questions on these same terms.</p>",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    "No, because print() doesn't count as code",
    "<p><strong>What happened:</strong> this treats print() as somehow not \"real\" code.</p><p><strong>Why:</strong> print() is a real Python statement, just like any other. It counts.</p><p><strong>Next step:</strong> a couple of matching questions on these same terms.</p>",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'Yes, because nothing will happen when it runs',
    "<p><strong>What happened:</strong> this assumes the line won't actually do anything.</p><p><strong>Why:</strong> running that line does something very real, it prints \"Ready to code!\" to the screen.</p><p><strong>Next step:</strong> a couple of matching questions on these same terms.</p>",
    $vocabquizid, 0);

// --- Vocab Quiz (Matching): rows 0/1 are correct/wrong feedback+jumpto, rest are pairs ---
foxcs_insert_answer($DB, $lessonid, $vocabquizid, "Nice work, you matched all four correctly.", null, LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $vocabquizid, "Not quite, let's break these down.", null, $breakdownid, 0);
foxcs_insert_answer($DB, $lessonid, $vocabquizid, 'program', 'A saved, real file containing statements a computer can run, in order, from top to bottom', 0, 0);
foxcs_insert_answer($DB, $lessonid, $vocabquizid, 'statement', "One complete instruction inside a program", 0, 0);
foxcs_insert_answer($DB, $lessonid, $vocabquizid, 'run / execute', 'To actually carry out a program\'s statements, not just write or read them', 0, 0);
foxcs_insert_answer($DB, $lessonid, $vocabquizid, 'syntax', "The exact spelling and structure a language requires to run at all", 0, 0);

// --- Vocab Retry (Matching, rephrased) ---
foxcs_insert_answer($DB, $lessonid, $vocabretryid, "Nice work, that's all four correct.", null, LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $vocabretryid, "Still not quite. Check in with your teacher on these terms.", null, LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $vocabretryid, 'program', 'The whole saved file of code, start to finish', 0, 0);
foxcs_insert_answer($DB, $lessonid, $vocabretryid, 'statement', 'A single line of real, working instruction', 0, 0);
foxcs_insert_answer($DB, $lessonid, $vocabretryid, 'run / execute', "Actually making the computer carry out the code, not just viewing it", 0, 0);
foxcs_insert_answer($DB, $lessonid, $vocabretryid, 'syntax', 'The precise rules for how the code has to be written to work at all', 0, 0);

echo "Answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
