<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Common functions and callbacks.
 *
 * @package    tool_redirect
 * @copyright  2020 NYIAJ LLC <https://nyiaj.io>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_redirect\table\rule_table;

require(__DIR__.'/../../../config.php');
require_once("$CFG->libdir/adminlib.php");

global $USER;

$context = context_system::instance();

admin_externalpage_setup('tool_redirect_rules');

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/admin/tool/redirect/rules.php'));
$PAGE->set_title(get_string('managerules', 'tool_redirect'));
$PAGE->set_heading(get_string('managerules', 'tool_redirect'));

require_login();
require_capability('tool/redirect:managerules', $context);

$table = new rule_table('rules');
$table->define_baseurl($PAGE->url);
ob_start();
$table->out(25, false);
$tablehtml = ob_get_clean();

echo $OUTPUT->header();

if (isset($CFG->tool_redirect_disable) && $CFG->tool_redirect_disable) {
    echo $OUTPUT->notification(get_string('redirectiondisabledcfg', 'tool_redirect'));
}

echo $OUTPUT->render_from_template('tool_redirect/managerules', [
    'createurl' => new moodle_url('/admin/tool/redirect/rule.php', ['action' => 'create']),
    'tablehtml' => $tablehtml
]);

echo $OUTPUT->footer();