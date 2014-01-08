<?php

require_once('common.php');

$action = AdminController::callAction();
AdminController::$action();

?>