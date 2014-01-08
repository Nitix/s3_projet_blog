<?php

require_once('common.php');

$action = BlogController::callAction($_GET);
BlogController::$action();

?>