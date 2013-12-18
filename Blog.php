<?php

function loadClasses($class_name) {
    include $class_name . '.php';
}

spl_autoload_register('loadClasses');

$action = BlogController::callAction($_GET);
BlogController::$action();

?>