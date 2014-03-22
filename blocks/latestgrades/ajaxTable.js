/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function callAjaxFunction(userid, root) {    
    var mylist=document.getElementById("courseList");
    var courseid=mylist.options[mylist.selectedIndex].id;
    $.ajax({
        type: "POST",
        url: root+"/blocks/latestgrades/response.php",
        data: {course_id: courseid , user_id: userid},
        success:function(evt){
            console.log(evt);
            document.getElementById("ajaxDiv").innerHTML= evt;
        },
        error:function(evt){
            console.log("FAIL: What is evt: ");
            console.log(evt);
        } 
    })
}
