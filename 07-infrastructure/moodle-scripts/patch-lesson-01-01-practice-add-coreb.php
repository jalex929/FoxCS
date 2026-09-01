<?php
// patch-lesson-01-01-practice-add-coreb.php
//
// Adds a second Core-level checkpoint ("01.1 Core B: Order Matters") to the existing
// Practice ladder (cmid=188, lessonid from mdl_lesson) for Lesson 01.1. Requested directly
// by Jay 2026-08-31: Practice only tested one skill (computer literalness, the vending
// machine Core question); the rest of 01.1's Instruction content had zero Practice coverage.
//
// Skill targeted: distinguishes_order_effects -- "Understands that a program runs
// instructions in the order they're written, and that changing that order changes the
// result." Grounded directly in the live 01.1 Instruction content's Guided Example page
// (cmid=193, page id=27 on this instance): the exact same score=0 -> +5 -> +5 -> display(10)
// trace, but with the display instruction moved earlier so the result changes to 5. Reusing
// the exact numbers/scenario the student just saw in Instruction is deliberate -- this is
// reinforcement of familiar content, not a new domain, which is the right choice right after
// first exposure (matches Instruction's own Guided Example, not a novel scenario the way
// Extend 1/2 deliberately use novel scenarios for stretch).
//
// This is a genuinely distinct skill from the existing Core ladder (Core = "the computer
// won't infer/correct your intent"; Core B = "the computer runs steps in the order you wrote
// them"), so it's a real second checkpoint, not a duplicate of Core.
//
// Proportionate remediation depth: Core's skill (intent-inference) got a 3-tier ladder
// because it's a genuinely slippery misconception with several distinct wrong-answer paths.
// Core B's skill (order/sequence) is more mechanical -- one reteach step that walks the exact
// trace again is enough; it does not need its own Reinforce 1/2 or Extend chain (Core's own
// Extend path already serves as this lesson's "stretch" experience for strong students).
//
// Wiring: every existing terminal answer in this ladder (10 rows, verified directly against
// mdl_lesson_answers before writing this patch) currently jumps to LESSON_EOL. This patch
// redirects all 10 to Core B's new page id instead, so every student -- regardless of which
// branch they took through the existing ladder -- hits this second checkpoint before the
// lesson actually ends. Core B itself becomes the new funnel point into LESSON_EOL.
//
// Run: sudo -u www-data php patch-lesson-01-01-practice-add-coreb.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_BRANCHTABLE = 20;

$cm = $DB->get_record('course_modules', ['id' => 188], '*', MUST_EXIST);
$lesson = $DB->get_record('lesson', ['id' => $cm->instance], '*', MUST_EXIST);
$lessonid = $lesson->id;
echo "Patching lessonid={$lessonid} (cmid=188)\n";

// ---------------------------------------------------------------------------
// 1. Find the current last page (Extend 2, title '01.1 Extend 2') to append after.
// ---------------------------------------------------------------------------
$extend2 = $DB->get_record('lesson_pages', ['lessonid' => $lessonid, 'title' => '01.1 Extend 2'], '*', MUST_EXIST);

// ---------------------------------------------------------------------------
// 2. Insert Core B and Reteach B pages.
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

$coreb_html = <<<'HTML'
<p>Here's the same example from the Guided Example you just read, with one change: the instructions are in a different order.</p>
<p>A program does exactly this, in exactly this order:</p>
<ol>
<li>Set score to 0.</li>
<li>Add 5 to score.</li>
<li>Display score.</li>
<li>Add 5 to score again.</li>
</ol>
<p>What does the program actually display?</p>
HTML;

$rebteachb_html = <<<'HTML'
<h3>Quick Recap: Order Changes the Result</h3>
<p>Let's trace it exactly the way the computer would, one instruction at a time:</p>
<p><strong>Step 1:</strong> score starts at 0.</p>
<p><strong>Step 2:</strong> add 5 to score. score is now 5.</p>
<p><strong>Step 3:</strong> display score. The computer shows <strong>5</strong>, because that's what score actually holds at this exact point.</p>
<p><strong>Step 4:</strong> add 5 to score again. score is now 10, but this happens after the display already ran, so nothing shows this new value.</p>
<p>The instructions are the same four steps from the Guided Example. Moving "display score" earlier changes what actually gets shown, even though nothing else about the program changed. The order instructions run in is part of what a program <em>is</em>, not just a detail.</p>
HTML;

$corebid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Core B', $coreb_html, LESSON_PAGE_MULTICHOICE, $extend2->id);
$reteachbid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Reteach B', $rebteachb_html, LESSON_PAGE_BRANCHTABLE, $corebid);
echo "Pages: CoreB={$corebid} ReteachB={$reteachbid}\n";

// ---------------------------------------------------------------------------
// 3. Redirect every existing terminal answer (jumpto=-9) to Core B instead of LESSON_EOL.
// ---------------------------------------------------------------------------
$terminalanswers = $DB->get_records_select('lesson_answers', 'lessonid = ? AND jumpto = ?', [$lessonid, LESSON_EOL]);
$redirected = 0;
foreach ($terminalanswers as $a) {
    $DB->set_field('lesson_answers', 'jumpto', $corebid, ['id' => $a->id]);
    $redirected++;
}
echo "Redirected {$redirected} existing terminal answers to Core B (pageid={$corebid}).\n";

// ---------------------------------------------------------------------------
// 4. Insert Core B and Reteach B answers.
// ---------------------------------------------------------------------------
foxcs_insert_answer($DB, $lessonid, $corebid,
    '5. The display instruction runs right after the first "add 5," so score is 5 at that exact point. The second "add 5" happens afterward and is never displayed.',
    "That's right. The computer runs these four steps in exactly the order they're written. By the time \"display score\" runs, only one \"add 5\" has happened, so it shows 5. The second \"add 5\" still happens, score really is 10 after that, but nothing displays it again.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $corebid,
    '10, because that\'s what the program adds up to overall.',
    '<p><strong>What happened:</strong> this answer uses the final total, not what actually gets displayed at the moment the display instruction runs.</p><p><strong>Why:</strong> it\'s natural to think about where a program "ends up," but the display instruction runs at a specific point, not at the very end.</p><p><strong>Next step:</strong> the next page walks through the exact order again.</p>',
    $reteachbid, 0);
foxcs_insert_answer($DB, $lessonid, $corebid,
    '0, because the display instruction runs before either "add 5" happens.',
    '<p><strong>What happened:</strong> this answer places the display instruction first in the sequence.</p><p><strong>Why:</strong> it\'s easy to lose track of exactly where each step falls once the order changes from what you saw before.</p><p><strong>Next step:</strong> the next page walks through the exact order again.</p>',
    $reteachbid, 0);
foxcs_insert_answer($DB, $lessonid, $corebid,
    'The program shows an error, because the instructions are out of order.',
    '<p><strong>What happened:</strong> this answer assumes a program stops or breaks when steps are reordered.</p><p><strong>Why:</strong> reordering steps doesn\'t break anything for the computer, it just runs them in the new order. The result changes, but nothing goes wrong.</p><p><strong>Next step:</strong> the next page walks through the exact order again.</p>',
    $reteachbid, 0);

foxcs_insert_answer($DB, $lessonid, $reteachbid, 'Continue', null, LESSON_EOL, 0);

echo "Answers inserted for Core B and Reteach B.\n";
echo "Done.\n";
