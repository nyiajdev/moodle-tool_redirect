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
 * English strings for tool_redirect.
 *
 * @package    tool_redirect
 * @copyright  2020 NYIAJ LLC <https://nyiaj.io>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['createrule'] = 'Create redirection rule';
$string['createrules'] = 'Create redirection rule';
$string['delete'] = 'Delete';
$string['deleteconfirm'] = 'Are you sure you want to delete this redirection rule?';
$string['deleterule'] = 'Delete redirection rule';
$string['description'] = 'Description';
$string['description_help'] = 'Optional description/note of redirect purpose. Only admins and managers see this.';
$string['disabled'] = 'Disabled';
$string['edit'] = 'Edit';
$string['editrule'] = 'Edit redirection rule';
$string['enabled'] = 'Enabled';
$string['enabled_help'] = 'If enabled redirects will happen to page requests matching this rule.';
$string['managerules'] = 'Manage redirection rules';
$string['matchtype'] = 'URL match type';
$string['matchtype_help'] = 'Choose how the "Redirect from" URL should be matched for redirection.';
$string['matchtypeurlmatchbase'] = 'URL base match (URL_MATCH_BASE)';
$string['matchtypeurlmatchexact'] = 'URL match exact (URL_MATCH_EXACT)';
$string['matchtypeurlmatchparams'] = 'URL base match (URL_MATCH_BASE)';
$string['matchtypeurlmatchparams'] = 'URL match params (URL_MATCH_PARAMS)';
$string['pluginname'] = 'Redirect any page';
$string['privacy:metadata'] = 'The Redirect any page plugin does not store any personal data.';
$string['redirect:managerules'] = 'Manage redirection rules';
$string['redirectfrom'] = 'Redirect from / Match URL';
$string['redirectfrom_help'] = 'Match this URL for redirection. If a user navigates to a page with this URL, they will be redirected to the "Redirect to" URL.';
$string['redirectiondisabledcfg'] = 'Redirection is disabled in config.php. To enable redirection for your site, you must edit /path/to/moodle/<b>config.php</b> and remove <pre>$CFG->tool_redirect_disable = true;</pre>';
$string['redirectplaceholder'] = 'Redirect old course link...';
$string['redirects'] = 'Redirects';
$string['redirects_help'] = 'Total number of requests that were redirected with this rule.';
$string['redirectto'] = 'Redirect to';
$string['redirectto_help'] = 'Enter the URL users should be redirected to when this rule matches.';
$string['rulecreated'] = 'Redirection rule successfully created';
$string['ruledeleted'] = 'Redirection rule successfully deleted';
$string['ruleedited'] = 'Redirection rule successfully edited';
$string['forwardparams'] = 'Forward URL parameters';
$string['forwardparams_help'] = 'If checked, "from" URL params will be copied to redirect "to" URL.';
