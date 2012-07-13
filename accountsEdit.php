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
	$action = SecurityCheck::sanitize($_GET['action']);
	

	$am = new AccountManagment();
	
	//am i editing?	
	$tpl->cSet('ID_ACCOUNT', $idAccount);
	if(!empty($idAccount)){
		//check permission
		$idUser = $_SESSION['user']['id'];
		$permission = empty($idAccount) ? true : $am->doIHavePermissionForThisAccount($idAccount, $idUser);
		if(!$permission){
			throw new Exception('Ups! no tenes permiso para operar sobre esta cuenta.');
		}

		//delete
		if($action == 'delete'){
			echo 'deleted';
		}
		
		$tpl->cParse('OPT_DELETE_BUTTON');
		$tpl->cParse('OPT_DELETE_BUTTON_FOOTER');
		$account = $am->getAccountById($idAccount);
		$tpl->cSet('ACCOUNT_DESCRIPTION', $account['description']);
		$tpl->cSet('BANK_SELECTED', $account['idBank']);
		
	}
	
	//account types
	$accountTypes = $am->getAccountTypes($idAccount);
	foreach($accountTypes as $accountType){
		$tpl->cSet('ACCOUNT_TYPE_ID',$accountType['id']);
		$tpl->cSet('ACCOUNT_TYPE_DESCRIPTION',$accountType['description']);
		$tpl->cSet('ACCOUNT_TYPE_SELECTED', count($accountType['Account']) > 0 ? 'selected' : '');
		$tpl->cSet('REQUIRE_BANK', $accountType['bankRequired'] == 1 ? 'bankRequired' : 'bankOptional');
		$tpl->cParse('ROW_ACCOUNT_TYPE');
	}
	
	//available currencies
	$currencies = $am->getCurrencies($idAccount);
	foreach($currencies as $currency){
		$tpl->cSet('ACCOUNT_CURRENCY_ID',$currency['id']);
		$tpl->cSet('ACCOUNT_CURRENCY_DESCRIPTION',$currency['description'] . ' (' . $currency['symbol'] . ')');
		$tpl->cSet('ACCOUNT_CURRENCY_SELECTED', count($currency['Account']) > 0 ? 'selected' : '');
		$tpl->cParse('ROW_ACCOUNT_CURRENCY');
	}
	
	
	//country
	$tpl->cSet('MY_COUNTRY_ISO',$_SESSION['user']['Userdata'][0]['Country']['iso2']);
	$tpl->cSet('MY_COUNTRY_ID',$_SESSION['user']['Userdata'][0]['Country']['country_id']);
	$tpl->cSet('MY_COUNTRY_DESCRIPTION',$_SESSION['user']['Userdata'][0]['Country']['short_name']);
	
	$tpl->cParse('OPT_FORM');
	
} catch (Exception $e){
	$tpl->cSet('ERROR', $e->getMessage());
	$tpl->cParse('OPT_ERROR');	
}

$tpl->cPrint();
?>