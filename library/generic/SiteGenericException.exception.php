<?php
/**
 * $Id: SiteGenericException.exception.php 12 2010-07-06 04:34:57Z corlatti $
 * @author Claudio Corlatti
 *
 */
class SiteGenericException extends Exception {
	
	//array that contents this
	// array(array(0 => idLanguage, 1 => Localized text))
	public $errorMessage;
	
	/**
	 * 
	 *@param message[optional] 
	 *@param code[optional] 
	 */
	public function __construct($message, $code=9999) {
		$this->errorMessage = $message;
		parent::__construct ( get_class(self), $code );
	}
	
	public final function getErrorMessage(){
		$result = null;
		try {
			if($this->errorMessage != ''){
				$result = $this->errorMessage;
			} else {
				$result = _('Runtime exception. Description not available.');
			}
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}
	
	
}

?>
