<?php
/**
* $Id$
*
*/
require 'library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');

$tpl = new CCTemplate('static/');
$tpl->cInit('index.html');

try {
	
	
	
} catch (Exception $e){
	$tpl->cSet('ERROR', $e->getMessage());
	$tpl->cParse('OPT_ERROR');	
}

$tpl->cPrint();
?>