<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Install-time migration from block_moodec to block_educheckout.
 *
 * On first install: rename block_instances rows, the block registration in
 * {block}, plugin config, role capabilities, and drop the stale block_moodec
 * capability rows from {capabilities}. A clean install (no prior moodec data)
 * is a no-op.
 *
 * @package    block_educheckout
 * @copyright  2026 the EduCheckout contributors
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Migrate any leftover block_moodec data to block_educheckout.
 */
function xmldb_block_educheckout_install() {
    global $DB;

    $DB->set_field('block_instances', 'blockname', 'educheckout', ['blockname' => 'moodec']);

    if ($DB->record_exists('block', ['name' => 'moodec'])) {
        if ($DB->record_exists('block', ['name' => 'educheckout'])) {
            $DB->delete_records('block', ['name' => 'moodec']);
        } else {
            $DB->set_field('block', 'name', 'educheckout', ['name' => 'moodec']);
        }
    }

    $DB->set_field('config_plugins', 'plugin', 'block_educheckout', ['plugin' => 'block_moodec']);

    $caps = $DB->get_records_sql(
        "SELECT id, capability FROM {role_capabilities} WHERE " . $DB->sql_like('capability', '?'),
        ['block/moodec:%']
    );
    foreach ($caps as $row) {
        $new = 'block/educheckout:' . substr($row->capability, strlen('block/moodec:'));
        $DB->set_field('role_capabilities', 'capability', $new, ['id' => $row->id]);
    }

    $DB->delete_records_select(
        'capabilities',
        $DB->sql_like('name', '?'),
        ['block/moodec:%']
    );
}
