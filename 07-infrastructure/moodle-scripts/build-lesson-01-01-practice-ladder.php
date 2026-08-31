<?php
// build-lesson-01-01-practice-ladder.php
//
// Builds the first real Reinforce/Core/Extend adaptive-practice ladder cluster as a native
// Moodle Lesson activity (mod_lesson), inside FoxCS: Python's Unit 01, for Lesson 01.1
// "What Programs Do". See:
//   - 02-authoring-system/objectives-and-skills-proficiency.md ("Reinforce / Core / Extend
//     Ladder" + "Ladder Density by Course" sections) for the policy this implements.
//   - 02-authoring-system/moodle-lesson-ladder-setup.md for the click-by-click mechanics
//     this script automates instead of doing by hand.
//   - 02-authoring-system/tools/check-lesson-ladder-wiring.php -- run this against the
//     resulting cmid after this script finishes.
//
// Skill targeted: explains_computer_literalness -- "Explains that a computer runs a
// program's instructions exactly as written, without inferring or correcting for what the
// programmer actually meant." Chosen (rather than lesson-schema.md's worked-example
// `uses_print`) because the *actual* live H5P Instruction content at cmid=117 (verified by
// extracting the real .h5p package from this instance's moodledata, contenthash
// 20ff22e23562f920efdcf04f4f5539e84fec5630) teaches "what a program is" and "computers are
// very literal", not print() -- print() isn't introduced until lesson 01.4 in this build.
// This skill is grounded directly in that content's recipe/vending-machine "computers do
// exactly what's written, mistake included" idea (the instruction page's own second Quick
// Check), and is a good ladder candidate per adaptive-practice-model.md's own test ("a
// student might get it wrong in more than one way, where *which* way matters") -- the three
// wrong-answer paths below represent three distinct, real misconceptions (assumes the
// computer infers intent / notices and pauses / auto-corrects), not one generic "wrong".
//
// Ladder shape (pool size Core 1 / Reinforce 2 / Extend 2, the settled 2026-08-31 cap):
//   01.1 Core        -- MultiChoice, vending-machine scenario (the grounding content itself)
//     wrong -> 01.1 Reinforce 1 / right -> 01.1 Extend 1
//   01.1 Reinforce 1 -- MultiChoice, decomposed: ONE instruction, ONE typo, no conditional
//     wrong -> 01.1 Reinforce 2 / right -> exit (LESSON_EOL)
//   01.1 Reinforce 2 -- MultiChoice, further decomposed to a bare true/false claim
//     wrong -> 01.1 Reteach / right -> exit (LESSON_EOL)
//   01.1 Reteach     -- Content page (qtype BRANCHTABLE), brief re-explanation, "your
//     teacher" language, single Continue button -> exit (LESSON_EOL)
//   01.1 Extend 1    -- MultiChoice, richer game-scoring scenario, no restated basics
//     right -> 01.1 Extend 2 / wrong -> exit (LESSON_EOL, a miss on enrichment isn't a gate)
//   01.1 Extend 2    -- MultiChoice, richer boundary-condition scenario, different context
//     either outcome -> exit (LESSON_EOL)
//
// This is the only skill cluster in this lesson (scope: "one full skill-node ladder
// cluster"), so every "exit to next skill's Core" instruction in moodle-lesson-ladder-setup.md
// resolves to LESSON_EOL (end of lesson) instead, since there is no next skill's Core page yet.
//
// Grading / review settings (Jay's explicit 2026-08-31 requirement: server-side saved
// responses, no local file save, and students can review their own past attempt):
//   - custom = 1 (per-answer point scoring). REQUIRED, not cosmetic: Moodle's *simple*
//     scoring mode (custom=0) treats an answer as "correct" via jumpto_is_correct(), which
//     just checks whether the jump target is LATER in the page's physical/linear sequence
//     (mod/lesson/locallib.php ~line 2450). Because this ladder deliberately jumps a WRONG
//     Core answer forward to Reinforce 1 (also physically later than Core), simple scoring
//     would have misclassified that wrong answer as "correct" for grading purposes. Custom
//     scoring makes correctness come from the answer's own explicit `score` value instead
//     (mod/lesson/pagetypes/multichoice.php ~line 182), which is what we actually want.
//   - retake = 0, modattempts = 1: verified directly against mod/lesson/locallib.php and
//     lang/en/lesson.php on this instance, not guessed:
//       - is_in_review_mode() (locallib.php ~line 2957) returns true once a student has a
//         lesson_grades row AND retake=0 -- every later visit shows their recorded path
//         read-only instead of starting a new attempt.
//       - modattempts ("Allow student review", lang string 'modattempts': "If enabled,
//         students can navigate through the lesson again from the start") drives the
//         explicit "Review lesson" link built in locallib.php ~line 3719-3738, which walks
//         the student back through the exact page path they took and shows their own
//         previous answer on each page.
//   - review (lang string 'displayreview', "Provide option to try a question again") = 0.
//     This is a different, same-page no-credit retry-immediately feature, NOT attempt
//     review; left off because it's confusing precisely when wrong-answer jumps don't
//     target "this page" (lesson.php's own help text says so), and our Reinforce lane is
//     already the "try again, but smaller" mechanism.
//   - displayleft = 0. Deliberate: Moodle's Lesson left-hand page menu shows every page's
//     TITLE as a clickable nav link, and our page titles (below) contain the words
//     "Reinforce"/"Extend"/"Reteach" per moodle-lesson-ladder-setup.md's own naming
//     convention (needed so a human -- or this checker script -- can tell pages apart in
//     the jump-target dropdown / DB). That convention is authoring/admin metadata; it must
//     never become a visible student-facing nav element, per
//     objectives-and-skills-proficiency.md's "Reinforce/Core/Extend Is Not Shown to
//     Students" rule. (The page title does still appear in the browser tab's <title> text
//     via mod/lesson/renderer.php's header() -- that's the one place this naming leaks to
//     the student at all, and it's flagged in the build report rather than silently ignored.)
//   - grade = 100, practice = 0: mirrors 01.1 Mastery Check (Quiz) (mdl_quiz id 2, grade=100)
//     so this activity is a normal graded, gradebook-linked activity the same way -- NOT a
//     Moodle "practice lesson" (that mode records zero grades, a different meaning of
//     "practice" than this repo's Reinforce/Core/Extend "Practice" module).
//
// Run: sudo -u www-data php build-lesson-01-01-practice-ladder.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

