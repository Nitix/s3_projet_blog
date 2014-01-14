<?php

require_once('common.php');

$action = UserControlController::callAction();
UserControlController::$action();

?>