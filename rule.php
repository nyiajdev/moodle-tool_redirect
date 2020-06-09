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
 * @package    tool_redirect
 * @copyright  2020 NYIAJ LLC <https://nyiaj.io>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_redirect\form\rule_form;
use tool_redirect\persistent\rule;

require_once(__DIR__.'/../../../config.php');
require_once("$CFG->libdir/adminlib.php");

global $PAGE, $DB;

$action = required_param('action', PARAM_TEXT);

$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/admin/tool/redirect/rule.php', ['action' => $action]));
$PAGE->navbar->add(get_string('managerules', 'tool_redirect'), new moodle_url('/admin/tool/redirect/rules.php'));

require_login();
require_capability('tool/redirect:managerules', $context);

switch ($action) {
    case 'create':
        $PAGE->set_title(get_string('createrule', 'tool_redirect'));
        $PAGE->set_heading(get_string('createrule', 'tool_redirect'));
        $PAGE->navbar->add(get_string('createrule', 'tool_redirect'));

        $form = new rule_form($PAGE->url, [
            'persistent' => null,
        ]);

        if ($data = $form->get_data()) {
            $rule = new rule(0, $data);
            $rule->create();

            \core\notification::success(get_string('rulecreated', 'tool_redirect', $rule->to_record()));
            redirect(new moodle_url('/admin/tool/redirect/rules.php'));
        } else if ($form->is_cancelled()) {
            redirect(new moodle_url('/admin/tool/redirect/rules.php'));
        }

        echo $OUTPUT->header();
        $form->display();

        break;

    case 'edit':
        $PAGE->set_title(get_string('editrule', 'tool_redirect'));
        $PAGE->set_heading(get_string('editrule', 'tool_redirect'));
        $PAGE->navbar->add(get_string('editrule', 'tool_redirect'));

        $id = required_param('id', PARAM_INT);
        $url = clone $PAGE->url;
        $url->params(['id' => $id]);
        $PAGE->set_url($url);

        $rule = new rule($id);

        $form = new rule_form($PAGE->url, [
            'persistent' => $rule,
        ]);

        if ($data = $form->get_data()) {
            $rule->from_record($data);
            $rule->update();

            \core\notification::success(get_string('ruleedited', 'tool_redirect', $rule->to_record()));
            redirect(new moodle_url('/admin/tool/redirect/rules.php'));
        } else if ($form->is_cancelled()) {
            redirect(new moodle_url('/admin/tool/redirect/rules.php'));
        }

        echo $OUTPUT->header();
        $form->display();

        break;

    case 'delete':
        $PAGE->set_title(get_string('deleterule', 'tool_redirect'));
        $PAGE->set_heading(get_string('deleterule', 'tool_redirect'));
        $PAGE->navbar->add(get_string('deleterule', 'tool_redirect'));

        $id = required_param('id', PARAM_INT);
        $url = clone $PAGE->url;
        $url->params(['id' => $id]);
        $PAGE->set_url($url);

        $rule = new rule($id);

        if ($confirm = optional_param('confirm', 0, PARAM_BOOL)) {
            $rule->delete();
            \core\notification::success(get_string('ruledeleted', 'tool_redirect', $rule->to_record()));
            redirect(new moodle_url('/admin/tool/redirect/rules.php'));
        }

        echo $OUTPUT->header();
        $url = clone $PAGE->url;
        $url->param('confirm', 1);

        $message = get_string('deleteconfirm', 'tool_redirect', $rule->to_record());
        echo $OUTPUT->confirm($message, $url, new moodle_url('/admin/tool/redirect/rules.php'));
        break;

    default:
        throw new coding_exception('Invalid action');
}

echo $OUTPUT->footer();