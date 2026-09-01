<?php
// build-lesson-01-01-instruction-native.php
//
// Pilot build, 2026-08-31: replaces 01.1's H5P Interactive Book Instruction module (cmid 117)
// with a native Moodle Lesson activity, per Jay's decision that Instruction/Vocab/Guided
// Example should move to the same native mechanism as Practice (mod_lesson), not stay split
// across H5P + native. This is the norm-setting pilot for all future lessons across all 4
// CS pathways -- read in full before copying, same as build-lesson-01-01-practice-ladder.php
// was for the Practice ladder pattern.
//
// Shape: a flowing, LINEAR sequence of Content pages (What Is a Program -> Computers Are
// Very Literal -> Guided Example -> Where Python Fits In -> Key Terms), with two embedded
// Quick Check question pages along the way. No branching/remediation here -- that's
// Practice's job (see the separate, already-built "01.1 What Programs Do (Practice)",
// cmid 188). Every answer still proceeds to the same next page regardless of correctness;
// score value differs so the attempt is genuinely gradable (matches
// xp-and-incentives.md's not-yet-implemented "Embedded Quick Check" XP row, and now IS
// implementable, since mod_lesson saves every answer server-side natively).
//
// Content itself: Chapters 1 ("What Is a Program?", "Computers Are Very Literal", "Where
// Python Fits In", "Key Terms") and both quick-check questions are ported VERBATIM from the
// real, already-screened H5P book source (07-infrastructure/moodle-scripts/python/
// lesson_01_01_instruction.py) -- not re-authored. The "Guided Example" page is new content,
// since the H5P book never had a distinct guided-example walkthrough (Jay named this as a
// real, missing piece when describing the desired flow). It deliberately does NOT reuse
// either Quick Check's specific scenario, and does NOT reuse Practice's Core question's
// vending-machine-price scenario, to avoid leaking that ladder's actual test item.
//
// Settings: identical to build-lesson-01-01-practice-ladder.php's, for the same reasons
// documented there (custom=1, retake=0, modattempts=1, review=0, displayleft=0,
// displayleftif=0, grade=100, practice=0) -- copied deliberately, not re-derived, since
// those were already verified against this instance's mod/lesson source this session.
//
// Run: sudo -u www-data php build-lesson-01-01-instruction-native.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2; // Unit 01: What Is Programming?
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum], '*', MUST_EXIST);

