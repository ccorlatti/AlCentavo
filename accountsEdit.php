<?php
/**
* $Id$
*
* @author     Claudio Corlatti
*/
require 'library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');
IncludeHelper::inc('library/session/accounting/AccountManagment.class.php');

$tpl = new CCTemplate('static/');
$tpl->cInit('accountsEdit.html');

try {
	
	SecurityCheck::checkSession();
	
	$tpl->cSet('USER_NAME', $_SESSION['user']['name']);
	
	//request parameters
	$idAccount = SecurityCheck::sanitize($_GET['idAccount']);
	
	
	//account types
	$am = new AccountManagment();
	$accountTypes = $am->getAccountTypes($idAccount);
	
	foreach($accountTypes as $accountType){
		$tpl->cSet('ACCOUNT_TYPE_ID',$accountType['id']);
		$tpl->cSet('ACCOUNT_TYPE_DESCRIPTION',$accountType['description']);
		$tpl->cSet('ACCOUNT_TYPE_SELECTED','');
		$tpl->cParse('ROW_ACCOUNT_TYPE');
	}
	
	
	
	
	
} catch (Exception $e){
	$tpl->cSet('ERROR', $e->getMessage());
	$tpl->cParse('OPT_ERROR');	
}

$tpl->cPrint();
?>