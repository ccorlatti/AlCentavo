<?php
/**
 * $Id$
 *
 */
require '../../library/bootstrap/prepend.php';
IncludeHelper::inc('library/util/SecurityCheck.class.php');
IncludeHelper::inc('library/session/response/GenericResponse.class.php');
IncludeHelper::inc('library/session/users/UserManagment.class.php');

//request data
$name = SecurityCheck::sanitize($_POST['name']);
$email = SecurityCheck::sanitize($_POST['email']);
$password = SecurityCheck::sanitize($_POST['password']);

$output = new GenericResponse();
try {

	$userManagment = new UserManagment();
	$userManagment->register($name,  $email, $email, $password);
	
	
	
	

} catch (Exception $e){
	$output->result['error'] = true;
	$output->result['description'] = $e->getMessage();
}

echo json_encode($output);

?>

