<?php
/**
* $Id$
*
*/
require 'library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');


$tpl = new CCTemplate('static/');
$tpl->cInit('login.html');

try {
	
	$action = SecurityCheck::sanitize($_POST['action']);
	
	
	
	switch ($action){
		case 'login':
			
			
			$username = SecurityCheck::sanitize($_POST['email']);
			$password = SecurityCheck::sanitize($_POST['password']);
			$remember = SecurityCheck::sanitize($_POST['remember']);
			
			$userManagment = new UserManagment();
			$user = $userManagment->login($username, $password);

			if(is_array($user)){
				
				if(!empty($remember)){
					SecurityCheck::remember($username, sha1($password));
				}
				
				
				SessionHandler::setValue('isLoggedIn', 1);
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