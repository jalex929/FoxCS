<?php
// build-lesson-01-06-practice-ladder.php
//
// Builds Lesson 01.6's (Common Syntax Mistakes) Reinforce/Core/Extend Practice
// ladder as a native Moodle Lesson activity, following the settled pattern.
// THREE skill clusters, one per real stated objective in 01_instruction.html:
//   1. "I can identify and fix common early Python mistakes."
//      -> cluster 01.6a: fixes_common_mistakes
//   2. "I can explain the difference between a SyntaxError and a NameError."
//      -> cluster 01.6b: classifies_error_type
//   3. Language objective: SyntaxError / NameError / syntax terms
//      -> cluster 01.6c: describes_error_vocab
//
// Every broken-line example across all three clusters is deliberately distinct
// from every other one already used in this lesson (tabs' Big Four table:
// Hello/Hi examples; Instruction Quick Checks: Victory/Level Up; Mastery Check:
// New Record!/Paused/Continue; Coding Exercise: Welcome to the arena/Choose your
// character/Good luck out there!/Battle Start).
//
// Pool size: Core 1 / Reinforce 1 / Extend 1 per cluster.
//
// Run check-lesson-ladder-wiring.php --cmid=<this cmid> --pool-cap=2 after this.
//
// Run: sudo -u www-data php build-lesson-01-06-practice-ladder.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2; // "Unit 01: What Is Programming?" -- literal section NUMBER.

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
$moduleinfo->name = '01.6 Practice';
$moduleinfo->introeditor = [
    'text' => '<p>A few quick questions about what you just learned in 01.6. The questions '
        . 'adjust to how you\'re doing: if something\'s tricky, you\'ll get a smaller step to '
        . 'work through before moving on, and if you\'ve got it, you\'ll get a chance to '
        . 'stretch further.</p><p>Everything you answer here is saved automatically as you '
        . 'go. You can come back to this activity afterward to review what you answered.</p>',
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
$moduleinfo->maxanswers = 4;
$moduleinfo->displayleft = 0;
$moduleinfo->displayleftif = 0;
$moduleinfo->mediafile = 0;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$lessonid = $result->id;
echo "Created lesson activity: cmid={$cmid} lessonid={$lessonid}\n";

// ===========================================================================
// Cluster 01.6a: fixes_common_mistakes (Objective 1)
// ===========================================================================
$a_core_html = '<p>Which of these correctly fixes this broken line?</p><pre>print("Power up)</pre>';
$a_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.6a Core', $a_core_html, LESSON_PAGE_MULTICHOICE, 0);

$a_reinforce_html = '<p>Which of these correctly fixes this broken line?</p><pre>print(Jump)</pre>';
$a_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.6a Reinforce 1', $a_reinforce_html, LESSON_PAGE_MULTICHOICE, $a_coreid);

$a_extend_html = '<p>This line has two mistakes at once. Which of these correctly fixes BOTH?</p><pre>Print("Dash"</pre>';
$a_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.6a Extend 1', $a_extend_html, LESSON_PAGE_MULTICHOICE, $a_reinforceid);

// ===========================================================================
// Cluster 01.6b: classifies_error_type (Objective 2)
// ===========================================================================
$b_core_html = '<p>What error does this line raise?</p><pre>print(Shield)</pre>';
$b_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.6b Core', $b_core_html, LESSON_PAGE_MULTICHOICE, $a_extendid);

$b_reinforce_html = '<p>What error does this line raise?</p><pre>print "Reload"</pre>';
$b_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.6b Reinforce 1', $b_reinforce_html, LESSON_PAGE_MULTICHOICE, $b_coreid);

$b_extend_html = '<p>A classmate says: "<code>print(Coins)</code> raises a SyntaxError because Coins is missing quotes." What\'s wrong with that reasoning?</p>';
$b_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.6b Extend 1', $b_extend_html, LESSON_PAGE_MULTICHOICE, $b_reinforceid);

// ===========================================================================
// Cluster 01.6c: describes_error_vocab (Language Objective)
// ===========================================================================
$c_core_html = '<p>What is the general term for a programming language\'s grammar rules?</p>';
$c_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.6c Core', $c_core_html, LESSON_PAGE_MULTICHOICE, $b_extendid);

$c_reinforce_html = '<p>What do you call the ( or ) symbol required in a function call like <code>print("Hi")</code>?</p>';
$c_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.6c Reinforce 1', $c_reinforce_html, LESSON_PAGE_MULTICHOICE, $c_coreid);

$c_extend_html = '<p>An error message says <code>SyntaxError: EOL while scanning string literal</code>. What does EOL mean here, and what usually causes it?</p>';
$c_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.6c Extend 1', $c_extend_html, LESSON_PAGE_MULTICHOICE, $c_reinforceid);

echo "Pages: A(core={$a_coreid} reinforce={$a_reinforceid} extend={$a_extendid}) "
   . "B(core={$b_coreid} reinforce={$b_reinforceid} extend={$b_extendid}) "
   . "C(core={$c_coreid} reinforce={$c_reinforceid} extend={$c_extendid})\n";

// ---------------------------------------------------------------------------
// Answers.
// ---------------------------------------------------------------------------

// --- 01.6a Core: missing closing quote ---
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'print("Power up")',
    "Right! The original was missing its closing quote. This adds it back, matching the opening \".",
    $a_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'print(Power up)',
    "This removes the quotes entirely, which would raise a NameError instead. The original just needed its closing quote added back.",
    $a_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'Print("Power up)',
    "This still has the same missing closing quote as before, and now also capitalizes Print incorrectly. Neither problem is fixed.",
    $a_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'print("Power up"',
    "This still doesn't close the parentheses. Check both the quote and the parenthesis at the end of the line.",
    $a_reinforceid, 0);

