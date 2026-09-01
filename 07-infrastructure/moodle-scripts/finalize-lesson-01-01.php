<?php
// finalize-lesson-01-01.php
//
// Applies Jay's 2026-08-31 finalization pass for Lesson 01.1, after the tabbed
// Instruction rebuild (cmid=193) and its own labeling/completion pass:
//   1. Deletes truly obsolete modules: cmid=98 (old MVP static "01.1" resource,
//      superseded by cmid=193) and cmid=117 (old H5P Instruction book,
//      superseded twice over -- first by the 7-page linear pilot, now by the
//      tabbed rebuild). Both verified hidden with zero real attempts before
//      this script was written. NOT touching cmid=91 (Unit 01 Overview) or
//      99-103 (01.2-01.6 MVP placeholders) -- those aren't yet superseded by
//      real content and stay as-is.
//   2. Reorders Unit 01's section sequence so real 01.1 content displays in
//      completion order: Instruction -> Practice -> Project materials ->
//      Mastery Check, with the still-needed 01.2-01.6 placeholders after.
//   3. Makes Mastery Check (cmid=114) visible (was hidden).
//   4. Sets completion tracking requiring students to actually reach the end
//      of Instruction and Practice (completionendreached=1), keeping
//      Instruction's existing completionpassgrade=1 (50%) as an additional
//      real-performance signal.
//   5. Sets a due date of 2026-09-01 15:30 America/Chicago (unix 1788294600)
//      on Instruction, Practice, and Mastery Check.
//   6. Rewrites the Mastery Check's intro with a real pre-attempt warning
//      (scored attempt, don't start until ready, complete Practice/Project
//      first) and rebuilds its question order with a new REQUIRED first
//      question: a short-answer academic-integrity acknowledgment (maxmark=0,
//      doesn't dilute the 4 real essay questions' average), ahead of the 4
//      existing essay questions (ids 17-20, untouched, just reordered after).
//
// Run: sudo -u www-data php finalize-lesson-01-01.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 2], '*', MUST_EXIST);

// ---------------------------------------------------------------------------
// 1. Delete obsolete modules.
// ---------------------------------------------------------------------------
foreach ([98, 117] as $obsoletecmid) {
    if ($DB->record_exists('course_modules', ['id' => $obsoletecmid])) {
        course_delete_module($obsoletecmid);
        echo "Deleted obsolete cmid={$obsoletecmid}\n";
    } else {
        echo "cmid={$obsoletecmid} already gone, skipping\n";
    }
}

// ---------------------------------------------------------------------------
// 2. Reorder the section sequence.
// ---------------------------------------------------------------------------
$neworder = '91,193,188,92,93,114,99,100,101,102,103';
$DB->set_field('course_sections', 'sequence', $neworder, ['id' => $section->id]);
echo "Section sequence set to: {$neworder}\n";

// ---------------------------------------------------------------------------
// 3. Make Mastery Check visible.
// ---------------------------------------------------------------------------
$DB->set_field('course_modules', 'visible', 1, ['id' => 114]);
echo "cmid=114 (Mastery Check) set visible.\n";

// ---------------------------------------------------------------------------
// 4. Completion tracking: must reach end (+ keep Instruction's passgrade).
// ---------------------------------------------------------------------------
foreach ([193, 188] as $lessoncmid) {
    $cm = $DB->get_record('course_modules', ['id' => $lessoncmid], '*', MUST_EXIST);
    $DB->set_field('course_modules', 'completion', 2, ['id' => $lessoncmid]);
    $DB->set_field('lesson', 'completionendreached', 1, ['id' => $cm->instance]);
    echo "cmid={$lessoncmid}: completion=2, completionendreached=1\n";
}
// Instruction (193) keeps its existing completionpassgrade=1 / gradepass=50 from
// the earlier pass -- verified still set, not re-touched here.

// ---------------------------------------------------------------------------
// 5. Due date: 2026-09-01 15:30 America/Chicago on Instruction, Practice, Mastery Check.
// ---------------------------------------------------------------------------
$duedate = 1788294600;
foreach ([193, 188] as $lessoncmid) {
    $cm = $DB->get_record('course_modules', ['id' => $lessoncmid], '*', MUST_EXIST);
    $DB->set_field('lesson', 'deadline', $duedate, ['id' => $cm->instance]);
    echo "cmid={$lessoncmid}: deadline set to {$duedate}\n";
}
$mccm = $DB->get_record('course_modules', ['id' => 114], '*', MUST_EXIST);
$DB->set_field('quiz', 'timeclose', $duedate, ['id' => $mccm->instance]);
echo "cmid=114: timeclose set to {$duedate}\n";

