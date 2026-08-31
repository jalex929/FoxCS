<?php
// Seminar III, Lesson 1: real Reinforce/Core/Extend adaptive ladder for the
// Order of Operations skill, built as a native Moodle Lesson activity
// (mod_lesson), per 02-authoring-system/objectives-and-skills-proficiency.md's
// "Reinforce / Core / Extend Ladder" section and moodle-lesson-ladder-setup.md's
// click-by-click mechanics.
//
// WHY THIS SKILL, THIS LESSON: "1.3 -- Order of Operations Practice" (the
// existing H5P activity, built by build_ooo_practice.py) is a fixed 5-question
// difficulty progression -- explicitly flagged in courses/seminar-iii/CLAUDE.md
// ("Content Redesign, Lesson 1") as NOT real adaptive branching, with "building
// a real mod_lesson-based adaptive version of this practice" named directly as
// the next real task. This script is that task. Order of Operations is also a
// skill that predictably splits students into "has it," "needs a smaller step"
// (loses the thread partway through a multi-operation expression), and "ready
// for more" (can apply the same rule in a word-problem/expression context) --
// exactly the case objectives-and-skills-proficiency.md's "Ladder Density by
// Course" section calls out as the kind of Seminar III skill check that
// actually warrants a cluster (Seminar III is 0-1 clusters/lesson, selective,
// not every lesson).
//
// SCOPE: ONE skill, ONE cluster: Core 1, Reinforce 2, Extend 2 (within the
// repo's Core 1 / Reinforce 1-2 / Extend 1-2 pool-size cap). Reinforce items
// decompose the Core expression into smaller, already-partially-solved steps
// (real intervention, not just easier numbers). Extend items keep the same
// order-of-operations mechanics but apply them inside a word-problem context
// Core didn't have, without re-explaining the rule itself (per the "Extend
// means richer context, not more scaffolding" rule).
//
// Never shows "Reinforce"/"Core"/"Extend" to students: multichoice pages
// (Core/Reinforce/Extend) never render their page `title` to students at all
// (confirmed by reading mod/lesson/pagetypes/multichoice.php's display() --
// unlike branchtable pages, it never touches $this->properties->title), so
// those lane-named titles are authoring-only labels for the Lesson editor's
// jump-target dropdown, per moodle-lesson-ladder-setup.md's own naming
// convention. Branchtable (content) pages DO render their title as a heading
// (confirmed in pagetypes/branchtable.php's display()), so the Reteach page's
// title still needs a plain, non-clinical, but checker-matchable ending
// ("... Reteach") -- see the checker note below.
//
// SCORING: lesson->custom = 1, with each answer's `score` (1 correct / 0
// wrong) as the sole correctness signal. This is a deliberate departure from
// mod_lesson's non-custom default, which infers "correct" purely from whether
// jumpto lands on a page *physically later* in the page sequence
// (jumpto_is_correct() in locallib.php) -- unusable here, since Reinforce and
// Extend pages both sit physically after Core, so a naive forward-jump check
// cannot tell "needed help" from "got it and moved on." Custom scoring
// decouples correctness from jump target entirely, matching this ladder's
// actual intent.
//
// STUDENT REVIEW / SERVER-SIDE SAVE (Jay's explicit requirement this session):
// mod_lesson always records every answer server-side in lesson_attempts (never
// a local/browser save) -- confirmed against this instance's real schema
// (lesson_attempts: userid, pageid, answerid, useranswer, retry, timeseen).
// modattempts is set to 1 here ("Allow student review" in the mod_form; its
// real column-level doc-comment in locallib.php literally reads "Toggle to
// allow the user to go back and review answers") specifically so a student
// can walk back through their own past attempt and see what they answered,
// not just get a fresh blank attempt. retake stays at its column default (1,
// allow multiple attempts) so "review" has something to review. This is a
// different mechanism from mod_lesson's teacher-only class report
// (report.php hard-requires mod/lesson:viewreports) -- modattempts is the
// student-facing equivalent, confirmed by reading the real source, not
// assumed from the settings label alone.
//
// GRADEBOOK: standard create_module() grade wiring (grade=10 points),
// verified after creation against mdl_grade_items directly, same as this
// lesson's own checklist requires -- see the verification block in this
// file's companion inspection scripts, not repeated here.
//
// NAMING / PLACEMENT (per Jay's direct correction mid-build): every sibling
// activity in this course's Section 2 ("Lesson 1: Academic Problem-Solving")
// uses the exact "N.M -- Title" convention (double hyphen, spaces). Live
// current numbering in that section runs 1.1 through 1.9 (verified against
// real timemodified timestamps in mdl_h5pactivity -- 1.1-1.9 are all
// 2026-08-31; an older 1.12-1.15 generation from 2026-08-30 sits hidden in
// the section's module sequence, superseded by the 1.1-1.9 consolidation
// described in worklog.md, not a currently-live numbering to avoid colliding
// with). This lesson is built as "1.10 -- Order of Operations: Extra
// Practice" and positioned immediately after "1.3 -- Order of Operations
// Practice" (cmid 157) in the section's module sequence -- a positional
// insert, not a renumbering of any existing sibling.
//
// Run: sudo -u www-data php build_ooo_adaptive_ladder.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/mod/lesson/locallib.php');
require_once($CFG->dirroot . '/mod/lesson/pagetypes/multichoice.php');
require_once($CFG->dirroot . '/mod/lesson/pagetypes/branchtable.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 2], '*', MUST_EXIST);
echo "Target section: {$section->section} ({$course->fullname})\n";

// ---------------------------------------------------------------------
// 1. Create the Lesson activity shell.
// ---------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'lesson';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'lesson']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2;
$moduleinfo->visible = 0; // matches every current sibling in this still-hidden section
$moduleinfo->name = '1.10 -- Order of Operations: Extra Practice';
$moduleinfo->introeditor = [
    'text' => '<p>A short check on order of operations, the skill from 1.3. Answer each question as best you can.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->custom = 1;          // per-answer score decides correctness, not jump direction (see header note)
$moduleinfo->retake = 1;          // allow multiple attempts
$moduleinfo->modattempts = 1;     // "Allow student review" -- students can walk back through a past attempt
$moduleinfo->review = 0;          // no in-place retry prompt; wrong answers are already routed by an explicit jump
$moduleinfo->ongoing = 0;
$moduleinfo->practice = 0;        // real graded activity, appears in the gradebook
$moduleinfo->usemaxgrade = 0;     // mean of attempts if retaken
$moduleinfo->maxanswers = 4;
$moduleinfo->maxattempts = 5;
$moduleinfo->minquestions = 0;
$moduleinfo->maxpages = 0;
$moduleinfo->nextpagedefault = 0;
$moduleinfo->feedback = 1;
$moduleinfo->timelimit = 0;
$moduleinfo->timespent = 0;
$moduleinfo->completed = 0;
$moduleinfo->gradebetterthan = 0;
$moduleinfo->width = 640;
$moduleinfo->height = 480;
$moduleinfo->bgcolor = '#FFFFFF';
$moduleinfo->mediafile = 0;
$moduleinfo->mediaheight = 100;
$moduleinfo->mediawidth = 650;
$moduleinfo->mediaclose = 0;
$moduleinfo->slideshow = 0;
$moduleinfo->displayleft = 0;
$moduleinfo->displayleftif = 0;
$moduleinfo->progressbar = 0;
$moduleinfo->available = 0;
$moduleinfo->deadline = 0;
$moduleinfo->usepassword = 0;
$moduleinfo->password = '';
$moduleinfo->dependency = 0;
$moduleinfo->activitylink = 0;
$moduleinfo->allowofflineattempts = 0;
$moduleinfo->grade = 10;

$result = create_module($moduleinfo);
$lessonrecord = $DB->get_record('lesson', ['id' => $result->instance], '*', MUST_EXIST);
$cmid = $result->coursemodule;
echo "Created lesson cmid={$cmid} lessonid={$lessonrecord->id}\n";

$context = context_module::instance($cmid);
$lesson = new lesson($lessonrecord);

// ---------------------------------------------------------------------
// 2. Create pages. Every jump is written as a placeholder (LESSON_THISPAGE)
//    on this first pass, then resolved to real page ids/EOL in pass 2 below
//    -- pages need to exist before we can point at their real ids, and
//    several answers point at pages created later in this list.
// ---------------------------------------------------------------------
function ooo_mc_page($lesson, $context, $prevpageid, $title, $questionhtml, $answers) {
    // $answers: list of ['text' => ..., 'correct' => bool, 'response' => ...]
    $properties = new stdClass();
    $properties->title = $title;
    $properties->contents_editor = ['text' => $questionhtml, 'format' => FORMAT_HTML];
    $properties->qtype = LESSON_PAGE_MULTICHOICE;
    $properties->qoption = 0;
    $properties->layout = 1;
    $properties->display = 1;
    $properties->pageid = $prevpageid;

    $properties->answer_editor = [];
    $properties->response_editor = [];
    $properties->jumpto = [];
    $properties->score = [];
    foreach (array_values($answers) as $i => $a) {
        $properties->answer_editor[$i] = ['text' => '<div>' . $a['text'] . '</div>', 'format' => FORMAT_HTML];
        $properties->response_editor[$i] = ['text' => '<p>' . $a['response'] . '</p>', 'format' => FORMAT_HTML];
        $properties->jumpto[$i] = LESSON_THISPAGE; // placeholder
        $properties->score[$i] = $a['correct'] ? 1 : 0;
    }

    $page = lesson_page_type_multichoice::create($properties, $lesson, $context, 0);
    return $page->id;
}

function ooo_content_page($lesson, $context, $prevpageid, $title, $bodyhtml, $buttontext) {
    $properties = new stdClass();
    $properties->title = $title;
    $properties->contents_editor = ['text' => $bodyhtml, 'format' => FORMAT_HTML];
    $properties->qtype = LESSON_PAGE_BRANCHTABLE;
    $properties->qoption = 0;
    $properties->layout = 0;
    $properties->display = 1;
    $properties->pageid = $prevpageid;

    $properties->answer_editor = [0 => $buttontext]; // plain string: branch tables take a text-only answer
    $properties->jumpto = [0 => LESSON_THISPAGE]; // placeholder

    $page = lesson_page_type_branchtable::create($properties, $lesson, $context, 0);
    return $page->id;
}

$prev = 0;

$introid = ooo_content_page($lesson, $context, $prev,
    'Order of Operations: Quick Check',
    '<p>This is a short check on order of operations, the same skill from today\'s practice. '
    . 'Work through the questions one at a time. They will adjust a little based on how you\'re doing, '
    . 'so just do your best on each one.</p>',
    'Start');
$prev = $introid;

$coreid = ooo_mc_page($lesson, $context, $prev, '1.10 Core',
    '<p>Evaluate: 4 + 3 &times; (8 &minus; 5)<sup>2</sup></p>',
    [
        ['text' => '31', 'correct' => true,
         'response' => 'Right! Parentheses first: 8 &minus; 5 = 3. Then the exponent: 3&sup2; = 9. Then multiply: 3 &times; 9 = 27. Then add: 4 + 27 = 31.'],
        ['text' => '13', 'correct' => false,
         'response' => 'This is what you\'d get by skipping the exponent step, using 3 instead of 3&sup2;. Check whether every operation got its turn.'],
        ['text' => '63', 'correct' => false,
         'response' => 'This is what you\'d get by adding 4 and 3 before handling the parentheses and exponent. Parentheses and exponents always come before addition.'],
    ]);
$prev = $coreid;

$reinforce1id = ooo_mc_page($lesson, $context, $prev, '1.10 Reinforce 1',
    '<p>What is (8 &minus; 5)<sup>2</sup>?</p>',
    [
        ['text' => '9', 'correct' => true,
         'response' => 'Right! 8 &minus; 5 = 3, and 3&sup2; = 9.'],
        ['text' => '6', 'correct' => false,
         'response' => 'This is what you\'d get by forgetting to square the result. Once you get 3 from the subtraction, square it before moving on.'],
        ['text' => '39', 'correct' => false,
         'response' => 'This looks like 8&sup2; &minus; 5&sup2; instead. Do the subtraction inside the parentheses first, then square that result.'],
    ]);
$prev = $reinforce1id;

$reinforce2id = ooo_mc_page($lesson, $context, $prev, '1.10 Reinforce 2',
    '<p>You\'ve found that (8 &minus; 5)<sup>2</sup> = 9. What is 4 + 3 &times; 9?</p>',
    [
        ['text' => '31', 'correct' => true,
         'response' => 'Right! Multiply first: 3 &times; 9 = 27. Then add: 4 + 27 = 31.'],
        ['text' => '63', 'correct' => false,
         'response' => 'This is what you\'d get by adding 4 and 3 first. Multiplication happens before addition, even though the addition is written first.'],
        ['text' => '27', 'correct' => false,
         'response' => 'This stops after the multiplication step. There\'s one more step: add the 4.'],
    ]);
$prev = $reinforce2id;

$extend1id = ooo_mc_page($lesson, $context, $prev, '1.10 Extend 1',
    '<p>A gym charges a $15 sign-up fee, plus $2 per fitness class, minus an $8 one-time discount for referring a friend. '
    . 'Using the expression 15 + 2 &times; c &minus; 8, what is the total cost for a member who takes c = 6 classes?</p>',
    [
        ['text' => '$19', 'correct' => true,
         'response' => 'Right! 2 &times; 6 = 12 first. Then 15 + 12 &minus; 8 = 19.'],
        ['text' => '$94', 'correct' => false,
         'response' => 'This comes from working strictly left to right (15 + 2 = 17, &times; 6 = 102, &minus; 8 = 94) instead of multiplying first.'],
        ['text' => '$15', 'correct' => false,
         'response' => 'This treats "2 &times; c" as "2 + c" instead of multiplying the per-class rate by the number of classes.'],
    ]);
$prev = $extend1id;

$extend2id = ooo_mc_page($lesson, $context, $prev, '1.10 Extend 2',
    '<p>A cell phone plan costs $20 per month, plus $0.05 per text over the free limit, minus a $5 loyalty credit. '
    . 'Using the expression 20 + 0.05 &times; (t &minus; 200) &minus; 5, what is the bill for a customer who sent t = 240 texts?</p>',
    [
        ['text' => '$17', 'correct' => true,
         'response' => 'Right! Parentheses first: 240 &minus; 200 = 40. Then multiply: 0.05 &times; 40 = 2. Then combine in order: 20 + 2 = 22, and 22 &minus; 5 = 17.'],
        ['text' => '$22', 'correct' => false,
         'response' => 'This is what you\'d get by forgetting the last step, subtracting the $5 loyalty credit.'],
        ['text' => '$797', 'correct' => false,
         'response' => 'This comes from multiplying 0.05 by everything before the parentheses too, instead of only by (t &minus; 200).'],
    ]);
$prev = $extend2id;

$reteachid = ooo_content_page($lesson, $context, $prev,
    'Time to Reteach',
    '<p>Order of operations always follows the same sequence: parentheses first, then exponents, '
    . 'then multiplication and division (left to right), then addition and subtraction (left to right). '
    . 'It can help to rewrite the problem one step at a time instead of solving it all at once.</p>'
    . '<p>Take these questions to your teacher so you can talk through them together. '
    . 'That\'s a normal, useful part of learning this skill, not a setback.</p>',
    'Finish');
$prev = $reteachid;

$closingid = ooo_content_page($lesson, $context, $prev,
    'Nice Work',
    '<p>Nice work working through that. Order of operations comes up again later this year, '
    . 'so the practice you just did will help.</p>',
    'Finish');
$prev = $closingid;

echo "Pages created: intro={$introid} core={$coreid} reinforce1={$reinforce1id} reinforce2={$reinforce2id} "
    . "extend1={$extend1id} extend2={$extend2id} reteach={$reteachid} closing={$closingid}\n";

// ---------------------------------------------------------------------
// 3. Pass 2: resolve real jump targets.
// ---------------------------------------------------------------------
function ooo_set_jumps($DB, $pageid, $jumptargets) {
    // $jumptargets: list of jumpto values, in the same order the answers
    // were created (answer ids come back in insertion order from
    // get_records() sorted by id, which matches insertion order here).
    $answers = $DB->get_records('lesson_answers', ['pageid' => $pageid], 'id ASC');
    $answers = array_values($answers);
    foreach ($jumptargets as $i => $jumpto) {
        if (!isset($answers[$i])) {
            throw new \moodle_exception('Answer index ' . $i . ' not found for page ' . $pageid);
        }
        $DB->set_field('lesson_answers', 'jumpto', $jumpto, ['id' => $answers[$i]->id]);
    }
}

// Intro: single "Start" button -> Core.
ooo_set_jumps($DB, $introid, [$coreid]);

// Core: correct -> Extend 1, both wrong answers -> Reinforce 1.
ooo_set_jumps($DB, $coreid, [$extend1id, $reinforce1id, $reinforce1id]);

// Reinforce 1: correct -> Closing (shown they've got it with support),
// both wrong answers -> Reinforce 2 (stay in-lane, sticky).
ooo_set_jumps($DB, $reinforce1id, [$closingid, $reinforce2id, $reinforce2id]);

// Reinforce 2 (last item in the Reinforce pool): correct -> Closing,
// both wrong answers -> Reteach (real exit, not a third auto-served item).
ooo_set_jumps($DB, $reinforce2id, [$closingid, $reteachid, $reteachid]);

// Extend 1: correct -> Extend 2 (sticky), a miss on enrichment isn't a
// gate, so both wrong answers -> Closing directly.
ooo_set_jumps($DB, $extend1id, [$extend2id, $closingid, $closingid]);

// Extend 2 (last item in the Extend pool): either outcome -> Closing.
ooo_set_jumps($DB, $extend2id, [$closingid, $closingid, $closingid]);

// Reteach: "Finish" -> end of lesson.
ooo_set_jumps($DB, $reteachid, [LESSON_EOL]);

// Closing: "Finish" -> end of lesson.
ooo_set_jumps($DB, $closingid, [LESSON_EOL]);

echo "Jumps wired.\n";

// ---------------------------------------------------------------------
// 4. Position the new activity right after "1.3 -- Order of Operations
//    Practice" (cmid 157) in the section's module sequence, without
//    renumbering any existing sibling.
// ---------------------------------------------------------------------
$currentseq = explode(',', $section->sequence);
$currentseq = array_filter($currentseq, fn($id) => (int) $id !== (int) $cmid); // just in case create_module already appended it
$insertafter = array_search('157', $currentseq, true);
if ($insertafter === false) {
    echo "WARNING: cmid 157 not found in section sequence, appending new activity at the end instead.\n";
    $currentseq[] = $cmid;
} else {
    array_splice($currentseq, $insertafter + 1, 0, [$cmid]);
}
$newseq = implode(',', $currentseq);
$DB->set_field('course_sections', 'sequence', $newseq, ['id' => $section->id]);
rebuild_course_cache($course->id, true);

echo "New section sequence: {$newseq}\n";
echo "DONE. cmid={$cmid} lessonid={$lessonrecord->id}\n";
