<?php

class UserController{
	
	protected static $actions = array(
		'list' 		=> 'listAction',
		'detail' 	=> 'detailAction',
	);
		
	public static function home(){
		self::listAction();
	}

	public static function listAction(){
		try{
			$display = new UserDisplay(User::findAll());
			$display->displayPage('list');
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération des utilisateurs';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}	
	
	public static function detailAction(){
		try{
			if(!isset($_GET['id'])){
				$error = 'Identifiant non valide';
				$display = new Display($error);
				$display->displayPage('error');
			}else{				
				$user = User::findById($_GET['id']);
				$display = new UserDisplay($user);
				$display->displayPage('billet');
			}
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération de l\'utilisateur';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
}