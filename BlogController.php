<?php
	
class BlogController
{
	private static $actions = array(
		'list' => 'listAction',
		'detail' => 'detailAction',
		'cat' => 'catAction'
	);
		
	
	public static function listAction(){
		try{
			$billets = Billet::findAll();
			$display = new Display($billets);
			$display->displayPage('listBillets');
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération des billets';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
	public static function detailAction(){
		try{
			if(!isset($_GET['id']))
				throw new Exception('Identifiant non valide');
			$billets = Billet::findById($_GET['id']);
			$display = new Display($billets);
			$display->displayPage('billet');
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération des billets';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
	public static function catAction(){
		try{
			if(!isset($_GET['id']))
				throw new Exception('Identifiant non valide');
			$billets = Billet::findByCat_ID($_GET['id']);
			$display = new Display($billets);
			$display->displayPage('catDetail');
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération des billets';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
	
	public static function callAction($requete){
		if(isset($requete['a'])){
			return BlogController::$actions[$requete['a']];
		}else{
			return 'listAction';
		}
	}
}