// ---------------------------------------------------------------------------
// 1. Create the Lesson activity module.
// ---------------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'lesson';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'lesson']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.1 What Programs Do (Instruction)';
$moduleinfo->introeditor = [
    'text' => '<p>Work through this at your own pace using the Continue button. A couple of quick '
        . 'questions are mixed in along the way, just to check your understanding as you go '
        . '(they don\'t affect whether you move forward). Everything saves automatically.</p>',
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
echo "Created lesson activity: cmid={$cmid} lessonid={$lessonid} in course {$course->id}, section {$sectionnum}\n";

// ---------------------------------------------------------------------------
// 2. Insert pages in order.
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

$p1_html = <<<'HTML'
<h2>What Is a Program?</h2>
<p>A <strong>program</strong> is a set of step-by-step instructions that a computer follows, exactly, in order. That's the whole idea. Everything else you learn this year is really just learning more powerful ways to write those instructions.</p>
<p>Think about a recipe. A recipe doesn't just say "make dinner." It breaks the task into exact steps: preheat the oven, chop the onion, add two cups of water. A cook who has never seen the dish before can still follow it, step by step, and produce the same result every time. A program does the same thing for a computer: it breaks a task into exact steps the computer can follow without needing to understand why, only what.</p>
HTML;

$q1_html = '<p>A recipe and a computer program are similar because they are both ___.</p>';

$p2_html = <<<'HTML'
<h2>Computers Are Very Literal</h2>
<p>This matters because computers are extremely literal. A computer does not guess what you probably meant. It does exactly what the instructions say, no more, no less. That's not a limitation to work around, it's the whole reason programs are useful. If a computer improvised, you couldn't trust it to do the same thing twice.</p>
<p><strong>Real-World Example: a vending machine is a program too.</strong> A vending machine takes your money, checks whether you inserted enough, then either releases the item or shows an error. Every one of those checks and decisions was written ahead of time by a programmer as an exact instruction: "<strong>if</strong> the amount inserted is less than the price, <strong>then</strong> do not release the item." The machine isn't deciding anything in the moment. It's following instructions someone else already wrote, the same way a program running on any computer does.</p>
HTML;

$q2_html = "<p>A program's instructions say to add two numbers, but the programmer wrote the wrong numbers by mistake. What will the computer display when the program runs?</p>";

$p3_html = <<<'HTML'
<h2>Let's Walk Through an Example Together</h2>
<p>Here's a short list of instructions, the kind a computer would run one at a time, in order:</p>
<ol>
<li>Set <code>score</code> to 0.</li>
<li>Add 5 to <code>score</code>.</li>
<li>Add 5 to <code>score</code> again.</li>
<li>Display <code>score</code>.</li>
</ol>
<p>Let's trace through it exactly the way a computer would, one instruction at a time:</p>
<p><strong>Step 1:</strong> <code>score</code> starts at 0. Nothing tricky yet, this is just the starting point.</p>
<p><strong>Step 2:</strong> The instruction says add 5 to <code>score</code>. It doesn't matter what <code>score</code> "should" be or what you're picturing in your head, the computer only looks at what <code>score</code> actually is right now (0) and adds 5 to it. <code>score</code> is now 5.</p>
<p><strong>Step 3:</strong> Same move again. <code>score</code> is 5, add 5, <code>score</code> is now 10.</p>
<p><strong>Step 4:</strong> Display <code>score</code>. The computer shows <strong>10</strong>, because that's what <code>score</code> actually holds at this exact point, not because 10 is a "nice round number" or because that's obviously what a programmer would want.</p>
<p>Notice what made this easy to trace: at every single step, we only used the instruction that was actually written, and only the value <code>score</code> actually held at that moment, never what we assumed or expected. That's the whole skill: read the instruction exactly as written, apply it to exactly what's true right now, one step at a time. It feels slow at first. It's also exactly how you'll debug real code later this year when something isn't doing what you expected.</p>
HTML;

$p4_html = <<<'HTML'
<h2>Where Python Fits In</h2>
<p><strong>Python</strong> is a programming language: a tool humans use to write instructions in a form a computer can actually carry out. There are many programming languages, the same way there are many spoken languages. They're different ways of writing the same kind of thing: precise, step-by-step instructions.</p>
<p><strong>Game Connection: every game you've ever played is a program.</strong> A game is a (very large) set of instructions: when the player presses this button, move the character that direction; when health reaches zero, show the game-over screen. Nothing in a game happens by magic or by the game "wanting" something to happen. Somewhere, a programmer wrote the exact instruction for it. This whole course is about learning to write those instructions yourself, starting from the smallest possible piece.</p>
HTML;

$p5_html = <<<'HTML'
<h2>Key Terms</h2>
<p><strong>program:</strong> A set of step-by-step instructions a computer follows, in order. Think of it like a recipe.</p>
<p><strong>instruction:</strong> A single step in a program that tells the computer exactly what to do. Think of it like one line in a recipe.</p>
<p><strong>programmer:</strong> A person who writes the instructions that make up a program. Think of it like the person who writes a recipe.</p>
<p><strong>Python:</strong> A programming language, a tool for writing instructions in a form a computer can carry out. The one this course uses.</p>
HTML;

$id1 = foxcs_insert_lesson_page($DB, $lessonid, '01.1 What Is a Program', $p1_html, LESSON_PAGE_BRANCHTABLE, 0);
$idq1 = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Quick Check A', $q1_html, LESSON_PAGE_MULTICHOICE, $id1);
$id2 = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Computers Are Very Literal', $p2_html, LESSON_PAGE_BRANCHTABLE, $idq1);
$idq2 = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Quick Check B', $q2_html, LESSON_PAGE_MULTICHOICE, $id2);
$id3 = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Guided Example', $p3_html, LESSON_PAGE_BRANCHTABLE, $idq2);
$id4 = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Where Python Fits In', $p4_html, LESSON_PAGE_BRANCHTABLE, $id3);
$id5 = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Key Terms', $p5_html, LESSON_PAGE_BRANCHTABLE, $id4);

echo "Pages: p1={$id1} q1={$idq1} p2={$id2} q2={$idq2} guided={$id3} p4={$id4} p5={$id5}\n";

// ---------------------------------------------------------------------------
// 3. Insert answers (Continue buttons for Content pages, real options for Quick Checks).
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

// Content pages: single Continue button, no scoring.
foxcs_insert_answer($DB, $lessonid, $id1, 'Continue', null, $idq1, 0);
foxcs_insert_answer($DB, $lessonid, $id2, 'Continue', null, $idq2, 0);
foxcs_insert_answer($DB, $lessonid, $id3, 'Continue', null, $id4, 0);
foxcs_insert_answer($DB, $lessonid, $id4, 'Continue', null, $id5, 0);
foxcs_insert_answer($DB, $lessonid, $id5, 'Continue', null, LESSON_EOL, 0);

// Quick Check A -- every option proceeds to the next content page regardless of
// correctness (this is a check-in, not a gate); score differs for grading/XP purposes only.
foxcs_insert_answer($DB, $lessonid, $idq1, 'a set of exact, ordered steps',
    "Right! Both a recipe and a program are exact, ordered steps that produce the same result every time they're followed.", $id2, 1);
foxcs_insert_answer($DB, $lessonid, $idq1, 'something only an expert can understand',
    "Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.", $id2, 0);
foxcs_insert_answer($DB, $lessonid, $idq1, 'a list of ingredients or tools',
    "Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.", $id2, 0);
foxcs_insert_answer($DB, $lessonid, $idq1, 'a finished result, like a meal or a working app',
    "Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.", $id2, 0);

// Quick Check B -- same pattern.
foxcs_insert_answer($DB, $lessonid, $idq2, 'The result of the instructions exactly as written, mistake included',
    'Right! The computer follows the instructions exactly as written. It has no way to know what the programmer "really" meant, only what was actually written down.', $id3, 1);
foxcs_insert_answer($DB, $lessonid, $idq2, 'The result the programmer actually meant to get',
    "Remember the vending machine example: the machine doesn't decide anything on its own.", $id3, 0);
foxcs_insert_answer($DB, $lessonid, $idq2, 'An automatic correction of the mistake',
    "Remember the vending machine example: the machine doesn't decide anything on its own.", $id3, 0);
foxcs_insert_answer($DB, $lessonid, $idq2, 'Nothing, because the computer will notice the mistake and stop on its own',
    "Remember the vending machine example: the machine doesn't decide anything on its own.", $id3, 0);

echo "Answers inserted for all 7 pages.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
