<?php
// build-lesson-01-05-instruction-tabbed.php
//
// Builds 01.5 Comments and Documentation's Instruction as a native tabbed Lesson,
// following the settled 01.4 pattern exactly: one tabbed Content page (4 tabs:
// What's a Comment? / Weak vs. Strong / Commenting Out / Key Terms w/ flip-card
// flashcards, content-01-05-tabbed-instruction.html) -> Quick Check A -> Quick
// Check B -> Vocab Quiz (native Matching, 3 terms, wrong -> Breakdown -> Retry
// with rephrased definitions).
//
// Content ported from the real, already-written prose in
// courses/python/content/unit_01_what_is_programming/lesson_01_05_comments_and_documentation/
// 01_instruction.html -- but the two Quick Checks are NEW scenarios, not restatements
// of the two quick-checks already embedded in that source page (predicting output
// of "# Show the score" -> Score: 0, and "why doesn't Press start ever display").
// Quick Check A uses a two-comment/two-print variant; Quick Check B asks students
// to identify WHICH line in a snippet is commented out, not just why it doesn't run.
//
// SETTING NOTE: 01.5 has only 3 vocab terms (comment, documentation, commenting
// out), not 5 like 01.4 -- maxanswers is 4 (3 terms + margin), not 6.
//
// Run: sudo -u www-data php build-lesson-01-05-instruction-tabbed.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_MATCHING = 5;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = $DB->get_field('course_modules', 'section', ['id' => 212]); // 01.4 Printing Output's live section, verified against the DB rather than hardcoded.

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
$moduleinfo->name = '01.5 Comments and Documentation';
$moduleinfo->introeditor = [
    'text' => '<p>Work through this at your own pace using the Continue button. A couple of quick questions are mixed in along the way, just to check your understanding as you go (they don\'t affect whether you move forward). Everything saves automatically.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->grade = 100;
$moduleinfo->custom = 1;
$moduleinfo->retake = 1; // unlimited attempts, per Jay's 2026-09-03 standing instruction (see decisions-log.md).
$moduleinfo->modattempts = 1;
$moduleinfo->review = 0;
$moduleinfo->feedback = 1;
$moduleinfo->practice = 0;
$moduleinfo->usepassword = 0;
$moduleinfo->maxanswers = 4; // 3 vocab terms + margin
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
$tabhtml = file_get_contents('/tmp/content-01-05-tabbed-instruction.html');
if ($tabhtml === false) {
    fwrite(STDERR, "Could not read /tmp/content-01-05-tabbed-instruction.html -- stage it there first (www-data can't traverse /home/jay).\n");
    exit(1);
}
$tabpageid = foxcs_insert_lesson_page($DB, $lessonid, '01.5 Comments and Documentation', $tabhtml, LESSON_PAGE_BRANCHTABLE, 0);

// ---------------------------------------------------------------------------
// 3. Quick Check A (two comments/two prints) and B (identify the commented line)
//    -- new scenarios, not in the tabs.
// ---------------------------------------------------------------------------
$qca_html = '<p>What does this program display?</p><pre># Show player name
print("Hero")
# print("Villain")
print("Ready")</pre>';
$qcaid = foxcs_insert_lesson_page($DB, $lessonid, '01.5 Quick Check A', $qca_html, LESSON_PAGE_MULTICHOICE, $tabpageid);

$qcb_html = '<p>Which line in this snippet is commented out, so it will NOT run?</p><pre>print("Start")
# print("Debug: score=100")
print("Go")</pre>';
$qcbid = foxcs_insert_lesson_page($DB, $lessonid, '01.5 Quick Check B', $qcb_html, LESSON_PAGE_MULTICHOICE, $qcaid);

// ---------------------------------------------------------------------------
// 4. Vocab Quiz -> Breakdown -> Vocab Retry.
// ---------------------------------------------------------------------------
$vocabquiz_html = '<p>Match each term to its definition.</p>';
$vocabquizid = foxcs_insert_lesson_page($DB, $lessonid, '01.5 Vocab Quiz', $vocabquiz_html, LESSON_PAGE_MATCHING, $qcbid);

$breakdown_html = <<<'HTML'
<h3>Let's Break These Down One at a Time</h3>
<p>All three of these terms describe how programmers leave notes for other humans, not for Python.</p>
<p><strong>comment</strong> is a single line (or part of a line) starting with # that Python skips entirely when running the program.</p>
<p><strong>documentation</strong> is the bigger idea: any written explanation of what code does and why. Comments are the simplest form documentation can take.</p>
<p><strong>commenting out</strong> is a specific use of comments: putting a # in front of real, working code to temporarily disable it without deleting it.</p>
<p>Take another look, phrased a little differently this time.</p>
HTML;
$breakdownid = foxcs_insert_lesson_page($DB, $lessonid, '01.5 Vocab Breakdown', $breakdown_html, LESSON_PAGE_BRANCHTABLE, $vocabquizid);

$vocabretry_html = '<p>Match each term to its definition. This time the definitions are worded a little differently.</p>';
$vocabretryid = foxcs_insert_lesson_page($DB, $lessonid, '01.5 Vocab Retry', $vocabretry_html, LESSON_PAGE_MATCHING, $breakdownid);

echo "Pages: Tab={$tabpageid} QCA={$qcaid} QCB={$qcbid} VocabQuiz={$vocabquizid} Breakdown={$breakdownid} VocabRetry={$vocabretryid}\n";

// ---------------------------------------------------------------------------
// 5. Answers.
// ---------------------------------------------------------------------------
foxcs_insert_answer($DB, $lessonid, $tabpageid, 'Continue', null, $qcaid, 0);

// --- Quick Check A: correct = "Hero" then "Ready" ---
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Hero, then on the next line, Ready',
    "Right! The commented-out print(\"Villain\") never runs. Python skips straight from the first print() to the second.",
    $qcbid, 1);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Hero, then Villain, then Ready',
    "Look again at the line print(\"Villain\") is on -- it starts with a #, which means Python skips it entirely. It never runs.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Show player name, Hero, Ready',
    "The comment text itself (\"Show player name\") never displays. Comments produce no output at all, not even their own words.",
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'Nothing displays',
    "Two real print() statements are still here and will run. Only the commented-out line is skipped.",
    $qcbid, 0);

