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
 * tool_redirect rule persistent.
 *
 * @package    tool_redirect
 * @copyright  2020 NYIAJ LLC <https://nyiaj.io>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirect\form;

use core\form\persistent;

class rule_form extends persistent {
    protected static $persistentclass = 'tool_redirect\\persistent\\rule';

    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'description', get_string('description', 'tool_redirect'),
            ['maxlength' => 255, 'placeholder' => get_string('redirectplaceholder', 'tool_redirect')]);
        $mform->setType('description', PARAM_TEXT);

        $mform->addElement('advcheckbox', 'enabled', get_string('enabled', 'tool_redirect'));
        $mform->setType('enabled', PARAM_BOOL);
        $mform->addHelpButton('enabled', 'enabled', 'tool_redirect');

        $mform->addElement('text', 'redirectfrom', get_string('redirectfrom', 'tool_redirect'));
        $mform->setType('redirectfrom', PARAM_TEXT);
        $mform->addRule('redirectfrom', get_string('required'), 'required');
        $mform->addHelpButton('redirectfrom', 'redirectfrom', 'tool_redirect');

        $mform->addElement('text', 'redirectto', get_string('redirectto', 'tool_redirect'));
        $mform->setType('redirectto', PARAM_TEXT);
        $mform->addRule('redirectto', get_string('required'), 'required');
        $mform->addHelpButton('redirectto', 'redirectto', 'tool_redirect');

        $mform->addElement('select', 'matchtype', get_string('matchtype', 'tool_redirect'), [
            URL_MATCH_BASE => get_string('matchtypeurlmatchbase', 'tool_redirect'),
            URL_MATCH_PARAMS => get_string('matchtypeurlmatchparams', 'tool_redirect'),
            URL_MATCH_EXACT => get_string('matchtypeurlmatchexact', 'tool_redirect')
        ]);
        $mform->setType('matchtype', PARAM_INT);
        $mform->addHelpButton('matchtype', 'matchtype', 'tool_redirect');

        $mform->addElement('advcheckbox', 'forwardparams', get_string('forwardparams', 'tool_redirect'));
        $mform->setType('forwardparams', PARAM_BOOL);
        $mform->addHelpButton('forwardparams', 'forwardparams', 'tool_redirect');

        $this->add_action_buttons();
    }
}