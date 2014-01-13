<?php
	
class BlogController extends Controller
{
	protected static $actions = array(
		'list' 		=> 'listAction',
		'detail' 	=> 'detailAction',
		'cat' 		=> 'catAction',
		'listCat'	=> 'listCatAction',
		'autor'		=> 'userAction'
	);
		
	public static function home(){
		self::last10BilletsAction();
	}
	
	public static function listAction(){
		try{
			$billets = Billet::findAll();
			$display = new BlogDisplay($billets);
			$display->displayPage('listBillets');
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$error = 'Erreur lors de la récupération des billets';
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
				$billets = Billet::findById($_GET['id']);
				$display = new BlogDisplay($billets);
				$display->displayPage('billet');
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$error = 'Erreur lors de la récupération du billet';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
	public static function catAction(){
		try{
			if(!isset($_GET['id'])){
				$error = 'Identifiant non valide';
				$display = new Display($error);
				$display->displayPage('error');
			}else{
				$cat = Categorie::findById($_GET['id']);
				$display = new BlogDisplay($cat);
				$display->displayPage('catDetail');
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$error = 'Erreur lors de la récupération de la catégorie';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
	public static function listCatAction(){
		try{
			$cats = Categorie::findAll();
			$display = new BlogDisplay($cats);
			$display->displayPage('listCats');
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$error = 'Erreur lors de la récupération des catégories';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}

	public static function userAction(){
		try{
			if(!isset($_GET['id'])){
				$error = 'Identifiant non valide';
				$display = new Display($error);
				$display->displayPage('error');
			}else{
				$user = User::findById($_GET['id']);
				$display = new BlogDisplay($user);
				$display->displayPage('userDetail');
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$error = 'Erreur lors de la récupération de l\'auteur';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}		

	public static function last10BilletsAction(){
		try{
			$billets = Billet::findLastLimited(10);
			$display = new BlogDisplay($billets);
			$display->displayPage('last10billets');
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$error = 'Erreur lors de la récupération des billets';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
}