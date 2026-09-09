<?php
// fix-unit02-ce-before-you-start.php
//
// Rewrites the "Before You Start" video callout on the 4 live Unit 02
// Coding Exercises (2.2-2.5, cmid 264-267). Per Jay's direct feedback
// 2026-09-09:
//   - Say "video," not "Subtopic" -- drop the internal GMetrix
//     Domain/Topic/Subtopic label jargon from student-facing text.
//   - Be explicit that this IS the required GMetrix video for the section,
//     not just a supplementary resource.
//   - Keep the gentle nudge to do the Instruction page first if they
//     haven't.
//   - No boxed/columned callout -- a plain paragraph with a bold lead
//     sentence is enough. (The old version had a bordered/backgrounded div
//     with a separate uppercase label line, which Jay flagged as rendering
//     in unwanted columns.)
//   - Never state a video length FoxCS hasn't independently confirmed, and
//     never leave a visible "not yet confirmed" caveat in student content --
//     that's teacher-facing information, not something students need.
//
// Run: sudo -u www-data php fix-unit02-ce-before-you-start.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);

\core\cron::setup_user();

$updates = [
    264 => [
        'intro' => '<p>This exercise is about <strong>integers</strong> -- whole numbers with no decimal point.</p>'
            . '<p><strong>Watch the video first.</strong> This is the GMetrix video for Identify Data Types: int -- '
            . '&quot;Python Tutorial for Beginners 3: Integers and Floats - Working with Numeric Data&quot; by Corey Schafer, '
            . 'embedded on the 2.2 Integers: Instruction page. If you haven\'t gone through the Instruction page yet, do that first, then come back here.</p>'
            . '<h3>What To Do</h3><ol><li>Download <strong>GMETRIX-112-numbers.py</strong> below (under "Additional files") and open it in VS Code.</li><li>Follow the numbered steps written as comments inside the file -- they walk you through a fill-in-the-blank question and a short coding task.</li><li>Run the file in VS Code to check your work as you go.</li></ol>'
            . '<h3>How to Submit</h3><p>Save your finished file as <strong>GMETRIX-112-numbers-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p>'
            . '<p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    265 => [
        'intro' => '<p>This exercise is about <strong>floats</strong> -- numbers with a decimal point -- and what happens when you do math with them.</p>'
            . '<p><strong>Watch the video first.</strong> This is the GMetrix video for Identify Data Types: float -- '
            . '&quot;Python Integers vs Floats - Visually Explained&quot; by Visually Explained, '
            . 'embedded on the 2.3 Floats: Instruction page. If you haven\'t gone through the Instruction page yet, do that first, then come back here.</p>'
            . '<h3>What To Do</h3><ol><li>Download <strong>GMETRIX-113-numbers.py</strong> below and open it in VS Code.</li><li>Follow the numbered steps in the file\'s comments: you\'ll add a calculation, change it, and answer two questions about what data type came back.</li><li>Run the file in VS Code to check your work as you go.</li></ol>'
            . '<h3>How to Submit</h3><p>Save your finished file as <strong>GMETRIX-113-numbers-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p>'
            . '<p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    266 => [
        'intro' => '<p>This exercise is about <strong>strings</strong> -- text wrapped in quotation marks.</p>'
            . '<p><strong>Watch the video first.</strong> This is the GMetrix video for Identify Data Types: str -- '
            . '&quot;Python Strings || Python Tutorial || Python Programming&quot; by Socratica, '
            . 'embedded on the 2.4 Strings: Instruction page. If you haven\'t gone through the Instruction page yet, do that first, then come back here.</p>'
            . '<h3>What To Do</h3><ol><li>Download <strong>GMETRIX-111-str.py</strong> below and open it in VS Code.</li><li>Follow the numbered steps in the file\'s comments: you\'ll print a full name, then answer two quoting questions.</li><li>Run the file in VS Code to check your work as you go.</li></ol>'
            . '<h3>How to Submit</h3><p>Save your finished file as <strong>GMETRIX-111-str-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p>'
            . '<p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    267 => [
        'intro' => '<p>This exercise is about <strong>booleans</strong> -- values that are only ever <code>True</code> or <code>False</code>.</p>'
            . '<p><strong>Watch the video first.</strong> This is the GMetrix video for Identify Data Types: bool -- '
            . '&quot;Python Booleans || Python Tutorial || Learn Python Programming&quot; by Socratica (4:39), '
            . 'embedded on the 2.5 Booleans: Instruction page. If you haven\'t gone through the Instruction page yet, do that first, then come back here.</p>'
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
