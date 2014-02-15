<?php

/**
 * Gere l'affichage de façon générale
 */
class Display{
		
	/**
	 * Données données par le controller
	 */
	private $data;	
	
	/**
	 * Contructeur avec les données à afficher
	 */
	public function __construct($data) {
		$this->data = $data;
	} 
	
	/**
	 * Prépare l'affichage de la page de connexion
	 * @return String contenu à afficher
	 * 
	 */
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
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta charset="utf-8">
			<title>Projet Blog</title>
			<link rel="stylesheet" href="data/css/bootstrap.css"/>
			<link rel="stylesheet" href="data/css/bootstrap-theme.css"/>
			<link rel="stylesheet" href="data/css/perso.css"/>
			<script src="data/js/jquery-2.1.0.min.js"></script>			
			<script src="data/js/bootstrap.min.js"></script>
		</head>
		<body>
			<header><div class="well"><div class="page-header"><h1>Bienvenue le BLOG<br /><small>Ici on parle de tout et de rien, de rien surtout</small></h1></div></div>
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="col-md-offset-3 ">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="Blog.php">Blog</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"><ul class="nav navbar-nav" >
				<li><a href="Blog.php">Accueil</a></li>
				<li><a href="Blog.php?a=list">Liste des billets</a></li>
				<li><a href="Blog.php?a=listCat">Liste des catégorie</a></li>
				<li><a href="Blog.php?a=listUser">Liste des utilisateurs</a></li>';
				if(!isset($_SESSION['id']))
					echo '<li><a href="Utilisateur.php?a=login">Se connecter</a></li>
					<li><a href="Utilisateur.php?a=register">S\'enregistrer</a></li>';
				else {
					echo '<li>Bienvenue '.$_SESSION['speudo'].'</li>
						<li><a href="Utilisateur.php?a=logout">Se déconnecter</a></li>';
					
					try{
						Authenticate::checkAccessRights(1);
						echo '<li><a href="Admin.php">Administration</a></li>';
					}catch(Exception $e){}
				}
				echo '</ul></div></div></div></nav>
			</header>
			<div class="container-fluid">'.$this->generateLeftMenu().$body.$this->generateRightMenu().'</div><br />
			<footer class="row"><div class="well center">Ecris par Guillaume Pierson et Jordane Mahout</div></footer>
		</body>
	</html>';
	}
	
	/**
	 * Prépare l'affichage du menu de gauche
	 * @return String menu à afficher
	 * 
	 */
	protected function generateLeftMenu()
	{
		$html = '<nav class="col-xs-12 col-md-3"><div class="list-group"><span class="list-group-item">Les Catégories</span>';        
		try{
			$cats = Categorie::findAll();
			foreach ($cats as $cat) {
				$html .= '<a class="list-group-item" href="Blog.php?a=cat&amp;id='.$cat->__get('id').'">'.$cat->__get('titre').'</a>';
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= ' </div></nav>';
		return $html;
	}
	
	/**
	 * Prépare l'affichage du menu de droite
	 * @return String contenu à afficher
	 * 
	 */
	protected function generateRightMenu()
	{
		$html = '<nav class="col-xs-12 col-md-3"><div class="list-group"><span class="list-group-item">Liste des 10 derniers billets</span>';
		try{
			$billets = Billet::findLastLimited(10);
			if(!empty($billets)){
				foreach ($billets as $billet) {
						$html .= '<a class="list-group-item" href="Blog.php?a=detail&amp;id='.$billet->__get('id').'">'.$billet->__get('titre').'</a>';
				}
			}else{
				$html = 'LOL, il n\'y a pas de billets...';
			}
		}catch(Exception $e){
			if(DEBUG)
				throw $e; 
			$html .= 'Erreur à la récupération des billets';
		}
		$html .= '</div></nav>';
		return $html;
	}
	
	/**
	 * Prépare l'affichage de la page d'erreur
	 * @return String erreur à afficher
	 * 
	 */	
	protected function error(){
		return '<section><div class="error">'.$this->data.'</div></section>';
	}

}
