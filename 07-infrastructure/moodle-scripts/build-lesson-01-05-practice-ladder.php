<?php
// build-lesson-01-05-practice-ladder.php
//
// Builds Lesson 01.5's (Comments and Documentation) Reinforce/Core/Extend Practice
// ladder as a native Moodle Lesson activity, following build-lesson-01-04-practice-
// ladder.php's exact mechanism/settings. THREE skill clusters, one per real stated
// objective in 01_instruction.html:
//   1. "I can predict which lines of a program run, when some lines are comments."
//      -> cluster 01.5a: predicts_comment_execution
//   2. "I can write a comment that explains why a line of code exists, not just
//      what it does." -> cluster 01.5b: distinguishes_weak_vs_strong_comments
//      (framed as multichoice recognition, since the ladder format is multichoice --
//      the actual WRITING of a comment is what the Coding Exercise and Mastery
//      Check's open-response items test instead)
//   3. Language objective: "I can explain the difference between code and a comment
//      using the terms comment and documentation." -> cluster 01.5c: describes_comment_vocab
//
// Every snippet across all three clusters is deliberately distinct from every other
// one already used in this lesson:
//   - Instruction tabs:         "# Show the score" -> score=0 example; commenting-out welcome/ready example
//   - Instruction Quick Checks: two-comment/two-print Hero/Ready example; identify-the-commented-line example
//   - Mastery Check:            Level 5 / Level 6 (not unlocked) / Keep going! example
//   - Practice (this script):   all new variants below
//
// Pool size: Core 1 / Reinforce 1 / Extend 1 per cluster.
//
// Run check-lesson-ladder-wiring.php --cmid=<this cmid> --pool-cap=2 after this.
//
// Run: sudo -u www-data php build-lesson-01-05-practice-ladder.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = $DB->get_field('course_modules', 'section', ['id' => 213]); // 01.4 Practice's live section

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
$moduleinfo->name = '01.5 Practice';
$moduleinfo->introeditor = [
    'text' => '<p>A few quick questions about what you just learned in 01.5. The questions '
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
// Cluster 01.5a: predicts_comment_execution (Objective 1)
// ===========================================================================
$a_core_html = '<p>What does this display?</p><pre># Set up the round
print("Round 1")
# print("Round 1 - test mode")
print("Fight!")</pre>';
$a_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.5a Core', $a_core_html, LESSON_PAGE_MULTICHOICE, 0);

$a_reinforce_html = '<p>What does this display?</p><pre># print("Loading...")
print("Ready")</pre>';
$a_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.5a Reinforce 1', $a_reinforce_html, LESSON_PAGE_MULTICHOICE, $a_coreid);

$a_extend_html = '<p>What does this display, line by line?</p><pre>print("Checkpoint reached")
# Save progress here later
# print("Autosave complete")
print("Continue playing")
# print("Debug: checkpoint id=4")</pre>';
$a_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.5a Extend 1', $a_extend_html, LESSON_PAGE_MULTICHOICE, $a_reinforceid);

// ===========================================================================
// Cluster 01.5b: distinguishes_weak_vs_strong_comments (Objective 2)
// ===========================================================================
$b_core_html = '<p>Which comment explains WHY this line exists, not just what it does?</p><pre>print(health)</pre>';
$b_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.5b Core', $b_core_html, LESSON_PAGE_MULTICHOICE, $a_extendid);

$b_reinforce_html = '<p>Which of these is a WEAK comment, one that just restates the code?</p><pre>print(lives)</pre>';
$b_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.5b Reinforce 1', $b_reinforce_html, LESSON_PAGE_MULTICHOICE, $b_coreid);

$b_extend_html = '<p>A teammate wrote this comment above a line that resets a player\'s inventory: <code># reset the inventory</code>. What\'s the best reason to rewrite it, and what should it explain instead?</p>';
$b_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.5b Extend 1', $b_extend_html, LESSON_PAGE_MULTICHOICE, $b_reinforceid);

// ===========================================================================
// Cluster 01.5c: describes_comment_vocab (Language Objective)
// ===========================================================================
$c_core_html = '<p>What do you call a line that starts with # and that Python skips when it runs the program?</p>';
$c_coreid = foxcs_insert_lesson_page($DB, $lessonid, '01.5c Core', $c_core_html, LESSON_PAGE_MULTICHOICE, $b_extendid);

$c_reinforce_html = '<p>A well-commented file that clearly explains what it does and why is described as being well what?</p>';
$c_reinforceid = foxcs_insert_lesson_page($DB, $lessonid, '01.5c Reinforce 1', $c_reinforce_html, LESSON_PAGE_MULTICHOICE, $c_coreid);

$c_extend_html = '<p>You put a # in front of a working <code>print()</code> line to temporarily stop it from running, planning to remove the # again later. What is this specific action called?</p>';
$c_extendid = foxcs_insert_lesson_page($DB, $lessonid, '01.5c Extend 1', $c_extend_html, LESSON_PAGE_MULTICHOICE, $c_reinforceid);

echo "Pages: A(core={$a_coreid} reinforce={$a_reinforceid} extend={$a_extendid}) "
   . "B(core={$b_coreid} reinforce={$b_reinforceid} extend={$b_extendid}) "
   . "C(core={$c_coreid} reinforce={$c_reinforceid} extend={$c_extendid})\n";

// ---------------------------------------------------------------------------
// Answers.
// ---------------------------------------------------------------------------

// --- 01.5a Core ---
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'Round 1, then on the next line, Fight!',
    "Right! The commented-out print(\"Round 1 - test mode\") never runs. The comment above the first line never displays either.",
    $a_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'Round 1, then Round 1 - test mode, then Fight!',
    "Look at the line print(\"Round 1 - test mode\") is on -- it starts with #, so Python skips it entirely.",
    $a_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'Set up the round, Round 1, Fight!',
    "\"Set up the round\" is a comment, not a print() statement. Comments produce no output at all.",
    $a_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $a_coreid,
    'Just Fight!',
    "The first print() statement (print(\"Round 1\")) has no # in front of it, so it runs too.",
    $a_reinforceid, 0);

