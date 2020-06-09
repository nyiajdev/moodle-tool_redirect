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
 * Rule persistent.
 *
 * @package    tool_redirect
 * @copyright  2020 NYIAJ LLC <https://nyiaj.io>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_redirect\persistent;

use coding_exception;
use core\invalid_persistent_exception;
use core\persistent;
use moodle_exception;
use moodle_url;

defined('MOODLE_INTERNAL') || die();

class rule extends persistent {
    const TABLE = 'tool_redirect_rule';

    /**
     * Return the custom definition of the properties of this model.
     *
     * @return array Where keys are the property names.
     */
    protected static function define_properties() {
        return [
            'description' => [
                'type' => PARAM_TEXT,
            ],
            'redirectfrom' => [
                'type' => PARAM_TEXT,
            ],
            'redirectto' => [
                'type' => PARAM_TEXT,
            ],
            'enabled' => [
                'type' => PARAM_BOOL,
            ],
            'totalredirects' => [
                'type' => PARAM_INT,
                'default' => 0
            ],
            'matchtype' => [
                'type' => PARAM_INT,
                'default' => URL_MATCH_BASE
            ],
            'forwardparams' => [
                'type' => PARAM_BOOL,
                'default' => false
            ]
        ];
    }

    /**
     * Find a matching rule based on URL.
     *
     * @param moodle_url $url
     * @return rule|null
     * @throws coding_exception
     * @throws moodle_exception
     */
    public static function match(moodle_url $url): ?rule {
        foreach (rule::get_records(['enabled' => true]) as $rule) {
            if ($rule->compare($url)) {
                return $rule;
            }
        }

        return null;
    }

    /**
     * Perform redirect with this rule.
     *
     * @throws coding_exception
     * @throws invalid_persistent_exception
     * @throws moodle_exception
     */
    public function redirect() {
        $this->set('totalredirects', $this->get('totalredirects') + 1)->update();
        redirect(new moodle_url($this->get('redirectto')));
    }

    /**
     * Compare URL to this rule. Return true if matches.
     *
     * @param moodle_url $url
     * @return bool
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function compare(moodle_url $url) {
        if ($this->get('matchtype') <= URL_MATCH_EXACT) {
            return $url->compare(new moodle_url($this->get('redirectfrom')), $this->get('matchtype'));
        }

        return false;
    }
}