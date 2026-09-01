<?php
// rebuild-lesson-01-01-instruction-tabbed.php
//
// Replaces the 7-page linear Instruction pilot on cmid=193 (lessonid=5, foxcs-python,
// Unit 01) with the tabbed design Jay approved 2026-08-31 after several mockup rounds
// (see the published artifact and this session's chat history for the design trail):
//   1. Tabbed Content page -- 5 tabs (What Is a Program / Computers Are Literal / Guided
//      Example / Where Python Fits In / Key Terms w/ flip-card flashcards), pure CSS,
//      no JS. Deliberately has NO per-tab "click to reveal" checkpoints -- Jay's explicit
//      call: those don't actually make a student do anything provable, so they were cut.
//   2. Quick Check A (Multichoice) -- unchanged content/answers from the old pageid 24.
//   3. Quick Check B (Multichoice) -- unchanged content/answers from the old pageid 26.
//   4. Vocab Quiz (native Matching page, LESSON_PAGE_MATCHING=5) -- NEW. Jay's explicit
//      call: give this simple branching too, not just a flat one-shot check. Wrong (not
//      ALL 4 matched) -> Vocab Breakdown (reteach) -> Vocab Retry, a second Matching page
//      using scenario-style rephrasings of the same 4 terms rather than repeating the
//      bare dictionary definitions verbatim (same "don't just repeat the exact same
//      question" principle already used in Practice's Reinforce ladder). Retry is
//      terminal either way (non-gating, matches the rest of this lesson's philosophy).
//
// DOK / Bloom's spread across this lesson (per Jay's explicit ask to vary these,
// 2026-08-31): tabs = Remember/Understand; Guided Example = Apply; Quick Check A =
// Understand (analogy); Quick Check B = Apply/Analyze (novel mistake scenario); Vocab
// Quiz/Retry = Remember then Understand (bare recall vs. scenario recognition); Practice's
// own Core A = Analyze, Extend 1's "Is your friend right?" = Evaluate. This page's own
// content intentionally stays Remember/Understand/Apply -- Analyze/Evaluate is Practice's
// job, not Instruction's.
//
// Verified before writing this: zero real student attempts existed anywhere on cmid=193
// (mdl_lesson_attempts, checked earlier this session), so a full page-set replacement is
// safe -- no live data at risk.
//
// Run: sudo -u www-data php rebuild-lesson-01-01-instruction-tabbed.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_MATCHING = 5;
const LESSON_PAGE_BRANCHTABLE = 20;

$cm = $DB->get_record('course_modules', ['id' => 193], '*', MUST_EXIST);
$lesson = $DB->get_record('lesson', ['id' => $cm->instance], '*', MUST_EXIST);
$lessonid = $lesson->id;
echo "Rebuilding lessonid={$lessonid} (cmid=193)\n";

// ---------------------------------------------------------------------------
// 0. Wipe the existing 7-page linear structure and its answers.
// ---------------------------------------------------------------------------
$oldpages = $DB->get_records('lesson_pages', ['lessonid' => $lessonid], 'id', 'id');
foreach ($oldpages as $p) {
    $DB->delete_records('lesson_answers', ['lessonid' => $lessonid, 'pageid' => $p->id]);
}
$DB->delete_records('lesson_pages', ['lessonid' => $lessonid]);
echo "Cleared " . count($oldpages) . " old pages and their answers.\n";

// ---------------------------------------------------------------------------
// Helpers (identical pattern to build-lesson-01-01-practice-ladder.php).
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

// Matching page: row 0 = correct-response feedback, row 1 = wrong-response feedback,
// rows 2+ = term/response pairs (response text must be unique per page -- the native
// matching UI checks trimmed string equality of the response text itself).
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
// 1. Tabbed content page.
// ---------------------------------------------------------------------------
$tabhtml = file_get_contents('/tmp/content-01-01-tabbed-instruction.html');
if ($tabhtml === false) {
    fwrite(STDERR, "Could not read /tmp/content-01-01-tabbed-instruction.html\n");
    exit(1);
}

$tabpageid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 What Programs Do', $tabhtml, LESSON_PAGE_BRANCHTABLE, 0);

// ---------------------------------------------------------------------------
// 2. Quick Check A / B (unchanged content from the old pilot).
// ---------------------------------------------------------------------------
$qca_html = '<p>A recipe and a computer program are similar because they are both ___.</p>';
$qcaid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Quick Check A', $qca_html, LESSON_PAGE_MULTICHOICE, $tabpageid);

$qcb_html = '<p>A program\'s instructions say to add two numbers, but the programmer wrote the wrong numbers by mistake. What will the computer display when the program runs?</p>';
$qcbid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Quick Check B', $qcb_html, LESSON_PAGE_MULTICHOICE, $qcaid);

