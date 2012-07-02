<?php
/**
* $Id$
* @author     Claudio Corlatti
* 
*/
require 'library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');
IncludeHelper::inc('library/session/accounting/AccountManagment.class.php');

$tpl = new CCTemplate('static/');
$tpl->cInit('accounts.html');

try {
	
	SecurityCheck::checkSession();
	
	$tpl->cSet('USER_NAME', $_SESSION['user']['name']);
	$idUser = $_SESSION['user']['id'];
	
	$am = new AccountManagment();
	
	$accounts = $am->getEnabledAccounts($idUser);
	if(count($accounts) > 0){
		
		foreach($accounts as $account){
			$tpl->cSet('ACCOUNT_DESCRIPTION', $account['description']);
			$tpl->cSet('ACCOUNT_ID', $account['id']);
			$tpl->cSet('ACCOUNT_TYPE', $account['Accounttype']['description']);
			$tpl->cSet('ACCOUNT_BANK', $account['Bank']['description']);
			$tpl->cSet('ACCOUNT_CURRENCY', $account['Currency']['description'] . ' (' . $account['Currency']['symbol'] . ')');
			$tpl->cParse('ROW_ACCOUNT');
		}
		
		$tpl->cParse('ROW_ACCOUNTS');
	
	} else {
		$tpl->cParse('ROW_NO_ACCOUNTS');
	}
	
} catch (Exception $e){
	$tpl->cSet('ERROR', $e->getMessage());
	$tpl->cParse('OPT_ERROR');	
}

$tpl->cPrint();
?>