// --- 01.5a Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'Just Ready',
    "Right! The first line is commented out, so only print(\"Ready\") actually runs.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'Loading..., then Ready',
    "The first line starts with #, which means Python skips it. Only the second line runs.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'Nothing displays',
    "The second line, print(\"Ready\"), has no # in front of it. It's real code and it runs.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_reinforceid,
    'An error',
    "This code is valid Python. A commented-out line doesn't cause an error, it's just skipped.",
    LESSON_EOL, 0);

// --- 01.5a Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Checkpoint reached, then on the next line, Continue playing',
    "Exactly. Only the two lines with no # in front of them run, in the order they appear.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'All five lines display, in order',
    "Three of these five lines start with #, which means Python skips them. Only two are real print() statements.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Checkpoint reached, Autosave complete, Continue playing',
    "Autosave complete comes from a commented-out print() line (it starts with #), so it never actually runs.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $a_extendid,
    'Continue playing, then Checkpoint reached',
    "Python runs top to bottom. Checkpoint reached is the first real print() statement, so it displays first.",
    LESSON_EOL, 0);

// --- 01.5b Core ---
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    '# subtract fall damage before the next frame renders',
    "Right! This tells you WHY the line exists (a specific game-logic reason), not just what print(health) obviously already shows.",
    $b_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    '# print the health',
    "This just restates what the code already shows. It doesn't add any new information.",
    $b_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    '# this is a print statement',
    "This describes what kind of line it is, which is already obvious from reading the code. It doesn't explain why.",
    $b_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $b_coreid,
    '# health',
    "This just repeats the variable name. It gives no new context about why this line exists.",
    $b_reinforceid, 0);

// --- 01.5b Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    '# print the lives',
    "Right! This just restates what print(lives) already shows -- it adds nothing new.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    '# warn the player they are down to their last life',
    "This explains a real reason the line might exist. That makes it a strong comment, not a weak one.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    '# shown after every round, per the design doc',
    "This adds context the code doesn't already show. That's a strong comment, not a weak one.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_reinforceid,
    '# tells the player how many tries they have left',
    "This explains the purpose behind the line. That makes it a strong comment, not a weak one.",
    LESSON_EOL, 0);

// --- 01.5b Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'It just restates the code; it should explain when or why the reset happens, like after a game over',
    "Exactly. \"reset the inventory\" adds nothing a reader can't already see from the line itself. A strong version names the real trigger or reason.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'It\'s too short; comments need to be at least one full sentence',
    "Length isn't the real issue. A short comment that explains WHY can still be strong; a long one that just restates the code is still weak.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'It should be deleted, since Python ignores comments anyway',
    "Python ignoring a comment doesn't mean it's useless. Comments exist for the humans reading the code, not for Python.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $b_extendid,
    'Nothing, this comment is already strong',
    "This comment just repeats what the line already shows (it resets the inventory). It doesn't say why or when that happens.",
    LESSON_EOL, 0);

// --- 01.5c Core ---
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'A comment',
    "Right! That's exactly what a comment is: a line Python ignores, meant for human readers.",
    $c_extendid, 1);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'Documentation',
    "Close -- a comment IS a form of documentation, but there's a more specific term for a single # line itself.",
    $c_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'A SyntaxError',
    "A commented-out line doesn't cause any error at all. Python just skips it.",
    $c_reinforceid, 0);
foxcs_insert_answer($DB, $lessonid, $c_coreid,
    'An argument',
    "An argument is a value passed into a function, like the text inside print()'s parentheses. That's not what this describes.",
    $c_reinforceid, 0);

// --- 01.5c Reinforce 1 ---
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'Documented',
    "Right! Documentation is the broader idea of written explanation. Comments are the simplest form of it.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'Commented out',
    "Commenting out specifically means disabling real code with a #. A file full of explanatory notes is described differently.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'Debugged',
    "Debugging means finding and fixing errors. That's not the same as explaining what code does and why.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_reinforceid,
    'Formatted',
    "Formatting is about how code looks (spacing, indentation), not about written explanations.",
    LESSON_EOL, 0);

// --- 01.5c Extend 1 ---
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'Commenting out',
    "Exactly. Commenting out is specifically using # to disable real, working code temporarily, without deleting it.",
    LESSON_EOL, 1);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'Documenting',
    "Documenting is writing explanations of what code does and why. Disabling a line temporarily is a more specific action than that.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'Debugging',
    "Debugging is the broader process of finding and fixing problems. Temporarily disabling one line with # has its own specific name.",
    LESSON_EOL, 0);
foxcs_insert_answer($DB, $lessonid, $c_extendid,
    'Deleting',
    "Deleting removes the line permanently. This action keeps the line in the file, just disabled -- that's a different, specific thing.",
    LESSON_EOL, 0);

echo "All answers inserted.\n";
echo "Done. cmid={$cmid} lessonid={$lessonid}\n";
