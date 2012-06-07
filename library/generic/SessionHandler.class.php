<?php
/**
 * $Id: SessionHandler.class.php 12 2010-07-06 04:34:57Z corlatti $
 * @author Claudio Corlatti
 *
 */
/**
 * Session handler
 * 
 * $_SESSION var structure
 * 
 * $_SESSION[
 * 		login => [ 
 * 					isLoggedIn,	userName,
 * 					groups => [ id, description ]
 * 				 ],
 * 		preferences => [ lang ],
 * 		personal => [ fullName, nickName, defaultMail ] 
 * ]
 *
 */
final class SessionHandler {
	
	private $session;
	
	/**
	 * 
	 */
	function __construct() {
		
	}
	
	/**
	 * returns session var value
	 *
	 * @param unknown_type $var
	 * @param unknown_type $defaultValue
	 * @return unknown
	 * @todo tries to get the value from cookie
	 */
	public function getValue($var, $defaultValue){
		$resultado = $defaultValue;
		try {
			//tries to get the value from session
			if(isset($_SESSION[$var])){
				$resultado = $_SESSION[$var];
			} else {
				//tries to get the value from cookie
			}
		} catch(Exception $e){
			throw $e;
		}
		return $resultado;
	}
}

?>
