<?php
/**
* $Id$
* @author     Claudio Corlatti
* 
*/
require 'library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');

$tpl = new CCTemplate('static/');
$tpl->cInit('accounts.html');

try {
	
	SecurityCheck::checkSession();
	
	$tpl->cSet('USER_NAME', $_SESSION['user']['name']);
	
	
	
} catch (Exception $e){
	$tpl->cSet('ERROR', $e->getMessage());
	$tpl->cParse('OPT_ERROR');	
}

$tpl->cPrint();
?>