// ---------------------------------------------------------------------------
// 6. Mastery Check intro warning + integrity-acknowledgment first question.
// ---------------------------------------------------------------------------
$mcintro = <<<'HTML'
<p><strong>This is a scored test attempt, not practice.</strong> Once you start, it counts.</p>
<p>Before you begin, make sure you have already completed 01.1's Practice and Project/application work -- this Mastery Check assumes you've already applied these skills, not that you're seeing them for the first time.</p>
<p>Don't start until you're actually ready. Ask your teacher for the password when you are.</p>
HTML;
$DB->set_field('quiz', 'intro', $mcintro, ['id' => $mccm->instance]);
$DB->set_field('quiz', 'introformat', FORMAT_HTML, ['id' => $mccm->instance]);
echo "cmid=114: intro warning updated.\n";

// Build the integrity-acknowledgment question via the real question-save code
// path (same pattern as create_lesson1_mastery_check_quiz.php).
$existingcat = $DB->get_record('question_categories', ['name' => 'Lesson 01.1 Mastery Check', 'contextid' => $coursecontext->id], '*', MUST_EXIST);

$integritytext = <<<'HTML'
<p><strong>Before you begin: read this carefully.</strong></p>
<p>By starting this Mastery Check, you are confirming that during this attempt you will <strong>not</strong>:</p>
<ul>
<li>use any unauthorized sources (websites, AI tools, notes, textbooks, etc.)</li>
<li>use study materials of any kind</li>
<li>share information with peers, or receive information from a peer</li>
<li>keep your phone in your possession</li>
</ul>
<p>Violating any of these will result in a <strong>0% (F)</strong> on this Mastery Check, and you will be <strong>ineligible for any retake</strong> to earn credit for this skill.</p>
<p>Type <strong>I understand</strong> below to continue.</p>
HTML;

$question = new stdClass();
$question->qtype = 'shortanswer';
$question->category = $existingcat->id;
$question->contextid = $coursecontext->id;
$question->createdby = $USER->id;
$question->modifiedby = $USER->id;

$form = new stdClass();
$form->category = $existingcat->id;
$form->context = $coursecontext;
$form->name = 'Mastery Check Academic Integrity Acknowledgment';
$form->questiontext = ['text' => $integritytext, 'format' => FORMAT_HTML];
$form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
$form->defaultmark = 1;
$form->penalty = 0;
$form->usecase = 0;
$form->answer = ['I understand', 'i understand', '*'];
$form->fraction = [1, 1, 0];
$form->feedback = [
    ['text' => '', 'format' => FORMAT_HTML],
    ['text' => '', 'format' => FORMAT_HTML],
    ['text' => 'You must type "I understand" to begin.', 'format' => FORMAT_HTML],
];

$qtype = question_bank::get_qtype('shortanswer');
$saved = $qtype->save_question($question, $form);
echo "Saved integrity question id={$saved->id}\n";

// Rebuild quiz_slots in order: integrity (maxmark=0) then the 4 existing essays.
$quiz = $DB->get_record('quiz', ['id' => $mccm->instance], '*', MUST_EXIST);
$oldslots = $DB->get_records('quiz_slots', ['quizid' => $quiz->id], 'slot');
$existingquestionids = [];
foreach ($oldslots as $slot) {
    $qr = $DB->get_record('question_references', ['itemid' => $slot->id, 'component' => 'mod_quiz', 'questionarea' => 'slot']);
    $qbe = $DB->get_record('question_bank_entries', ['id' => $qr->questionbankentryid]);
    $qv = $DB->get_record('question_versions', ['questionbankentryid' => $qbe->id]);
    $existingquestionids[] = $qv->questionid;
}
$DB->delete_records('quiz_slots', ['quizid' => $quiz->id]);
echo "Cleared " . count($oldslots) . " old slots.\n";

quiz_add_quiz_question($saved->id, $quiz, 0, 0);
echo "Added integrity question as slot 1, maxmark=0.\n";
foreach ($existingquestionids as $qid) {
    quiz_add_quiz_question($qid, $quiz, 0, 1);
}
echo "Re-added " . count($existingquestionids) . " existing essay questions after it.\n";

$quizobj = \mod_quiz\quiz_settings::create($quiz->id);
$quizobj->get_grade_calculator()->recompute_quiz_sumgrades();
echo "Recomputed quiz sumgrades.\n";

echo "Done.\n";