// mod_lesson constants, hardcoded rather than required from mod/lesson/locallib.php or
// pagetypes/*.php -- same approach check-lesson-ladder-wiring.php takes, to avoid define()
// collisions from partially bootstrapping lesson's own libs outside its normal request flow.
const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2; // Unit 01: What Is Programming? (verified: mdl_course_sections.section=2 for this course)
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
$moduleinfo->name = '01.1 What Programs Do (Practice)';
$moduleinfo->introeditor = [
    'text' => '<p>A few quick questions about what you just learned in 01.1. The questions '
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
echo "Created lesson activity: cmid={$cmid} lessonid={$lessonid} in course {$course->id}, section {$sectionnum}\n";

// ---------------------------------------------------------------------------
// 2. Insert the six pages in order, capturing ids as we go (prevpageid/nextpageid linking).
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
<p>A programmer is writing the program for a vending machine. The price of a bag of chips is supposed to be $1.25, but the programmer accidentally types the price into the program as $12.50 instead.</p>
<p>A customer walks up and inserts exactly $1.25.</p>
<p>Based on how computers actually run instructions, what will the vending machine do?</p>
HTML;

$reinforce1_html = <<<'HTML'
<p>A programmer writes an instruction telling the computer to display the word "Hello!" on the screen. By mistake, they type "Helo!" instead.</p>
<p>The program runs exactly as it was written. What does the computer display?</p>
HTML;

$reinforce2_html = <<<'HTML'
<p><strong>True or False:</strong></p>
<p>A computer can look at an instruction with a small mistake in it, figure out what the programmer really meant, and run that instead.</p>
HTML;

$reteach_html = <<<'HTML'
<h3>Quick Recap: Computers Follow Instructions Exactly</h3>
<p>A computer does not know what you meant to write. It only runs the exact instructions you actually gave it, even when those instructions contain a mistake.</p>
<p>That's why exact, careful instructions matter so much in programming. A small typo doesn't get "fixed" automatically. It becomes part of what the program actually does.</p>
<p>This is one of the trickiest ideas in this unit, and it's completely normal if it still feels fuzzy. Check in with your teacher so you can talk through an example together.</p>
HTML;

$extend1_html = <<<'HTML'
<p>A friend is building a simple scoring system for a game. It's supposed to award 10 points for every coin the player collects. A typo in the program means it only awards 10 points for the very first coin. Every coin after that only adds 1 point.</p>
<p>A player collects 5 coins. The game displays a total score of 14.</p>
<p>Your friend says: "That's obviously a glitch. The game should just know we wanted 50 points, and show that instead."</p>
<p>Is your friend right?</p>
HTML;

$extend2_html = <<<'HTML'
<p>A school's attendance program is supposed to mark a student "Present" if they scan their ID before 8:00 AM, and "Late" at 8:00 AM or after. A typo in the program means it actually checks for "before 8:00 AM" or "after 8:00 AM," leaving out the words "at or."</p>
<p>A student scans in at exactly 8:00:00 AM.</p>
<p>Based on how the program is actually written, what will it record for that student?</p>
HTML;

$coreid       = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Core',        $core_html,       LESSON_PAGE_MULTICHOICE, 0);
$reinforce1id = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Reinforce 1', $reinforce1_html, LESSON_PAGE_MULTICHOICE, $coreid);
$reinforce2id = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Reinforce 2', $reinforce2_html, LESSON_PAGE_MULTICHOICE, $reinforce1id);
$reteachid    = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Reteach',     $reteach_html,    LESSON_PAGE_BRANCHTABLE, $reinforce2id);
$extend1id    = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Extend 1',    $extend1_html,    LESSON_PAGE_MULTICHOICE, $reteachid);
$extend2id    = foxcs_insert_lesson_page($DB, $lessonid, '01.1 Extend 2',    $extend2_html,    LESSON_PAGE_MULTICHOICE, $extend1id);

echo "Pages: Core={$coreid} Reinforce1={$reinforce1id} Reinforce2={$reinforce2id} Reteach={$reteachid} Extend1={$extend1id} Extend2={$extend2id}\n";

// ---------------------------------------------------------------------------
// 3. Insert answers now that every page id is known (resolves forward jumps).
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
    'It will not release the bag of chips. The program checks whether the amount inserted matches $12.50, exactly as written, even though that was a mistake.',
    "That's right. The vending machine only knows the instruction actually written into the program. It compares the customer's $1.25 against $12.50, because that's the price value the programmer typed, mistake included. A computer can't tell the difference between an instruction that's correct and one that has a typo. It just runs what's there.",
    $extend1id, 1);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'It will release the bag of chips, because $1.25 is what the customer actually meant to pay.',
    "<p><strong>What happened:</strong> this answer assumes the machine can tell what the customer, or the programmer, actually meant.</p><p><strong>Why:</strong> it is easy to think a computer will figure out the sensible outcome, the way a person would.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'It will pause and ask the customer to double check the amount before deciding.',
    "<p><strong>What happened:</strong> this answer treats the vending machine like it can notice something looks off and check in.</p><p><strong>Why:</strong> that is a very human response, but a computer does not pause to reconsider unless a programmer specifically wrote an instruction telling it to.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);
