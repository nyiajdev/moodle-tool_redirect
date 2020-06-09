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

namespace tool_redirect\table;

use moodle_exception;
use stdClass;
use tool_redirect\persistent\rule;

require_once($CFG->libdir . '/tablelib.php');

/**
 * Table that lists rules.
 *
 * @package tool_redirect
 */
class rule_table extends \table_sql
{
    /**
     * @param string $uniqueid
     * @throws \coding_exception
     */
    public function __construct($uniqueid) {
        parent::__construct($uniqueid);

        // Define the headers and columns.
        $headers = [];
        $columns = [];

        $headers[] = get_string('redirectfrom', 'tool_redirect');
        $headers[] = get_string('redirectto', 'tool_redirect');
        $headers[] = get_string('enabled', 'tool_redirect');
        $headers[] = get_string('description', 'tool_redirect');
        $headers[] = get_string('redirects', 'tool_redirect');
        $headers[] = get_string('actions');
        $columns[] = 'redirectfrom';
        $columns[] = 'redirectto';
        $columns[] = 'enabled';
        $columns[] = 'description';
        $columns[] = 'actions';

        $this->define_columns($columns);
        $this->define_headers($headers);

        //$this->no_sorting('');
        $this->sort_default_column = 'title';

        // Set help icons.
        $this->define_help_for_headers([
            '4' => new \help_icon('redirects', 'tool_redirect'),
        ]);
    }

    public function col_enabled($data)
    {
        if ($data->enabled) {
            return '<span class="badge bg-success">' . get_string('enabled', 'tool_redirect') . '</span>';
        } else {
            return '<span class="badge bg-danger">' . get_string('disabled', 'tool_redirect') . '</span>';
        }
    }

    /**
     * Actions for tags.
     *
     * @param stdClass $data
     * @return string
     * @throws moodle_exception
     */
    public function col_actions($data) {
        global $OUTPUT;

        return $OUTPUT->render_from_template('tool_redirect/ruleactions', [
            'editurl' => new \moodle_url('/admin/tool/redirect/rule.php', ['action' => 'edit', 'id' => $data->id]),
            'deleteurl' => new \moodle_url('/admin/tool/redirect/rule.php', ['action' => 'delete', 'id' => $data->id])
        ]);
    }

    /**
     * @param int $pagesize
     * @param bool $useinitialsbar
     * @throws \dml_exception
     */
    function query_db($pagesize, $useinitialsbar = true)
    {
        global $DB;

        list($wsql, $params) = $this->get_sql_where();

        $sql = 'SELECT r.* FROM {' . rule::TABLE . '} r ' . $wsql;

        $sort = $this->get_sql_sort();
        if ($sort) {
            $sql = $sql . ' ORDER BY ' . $sort;
        }

        if ($pagesize != -1) {
            $count_sql = 'SELECT COUNT(DISTINCT r.id) FROM {' . rule::TABLE . '} r ' . $wsql;
            $total = $DB->count_records_sql($count_sql, $params);
            $this->pagesize($pagesize, $total);
        } else {
            $this->pageable(false);
        }

        $this->rawdata = $DB->get_recordset_sql($sql, $params, $this->get_page_start(), $this->get_page_size());
    }
}