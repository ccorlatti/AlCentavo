<?php
/**
 * $Id$
 * 
 * @author Claudio Corlatti
 *
 */
IncludeHelper::inc('library/generic/SessionHandler.class.php');
IncludeHelper::inc('library/session/users/UserManagment.class.php');

class SecurityCheck {
		
	
	public static function checkAjaxRequest() {
		try {
			//print_r($_SERVER);
		

			//perform some security check
			SecurityCheck::checkAjaxSession();

		} catch ( Exception $e ) {
			throw $e;
		}
	}
	
	public static function sanitize($string) {
		$result = '';
		try {
			if (get_magic_quotes_gpc ()) {
				$string = stripslashes ( $string );
			}
			if (phpversion() >= '4.3.0') {
				$string = $string;
			} else {
				$string = $string;
			}
			$result = $string;
		} catch ( Exception $e ) {
			throw $e;
		}
		return $result;
	}
	
	
	public static function remember($username, $password){
		try {
			
			setcookie (REMEMBER_COOKIE_NAME, 'username=' . $username . '&hash=' . $password , time() + (3600 * 24 * 30));

		} catch (Exception $e){
			throw $e;
		}
		
	}
	
	
	public static function checkAutoLogin(){
		$result = false;
		try {
			
			if(isset($_COOKIE[REMEMBER_COOKIE_NAME])){
				
				parse_str($_COOKIE[REMEMBER_COOKIE_NAME]);
				$password = $hash; 
				
				$userManagment = new UserManagment();
				try {
					$user = $userManagment->login($username, $password, true);
					
					if(is_array($user)){
						SessionHandler::setValue('isLoggedIn', 1);
						SessionHandler::setValue('user', $user);
							
						$result = true;
					}					
				} catch (Exception $e){
				}
				 
				
			}
			 
			
		} catch (Exception $e){
			throw $e;
		}
		return $result;
	}
	
	public static function checkSession(){
		try {			
			print_r($_SESSION);
			if(SessionHandler::getValue('isLoggedIn', 0) == 0){
				
				if(!SecurityCheck::checkAutoLogin()){
					Util::irA('login.php');
				}
			}
		} catch (Exception $e){
			throw $e;
		}
	}
	
	public static function checkAjaxSession(){
		try {
			if(SessionHandler::getValue('isLoggedIn', 0) == 0){
				throw new Exception('Forbidden request.');
			}
		} catch (Exception $e){
			throw $e;
		}
	}	

}

?>