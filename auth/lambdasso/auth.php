<?php
ini_set('display_errors',1);
if (!defined('MOODLE_INTERNAL')) {
	die('Direct access to this script is forbidden.');	///  It must be included from a Moodle page
}

//require_once("config.php");
require_once($CFG->libdir.'/authlib.php');
require_once($CFG->dirroot.'/user/lib.php');

class auth_plugin_lambdasso extends auth_plugin_base {

	/**
	 * Constructor.
	 */
	function auth_plugin_lambdasso() {
		$this->authtype = 'lambdasso';
	}

	protected function redirect_lambda() {
		global $CFG;
		redirect($CFG->wwwroot, get_string('loginthroughthemainwebsite', 'auth_lambdasso'));
	}

	/**
	 * Returns true if the username and password work and false if they are
	 * wrong or don't exist.
	 *
	 * @param string $username The username
	 * @param string $password The password
	 * @return bool Authentication success or failure.
	 */
	function user_login ($username, $password) {
		$this->redirect_lambda();
		return false;
	}

	/**
	 * Updates the user's password.
	 *
	 * called when the user password is updated.
	 *
	 * @param  object  $user		User table object  (with system magic quotes)
	 * @param  string  $newpassword Plaintext password (with system magic quotes)
	 * @return boolean result
	 *
	 */
	function user_update_password($user, $newpassword) {
		$this->redirect_lambda();
		return false;
	}

	function prevent_local_passwords() {
		return false;
	}

	/**
	 * Returns true if this authentication plugin is 'internal'.
	 *
	 * @return bool
	 */
	function is_internal() {
		return false;
	}

	/**
	 * Returns true if this authentication plugin can change the user's
	 * password.
	 *
	 * @return bool
	 */
	function can_change_password() {
		return false;
	}

	/**
	 * Returns the URL for changing the user's pw, or empty if the default can
	 * be used.
	 *
	 * @return string
	 */
	function change_password_url() {
		return '';
	}

	/**
	 * Returns true if plugin allows resetting of internal password.
	 *
	 * @return bool
	 */
	function can_reset_password() {
		return true;
	}

	/**
	 * Prints a form for configuring this authentication plugin.
	 *
	 * This function is called from admin/auth.php, and outputs a full page with
	 * a form for configuring this plugin.
	 *
	 * @param array $page An object containing all the data for this page.
	 */
	function config_form($config, $err, $user_fields) {
		include 'config.html';
	}

    /**
     * A chance to validate form data, and last chance to
     * do stuff before it is inserted in config_plugin
     * @param object object with submitted configuration settings (without system magic quotes)
     * @param array $err array of error messages
     */
     function validate_form($form, &$err) {     	
     	
     }

	/**
	 * Processes and stores configuration data for this authentication plugin.
	 */
	function process_config($config) {
		global $CFG;

		set_config('returnurl', trim($config->returnurl), 'auth/lambdasso');
		set_config('redirecturl', trim($config->redirecturl), 'auth/lambdasso');
		set_config('logouturl', trim($config->logouturl), 'auth/lambdasso');
		set_config('cookiename', trim($config->cookiename), 'auth/lambdasso');
		set_config('cookiedomain', trim($config->cookiedomain), 'auth/lambdasso');
		set_config('cookiepath', trim($config->cookiepath), 'auth/lambdasso');
		set_config('cookieremove', trim($config->cookieremove), 'auth/lambdasso');
		set_config('apiurl', trim($config->apiurl), 'auth/lambdasso');
		set_config('apiattribute', trim($config->apiattribute), 'auth/lambdasso');		
		set_config('apiprocessresult', trim($config->apiprocessresult), 'auth/lambdasso');		
		set_config('auths', trim($config->auths), 'auth/lambdasso');
		set_config('auths_list', trim($config->auths_list), 'auth/lambdasso');

		return true;
	}

   /**
	 * Confirm the new user as registered. This should normally not be used,
	 * but it may be necessary if the user auth_method is changed to manual
	 * before the user is confirmed.
	 */
	function user_confirm($username, $confirmsecret = null) {

	}

	/**
	 * In case that API does not return user's IDNUMBER as string (eg. xml, array. json)
	 * please use this function to pars API response and return user's IDNUMBER as string.
	 */
	function process_api_result ($apiresult) {
		
		$xml = new SimpleXMLElement($apiresult);
		$result = (string)$xml;
		
		return $result;
	}

