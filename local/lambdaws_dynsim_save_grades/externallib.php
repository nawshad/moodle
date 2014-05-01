<?php

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
 * External Web Service Template
 *
 * @package    lambdaws_dynsim_save_grades
 * @copyright  2011 Moodle Pty Ltd (http://moodle.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");

class local_lambdaws_dynsim_save_grades_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function lambdaws_dynsim_save_grades_parameters() {
        return new external_function_parameters(
                array('idnumber' => new external_value(PARAM_INT, 'idnumber', VALUE_DEFAULT, 0),
                      'dynsimid' => new external_value(PARAM_INT, 'dynsimid', VALUE_DEFAULT, 0),
                      'grade' => new external_value(PARAM_FLOAT, 'grade', VALUE_DEFAULT, 0.0),
                      'timecompleted' => new external_value(PARAM_INT, 'timecompleted', VALUE_DEFAULT, 0),
                      'description' => new external_value(PARAM_TEXT, 'description', VALUE_DEFAULT, 'Default')
                    )
        );
    }

  
     /* Returns welcome message
     * @return string welcome message
     */
    public static function lambdaws_dynsim_save_grades($idnumber, $dynsimid, $grade, $timecompleted, $description) {
        global $USER;

        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::lambdaws_dynsim_save_grades_parameters(),
                array('idnumber' =>$idnumber , 'dynsimid'=> $dynsimid, 'grade'=>$grade , 'timecompleted' => $timecompleted, 'description'=>$description));

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = get_context_instance(CONTEXT_USER, $USER->id);
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('moodle/user:viewdetails', $context)) {
            throw new moodle_exception('cannotviewprofile');
        }
        

        return 'ID Number: '.$idnumber.' Dynsim ID: '.$dynsimid.' Grade: '.$grade.' Time Completed: '.$timecompleted.' description: '.$description;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function lambdaws_dynsim_save_grades_returns() {
        return new external_value(PARAM_TEXT, 'The sum of two numbers sent as parameter');
    }



}
