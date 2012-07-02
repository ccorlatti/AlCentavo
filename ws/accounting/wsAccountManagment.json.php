<?php
/**
 * $Id$
 *
 */
require '../../library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');
IncludeHelper::inc('library/session/response/GenericResponse.class.php');
IncludeHelper::inc('library/session/accounting/AccountManagment.class.php');

//request data
$accountType = SecurityCheck::sanitize($_POST['accountType']);
$bank = SecurityCheck::sanitize($_POST['bank']);
$accountDescription = SecurityCheck::sanitize($_POST['accountDescription']);
$accountInitialBalance = SecurityCheck::sanitize($_POST['accountInitialBalance']);
$action = SecurityCheck::sanitize($_POST['action']);
$idAccount = SecurityCheck::sanitize($_POST['idAccount']);
$currency = SecurityCheck::sanitize($_POST['currency']);

$output = new GenericResponse();
try {

	SecurityCheck::checkAjaxRequest();
	
	$accountManagment = new AccountManagment();
	
	//check permission 
	$idUser = $_SESSION['user']['id'];
	$permission = empty($idAccount) ? true : $accountManagment->doIHavePermissionForThisAccount($idAccount, $idUser);
	if(!$permission){
		throw new Exception('No tiene permiso para operar sobre esta cuenta.');
	}
	
	//action
	switch($action){
		case 'save':
			
			$basicData = array(
				'description' => $accountDescription,
				'idBank' => $bank,
				'idCurrency' => $currency,
				'idAccountType' => $accountType,
				'initialBalance' => $accountInitialBalance
			);
						
			$idAccount = $accountManagment->saveSimpleAccount($idAccount, $idUser, $basicData);
			
			break;
		case 'delete':
			
			break;
	}
	
	

} catch (Exception $e){
	$output->result['error'] = true;
	$output->result['description'] = $e->getMessage();
}

echo json_encode($output);

?>

