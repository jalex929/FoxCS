<?php
// build-lesson-01-03-practice-ladder.php
//
// 01.3 Practice: Core/Reinforce/Extend ladder, same proven native-Lesson pattern as
// 01.1/01.2. Two real, decomposable misconceptions targeted:
//   Core/Reinforce: "writing or saving code isn't the same as running it" -- a very
//   common first-day confusion (typing/saving feels like it should "do" something).
//   Extend: "a program with valid syntax but the wrong order still runs (just wrong),
//   while a real syntax error stops it from running at all" -- the deeper distinction
//   between a logic mistake and a syntax mistake, which 01.6 will build on later.
//
// Run: sudo -u www-data php build-lesson-01-03-practice-ladder.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2;

// ---------------------------------------------------------------------------
// 1. Create the lesson activity.
// ---------------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'lesson';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'lesson']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.3 Practice';
$moduleinfo->introeditor = [
    'text' => '<p>A few quick questions about what you just learned in 01.3. The questions '
        . 'adjust to how you\'re doing: if something\'s tricky, you\'ll get a smaller step to '
        . 'work through before moving on, and if you\'ve got it, you\'ll get a chance to '
        . 'stretch further.</p><p>Everything you answer here is saved automatically as you '
        . 'go. You can come back to this activity afterward to review what you answered.</p>',
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

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$lessonid = $result->id;
echo "Created lesson activity: cmid={$cmid} lessonid={$lessonid}\n";

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

$codeblock1 = '<div style="background:#1e1e1e;color:#d4d4d4;font-family:Consolas,Monaco,monospace;padding:0.8rem 1rem;border-radius:8px;margin:0.6rem 0;">print("Score: 100")</div>';

$core_html = <<<HTML
<p>A student types this into their file and saves it:</p>
{$codeblock1}
<p>Nothing appears anywhere on the screen. What's the most likely reason?</p>
HTML;

$reinforce1_html = <<<'HTML'
<p><strong>True or False:</strong></p>
<p>Just opening a Python file and looking at the code counts as running it.</p>
HTML;

$reinforce2_html = <<<'HTML'
<p>Which of these actually makes a computer carry out your code?</p>
HTML;

$reteach_html = <<<'HTML'
<h3>Quick Recap: Writing Isn't Running</h3>
<p>Typing code and saving your file are both real, necessary steps, but neither one actually makes anything happen. The computer doesn't carry out a single line until you tell it to <strong>run</strong> the file.</p>
<p>Think of it like writing a recipe on a piece of paper. Writing it down, even saving it in a folder, doesn't cook anything. Someone has to actually follow the steps for the recipe to do anything.</p>
<p>This is one of the most common first-week mix-ups in programming, and it's completely normal to need a second look at it. Check in with your teacher so you can talk through an example together.</p>
HTML;

$extend1_html = <<<'HTML'
<p>A program is supposed to greet, then ask a question:</p>
<div style="background:#1e1e1e;color:#d4d4d4;font-family:Consolas,Monaco,monospace;padding:0.8rem 1rem;border-radius:8px;margin:0.6rem 0;">print("Hi there!")<br>print("What's your favorite game?")</div>
<p>A student accidentally reverses the two lines. When they run it, no error shows up at all. What's actually different about the result?</p>
HTML;

$extend2_html = <<<'HTML'
<p>A student's program has a real typo:</p>
<div style="background:#1e1e1e;color:#d4d4d4;font-family:Consolas,Monaco,monospace;padding:0.8rem 1rem;border-radius:8px;margin:0.6rem 0;">pint("Hello!")</div>
<p>Will this program still run, just with unexpected output, or will it fail to run at all? Why?</p>
HTML;

$coreid       = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Core',        $core_html,       LESSON_PAGE_MULTICHOICE, 0);
$reinforce1id = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Reinforce 1', $reinforce1_html, LESSON_PAGE_MULTICHOICE, $coreid);
$reinforce2id = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Reinforce 2', $reinforce2_html, LESSON_PAGE_MULTICHOICE, $reinforce1id);
$reteachid    = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Reteach',     $reteach_html,    LESSON_PAGE_BRANCHTABLE, $reinforce2id);
$extend1id    = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Extend 1',    $extend1_html,    LESSON_PAGE_MULTICHOICE, $reteachid);
$extend2id    = foxcs_insert_lesson_page($DB, $lessonid, '01.3 Extend 2',    $extend2_html,    LESSON_PAGE_MULTICHOICE, $extend1id);

echo "Pages: Core={$coreid} Reinforce1={$reinforce1id} Reinforce2={$reinforce2id} Reteach={$reteachid} Extend1={$extend1id} Extend2={$extend2id}\n";

// ---------------------------------------------------------------------------
// 3. Answers.
// ---------------------------------------------------------------------------
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

// --- Core ---
foxcs_insert_answer($DB, $lessonid, $coreid,
    "They haven't run the file yet",
    "That's right. Typing code and saving it are real steps, but neither one makes the computer actually carry anything out. Nothing happens until you click Run.",
    $extend1id, 1);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'There must be a typo in the code',
    "<p><strong>What happened:</strong> this assumes something's wrong with the code itself.</p><p><strong>Why:</strong> the line shown is perfectly valid Python. The missing step isn't in the code, it's in what the student did (or didn't do) after writing it.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);
foxcs_insert_answer($DB, $lessonid, $coreid,
    "print() doesn't actually work",
    "<p><strong>What happened:</strong> this doubts print() itself.</p><p><strong>Why:</strong> print() is a real, working statement. The issue isn't the command, it's whether the file was actually run.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'The file needs a special name to work',
    "<p><strong>What happened:</strong> this points to the filename as the problem.</p><p><strong>Why:</strong> as long as the file ends in <code>.py</code>, the name itself isn't the issue here.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);

// --- Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    "False. Opening or looking at a file doesn't run it, only actually running it does.",
    "That's right. Looking at code, even reading it carefully, doesn't make the computer do anything. Only actually running the file does.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'True. If the code is open and visible, it counts as running.',
    "<p><strong>What happened:</strong> this treats \"open\" and \"running\" as the same thing.</p><p><strong>Why:</strong> a file can be sitting open on your screen all day without a single line ever being carried out. Running is a separate, deliberate step.</p><p><strong>Next step:</strong> one more look at this idea, in an even smaller example.</p>",
    $reinforce2id, 0);

// --- Reinforce 2 ---
foxcs_insert_answer($DB, $lessonid, $reinforce2id,
    'Clicking Run',
    "That's right. Saving stores your code. Clicking Run is what actually makes the computer carry it out.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $reinforce2id,
    'Saving the file',
    "<p><strong>What happened:</strong> this says saving is what makes code execute.</p><p><strong>Why:</strong> saving just stores your work so it isn't lost. It's Run, specifically, that tells the computer to carry out the code.</p><p><strong>Next step:</strong> check in with your teacher so you can talk through an example together.</p>",
    $reteachid, 0);

// --- Reteach (Content page) ---
foxcs_insert_answer($DB, $lessonid, $reteachid, 'Continue', null, LESSON_EOL, 0);

// --- Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'The output shows the question before the greeting, but no error occurs, since both lines are still valid code',
    "Exactly. Reordering two valid statements doesn't break anything, Python still runs both lines without complaint. It just changes what happens, and when. Wrong order and broken code are two very different problems.",
    $extend2id, 1);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    "The program won't run at all, since the lines are out of order",
    'Both lines are still valid Python on their own, reordering them doesn\'t create an error. Look again at what actually changes here: is it whether the program runs, or what it does when it runs?',
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'Nothing changes, the greeting and question still print in the original order',
    'Python runs statements in the order they\'re written, not the order they were "supposed" to be in. If the lines were swapped, the output order swaps too.',
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'An error message appears explaining the lines are reversed',
    "Python has no way of knowing what order you \"meant\" the lines to be in, it just runs whatever's actually written, top to bottom. Reordering valid statements doesn't trigger an error.",
    LESSON_EOL, 0);

// --- Extend 2 ---
foxcs_insert_answer($DB, $lessonid, $extend2id,
    "It will fail to run at all, since \"pint\" isn't a real Python command",
    'Right. This is different from the reordering example. Reordering valid lines still runs, just differently. A typo like "pint" isn\'t valid Python at all, so the program can\'t run, not even the parts that would\'ve been correct.',
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $extend2id,
    'It will still run, just without printing anything',
    'A typo like this isn\'t just "printing nothing," it\'s not valid Python at all. Since Python doesn\'t recognize "pint" as a real command, it can\'t run the program, the same way reordering example from before still ran (because those lines WERE valid).',
    LESSON_EOL, 0);

echo "Answers inserted for all 6 pages.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