foxcs_insert_answer($DB, $lessonid, $coreid,
    'It will automatically correct the typo and charge the customer $1.25 instead.',
    "<p><strong>What happened:</strong> this answer assumes the program can notice and fix its own mistake.</p><p><strong>Why:</strong> that is an appealing idea, but nothing in the program told it to look for typos or correct them.</p><p><strong>Next step:</strong> the next question slows this idea down into a smaller piece.</p>",
    $reinforce1id, 0);

// --- Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'Helo!, spelled exactly the way the programmer typed it.',
    "That's right. The computer displays exactly what the instruction says, typo included. It has no way to know the programmer meant to type an extra letter, it only has the instruction as written.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'Hello!, because that\'s obviously what the programmer meant to type.',
    "<p><strong>What happened:</strong> this answer gives the computer credit for guessing the intended spelling.</p><p><strong>Why:</strong> a person reading \"Helo!\" would probably guess \"Hello!\" too, but a computer does not fill in a likely meaning.</p><p><strong>Next step:</strong> one more look at this same idea, in an even smaller example.</p>",
    $reinforce2id, 0);
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'Nothing. The computer will notice the misspelling and stop running.',
    "<p><strong>What happened:</strong> this answer assumes a typo will stop the program on its own.</p><p><strong>Why:</strong> a misspelled word inside quotation marks is not a broken instruction to the computer, it is just text to display, so there is nothing for the computer to flag as a problem.</p><p><strong>Next step:</strong> one more look at this idea, in an even smaller example.</p>",
    $reinforce2id, 0);
