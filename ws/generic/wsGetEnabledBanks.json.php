<?php
/**
 * $Id$
 * @author     Claudio Corlatti
 * 
 */
require '../../library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');
IncludeHelper::inc('library/session/response/GenericResponse.class.php');
IncludeHelper::inc('library/session/accounting/AccountManagment.class.php');


$output = new GenericResponse();
try {
	
	SecurityCheck::checkAjaxRequest();
	
	$idCountry = SecurityCheck::sanitize($_POST['country']);
	
	//get banks list
	$am = new AccountManagment();
	$banks = $am->getEnabledBanks($idCountry);
	
	$output->response = $banks;
		
} catch (Exception $e){
	$output->result['error'] = true;
	$output->result['description'] = $e->getMessage();
	
}

echo json_encode($output);

?>