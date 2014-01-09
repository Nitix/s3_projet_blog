<?php
	
class AdminController extends Controller
{

	protected static $actions = array(
		'addM' 		=> 'AddMessage',
		'saveM' 	=> 'saveMessage',
		'addC' 		=> 'addCategorie',
		'saveC' 	=> 'saveCategorie'
	);
	
	public static function home(){
		$display = new AdminDisplay(null);
		$display->displayPage('home');
	} 
	
	public static function addMessage($error = '', $titre = '', $contenu = '' ){
		$data['contenu'] = $contenu;
		$data['titre']   = $titre;
		$data['error']	 = $error;
		$data['jeton']	 = $_SESSION['jeton'];
		$display = new AdminDisplay($data);
		$display->displayPage('newMessage');
	}
	
	public static function saveMessage(){
		$data['contenu'] = '';
		$data['titre']   = '';
		$data['cat_id']  = -1;
		if(isset($_POST['contenu']) && isset($_POST['titre']) && isset($_POST['cat_id']) && isset($_POST['jeton'])){
			$data['contenu'] = htmlspecialchars($_POST['contenu']);
			$data['titre']   = htmlspecialchars($_POST['titre']);			
			if(!empty($data['contenu']) && !empty($data['titre'])){	
				if($_POST['jeton'] == $_SESSION['jeton']){ 	
					$data['cat_id'] = intval($_POST['cat_id']);
					try{
						Categorie::findById($data['cat_id']);
						try{
							$billet = new Billet();
							$billet->__set('titre', $data['titre']);
							$billet->__set('body', $data['contenu']);
							$billet->__set('cat_id', $data['cat_id']);
							$billet->__set('date', date("Y-m-d H:i:s"));
							$res = $billet->insert();
							if($res){
								$display = new AdminDisplay($data);
								$display->displayPage('messageEnregistre');	
							}else{
								self::addMessage("Erreur lors de l'ajout", $data['titre'], $data['contenu']);
							}
						}catch(Exception $e){
							self::addMessage("Erreur lors de l'ajout", $data['titre'], $data['contenu']);
							
						}
					}catch(Exception $e){
						self::addMessage("Catégorie inexistante", $data['titre'], $data['contenu']);
					}
				}else{
					self::addMessage("Hackeur ?", $data['titre'], $data['contenu']);
				}
			}else{
				self::addMessage("Titre ou contenu vide", $data['titre'], $data['contenu']);
			}
		}else{
			self::addMessage("Hackeur ?");
		}	
	}
	
	
	public static function saveCategorie(){
		$data['titre'] = '';
		$data['description'] = '';
		if(isset($_POST['description']) && isset($_POST['titre']) && isset($_POST['jeton'])){
			$data['description'] = htmlspecialchars($_POST['description']);
			$data['titre']   = htmlspecialchars($_POST['titre']);			
			if(!empty($data['description']) && !empty($data['titre'])){	
				if($_POST['jeton'] == $_SESSION['jeton']){ 	
					try{
						$categorie = new Categorie();
						$categorie->__set('titre', $data['titre']);
						$categorie->__set('description', $data['description']);
						$res = $categorie->insert();
						if($res){
							$display = new AdminDisplay($data);
							$display->displayPage('categorieEnregistre');	
						}else{
							$data['error'] = "Erreur lors de l'ajout";
							$display = new AdminDisplay($data);
							$display->displayPage('newCategorieError');	
						}
					}catch(Exception $e){
						$data['error'] = "Erreur lors de l'ajout";
						$display = new AdminDisplay($data);
						$display->displayPage('newCategorieError');
						
					}
				}else{
					$data['error'] = "Hackeur ?";
					$display = new AdminDisplay($data);
					$display->displayPage('newCategorieError');
				}
			}else{
				$data['error'] = "Titre ou description vide";
				$display = new AdminDisplay($data);
				$display->displayPage('newCategorieError');				
			}
		}else{
			$data['error'] = "Hackeur ?";
			$display = new AdminDisplay($data);
			$display->displayPage('newCategorieError');
		}	
	}
}