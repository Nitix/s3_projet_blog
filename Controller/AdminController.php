<?php
	
class AdminController extends Controller
{

	protected static $actions = array(
		'AddM' => 'AddMessage',
		'saveM' => 'saveMessage',
		'addC' => 'addCategorie',
		'saveC' => 'saveCategorie'
	);
	
	public static function addMessage(){
		$jeton = hash('sha-256', uniqid());
		$_SESSION['jeton'] = $jeton;
		$display = new AdminDisplay($jeton);
		$display->displayPage('newMessage');
	}
	
	public static function saveMessage(){
		$data['contenu'] = '';
		$data['titre']   = '';
		$data['cat_id']  = -1;
		if(isset($_POST['contenu']) && isset($_POST['titre']) && isset($_POST['cat_id']) && isset($_POST['jeton'])){
			$data['contenu'] = htmlspecialchars($_POST['contenu']);
			$data['titre']   = htmlspecialchars($_POST['titre']);			
			if(!empty($contenu) && !empty($titre)){	
				if($_POST['jeton'] == $_SESSION['jeton']){ 	
					$data['cat_id'] = $_POST['cat_id'];
					try{
						Categorie::findById($cat_id);
						try{
							$billet = new Billet();
							$billet->__set('titre', $data['titre']);
							$billet->__set('body', $data['contenu']);
							$billet->__set('cat_id', $data['contenu']);
							$billet->__set('date', date("Y-m-d H:i:s"));
							$res = $billet->insert();
							if($res){
								$display = new AdminDisplay($data);
								$display->displayPage('messageEnregistre');	
							}else{
								$data['error'] = "Erreur lors de l'ajout";
								$display = new AdminDisplay($data);
								$display->displayPage('newMessageError');	
							}
						}catch(Exception $e){
							$data['error'] = "Erreur lors de l'ajout";
							$display = new AdminDisplay($data);
							$display->displayPage('newMessageError');
							
						}
					}catch(Exception $e){
						$data['error'] = "Catégorie inexistante";
						$display = new AdminDisplay($data);
						$display->displayPage('newMessageError');
					}
				}else{
					$data['error'] = "Hackeur ?";
					$display = new AdminDisplay($data);
					$display->displayPage('newMessageError');
				}
			}else{
				$data['error'] = "Titre ou contenu vide";
				$display = new AdminDisplay($data);
				$display->displayPage('newMessageError');				
			}
		}else{
			$data['error'] = "Hackeur ?";
			$display = new AdminDisplay($data);
			$display->displayPage('newMessageError');
		}	
	}
	
	public static function addCategorie(){
		$jeton = hash('sha-256', uniqid());
		$_SESSION['jeton'] = $jeton;
		$display = new AdminDisplay($jeton);
		$display->displayPage('newCategorie');
	}
	
	public static function saveCategorie(){
		$data['titre'] = '';
		$data['description'] = '';
		if(isset($_POST['description']) && isset($_POST['titre']) && isset($_POST['jeton'])){
			$data['description'] = htmlspecialchars($_POST['description']);
			$data['titre']   = htmlspecialchars($_POST['titre']);			
			if(!empty($contenu) && !empty($titre)){	
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