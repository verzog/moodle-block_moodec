# Moodec storefront block (block_moodec)

A Moodle block that surfaces the [local_moodec](https://github.com/verzog/moodle-local_moodec)
course store. It shows a link into the catalogue and, for logged-in users, a
live summary of their open cart (item count, running total and currency) with a
shortcut to the cart page.

Targets **Moodle 5.0+ / PHP 8.2+**.

## Requirements

- Moodle 5.0 or later.
- The `local_moodec` storefront plugin (declared as a dependency), which in
  turn requires the `enrol_moodec` enrolment plugin.

## Installing via uploaded ZIP file

1. Log in to your Moodle site as an admin and go to
   _Site administration > Plugins > Install plugins_.
2. Upload the ZIP file. You should only be prompted to add extra details if
   your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually

The plugin can also be installed by putting the contents of this directory into

    {your/moodle/dirroot}/blocks/moodec

then log in as an admin and go to _Site administration > Notifications_ to
complete the installation.

## Usage

Turn editing on, then add the **Moodec storefront** block from the *Add a block*
menu on any page where you want learners to reach the store (course pages, the
site front page or the Dashboard).

## License

2026 LearningWorks Ltd

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program. If not, see <https://www.gnu.org/licenses/>.
