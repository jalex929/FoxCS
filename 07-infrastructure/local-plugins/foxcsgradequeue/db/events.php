<?php
defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\mod_assign\event\assessable_submitted',
        'callback' => '\local_foxcsgradequeue\observer::submission_submitted',
        // Runs after the submission transaction commits, so a rolled-back
        // submission never reaches the grading queue.
        'internal' => false,
    ],
];
