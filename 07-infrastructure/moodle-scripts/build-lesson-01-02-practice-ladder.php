<?php
// build-lesson-01-02-practice-ladder.php
//
// 01.2 Practice: a real Core/Reinforce/Extend ladder for Input-Process-Output, matching
// 01.1 Practice's proven settings/pattern exactly.
//
// Skill targeted: distinguishes_process_from_output -- the most common real IPO
// classification error is conflating the WORK a program does (Process) with the RESULT
// that work produces once it's shown back (Output). This has genuine decomposable
// structure (a full 3-tier ladder is warranted, same depth as 01.1's Core A): the Core
// scenario buries the distinction inside a multi-step example (a calculator), Reinforce
// isolates the process/output distinction directly, Reinforce 2 reduces it to a bare
// true/false claim, and Reteach gives a short recap. Extend 1/2 reward students who get
// it immediately with richer scenarios (an ATM's error message, a cached/stale result)
// rather than restating the basics.
//
// Run: sudo -u www-data php build-lesson-01-02-practice-ladder.php

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
$moduleinfo->name = '01.2 Practice';
$moduleinfo->introeditor = [
    'text' => '<p>A few quick questions about what you just learned in 01.2. The questions '
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

$core_html = <<<'HTML'
<p>A calculator app: you type "7 x 6" (the characters go in), the app multiplies 7 by 6, then the number "42" appears on the screen.</p>
<p>Which stage is the number "42" actually appearing on the screen?</p>
HTML;

$reinforce1_html = <<<'HTML'
<p>Let's slow this down. A calculator adds 7 + 6. The <strong>adding itself</strong>, the actual math happening, is the Process.</p>
<p>What is the number 13 that finally appears on the screen, once that adding is done?</p>
HTML;

$reinforce2_html = <<<'HTML'
<p><strong>True or False:</strong></p>
<p>The moment a program finishes calculating a result, but before that result is actually shown to you, the calculating itself already counts as Output.</p>
HTML;

$reteach_html = <<<'HTML'
<h3>Quick Recap: Process Is the Work, Output Is the Result</h3>
<p>Process and Output happen right next to each other in time, which is exactly why they're easy to mix up. But they are two separate stages.</p>
<p><strong>Process</strong> is the actual work: the calculating, comparing, or deciding. It happens inside the program, and you never directly see it happen.</p>
<p><strong>Output</strong> is what gets delivered back to you once that work is done: the number on the screen, the sound that plays, the message that displays.</p>
<p>A useful test: if you can point to it and say "there it is," it's probably Output. If it's the invisible work that produced what you're pointing at, it's Process.</p>
<p>This is one of the trickiest distinctions in this lesson, and it's completely normal if it still feels fuzzy. Check in with your teacher so you can talk through an example together.</p>
HTML;

$extend1_html = <<<'HTML'
<p>An ATM: you insert your card, type your PIN, the machine checks your PIN against your account, then either dispenses cash or shows "Incorrect PIN."</p>
<p>You type the wrong PIN. Which stage produces the "Incorrect PIN" message?</p>
HTML;

$extend2_html = <<<'HTML'
<p>A weather app already has yesterday's forecast saved on your phone from the last time you opened it. Today you open the app with no internet connection. It shows you that old saved forecast instead of a new one.</p>
<p>Is displaying that old saved forecast still real Output, even though the app didn't do any new Process work this time?</p>
HTML;

$coreid       = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Core',        $core_html,       LESSON_PAGE_MULTICHOICE, 0);
$reinforce1id = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Reinforce 1', $reinforce1_html, LESSON_PAGE_MULTICHOICE, $coreid);
$reinforce2id = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Reinforce 2', $reinforce2_html, LESSON_PAGE_MULTICHOICE, $reinforce1id);
$reteachid    = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Reteach',     $reteach_html,    LESSON_PAGE_BRANCHTABLE, $reinforce2id);
$extend1id    = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Extend 1',    $extend1_html,    LESSON_PAGE_MULTICHOICE, $reteachid);
$extend2id    = foxcs_insert_lesson_page($DB, $lessonid, '01.2 Extend 2',    $extend2_html,    LESSON_PAGE_MULTICHOICE, $extend1id);

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
    'Output',
    "That's right. The multiplying itself (the Process) already happened inside the app, invisibly. The \"42\" appearing on the screen is what the app delivers back to you, that's Output.",
    $extend1id, 1);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'Process',
    "<p><strong>What happened:</strong> this answer treats the number showing up as the same thing as the calculating that produced it.</p><p><strong>Why:</strong> Process and Output happen right next to each other, so it's easy to blur them together.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'Input',
    "<p><strong>What happened:</strong> this answer treats what's shown on screen as something going INTO the program, rather than coming back out of it.</p><p><strong>Why:</strong> Input was what you typed (\"7 x 6\"), before any work happened.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'System',
    "<p><strong>What happened:</strong> System describes the whole calculator app as one unit, not a specific step.</p><p><strong>Why:</strong> the question is asking about one particular moment in the IPO pattern, not the app as a whole.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);

