<?php
// Prototype plugin for the 2026-09-04 structural brainstorm's "Option C":
// lets a custom FoxCS lesson/resource page report its own interaction
// telemetry and mark Moodle completion directly, without adopting SCORM or
// rebuilding into native H5P/question types. See chat-log.md's 2026-09-04
// entry and decisions-log.md for the fuller reasoning.

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'local_foxcstelemetry';
$plugin->version = 2026090400;
$plugin->requires = 2026042000; // Matches this instance's Moodle 5.2.2+ core version.
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = '0.1 prototype (sandbox-adaptive-demo only)';
