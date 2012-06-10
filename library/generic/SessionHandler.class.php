<?php
/**
 * $Id: SessionHandler.class.php 12 2010-07-06 04:34:57Z corlatti $
 * @author Claudio Corlatti
 *
 */
/**
 * Session handler
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
	 */
	public static function getValue($var, $defaultValue){
		$resultado = $defaultValue;
		try {
			//tries to get the value from session
			if(isset($_SESSION[$var])){
				$resultado = $_SESSION[$var];
			} else {
				//TODO tries to get the value from cookie
			}
		} catch(Exception $e){
			throw $e;
		}
		return $resultado;
	}
	
	
	public static function setValue($var, $value){
		try {
			$_SESSION[$var] = $value;
		} catch(Exception $e){
			throw $e;
		}
	}	
	
	public static function close(){
		try {
			$_SESSION[] = array();
			session_destroy();
		} catch(Exception $e){
			throw $e;
		}
	}
	
}

?>
