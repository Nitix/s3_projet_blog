<?php

require_once('common.php');

$action = UserController::callAction();
UserController::$action();

?>