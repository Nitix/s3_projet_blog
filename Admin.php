<?php

require_once('common.php');

try{
	Authenticate::checkAccessRights(1);
}catch(Exception $e){
	echo "Vous n'avez pas les droits admins";
	die();
}

$action = AdminController::callAction();
AdminController::$action();

?>