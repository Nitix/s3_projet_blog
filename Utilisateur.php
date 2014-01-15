<?php
//Appelle le controlleur Utilisateur
require_once('common.php');

$action = UserController::callAction();
UserController::$action();

?>