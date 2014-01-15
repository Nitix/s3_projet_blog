<?php
	
/**
 * Gére les affichages utilisateurs
 */
class BlogController extends Controller
{
	/**
	 * Liste des actions
	 */
	protected static $actions = array(
		'list' 		=> 'listAction',
		'detail' 	=> 'detailAction',
		'cat' 		=> 'catAction',
		'listCat'	=> 'listCatAction',
		'listUser' 		=> 'listUserAction',
		'detailUser' 	=> 'detailUserAction',
		'autor'		=> 'userAction',
		'saveComment' => 'saveComment'
	);
	
	/**
	 * Action par défault, s'éxecute en cas d'action incorrect et en page de garde
	 */
	public static function home(){
		self::last10BilletsAction();
	}
	
	/**
	 * Affiche la liste des billets
	 */
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
	
	/**
	 * Affiche le contenu détaillé du billet
	 */
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
	
	/**
	 * Affiche le contenu de la catégorie
	 */
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
	
	/**
	 * Affiche la liste des catégories
	 */
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

	/**
	 * Affiche l'utilisateur demandée
	 */
	public static function userAction(){
		try{
			if(!isset($_GET['id'])){
				$error = 'Identifiant non valide';
				$display = new Display($error);
				$display->displayPage('error');
			}else{
				$user = User::findById($_GET['id']);
				$display = new BlogDisplay($user);
				$display->displayPage('autor');
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$error = 'Erreur lors de la récupération de l\'auteur';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}		

	/**
	 * Affiche la liste des 10 derniers billets page d'accueil
	 */
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
	
	/**
	 * Affiche la liste des utilisateurs
	 */
	public static function listUserAction(){
		try{
			$display = new BlogDisplay(User::findAll());
			$display->displayPage('listUsers');
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération des utilisateurs';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}	
	
	/**
	 * Affiche les détails d'un utilisateurs
	 */
	public static function detailUserAction(){
		try{
			if(!isset($_GET['id'])){
				$error = 'Identifiant non valide';
				$display = new Display($error);
				$display->displayPage('error');
			}else{				
				$user = User::findById($_GET['id']);
				$display = new BlogDisplay($user);
				$display->displayPage('user');
			}
		}catch(Exception $e){
			$error = 'Erreur lors de la récupération de l\'utilisateur';
			$display = new Display($error);
			$display->displayPage('error');
		}
	}
	
	/**
	 * Enregistre le commentaire
	 */
	public static function saveComment(){		
		if(isset($_POST['contenu'])&& isset($_POST['id']) && isset($_POST['jeton'])){
			$contenu = htmlspecialchars($_POST['contenu']);
			if(!empty($contenu)){	
				if($_POST['jeton'] == $_SESSION['jeton']){
					try{
						$billet = Billet::findById($_POST['id']); 						
						if(!empty($billet)){
							$comment = new Comment();
							$comment->__set('billet_id', $_POST['id']);
							$comment->__set('user_id', $_SESSION['id']);
							$comment->__set('contenu', $contenu);
							$res = $comment->insert();
							if($res){
								$display = new BlogDisplay('');
								$display->displayPage('commentEnregistre');	
							}else{
								$error = "Erreur lors de l'ajout";	
								$display = new Display($error);
								$display->displayPage('error');		
							}
						}else{
							$error = "Erreur lors de l'ajout";	
							$display = new Display($error);
							$display->displayPage('error');	
						}
					}catch(Exception $e){
						if(DEBUG)
							throw $e; 
						$error = "Erreur lors de l'ajout";	
						$display = new Display($error);
						$display->displayPage('error');
					}
				}else{
					$error = 'Erreur - c\tétait moins une (hack)';
					$display = new Display($error);
					$display->displayPage('error');	
				}
			}else{
				$error = 'Erreur - Contenu vide';
				$display = new Display($error);
				$display->displayPage('error');	
			}
		}else{
			$error = 'Erreur';
			$display = new Display($error);
			$display->displayPage('error');	
		}	
	}
}