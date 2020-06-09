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
 * tool_redirect upgrade code.
 *
 * @package    tool_redirect
 * @copyright  2020 NYIAJ LLC <https://nyiaj.io>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Function to upgrade tool_redirect.
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_tool_redirect_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2020060802) {

        // Define table tool_redirect_rule to be created.
        $table = new xmldb_table('tool_redirect_rule');

        // Adding fields to table tool_redirect_rule.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('description', XMLDB_TYPE_CHAR, '1000', null, null, null, null);
        $table->add_field('redirectfrom', XMLDB_TYPE_CHAR, '1000', null, XMLDB_NOTNULL, null, null);
        $table->add_field('redirectto', XMLDB_TYPE_CHAR, '1000', null, XMLDB_NOTNULL, null, null);
        $table->add_field('enabled', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
        $table->add_field('totalredirects', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table tool_redirect_rule.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for tool_redirect_rule.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Redirect savepoint reached.
        upgrade_plugin_savepoint(true, 2020060802, 'tool', 'redirect');
    }

    if ($oldversion < 2020060901) {

        // Define field matchtype to be added to tool_redirect_rule.
        $table = new xmldb_table('tool_redirect_rule');
        $field = new xmldb_field('matchtype', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'totalredirects');

        // Conditionally launch add field matchtype.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Redirect savepoint reached.
        upgrade_plugin_savepoint(true, 2020060901, 'tool', 'redirect');
    }

    if ($oldversion < 2020060902) {

        // Define field forwardparams to be added to tool_redirect_rule.
        $table = new xmldb_table('tool_redirect_rule');
        $field = new xmldb_field('forwardparams', XMLDB_TYPE_INTEGER, '1', null, null, null, null, 'matchtype');

        // Conditionally launch add field forwardparams.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Redirect savepoint reached.
        upgrade_plugin_savepoint(true, 2020060902, 'tool', 'redirect');
    }

    return true;
}
