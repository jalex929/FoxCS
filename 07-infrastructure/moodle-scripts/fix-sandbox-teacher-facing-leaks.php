<?php
// fix-sandbox-teacher-facing-leaks.php
//
// Trims internal build-process detail out of sandbox-course banners and a
// quiz intro, per Jay's 2026-09-09 standing rule that sandbox content
// should be "perfectly representative of what content can be set to go
// live" -- CLAUDE.md's Publishing Checklist already says the exempt
// "Sandbox prototype... Not live in any real course" wrapper should be
// injected at deploy time, not carry extra internal detail baked in
// (e.g. "built against skills-map.md," "pilot lesson," "5-module lesson
// pattern"). Found by an audit fork this session; the video-meta length
// caveat this same fork flagged on cmid 250/251/252 was independently
// re-checked directly against the live DB and found already clean --
// not touched here, no fix needed.
//
// Run: sudo -u www-data php fix-sandbox-teacher-facing-leaks.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
error_reporting(E_ALL);

\core\cron::setup_user();

$fs = get_file_storage();

$banners = [
    238 => [
        'old' => 'Sandbox prototype -- the full Instruction module for Unit 02\'s pilot lesson (02.1 Variables and Memory), built to prove the new 5-module lesson pattern before a full Unit 02 rollout. Not live in any real course.',
        'new' => 'Sandbox prototype -- not live in any real course.',
    ],
    250 => [
        'old' => 'Sandbox prototype -- Unit 02\'s third lesson (02.2 Integers), built against skills-map.md. Not live in any real course.',
        'new' => 'Sandbox prototype -- not live in any real course.',
    ],
    251 => [
        'old' => 'Sandbox prototype -- Unit 02\'s fourth lesson (02.3 Floats), built against skills-map.md. Not live in any real course.',
        'new' => 'Sandbox prototype -- not live in any real course.',
    ],
    252 => [
        'old' => 'Sandbox prototype -- Unit 02\'s fifth lesson (02.4 Strings), built against skills-map.md. Not live in any real course.',
        'new' => 'Sandbox prototype -- not live in any real course.',
    ],
    253 => [
        'old' => 'Sandbox prototype -- Unit 02\'s sixth lesson (02.5 Booleans), built against skills-map.md. Not live in any real course.',
        'new' => 'Sandbox prototype -- not live in any real course.',
    ],
];

foreach ($banners as $cmid => $text) {
    $modcontext = context_module::instance($cmid);
    $file = $fs->get_file($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html');
    if (!$file) {
        echo "cmid={$cmid}: index.html not found, skipping\n";
        continue;
    }
    $html = $file->get_content();
    if (strpos($html, $text['old']) === false) {
        echo "cmid={$cmid}: expected old banner text not found verbatim, skipping (check manually)\n";
        continue;
    }
    $html = str_replace($text['old'], $text['new'], $html);
    $fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);
    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_resource',
        'filearea' => 'content',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => 'index.html',
    ], $html);
    file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);
    echo "cmid={$cmid}: banner trimmed\n";
}

// Quiz 232 (id=10, "Python Basics (Adaptive Demo)") intro: drop "borrowed"
// internal-authoring note, keep the functional password line.
global $DB;
$quiz = $DB->get_record('quiz', ['id' => 10], '*', MUST_EXIST);
if ($quiz->intro === 'Adaptive-style quiz demo, borrowed Python question set. Password: test') {
    $DB->set_field('quiz', 'intro', 'Adaptive-style quiz demo. Password: test', ['id' => 10]);
    echo "quiz id=10: intro trimmed\n";
} else {
    echo "quiz id=10: intro text didn't match expected, skipping (check manually)\n";
}

echo "Done.\n";
