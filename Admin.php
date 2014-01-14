<?php

require_once('common.php');

Authenticate::checkAccessRights(1);

$action = AdminController::callAction();
AdminController::$action();

?>