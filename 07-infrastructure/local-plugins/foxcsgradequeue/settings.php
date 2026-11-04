<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_foxcsgradequeue', get_string('pluginname', 'local_foxcsgradequeue'));
    $settings->add(new admin_setting_configtext('local_foxcsgradequeue/queuedir',
        get_string('queuedir', 'local_foxcsgradequeue'), get_string('queuedir_desc', 'local_foxcsgradequeue'), '', PARAM_RAW_TRIMMED));
    $settings->add(new admin_setting_configtextarea('local_foxcsgradequeue/assignments',
        get_string('assignments', 'local_foxcsgradequeue'), get_string('assignments_desc', 'local_foxcsgradequeue'), '', PARAM_RAW_TRIMMED));
    $ADMIN->add('localplugins', $settings);
}
