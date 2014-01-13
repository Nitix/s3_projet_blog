<?php

abstract class Display{
		
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
			<title>Projet Blog</title>
			<link rel="stylesheet" href="data/css/site.css"/>
		</head>
		<body>
			<header>Bienvenue le BLOG<br />Ici on parle de tout et de rien, de rien surtout</header>
			<div id="conteneur">'.$this->generateLeftMenu().$body.$this->generateRightMenu().'</div><br />
			<footer>Ecris par Guillaume Pierson et Jordane Mahout</footer>
		</body>
	</html>';
	}
	
	
	protected function generateLeftMenu()
	{
		$html = '<nav id="leftmenu">Les Catégories<br />'; 
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
		$html = '<nav id="rightmenu">Liste des 10 derniers billets<br />';
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
		return '<section><div class="error">$this->data</div></section>';
	}

}
