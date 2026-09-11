<?php
// build-lesson-01-04-practice-ladder.php
//
// Builds Lesson 01.4's (Printing Output) Reinforce/Core/Extend Practice ladder as
// a native Moodle Lesson activity, following build-lesson-01-01-practice-ladder.php's
// exact mechanism/settings. THREE skill clusters, one per real stated objective in
// courses/python/content/.../lesson_01_04_printing_output/01_instruction.html
// (verified against that file directly, not invented):
//   1. "I can write a correct print() statement and predict what it will display."
//      -> cluster 01.4a: predicts_print_output
//   2. "I can identify and fix a missing quote or missing parenthesis error."
//      -> cluster 01.4b: diagnoses_print_syntax_errors
//   3. Language objective: "I can describe the parts of a print() statement using
//      the terms function, string, and argument."
//      -> cluster 01.4c: identifies_print_statement_parts
//
// Every broken-print-statement example across all three clusters is deliberately
// distinct from every other one already used in this lesson (content-authoring-
// standards.md: "a few real variants, not one question repeated"):
//   - Instruction tabs:        missing closing quote, missing parens entirely
//   - Instruction Quick Checks: missing opening quote, missing closing paren only
//   - Mastery Check:           missing closing quote, missing parens entirely (same as tabs, different exact strings)
//   - Practice (this script):  mismatched quote style, missing opening parenthesis
//
// Pool size: Core 1 / Reinforce 1 / Extend 1 per cluster (within the settled
// 1-2/1-2 range). No separate Reteach page in any cluster -- Reinforce's own
// content re-explains inline, matching 01.1's pattern where a single-item lane's
// wrong answer just exits rather than looping further.
//
// Run check-lesson-ladder-wiring.php --cmid=<this cmid> --pool-cap=2 after this.
//
// Run: sudo -u www-data php build-lesson-01-04-practice-ladder.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;

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

// ---------------------------------------------------------------------------
// 1. Create the Lesson activity.
// ---------------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'lesson';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'lesson']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.4 Practice';
$moduleinfo->introeditor = [
    'text' => '<p>A few quick questions about what you just learned in 01.4. The questions '
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

// ===========================================================================
// Cluster 01.4a: predicts_print_output (Objective 1)
// ===========================================================================
$a_core_html = '<p>What does this display, exactly?</p><pre>print("Game paused.")</pre>';
$a_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.4a Core', $a_core_html, LESSON_PAGE_MULTICHOICE, 0);

$a_reinforce_html = '<p>What does this display, exactly?</p><pre>print("Paused")</pre>';
$a_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.4a Reinforce 1', $a_reinforce_html, LESSON_PAGE_MULTICHOICE, $a_coreid);

$a_extend_html = '<p>What does this display, line by line?</p><pre>print("Level 2")
print("Enemies: 5")</pre>';
$a_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.4a Extend 1', $a_extend_html, LESSON_PAGE_MULTICHOICE, $a_reinforceid);

// ===========================================================================
// Cluster 01.4b: diagnoses_print_syntax_errors (Objective 2)
// New variants: mismatched quote style, missing opening parenthesis -- neither
// used anywhere else in this lesson (see header note).
// ===========================================================================
$b_core_html = "<p>What's wrong with this line?</p><pre>print(\"Game Over')</pre>";
$b_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.4b Core', $b_core_html, LESSON_PAGE_MULTICHOICE, $a_extendid);

$b_reinforce_html = '<p>Which of these uses matching quote marks correctly?</p>';
$b_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.4b Reinforce 1', $b_reinforce_html, LESSON_PAGE_MULTICHOICE, $b_coreid);

$b_extend_html = "<p>What's wrong with this line?</p><pre>print \"Boss defeated!\")</pre>";
$b_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.4b Extend 1', $b_extend_html, LESSON_PAGE_MULTICHOICE, $b_reinforceid);

// ===========================================================================
// Cluster 01.4c: identifies_print_statement_parts (Language Objective)
// ===========================================================================
$c_core_html = '<p>In <code>print("Ready to play!")</code>, what is <code>"Ready to play!"</code> called?</p>';
$c_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.4c Core', $c_core_html, LESSON_PAGE_MULTICHOICE, $b_extendid);

$c_reinforce_html = '<p>In <code>print("Ready to play!")</code>, what is <code>print</code> itself called?</p>';
$c_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.4c Reinforce 1', $c_reinforce_html, LESSON_PAGE_MULTICHOICE, $c_coreid);

$c_extend_html = '<p>In <code>print("You win!")</code>: the text <code>"You win!"</code> is a ______ because of its quotes, and it is also the ______ being passed into print(). Which pair correctly fills both blanks, in order?</p>';
$c_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.4c Extend 1', $c_extend_html, LESSON_PAGE_MULTICHOICE, $c_reinforceid);

echo "Pages: A(core={$a_coreid} reinforce={$a_reinforceid} extend={$a_extendid}) "
   . "B(core={$b_coreid} reinforce={$b_reinforceid} extend={$b_extendid}) "
   . "C(core={$c_coreid} reinforce={$c_reinforceid} extend={$c_extendid})\n";

// ---------------------------------------------------------------------------
// Answers.
// ---------------------------------------------------------------------------

// --- 01.4a Core ---
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'Game paused.',
    "Right! Only the text between the quotes is displayed, no quote marks, exactly as written.",
    $a_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    '"Game paused."',
    "<p><strong>What happened:</strong> this includes the quote marks themselves in the output.</p><p><strong>Why:</strong> quotes tell Python where the string starts and ends, they are not part of the text itself.</p><p><strong>Next step:</strong> try a shorter example.</p>",
    $a_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'Game paused',
    "<p><strong>What happened:</strong> this drops the period.</p><p><strong>Why:</strong> print() displays the string exactly as typed, punctuation included.</p><p><strong>Next step:</strong> try a shorter example.</p>",
    $a_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'An error, because something is missing',
    "<p><strong>What happened:</strong> this line is actually complete: the word print, matching parentheses, and a properly quoted string.</p><p><strong>Why:</strong> it's easy to expect an error when a line looks unfamiliar, but every required part is present here.</p><p><strong>Next step:</strong> try a shorter example.</p>",
    $a_reinforceid, 0);

