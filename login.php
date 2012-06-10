<?php
/**
* $Id$
*
*/
require 'library/bootstrap/prepend.php';
IncludeHelper::inc('library/generic/SessionHandler.class.php');
IncludeHelper::inc('library/util/SecurityCheck.class.php');
IncludeHelper::inc('library/session/users/UserManagment.class.php');

$tpl = new CCTemplate('static/');
$tpl->cInit('login.html');

try {
	
	$action = SecurityCheck::sanitize($_POST['action']);
	
	SessionHandler::close();
	
	switch ($action){
		case 'login':
			$username = SecurityCheck::sanitize($_POST['email']);
			$password = SecurityCheck::sanitize($_POST['password']);
			
			$userManagment = new UserManagment();
			$user = $userManagment->login($username, $password);

			if(is_array($user)){
				
				//erase encrypted password data
				$user['password'] = '';
				
				SessionHandler::setValue('isLoggedIn', true);
				SessionHandler::setValue('user', $user);
				
				Util::irA('dashboard.php');
				exit();
			}
			break;
	}
	
	
} catch (Exception $e){
	$tpl->cSet('ERROR', $e->getMessage());
	$tpl->cParse('OPT_ERROR');	
}

$tpl->cPrint();
?>