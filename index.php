<?php

require_once('common.php');

$action = BlogController::callAction();
BlogController::$action();

?>