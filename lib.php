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

use tool_redirect\persistent\rule;

defined('MOODLE_INTERNAL') || die;

/**
 * Give plugins an opportunity touch things before the http headers are sent
 * such as adding additional headers. The return value is ignored.
 */
function tool_redirect_before_http_headers()
{
    global $COURSE, $USER, $PAGE, $CFG;
    try {
        // First rule out conditions where a redirect should never happen.
        if (AJAX_SCRIPT) {
            return;
        }

        // Check if redirection is disabled.
        if (isset($CFG->tool_redirect_disable) && $CFG->tool_redirect_disable) {
            return;
        }

        if ($rule = rule::match($PAGE->url)) {
            $rule->redirect();
        }
    } catch (Exception $e) {
        debugging($e->getMessage()); // Prevent any issues from breaking entire site.
    }
}