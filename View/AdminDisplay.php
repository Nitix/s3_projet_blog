<?php

/**
 * 
 */
class AdminDisplay extends Display {
	
	private $data;	
	
	function __construct($data) {
		$this->data = $data;
	} 
	
	public function displayPage($action){
		try{
			$body = $this->$action();
		}catch(Exception $e){
			echo "Line :".$e->getLine();
			echo "Code :".$e->getCode();
			$body = "Méthode d'affichage non correct";
		}
	echo '<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="utf-8">
			<title>Administration</title>
			<link rel="stylesheet" href="css/site.css"/>
		</head>
		<body>
			'.$this->generateLeftMenu().$body.'<br />
		</body>
	</html>';
	}
	
	private function newMessage(){
		$html = '<section><h1>Nouveau message</h1>';

		if(!empty($this->data['jeton']))
			$html .= '<div>'.$this->data['error'].'</div>';
		$html .= '<form method="post" action="Admin.php?a=saveM">
				<input type="hidden" name="jeton" value="'.$this->data['jeton'].'" />
				<label for="titre">Titre du message</label>
				<input required autofocus type="text" name="titre" value="'.$this->data['titre'].'"/><br />
				<label for="contenu">Contenu du message</label>
				<textarea name="contenu" required>'.$this->data['contenu'].'</textarea><br />
				<label for="cat_id">Catégorie du message</label>
				<select name="cat_id">';
			$categories = Categorie::findAll();
			foreach ($categories as $categorie) {
				$html .= '<option value="'.$categorie->__get('id').'">'.$categorie->__get('titre');
			}
			$html .= '</select><br />
				<input type="submit" value="Sauver" />
				</form>';
			return $html;
	}
	
	private function messageEnregistre(){
		return 'Message enregistrée';
	}
	
	private function home(){
		return '<section>Selectionnez una action sur le menu de gauche</section>';
	}

	private function generateLeftMenu(){
		return '<nav><ul>
			<li><a href="Admin.php?a=addM">Ajouter un message</a></li>
			<li><a href="Admin.php?a=addC">Ajouter une catégorie</a></li></ul></nav>';
	}

}