	function logoutpage_hook() {
		global $redirect, $CFG;


		$lambdasso = get_config('auth/lambdasso');

		if (!isset($lambdasso->logouturl))
            $logouturl = '';
        else 
        	$logouturl = $lambdasso->logouturl;

        if (!isset($lambdasso->cookiename))
            $cookiename = '';
        else 
        	$cookiename = $lambdasso->cookiename;

        if (!isset($lambdasso->cookiedomain))
            $cookiedomain = null;
        else 
        	$cookiedomain = $lambdasso->cookiedomain;

        if (!isset($lambdasso->cookiepath))
            $cookiepath = '/';
        else 
        	$cookiepath = $lambdasso->cookiepath;

        if (!isset($lambdasso->cookieremove))
            $cookieremove = 0;
        else 
        	$cookieremove = $lambdasso->cookieremove;
        
        

        if($cookieremove==1)
        	if(isset($cookiedomain))
        		setcookie($cookiename, "", time() - 3600, $cookiepath, $cookiedomain);
        	else	
        		setcookie($cookiename, "", time() - 3600, $cookiepath);
        

		if($logouturl=="")			
			$redirect = $CFG->wwwroot.'/';
		else
			$redirect = $logouturl;
		
		}
	
	function loginpage_hook() {

		global $DB, $CFG;


		$lambdasso = get_config('auth/lambdasso');

		if (!isset($lambdasso->returnurl))
            $returnurl = "";
        else 
        	$returnurl = $lambdasso->returnurl;        

        if (!isset($lambdasso->redirecturl))
            $redirecturl = 0;
        else
        	$redirecturl = $lambdasso->redirecturl;        

        if (!isset($lambdasso->cookiename))
            $cookiename = "";
        else 
        	$cookiename = $lambdasso->cookiename;

		if (!isset($lambdasso->apiurl))
            $apiurl = "";
        else
        	$apiurl = $lambdasso->apiurl;

        if (!isset($lambdasso->apiattribute))
            $apiattribute = "";
        else
        	$apiattribute = $lambdasso->apiattribute;

        if (!isset($lambdasso->apiprocessresult))
            $apiprocessresult = 0;
        else
        	$apiprocessresult = $lambdasso->apiprocessresult;

        if (!isset($lambdasso->auths))
            $auths = null;
        else
        	$auths = $lambdasso->auths;

        if (!isset($lambdasso->auths_list))
            $auths_list = null;
        else
        	$auths_list = $lambdasso->auths_list;

		

		$SESSION = $_SESSION['SESSION'];

		if (isset($SESSION->wantsurl)) {
			$urltogo = $SESSION->wantsurl;
		} else {
			$urltogo = $CFG->wwwroot.'/';
		}
		unset($SESSION->wantsurl);

		// Authentification 
		if(!empty($auths)) {
			$auths_list_elements = explode(",", $auths_list);
			$auths_list_name = $auths_list_elements[$auths];
		}

	
    	if(!empty($_COOKIE[$cookiename])){

    		
    		// Decrypt cookie using API
    		if($apiurl!="") {

    			$host = $apiurl;
				$encryptedText = $apiattribute.$_COOKIE[$cookiename];
				$ch = curl_init();      
			    curl_setopt($ch,CURLOPT_URL, $host);
			    curl_setopt($ch, CURLOPT_POST, TRUE);
			    curl_setopt($ch,CURLOPT_POSTFIELDS, $encryptedText);
			    curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);      
			    
			    $result = curl_exec($ch);
			    $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

			    // API returns result without errors
			    if($httpCode==200) {

			    	if($apiprocessresult==1)
			    		$result = $this->process_api_result($result);

			    	// Retrive user from database by API call result
			    	if(!empty($auths))
			    		$user = $DB->get_record('user', array('idnumber' => $result, 'deleted' => 0, 'suspended' => 0, 'auth'=>$auths_list_name));			    	
			    	else
						$user = $DB->get_record('user', array('idnumber' => $result, 'deleted' => 0, 'suspended' => 0));
			    }

    		} else {

    			if(!empty($auths))		
    				$user = $DB->get_record('user', array('idnumber' => $_COOKIE[$cookiename], 'deleted' => 0, 'suspended' => 0, 'auth'=>$auths_list_name));
    			else    				
					$user = $DB->get_record('user', array('idnumber' => $_COOKIE[$cookiename], 'deleted' => 0, 'suspended' => 0));
			}
	            

	        if($user) {
        		$USER = complete_user_login($user);
				redirect($urltogo); 
			} 		
    	}

    	
    	else {
    		if($returnurl!="")
    			if($redirecturl==1)
    				redirect($returnurl . '?redirect='.urlencode($urltogo), get_string('loginthroughthemainwebsite', 'auth_lambdasso'));
    			else 
    				redirect($returnurl, get_string('loginthroughthemainwebsite', 'auth_lambdasso'));    		
    	}
    	

	}
}