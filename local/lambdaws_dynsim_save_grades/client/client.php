<?php
// This client for local_lambdaws_dynsim_save_grades is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//

/**
 * XMLRPC client for Moodle 2 - local_lambdaws_dynsim_save_grades
 *
 * This script does not depend of any Moodle code,
 * and it can be called from a browser.
 *
 * 
 */

/// MOODLE ADMINISTRATION SETUP STEPS
// 1- Install the plugin
// 2- Enable web service advance feature (Admin > Advanced features)
// 3- Enable XMLRPC protocol (Admin > Plugins > Web services > Manage protocols)
// 4- Create a token for a specific user and for the service 'My service' (Admin > Plugins > Web services > Manage tokens)
// 5- Run this script directly from your browser: you should see 'Hello, FIRSTNAME'

/// SETUP - NEED TO BE CHANGED

require_once('../../../config.php');
$domainname = $CFG->wwwroot;

/// FUNCTION NAME
$functionname = $_GET['wsfunction'];
$idnumber = (int)$_GET['idnumber'];
$dynsimid = (int)$_GET['dynsimid'];
$grade = (double)$_GET['grade'];
$timecompleted = (int)$_GET['time_completed'];
$description = $_GET['description'];
$token = $_GET['wstoken'];

/// PARAMETERS
//$welcomemsg = 'Hello, ';

///// XML-RPC CALL
header('Content-Type: text/plain');
$serverurl = $domainname . '/webservice/xmlrpc/server.php'. '?wstoken=' . $token;
require_once('./curl.php');
$curl = new curl;
$post = xmlrpc_encode_request($functionname, array($idnumber, $dynsimid, $grade, $timecompleted, $description));
$resp = xmlrpc_decode($curl->post($serverurl, $post));
print_r($resp);
