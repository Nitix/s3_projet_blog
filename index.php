<?php

//permet d'afficher le blog, quand on rentre l'adresse sans "Blog.php"
require_once('common.php');

$action = BlogController::callAction();
BlogController::$action();

?>