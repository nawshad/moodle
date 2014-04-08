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
 * Participation report
 *
 * @package    report
 * @subpackage participation
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
//require_once($CFG->dirroot.'/lib/tablelib.php');

//define('DEFAULT_PAGE_SIZE', 20);
//define('SHOW_ALL_PAGE_SIZE', 5000);

$id  = required_param('id', PARAM_INT); // course id.

$url = new moodle_url('/report/courseenrolments/index.php', array('id'=>$id));

$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    print_error('invalidcourse');
}

require_login($course);
$context = context_course::instance($course->id);
require_capability('report/courseenrolments:view', $context);

$strenrolments = get_string('courseenrolmentsreport', 'report_courseenrolments');
$PAGE->set_title($course->shortname .': '. $strenrolments);
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();


echo $OUTPUT->footer();


