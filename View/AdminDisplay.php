<?php

/**
 * Gére l'affichage des interfaces admin
 */
class AdminDisplay extends Display {
	
	/**
	 * Données données par le controller
	 */
	private $data;	
	
	/**
	 * Contructeur avec les données à afficher
	 */
	function __construct($data) {
		$this->data = $data;
	} 
	
	/**
	 * Affiche la page de base html
	 */
	public function displayPage($action){
		try{
			$body = $this->$action();
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			echo "Line :".$e->getLine();
			echo "Code :".$e->getCode();
			$body = "Méthode d'affichage non correct";
		}
	echo '<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="utf-8">
			<title>Administration</title>
			<link rel="stylesheet" href="data/css/site.css"/>
		</head>
		<body>
			<div id="conteneur">'.$this->generateLeftMenu().$body.'</div>
		</body>
	</html>';
	}
	
	/**
	 * Prépare l'affichage de la page de création d'un nouveau message
	 * @return String contenu à afficher
	 * 
	 */
	private function newMessage(){
		$html = '<section class=adminPanel><h1>Nouveau message</h1>';
		if(!empty($this->data['categories'])){
			if(!empty($this->data['error']))
				$html .= '<div>'.$this->data['error'].'</div>';
			$html .= '<form method="post" action="Admin.php?a=saveM">
					<input type="hidden" name="jeton" value="'.$this->data['jeton'].'" />
					<label for="titre">Titre du message</label><br />
					<input required autofocus type="text" name="titre" id="titre" value="'.$this->data['titre'].'"/><br />
					<label for="contenu">Contenu du message</label><br />
					<textarea id="contenu" name="contenu" required>'.$this->data['contenu'].'</textarea><br />
					<label for="cat_id">Catégorie du message</label>
					<select id="cat_id" name="cat_id">';
			foreach ($this->data['categories'] as $categorie) {
				$html .= '<option value="'.$categorie->__get('id').'">'.$categorie->__get('titre');
			}
			$html .= '</select><br />
				<input type="submit" value="Sauver" />
				</form></section>';
		}else{
			$html .= '<div class=error>Impossible veuillez définir les catégories avant ajout de messages</div></section>';
		}
		return $html;
	}
	
	/**
	 * Prépare l'affichage de la page de confirmation d'enregistrement de message
	 * @return String contenu à afficher
	 * 
	 */
	private function messageEnregistre(){
		return '<section class=adminPanel>Message enregistrée</section>';
	}
	
	/**
	 * Prépare l'affichage de la page d'acceuil adminstrateur
	 * @return String contenu à afficher
	 * 
	 */
	private function home(){
		return '<section class=adminPanel>Selectionnez une action sur le menu de gauche</section>';
	}

	/**
	 * Prépare l'affichage du menu de gauche
	 * @return String menu à afficher
	 * 
	 */
	protected function generateLeftMenu(){
		return '<nav class=menu><ul>
			<li><a href="Admin.php?a=addM">Ajouter un message</a></li>
			<li><a href="Admin.php?a=addC">Ajouter une catégorie</a></li>
			<li><a href="Blog.php">Retour au site</a></li></ul></nav>';
	}
	
	/**
	 * Supprimer le menu de droite, non nécessaire pour la connexion
	 * @return String vide
	 * 
	 */	
	protected function generateRightMenu()
	{
		return '';
	}

	/**
	 * Prépare l'affichage de la page d'ajout de catégorie
	 * @return String contenu à afficher
	 * 
	 */
	private function newCategorie(){
		$html = '<section class=adminPanel><h1>Nouvelle catégorie</h1>';

		if(!empty($this->data['error']))
			$html .= '<div>'.$this->data['error'].'</div>';
		$html .= '<form method="post" action="Admin.php?a=saveC">
			<input type="hidden" name="jeton" value="'.$this->data['jeton'].'" />
			<label for="titre">Titre de la catégorie</label><br />
			<input required autofocus class=titre type="text" id="titre" name="titre" value="'.$this->data['titre'].'"/><br />
			<label for="description">Contenu de la catégorie</label><br />
			<textarea name="description" id="description" required>'.$this->data['description'].'</textarea><br />
			<input type="submit" value="Sauver" />
			</form></section>';
			return $html;
	}
	
	/**
	 * Prépare l'affichage de la page de confirmation de nouvelle catégorie
	 * @return String contenu à afficher
	 * 
	 */
	private function categorieEnregistre(){
		return '<section class=adminPanel>Catégorie enregistrée</section>';
	}
	
}
