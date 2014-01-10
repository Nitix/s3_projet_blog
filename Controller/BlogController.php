<?php
	
class BlogController extends Controller
{
	protected static $actions = array(
		'list' 		=> 'listAction',
		'detail' 	=> 'detailAction',
		'cat' 		=> 'catAction'
	);
		
	public static function home(){
		self::listAction();
	}
	
	public static function listAction(){
		try{
			$billets = Billet::findAll();
			$display = new BlogDisplay($billets);
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
			$display = new BlogDisplay($billets);
			$display->displayPage('billet');
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération des billets';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
	public static function catAction(){
		try{
			if(!isset($_GET['id'])){
				$display = new BlogDisplay('Identifiant manquant');
				$display->displayPage('error');
			}else{
				$cat = Categorie::findById($_GET['id']);
				$display = new BlogDisplay($cat);
				$display->displayPage('catDetail');
			}
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération des billets';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
}