// --- 01.6a Reinforce 1: missing quotes entirely ---
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'print("Jump")',
    "Right! Wrapping Jump in quotes turns it into a string, so print() has real text to display instead of looking for an undefined variable.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'Print(Jump)',
    "This still leaves Jump unquoted, and now also capitalizes Print, which would cause a different NameError.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'print(Jump',
    "This drops the closing parenthesis entirely and still doesn't add quotes around Jump.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'print("Jump)',
    "This adds an opening quote but not a matching closing one, which trades one problem for another.",
    LESSON_EOL, 0);

// --- 01.6a Extend 1: capitalization + missing closing paren ---
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'print("Dash")',
    "Right! Both mistakes are fixed: print is lowercase, and the closing parenthesis is added.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Print("Dash")',
    "The closing parenthesis is fixed, but Print is still capitalized, which still raises a NameError.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'print("Dash"',
    "print is correctly lowercase now, but the closing parenthesis is still missing.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'print(Dash)',
    "This fixes neither original mistake and introduces a new one: the quotes around Dash are gone entirely.",
    LESSON_EOL, 0);

// --- 01.6b Core ---
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    'NameError',
    "Right! Shield has no quotes, so Python treats it as a variable name and can't find one defined by that name.",
    $b_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    'SyntaxError',
    "The grammar here is actually fine: print, matching parentheses, one item inside. The issue is what's inside, not the structure.",
    $b_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    'No error',
    "This line would raise an error when run. Check whether Shield is wrapped in quotes.",
    $b_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    'IndentationError',
    "There's no spacing or indentation issue here. Look at whether Shield has quotes around it.",
    $b_reinforceid, 0);

// --- 01.6b Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    'SyntaxError',
    "Right! Without parentheses, Python 3 can't parse this as a valid function call at all.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    'NameError',
    "A NameError needs the grammar to be valid first. Here, the missing parentheses break the grammar itself.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    'No error',
    "This line would raise an error when run. Count the parentheses.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    'EOL error only',
    "EOL errors come from an unclosed quote. The quotes here are fine. The parentheses are missing.",
    LESSON_EOL, 0);

// --- 01.6b Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'The reasoning mixes up the two error types -- missing quotes causes a NameError, not a SyntaxError',
    "Exactly. The grammar of print(Coins) is valid (matching parens, one item inside). Python runs it, looks for a variable named Coins, and fails to find one -- that's a NameError.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'Nothing is wrong, that reasoning is correct',
    "It's not correct -- this line raises a NameError, not a SyntaxError, because the grammar itself is valid.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'The reasoning is right, but the fix should add parentheses instead of quotes',
    "The parentheses are already correct here. The actual missing piece is quotes around Coins, and the resulting error is a NameError.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'print(Coins) does not raise any error at all',
    "It does raise an error when run -- just a NameError, not the SyntaxError the classmate named.",
    LESSON_EOL, 0);

// --- 01.6c Core ---
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'syntax',
    "Right! Syntax is the general term for a language's grammar rules -- matching quotes and parentheses are both part of Python's syntax.",
    $c_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'NameError',
    "A NameError is a specific kind of error, not the general term for grammar rules.",
    $c_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'EOL',
    "EOL refers to reaching the end of a line unexpectedly, not to grammar rules in general.",
    $c_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'argument',
    "An argument is a value passed into a function. That's not related to grammar rules.",
    $c_reinforceid, 0);

// --- 01.6c Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'parenthesis',
    "Right! Parenthesis refers to the ( or ) symbol, and every function call needs a matching pair.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'syntax',
    "Syntax is the broader term for grammar rules in general, not the specific ( or ) symbol itself.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'string',
    "A string is quoted text, not the ( or ) symbol.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'comment',
    "A comment is a line Python ignores, starting with #. That's a completely different symbol and idea.",
    LESSON_EOL, 0);

// --- 01.6c Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'EOL means "End Of Line" -- Python reached the end of the line while still expecting something, usually a missing closing quote',
    "Exactly. Python was in the middle of reading a string when the line ran out, most often because a closing quote was never typed.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'EOL means "Error On Line" -- it points to which line number has a NameError',
    "That's not what EOL stands for, and this specific error is a SyntaxError, not a NameError.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'EOL means the program finished running successfully',
    "This message is an error, not a success signal. EOL here means Python hit the end of a line before finishing what it was reading.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'EOL means the file is completely empty',
    "This isn't about an empty file. It's about Python reaching the end of one specific line before a string or statement was properly closed.",
    LESSON_EOL, 0);

echo "All answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