// --- Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'Output',
    "That's right. The adding already happened (that was Process). The 13 you actually see is what gets delivered back, that's Output.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'Process, same as the adding',
    "<p><strong>What happened:</strong> this groups the finished number in with the work that produced it.</p><p><strong>Why:</strong> it's natural to think of the whole thing, adding and showing, as one single step.</p><p><strong>Next step:</strong> one more look at this same idea, in an even smaller example.</p>",
    $reinforce2id, 0);
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'Neither, it\'s not really a "stage" at all',
    "<p><strong>What happened:</strong> this answer says the result doesn't fit anywhere in Input-Process-Output.</p><p><strong>Why:</strong> every program produces some kind of result that gets delivered back, and that delivery IS one of the three real stages.</p><p><strong>Next step:</strong> one more look at this idea, in an even smaller example.</p>",
    $reinforce2id, 0);
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'Input for the next calculation',
    "<p><strong>What happened:</strong> this answer looks ahead to what MIGHT happen next, rather than what this number actually is right now.</p><p><strong>Why:</strong> it's true a result could become input later, but in this exact moment it's what the program just delivered back.</p><p><strong>Next step:</strong> one more look at this idea, in an even smaller example.</p>",
    $reinforce2id, 0);

// --- Reinforce 2 ---
foxcs_insert_answer($DB, $lessonid, $reinforce2id,
    'False. Calculating is Process. Showing the result is Output. They\'re two separate stages, even though they happen close together.',
    "That's right. Process is the invisible work. Output is what actually gets delivered back once that work is finished. They're not the same moment, even when they happen back to back.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $reinforce2id,
    'True. Once the calculating is finished, that\'s already the Output.',
    "<p><strong>What happened:</strong> this says finishing the math and delivering the result are the same thing.</p><p><strong>Why:</strong> this is one of the trickiest ideas in this lesson. The math finishing happens inside the program, where you can't see it. Output is specifically the part where something actually gets delivered back to you.</p><p><strong>Next step:</strong> check in with your teacher so you can talk through an example together.</p>",
    $reteachid, 0);

// --- Reteach (Content page) ---
foxcs_insert_answer($DB, $lessonid, $reteachid, 'Continue', null, LESSON_EOL, 0);

// --- Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'Output',
    'Exactly. The checking (comparing your PIN against your account) is Process. The message that actually appears, "Incorrect PIN", is what the machine delivers back to you. That\'s Output, even though it\'s an error rather than cash.',
    $extend2id, 1);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'Process, since it\'s the result of a decision the machine made',
    'The decision itself (whether the PIN matches) is Process. The message that shows up because of that decision is a separate step, the one where something actually gets delivered back to you. Look again at what "Incorrect PIN" actually is: a decision, or the result you see because of one.',
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'Input, because it came from something you did (typing the wrong PIN)',
    'What you typed (the PIN itself) was the Input. What the machine shows you back, after checking it, is a different stage entirely. Look again at where the "Incorrect PIN" message actually falls in the sequence.',
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'System, because the whole ATM is involved',
    'System describes the whole ATM as one unit, not a specific step. Look again at which of the three real stages, Input, Process, or Output, "Incorrect PIN" actually is.',
    LESSON_EOL, 0);

// --- Extend 2 ---
foxcs_insert_answer($DB, $lessonid, $extend2id,
    'Yes, it\'s still Output. Something was delivered back to you, even though it wasn\'t freshly processed this time.',
    'Right. Output just means something is delivered back to you as a result. It doesn\'t require the program to do brand-new Process work every single time. A saved forecast being shown to you is still the app delivering something back, even if the "deciding" already happened earlier, on a previous visit.',
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $extend2id,
    'No, since nothing was actually processed this time, nothing can count as Output',
    'It\'s true no fresh calculating happened this time. But Output describes what gets delivered back to you, not how recently it was calculated. Think about whether you, the user, still received something back from the app.',
    LESSON_EOL, 0);

echo "Answers inserted for all 6 pages.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
