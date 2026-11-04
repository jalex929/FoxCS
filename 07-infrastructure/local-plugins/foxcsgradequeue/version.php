<?php
// Grading queue: writes one JSON event per Coding Exercise submission for
// the on-submission grading worker. See README.md in this folder.

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'local_foxcsgradequeue';
$plugin->version = 2026110400;
$plugin->requires = 2026042000; // Matches this instance's Moodle 5.2.2+ core version.
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = '0.1 (not yet installed on the live site)';
