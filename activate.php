<?php
/**
* $Id$
*
*/
require 'library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');
IncludeHelper::inc('library/session/users/UserManagment.class.php');

$tpl = new CCTemplate('static/');
$tpl->cInit('activate.html');

$validationCode = SecurityCheck::sanitize($_GET['key']);
$id = SecurityCheck::sanitize($_GET['id']);

try {
	
	$user = new UserManagment();
	$user->activate($id, $validationCode);
	
	$tpl->cParse('OPT_OK');
	
	
} catch (Exception $e){
	$tpl->cSet('ERROR', $e->getMessage());
	$tpl->cParse('OPT_ERROR');	
}

$tpl->cPrint();
?>