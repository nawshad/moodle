<?php

$string['pluginname'] = 'Lambda SSO Authentication';
$string['auth_lambdassotitle'] = "Lambda Authentication Plugin";
$string['auth_lambdassodescription'] = "Custom Authentication Plugin by Lambda Solutions";

$string['lambdaconfig'] = 'Lambda SSO Config';


$string['ssoinformation'] = 'SSO Information';
$string['ssoheading'] = 'SSO information';


$string['returnurllabel'] = 'Return URL';
$string['returnurldesc'] = 'Redirect the user back to the main site or upon failure<br />
<i>eg. http://yourdomain.com/login</i>';

$string['redirecturllabel'] = 'Add redirect URL';
$string['redirecturldesc'] = 'Adds redirect URL at the end of the return URL <br />
<i>eg. http://yourdomain.com/login?redirect=http://yourmoodle.com/course</i>';

$string['logouturllabel'] = 'Logout URL';
$string['logouturldesc'] = 'User redirects to this page after logging out.<br />
<i>eg. http://yourdomain.com/logout</i>';



$string['cookieinformation'] = 'Cookie Information';


$string['cookiename'] = 'Cookie name';
$string['cookienamedesc'] = "Cookie name that stores user's <i>idnumber</i>.<br /> 
<i>eg. USER</i>";

$string['cookiedomain'] = 'Cookie domain';
$string['cookiedomaindesc'] = 'Cookie domain.<br />
<i>eg. .yourdomain.com</i>';

$string['cookiepath'] = 'Cookie path';
$string['cookiepathdesc'] = 'Cookie path.<br />
<i>eg. /</i>';

$string['cookieremove'] = 'Remove cookie on log out';
$string['cookieremovedesc'] = "The cookie will be removed when the user logs out";



$string['cookieapi'] = 'Cookie API';
$string['cookieapilabel'] = 'Use API for cookie content decryption';

$string['cookieapiurl'] = 'Cookie API URL';
$string['cookieapiurldesc'] = 'API URL for cookie content decryption<br /> 
<i>eg. http://yourdomain.com/api</i>';

$string['cookieapiattribute'] = 'Cookie API attribute';
$string['cookieapiattributedesc'] = 'Cookie API attribute that will be sent with encrypted cookei <br />eg. <i>CookieText=</i>';

$string['apiprocessresultlabel'] = 'Process API response';
$string['apiprocessresultdesc'] = "Select YES in case that API does not return user's <i>idnumber</i> as a string";



$string['authmetode'] = 'Authentication Method';

$string['authmetodelabel'] = 'Authentication methods';
$string['authmetodedesc'] = 'If selected, SSO will log in only users with selected authentication method';


// errors
$string['plugindisabled'] = 'Lambda Authentication Plugin is disabled, please re-enable';

$string['unabletoauth'] = 'Unable to Authenticate User';
$string['userdoesnotexist'] = 'User does not exist';
$string['error401'] = 'ERROR 401';
$string['loginthroughthemainwebsite'] = 'Please login through the Main Website';

