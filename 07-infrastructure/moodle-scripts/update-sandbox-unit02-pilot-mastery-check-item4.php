<?php
// update-sandbox-unit02-pilot-mastery-check-item4.php
//
// Reworks Mastery Check Item 4 (quiz id 11, question id 107) from
// comma-only print prediction to a concatenation-fix item, per the
// 2026-09-04 post-02.1-review decision: Mastery Check items touching the
// printing-with-text skill need to test the +/comma distinction, not
// commas alone. Uses a new variable name ("total") not already used in
// Practice's own items (which use "score"), so this is a real synthesis
// check, not a verbatim repeat.
//
// Text-only edit (questiontext + the one accepted shortanswer string) on
// the existing question id -- no new question version, no qtype change,
// so this is a direct record update plus a question-definition cache
// purge, not a full question_bank::save_question() form-submission cycle.
//
// Run: sudo -u www-data php update-sandbox-unit02-pilot-mastery-check-item4.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/question/engine/bank.php');

\core\cron::setup_user();

$qid = 107;
$question = $DB->get_record('question', ['id' => $qid], '*', MUST_EXIST);
if (strpos($question->name, 'MC Item 4') !== 0) {
    fwrite(STDERR, "Question {$qid} is not MC Item 4 (name: {$question->name}); aborting.\n");
    exit(1);
}

$newtext = '<p>This line is supposed to print <code>Total: 12</code>, using <code>+</code>, but it crashes:</p><pre>total = 12
print("Total: " + total)</pre><p>Write the corrected line.</p>';

$DB->update_record('question', (object) [
    'id' => $qid,
    'name' => 'MC Item 4: fix the concatenation error',
    'questiontext' => $newtext,
]);

$answer = $DB->get_record('question_answers', ['question' => $qid], '*', MUST_EXIST);
$DB->update_record('question_answers', (object) [
    'id' => $answer->id,
    'answer' => 'print("Total: " + str(total))',
]);
// A second accepted form, matching Item 2's existing no-space-around-=
// convention (lives=3 alongside lives = 3).
$DB->insert_record('question_answers', (object) [
    'question' => $qid,
    'answer' => 'print("Total: "+str(total))',
    'fraction' => 1.0,
    'feedback' => '',
    'feedbackformat' => FORMAT_HTML,
]);

question_bank::notify_question_edited($qid);
cache_helper::purge_by_event('changesinquestion');

echo "Updated question id={$qid}.\n";
