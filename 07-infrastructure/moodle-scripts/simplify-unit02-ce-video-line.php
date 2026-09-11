<?php
// simplify-unit02-ce-video-line.php
//
// Second pass on the Unit 02 Coding Exercise "video" instruction (cmid
// 264-267), per Jay's direct feedback 2026-09-09: cut it down to the
// minimum needed. The full video title/creator/location sentence built
// earlier today already lives on each lesson's Instruction page -- repeating
// it here just spends the student's reading bandwidth that should go toward
// the coding prompt itself. New pattern, no box/border, two short bold
// lines:
//   Work on this coding exercise while you watch the video.
//   GMetrix video(s): <short term>
//
// Run: sudo -u www-data php simplify-unit02-ce-video-line.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);

\core\cron::setup_user();

$videoline = function (string $term): string {
    return '<p><strong>Work on this coding exercise while you watch the video.</strong></p>'
        . '<p><strong>GMetrix video(s):</strong> ' . $term . '</p>';
};

$updates = [
    264 => [
        'intro' => '<p>This exercise is about <strong>integers</strong> -- whole numbers with no decimal point.</p>'
            . $videoline('int')
            . '<h3>What To Do</h3><ol><li>Download <strong>GMETRIX-112-numbers.py</strong> below (under "Additional files") and open it in VS Code.</li><li>Follow the numbered steps written as comments inside the file -- they walk you through a fill-in-the-blank question and a short coding task.</li><li>Run the file in VS Code to check your work as you go.</li></ol>'
            . '<h3>How to Submit</h3><p>Save your finished file as <strong>GMETRIX-112-numbers-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p>'
            . '<p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    265 => [
        'intro' => '<p>This exercise is about <strong>floats</strong> -- numbers with a decimal point -- and what happens when you do math with them.</p>'
            . $videoline('float')
            . '<h3>What To Do</h3><ol><li>Download <strong>GMETRIX-113-numbers.py</strong> below and open it in VS Code.</li><li>Follow the numbered steps in the file\'s comments: you\'ll add a calculation, change it, and answer two questions about what data type came back.</li><li>Run the file in VS Code to check your work as you go.</li></ol>'
            . '<h3>How to Submit</h3><p>Save your finished file as <strong>GMETRIX-113-numbers-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p>'
            . '<p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    266 => [
        'intro' => '<p>This exercise is about <strong>strings</strong> -- text wrapped in quotation marks.</p>'
            . $videoline('str')
            . '<h3>What To Do</h3><ol><li>Download <strong>GMETRIX-111-str.py</strong> below and open it in VS Code.</li><li>Follow the numbered steps in the file\'s comments: you\'ll print a full name, then answer two quoting questions.</li><li>Run the file in VS Code to check your work as you go.</li></ol>'
            . '<h3>How to Submit</h3><p>Save your finished file as <strong>GMETRIX-111-str-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p>'
            . '<p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    267 => [
        'intro' => '<p>This exercise is about <strong>booleans</strong> -- values that are only ever <code>True</code> or <code>False</code>.</p>'
            . $videoline('bool')
            . '<h3>What To Do</h3><ol><li>Download <strong>GMETRIX-114-boolean.py</strong> below and open it in VS Code.</li><li>Run it first, exactly as it is. Read the error carefully -- it\'s telling you something real about Python.</li><li>Follow the numbered steps in the file\'s comments to fix the bug and answer a casing question.</li></ol>'
            . '<h3>How to Submit</h3><p>Save your finished file as <strong>GMETRIX-114-boolean-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p>'
            . '<p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
];

foreach ($updates as $cmid => $data) {
    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $assign = $DB->get_record('assign', ['id' => $cm->instance], '*', MUST_EXIST);
    $DB->set_field('assign', 'intro', $data['intro'], ['id' => $assign->id]);
    echo "Updated cmid={$cmid} (assign id={$assign->id})\n";
}

echo "Done.\n";
