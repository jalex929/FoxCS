<?php
defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'FoxCS grading queue';
$string['queuedir'] = 'Queue folder';
$string['queuedir_desc'] = 'Absolute path the web server can write to. Events go to incoming/ and submitted files to files/. Leave empty to turn the queue off.';
$string['assignments'] = 'Coding Exercises to queue';
$string['assignments_desc'] = 'Comma-separated activity ID numbers (the ID number field in each assignment\'s settings) that have an exercise spec on the grading worker. Other assignments are never queued.';
