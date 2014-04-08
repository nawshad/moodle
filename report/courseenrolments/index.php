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
 * Course Enrolment report
 *
 * @package    report
 * @subpackage courseenrolments
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

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
$PAGE->set_heading($course->fullname.': Enrolled Users');


$enrolledusers = $DB->get_records_sql('SELECT mu.id AS id, mu.firstname, mu.lastname, mu.email
                                        FROM mdl_role_assignments mra, mdl_user mu, mdl_course mc, mdl_context mcxt
                                        WHERE mra.userid = mu.id
                                        AND mra.contextid = mcxt.id
                                        AND mcxt.contextlevel =50
                                        AND mcxt.instanceid = mc.id
                                        AND mc.id =?
                                        AND (mra.roleid =5 OR mra.roleid=3)', array(2));



$strfirstname = get_string('firstname', 'report_courseenrolments');
$strlastname = get_string('lastname', 'report_courseenrolments');
$stremail = get_string('email', 'report_courseenrolments');

$table = new html_table();
$table->head  = array($strfirstname, $strlastname, $stremail);
$table->colclasses = array('mdl-left firstname', 'mdl-left lastname', 'mdl-left email');
$table->attributes = array('class' => 'courseenrolmentsreport generaltable');
$table->id = 'courseenrolmentsreporttable';
$table->data = array();

foreach ($enrolledusers as $enrolleduser){
    $table->data[] = array($enrolleduser->firstname, $enrolleduser->lastname, $enrolleduser->email);
}

echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();


