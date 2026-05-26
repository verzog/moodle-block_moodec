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
 * EduCheckout storefront block.
 *
 * Embeds the local_educheckout product catalogue directly in a block region,
 * so the storefront can be surfaced on the site home page (or any page the
 * block is allowed on) rather than only linked to.
 *
 * @package    block_educheckout
 * @copyright  2026 LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Block that renders the EduCheckout storefront catalogue.
 */
class block_educheckout extends block_base {
    /**
     * Initialise the block title.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_educheckout');
    }

    /**
     * The EduCheckout storefront block has no per-instance configuration.
     *
     * @return bool
     */
    public function instance_allow_config() {
        return false;
    }

    /**
     * Only one storefront block makes sense per context.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Where this block may be added.
     *
     * @return array
     */
    public function applicable_formats() {
        return [
            'all' => true,
            'site-index' => true,
            'my' => true,
            'mod' => false,
        ];
    }

    /**
     * Render the storefront catalogue inside the block.
     *
     * @return stdClass|null
     */
    public function get_content() {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        // The catalogue presenter lives in local_educheckout; if that plugin is
        // missing there is nothing to show.
        if (!class_exists('\local_educheckout\catalogue')) {
            $this->content->text = '';
            return $this->content;
        }

        $data = \local_educheckout\catalogue::export_for_template();
        $this->content->text = $OUTPUT->render_from_template('local_educheckout/catalogue', $data);

        return $this->content;
    }
}
