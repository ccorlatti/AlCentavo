<?php
/**
 * $Id$
 * 
 * @author Claudio Corlatti
 *
 */
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
	
	public static function checkSession(){
		try {
			if(empty($_SESSION['loggedIn'])){
				Util::irA('index.php');
			}
		} catch (Exception $e){
			throw $e;
		}
	}
	
	public static function checkAjaxSession(){
		try {
			if(empty($_SESSION['loggedIn'])){
				throw new Exception('Forbidden request.');
			}
		} catch (Exception $e){
			throw $e;
		}
	}	

}

?>