foxcs_insert_answer($DB, $lessonid, $reinforce1id,
    'An error message telling the programmer to check their spelling.',
    "<p><strong>What happened:</strong> this answer expects the computer to flag the spelling itself.</p><p><strong>Why:</strong> a computer only checks for the specific kinds of mistakes it has been built to catch, and a misspelled word inside quotes is not one of them.</p><p><strong>Next step:</strong> one more look at this idea, in an even smaller example.</p>",
    $reinforce2id, 0);

// --- Reinforce 2 ---
foxcs_insert_answer($DB, $lessonid, $reinforce2id,
    'False. The computer only runs the instructions exactly as written. It has no way to guess what someone meant.',
    "That's right. A computer can't read intentions, it can only read the exact instructions it's given. That's the same idea behind both examples you just worked through.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $reinforce2id,
    'True. The computer can tell what someone meant and use that instead.',
    "<p><strong>What happened:</strong> this says the computer can read the intent behind an instruction.</p><p><strong>Why:</strong> this is one of the trickiest ideas in this unit. Computers can feel like they \"understand\" us sometimes, especially with things like autocorrect or a voice assistant doing some of that guessing behind the scenes. A program you write yourself does not have any of that built in unless you add it.</p><p><strong>Next step:</strong> check in with your teacher so you can talk through an example together.</p>",
    $reteachid, 0);

// --- Reteach (Content page: one "Continue" button, no scoring) ---
foxcs_insert_answer($DB, $lessonid, $reteachid, 'Continue', null, LESSON_EOL, 0);

// --- Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $extend1id,
    "No. The game will always total the score based on exactly what the program's instructions say, even though that's not what your friend intended.",
    'Exactly. The 14 is not a mysterious glitch, it is the direct result of the actual instructions: 10 points for the first coin, 1 point for each of the next four (10 + 1 + 1 + 1 + 1 = 14). The game cannot display the "intended" score of 50, because nothing in the program says how to calculate that. Fixing this means rewriting the actual instruction, not waiting for the game to notice.',
    $extend2id, 1);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'Yes, obvious mistakes like this usually get corrected automatically by the game engine.',
    'A game engine runs the instructions it is given, the same as any other program. It does not scan for outcomes that look "obviously wrong" and swap in a different one. Look again at how the 14 actually got calculated from the instruction your friend wrote.',
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    'No, because the game will refuse to run at all once an error like this happens.',
    "This instruction isn't broken in a way the computer can detect. It runs just fine, it just doesn't do what your friend intended. That's different from an instruction with a piece missing, which would actually stop the program. Look again at how the 14 actually got calculated.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend1id,
    "Yes, the player's intent should override the programmer's mistake once the pattern is clear.",
    "Nothing in this program is watching for the player's intent. It's just following the point-awarding instruction it was given, coin by coin. Look again at how the 14 actually got calculated from that instruction.",
    LESSON_EOL, 0);

// --- Extend 2 ---
foxcs_insert_answer($DB, $lessonid, $extend2id,
    'Neither "Present" nor "Late." 8:00 AM exactly doesn\'t match "before 8:00 AM" or "after 8:00 AM," so neither instruction\'s condition is true.',
    "Right. The typo left a gap right at exactly 8:00:00, and the program only checks the two conditions it was actually given. Neither one is true at that exact moment, so there's no instruction telling it what to record. This kind of edge case, a value sitting exactly on a boundary, is exactly the sort of thing a typo like this can quietly break.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $extend2id,
    "Present, since that's obviously closer to what the school intended.",
    'The program does not compare options and pick the one that seems closest to what someone intended. It checks the exact conditions it was given, one at a time. Walk through the two written conditions again at exactly 8:00:00 AM.',
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend2id,
    'Late, because the system rounds up to the nearest recorded status to be safe.',
    'Nothing here rounds a result when a value does not match. That is not a step this program was ever given. Walk through the two written conditions again at exactly 8:00:00 AM.',
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $extend2id,
    'The program stops running and asks a teacher to decide.',
    'A gap in what a program\'s conditions cover does not make the program stop. It just means neither condition happens to be true this time, and nothing gets recorded. Walk through the two written conditions again at exactly 8:00:00 AM.',
    LESSON_EOL, 0);

echo "Answers inserted for all 6 pages.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
