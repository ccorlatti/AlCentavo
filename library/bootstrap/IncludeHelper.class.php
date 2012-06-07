<?php
/**
 * workaround nested includes
 *
 * $Id: IncludeHelper.class.php 12 2010-07-06 04:34:57Z corlatti $
 * @author Claudio Corlatti
 *
 */
final class IncludeHelper {

	static function inc($path) {
		try {
			require_once SITE_FOLDER . $path;
		} catch (Exception $ex){
			throw $ex;
		}
	}
	
	static function getPath($path) {
		return SITE_FOLDER . $path;
	}
}

?>
