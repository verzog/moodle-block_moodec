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
 * Surfaces the local_educheckout course store: a link into the catalogue and,
 * for logged-in users, a live summary of their open cart with a checkout
 * shortcut.
 *
 * @package    block_educheckout
 * @copyright  2026 LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Block that links to the EduCheckout storefront and shows a mini cart.
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
     * Build the block body: catalogue link plus a mini cart.
     *
     * @return stdClass|null
     */
    public function get_content() {
        global $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        $catalogueurl = new moodle_url('/local/educheckout/index.php');
        $items = [];
        $items[] = html_writer::link(
            $catalogueurl,
            get_string('browsecatalogue', 'block_educheckout'),
            ['class' => 'block-educheckout-catalogue']
        );

        if (isloggedin() && !isguestuser() && class_exists('\local_educheckout\cart')) {
            $cart = \local_educheckout\cart::get_open((int) $USER->id);
            $carturl = new moodle_url('/local/educheckout/cart.php');

            if ($cart->is_empty()) {
                $items[] = html_writer::span(
                    get_string('cartempty', 'block_educheckout'),
                    'block-educheckout-cart-empty'
                );
            } else {
                $a = new stdClass();
                $a->count = count($cart->get_items());
                $a->total = format_float($cart->get_total(), 2) . ' ' . $cart->get_currency();
                $items[] = html_writer::span(
                    get_string('cartsummary', 'block_educheckout', $a),
                    'block-educheckout-cart-summary'
                );
                $items[] = html_writer::link(
                    $carturl,
                    get_string('viewcart', 'block_educheckout'),
                    ['class' => 'block-educheckout-cart-link']
                );
            }
        }

        $this->content->text = html_writer::alist($items, ['class' => 'block-educheckout-links']);

        return $this->content;
    }
}
