<?php

function loadClasses($classname) {
	 // le répertoire d'installation de l'application
	 if (is_file( $classname.'.php' )) require_once $classname.'.php' ;
	 $myAppDirs = array( 'Controller', 'Model', 'View') ; 
	 foreach ($myAppDirs as $cdir) {
		 $filepath = $cdir .DIRECTORY_SEPARATOR . $classname . '.php' ; 
		 if (is_file( $filepath )) require_once $filepath ;
	 }
}

spl_autoload_register('loadClasses');

$action = BlogController::callAction($_GET);
BlogController::$action();

?>