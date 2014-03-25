<?php

require_once('../../config.php');

global $DB;

$courseid = $_POST['course_id'];
$userid=$_POST['user_id'];
$display_string = '';

$latestgrades = $DB->get_records_sql('
    SELECT mgi.itemname as name, (mgg.finalgrade/mgi.grademax)*100 as grade
    FROM   mdl_grade_grades mgg, mdl_grade_items mgi
    WHERE  mgi.id=mgg.itemid
    AND    mgg.userid=?
    AND    mgi.courseid=?
    AND    mgi.itemtype=\'mod\'
    AND    mgg.finalgrade is not NULL 
    ORDER BY mgg.timemodified DESC', array($userid,$courseid));


$display_string .= '<table class="latestGradesHeader">';
$display_string .= '<tr><th class=lg_left_th>Activity Name</th><th class=lg_right_th>Grades(%)</th></tr>';
$display_string .='</table>';
// Insert a new row in the table for each person returned

$display_string .='<div class="lg_scrollingTable">';
$display_string .='<table class="latestGradesBody">';

foreach ($latestgrades as $grade){               
    $display_string .= '<tr><td class="left_td">'.$grade->name.'</td><td class="right_td">'.round($grade->grade).'</td></tr>';   
}
$display_string .= '</table>';
$display_string .='</div>';

echo $display_string;

?>
