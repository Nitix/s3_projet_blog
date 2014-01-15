<?php
//Appelle le controlleur Blog

require_once('common.php');

$action = BlogController::callAction();
BlogController::$action();

?>