// --- Quick Check B: correct = the middle line ---
foxcs_insert_answer($DB, $lessonid, $qcbid,
    '# print("Debug: score=100")',
    "Right! The # at the start of that line turns the whole thing into a comment, so Python skips it. The other two lines are real print() statements and both run.",
    $vocabquizid, 1);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'print("Start")',
    "This line has no # in front of it, so it's real code, not a comment. It runs normally.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'print("Go")',
    "This line has no # in front of it either. Look for the one line that starts with #.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'None of these lines are commented out',
    "One of them is -- look for the line that starts with a # character.",
    $vocabquizid, 0);

// --- Vocab Quiz (Matching) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'Nice work, you matched all three correctly.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    "Not quite all three yet. Let's break these down.", null, $breakdownid, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'comment', 'A line (or part of a line) starting with # that Python ignores when running the program.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'documentation', 'Written explanation of what code does and why. Comments are the simplest form of it.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'commenting out', 'Disabling a line of real code temporarily by putting a # in front of it, without deleting it.', 0, 0);

// --- Vocab Breakdown (Content page) ---
foxcs_insert_answer($DB, $lessonid, $breakdownid, 'Continue', null, $vocabretryid, 0);

// --- Vocab Retry (Matching, rephrased) ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'Nice, that matches up.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    "That's okay, here's how they line up.", null, LESSON_EOL, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'comment', 'A note in the code, marked with #, meant for a human reader, that Python never actually runs.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'documentation', 'Any writing, comments included, that explains a program\'s purpose or reasoning to someone reading it later.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'commenting out', 'Using # to switch a working line of code off temporarily, while keeping it in the file for later.', 0, 0);

echo "All answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