// --- 01.4a Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'Paused',
    "Right! Just the text inside the quotes, exactly as typed.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    '"Paused"',
    "The quote marks are never part of what's displayed. They just mark where the string begins and ends.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'paused',
    "print() doesn't change capitalization. Whatever case the string was typed in is what displays.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'An error',
    "This line has all three required parts: print, parentheses, and a quoted string. It runs fine.",
    LESSON_EOL, 0);

// --- 01.4a Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Level 2, then on the next line, Enemies: 5',
    "Exactly. Each print() statement runs on its own line of code and produces its own line of output, in the order they appear.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Level 2 Enemies: 5, both on the same line',
    "Each separate print() statement produces its own line of output. Two print() calls means two lines displayed, not one combined line.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Enemies: 5, then Level 2',
    "Python runs statements top to bottom, in the order they're written. The first print() call is the one that displays first.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Only Enemies: 5 displays',
    "Both print() statements run. Nothing here causes the first one to be skipped.",
    LESSON_EOL, 0);

// --- 01.4b Core ---
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    "The quote marks don't match, it opens with \" and closes with '",
    "Right! Python needs the SAME quote character to open and close a string. Starting with \" and ending with ' leaves Python still looking for a matching \".",
    $b_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    'Missing closing parenthesis',
    "Look again at the parentheses. Count them. Both are actually there. The quote marks are the real problem.",
    $b_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    'Missing opening parenthesis',
    "Look again at the parentheses. Both are actually there. Check the quote marks instead.",
    $b_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    'Nothing is wrong with this line',
    "This line would actually raise a SyntaxError. Compare the character right after print( to the character right before the final ).",
    $b_reinforceid, 0);

// --- 01.4b Reinforce 1 (Matching answer text, still Multichoice per this ladder's convention) ---
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    '"Hello"',
    "Right! Both quote marks are double quotes, matching.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    '"Hello\'',
    "This opens with a double quote and closes with a single quote. They have to match.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    "'Hello\"",
    "This opens with a single quote and closes with a double quote. They have to match.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    'Hello',
    "This has no quote marks at all, so it isn't a string yet either.",
    LESSON_EOL, 0);

// --- 01.4b Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'Missing opening parenthesis',
    "Right! There's a closing ) at the end, but nothing right after the word print to start the function call. Python needs both.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'Missing closing parenthesis',
    "Look again at the end of the line. The closing ) is actually there. Check right after the word print instead.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'Missing a quote mark',
    "The string is properly opened and closed with matching double quotes. The parentheses are the real problem here.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'Nothing is wrong with this line',
    "This line would actually raise a SyntaxError. Look for the opening parenthesis right after the word print.",
    LESSON_EOL, 0);

// --- 01.4c Core ---
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'The argument',
    "Right! It's the specific value being handed to the print() function to display.",
    $c_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'The function',
    "print itself is the function. The quoted text is what gets passed INTO that function.",
    $c_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'The output',
    "Close, but output is what gets displayed on the screen once the line runs. The quoted text inside the parentheses has its own specific name.",
    $c_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'A SyntaxError',
    "This line is written correctly, so nothing here is an error. Think about what the quoted text's actual job is in this line.",
    $c_reinforceid, 0);

// --- 01.4c Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'A function',
    "Right! print is a named, reusable block of code Python already provides.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'An argument',
    "The argument is the value handed TO print, like the quoted text. print itself is the thing doing the work.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'A string',
    "A string is quoted text. print itself has no quotes around it, it's the name of a function.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'Output',
    "Output is what gets displayed once the line runs. print is the function that produces that output.",
    LESSON_EOL, 0);

// --- 01.4c Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'string, argument',
    "Exactly. It's a string because of the quotes wrapping it, and it's the argument because it's the specific value handed into print().",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'argument, string',
    "The order's swapped. The quotes are what make it a string; being passed into print() is what makes it the argument.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'output, function',
    "Neither term fits here. Output is what displays once the line runs; function refers to print itself, not the quoted text.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'function, output',
    "Neither term fits the quoted text. Think about what the quotes signal, and what role that text plays inside the parentheses.",
    LESSON_EOL, 0);

echo "All answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
