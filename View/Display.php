<?php

class Display{
		
	private $data;	
	
	public function __construct($data) {
		$this->data = $data;
	} 
	
	public function displayPage($action){
		try{
			$body = $this->$action();
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$body = "<section>Méthode d'affichage non correct</section>";
		}
	echo '<!DOCTYPE html>
	<html lang="fr">
		<head>
			<meta charset="utf-8">
			<title>Projet Blog</title>
			<link rel="stylesheet" href="data/css/site.css"/>
		</head>
		<body>
			<header>Bienvenue le BLOG<br />Ici on parle de tout et de rien, de rien surtout
			<nav><ul>
			<li><a href="Blog.php">Accueil</a></li>
			<li><a href="Blog.php?a=list">Liste des billets</a></li>
			<li><a href="Blog.php?a=listCat">Liste des catégorie</a></li>
			<li><a href="Blog.php?a=listUser">Liste des utilisateurs</a></li>';
			if(!isset($_SESSION['id']))
				echo '<li><a href="Utilisateur.php?a=login">Se connecter</a></li>
				<li><a href="Utilisateur.php?a=login">S\'enregistrer</a></li>';
			else {
				echo '<li>Bienvenue '.$_SESSION['speudo'].'</li>';
				try{
					Authenticate::checkAccessRights(1);
					echo '<li><a href="Admin.php">Administration</a></li>';
				}catch(Exception $e){}
			}
			echo '</ul></nav>
			</header>
			<div id="conteneur">'.$this->generateLeftMenu().$body.$this->generateRightMenu().'</div><br />
			<footer>Ecris par Guillaume Pierson et Jordane Mahout</footer>
		</body>
	</html>';
	}
	
	
	protected function generateLeftMenu()
	{
		$html = '<nav class=menu>Les Catégories<br />'; 
		try{
			$cats = Categorie::findAll();
			foreach ($cats as $cat) {
				$html .= '<a href="Blog.php?a=cat&amp;id='.$cat->__get('id').'">'.$cat->__get('titre').'</a><br />';
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= '</nav>';
		return $html;
	}
	
	protected function generateRightMenu()
	{
		$html = '<nav class=menu>Liste des 10 derniers billets<br />';
		try{
			$billets = Billet::findLastLimited(10);
			if(!empty($billets)){
				foreach ($billets as $billet) {
						$html .= '<a href="Blog.php?a=detail&amp;id='.$billet->__get('id').'">'.$billet->__get('titre').'</a><br />';
				}
			}else{
				$html = 'LOL, il n\'y a pas de billets...';
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$html .= 'Erreur à la récupération des billets';
		}
		$html .= '</nav>';
		return $html;
	}
	
		
	protected function error(){
		return '<section><div class="error">'.$this->data.'</div></section>';
	}

}
