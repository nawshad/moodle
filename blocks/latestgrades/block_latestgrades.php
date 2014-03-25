<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class block_latestgrades extends block_base {    
    public function init() {
        $this->title = get_string('pluginname', 'block_latestgrades');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section. 
    public function get_content() {
        global $USER, $DB,$CFG,$PAGE;
        $userid = $USER->id;
        $root = $CFG->wwwroot;

        $this->content         =  new stdClass;
        $this->content->footer = '';
        
        if(empty($this->instance)) {
            $this->content->text   = '';
            return $this->content;
        }
           
        $PAGE->requires->js( new moodle_url($root. '/blocks/latestgrades/jquery-1.11.0.min.js'));
        $PAGE->requires->js( new moodle_url($root. '/blocks/latestgrades/ajaxTable.js'));
        $courses = $DB->get_records_sql ('
                            SELECT mc.id, mc.fullname, mgi.timemodified 
                            FROM mdl_user mu, mdl_user_enrolments mue,
                                  mdl_enrol me,  
                                  mdl_course mc, 
                                  mdl_grade_items mgi, 
                                  mdl_grade_grades mgg
                             WHERE mu.id=mue.userid
                             AND   mue.enrolid=me.id
                             AND   me.courseid=mc.id
                             AND   mc.id=mgi.courseid
                             AND   mgi.id=mgg.itemid
                             AND   mu.id=mgg.userid
                             AND   mu.id=?
                             AND   mgi.itemtype=\'mod\'
                             AND   mgg.finalgrade is not NULL
                             ORDER BY mgi.timemodified DESC', array($userid));
        
        if($courses) {
            $this->content->text .= 
                '<body onload="callAjaxFunction('.$userid.',\''. addslashes(htmlspecialchars($root)) .'\')">
                     <div>
                         <center><b>Select your course:</b></center>
                         <select id="courseList" onclick="callAjaxFunction('.$userid.',\''. addslashes(htmlspecialchars($root)) .'\')">';
                         foreach ($courses as $coursename) {               
                             $this->content->text .= '<option id='.$coursename->id.'>'.$coursename->fullname.'</option>';  
                         }
                         $this->content->text .= '</select> 
                    </div>
                </body>'; 
            $this->content->text .= '<div id="ajaxDiv"></div>';
        }
        else {
            $this->content->text .= 'No Data Found';
        }
        return $this->content;                                                                                       
    }
    
    function applicable_formats() {
        return array('all' => true);
    } 
}  
?>