// ---------------------------------------------------------------------------
// 3. Vocab Quiz (Matching) -> wrong -> Vocab Breakdown -> Vocab Retry (Matching).
// ---------------------------------------------------------------------------
$vocabquiz_html = '<p>Match each term to its definition.</p>';
$vocabquizid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Vocab Quiz', $vocabquiz_html, LESSON_PAGE_MATCHING, $qcbid);

$breakdown_html = <<<'HTML'
<h3>Let's Break These Down One at a Time</h3>
<p>All four of these terms connect back to the same recipe idea from earlier in this lesson:</p>
<p><strong>program</strong> is the whole recipe: the complete, ordered list of exact steps that gets you from start to a finished result.</p>
<p><strong>instruction</strong> is just one line from that recipe: one specific step, on its own.</p>
<p><strong>programmer</strong> is the person who actually sat down and wrote the recipe out, step by step.</p>
<p><strong>Python</strong> is the specific language this class uses to write recipes like that for a computer.</p>
<p>Take another look, phrased a little differently this time.</p>
HTML;
$breakdownid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Vocab Breakdown', $breakdown_html, LESSON_PAGE_BRANCHTABLE, $vocabquizid);

$vocabretry_html = '<p>Match each term to its definition. This time the definitions are worded a little differently.</p>';
$vocabretryid = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Vocab Retry', $vocabretry_html, LESSON_PAGE_MATCHING, $breakdownid);

echo "Pages: Tab={$tabpageid} QCA={$qcaid} QCB={$qcbid} VocabQuiz={$vocabquizid} Breakdown={$breakdownid} VocabRetry={$vocabretryid}\n";

// ---------------------------------------------------------------------------
// 4. Answers.
// ---------------------------------------------------------------------------

// --- Tab page: single Continue -> Quick Check A ---
foxcs_insert_answer($DB, $lessonid, $tabpageid, 'Continue', null, $qcaid, 0);

// --- Quick Check A (all answers advance regardless of correctness -- a check-in, not a gate) ---
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'a set of exact, ordered steps',
    "Right! Both a recipe and a program are exact, ordered steps that produce the same result every time they're followed.",
    $qcbid, 1);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'something only an expert can understand',
    'Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.',
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'a list of ingredients or tools',
    'Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.',
    $qcbid, 0);
foxcs_insert_answer($DB, $lessonid, $qcaid,
    'a finished result, like a meal or a working app',
    'Look again at the recipe example above. Think about the one thing a recipe and a program both actually are, structurally.',
    $qcbid, 0);

// --- Quick Check B ---
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'The result of the instructions exactly as written, mistake included',
    'Right! The computer follows the instructions exactly as written. It has no way to know what the programmer "really" meant, only what was actually written down.',
    $vocabquizid, 1);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'The result the programmer actually meant to get',
    "Remember the vending machine example: the machine doesn't decide anything on its own.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'An automatic correction of the mistake',
    "Remember the vending machine example: the machine doesn't decide anything on its own.",
    $vocabquizid, 0);
foxcs_insert_answer($DB, $lessonid, $qcbid,
    'Nothing, because the computer will notice the mistake and stop on its own',
    "Remember the vending machine example: the machine doesn't decide anything on its own.",
    $vocabquizid, 0);

// --- Vocab Quiz (Matching): row0=correct feedback, row1=wrong feedback, then 4 pairs ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'Nice work, you matched all four correctly.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    "Not quite all four yet. Let's break these down.", null, $breakdownid, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'program', 'A set of step-by-step instructions a computer follows, in order.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'instruction', 'A single step in a program that tells the computer exactly what to do.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'programmer', 'A person who writes the instructions that make up a program.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabquizid,
    'Python', 'A programming language, a tool for writing instructions in a form a computer can carry out.', 0, 0);

// --- Vocab Breakdown (Content page, single Continue -> Vocab Retry) ---
foxcs_insert_answer($DB, $lessonid, $breakdownid, 'Continue', null, $vocabretryid, 0);

// --- Vocab Retry (Matching): scenario-phrased, not verbatim repeats. Terminal either way. ---
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'Nice, that matches up.', null, LESSON_EOL, 1);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    "That's okay, here's how they line up.", null, LESSON_EOL, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'program', 'The full, ordered list of exact steps that gets a computer from start to a finished result.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'instruction', 'Just one line from that list, telling the computer to do one specific thing.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'programmer', 'The person who sat down and actually wrote all of those steps.', 0, 0);
foxcs_insert_matching_answer($DB, $lessonid, $vocabretryid,
    'Python', 'The specific language this class uses to write those steps down.', 0, 0);

echo "All answers inserted.\n";
echo "Done. cmid=193 lessonid={$lessonid}\n";
