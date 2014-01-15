<?php
//fonctions neccessaires au bon fonctionnement du site

//crée la session
session_start();

//A mettre à true, pour le débugage, renvoie toutes les exceptions
define('DEBUG', true);

//Crée un jeton si besoin
if(!isset($_SESSION['jeton']))
	$_SESSION['jeton'] = hash('sha256', uniqid());

//class loader des fonctions crée
function loadClasses($classname) {
	 // le répertoire d'installation de l'application
	 if (is_file( $classname.'.php' )) require_once $classname.'.php' ;
	 $myAppDirs = array( 'Controller', 'Model', 'View') ; 
	 foreach ($myAppDirs as $cdir) {
		 $filepath = $cdir .DIRECTORY_SEPARATOR . $classname . '.php' ; 
		 if (is_file( $filepath )) require_once $filepath ;
	 }
}

//appel le loader des bibliothèques
require_once 'autoload'.DIRECTORY_SEPARATOR.'autoload.php';

//enregistre le loader
spl_autoload_register('loadClasses');

?>