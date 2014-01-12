<?php

class BlogDisplay extends Display
{
	private $data;	
	
	public function __construct($data) {
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
	
	private function billet()
	{
		$billet = $this->data;
		if(!empty($billet)){
			$cat = Categorie::findById($billet->__get('cat_id'));
			$html = '<section><article><h2>'.$billet->__get('titre').
				'</h2><p>'.$billet->__get('body').'</p>Catégorie : <a href="Blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></article></section>';
		}else{
			$html = '<section>Hmm, il semblerait que ce billet n\'existe pas, ou qu\'il a été supprimé, 
				ou as-tu essayé de hacker, ou serait-ce une mauvaise programmation, je ne le saurai jamais, en tout cas il n\'y a pas le billet demandé.</section>';
		}
		return $html;
	}
	
	private function listBillets()
	{
		if(!empty($this->data)){
			$html = '<section><table><caption>Liste de tous les billets</caption><tr><th>Titre</th><th>Catégorie</th></tr>';
			foreach ($this->data as $billet) {
				$cat = Categorie::findById($billet->__get('cat_id'));
				$html .= '<tr><td><a href="Blog.php?a=detail&id='.$billet->__get('id').'">'.$billet->__get('titre').
				'</a></td><td><a href="Blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td></tr>';
			}
			$html .= '</table></section>';
		}else{
			$html = '<section>Il n\'y aucun billet pour l\'instant, hmm, si tu es admin, tu pourrais en créer, si tu ne l\'est pas reviens plus tard, je suis désolé :(</section>';
		}
		return $html;
	}
	
	private function generateLeftMenu()
	{
		$html = '<nav id="leftmenu">Les Catégories<br />'; 
		try{
			$cats = Categorie::findAll();
			foreach ($cats as $cat) {
				$html .= '<a href="Blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a><br />';
			}
		}catch(Exception $e){
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= '</nav>';
		return $html;
	}
	
	private function generateRightMenu()
	{
		$html = '<nav id="rightmenu">Liste des 10 derniers billets<br />';
		try{
			$billets = Billet::findLastLimited(10);
			if(!empty($billets)){
				foreach ($billets as $billet) {
						$html .= '<a href="Blog.php?a=detail&id='.$billet->__get('id').'">'.$billet->__get('titre').'</a><br />';
				}
			}else{
				$html = 'LOL, il n\'y a pas de billets...';
			}
		}catch(Exception $e){
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= '</nav>';
		return $html;
	}
	private function catDetail(){
		if(!empty($this->data)){
			$html = '<section><p>Liste de tous les billets dans la catégorie '.$this->data->__get('titre').'</p>Desciption : '.$this->data->__get('description').'<br />';
			try{
				$billets = Billet::findByCat_ID($this->data->__get('id'));
				if(!empty($billets)){
					$html .= '<ul>';
					foreach ($billets as $billet) {
						$html .= '<li><a href="Blog.php?a=detail&id='.$billet->__get('id').'">'.$billet->__get('titre').'</a></li>';
					}
					$html .= '</ul></section>';
				}else{
					$html .= '<br /><div class="notFound">Il semblerait qu\'il n\'y aucun billet</div></section>';
				}
			}catch(Exception $e){
				$html .= 'Erreur à la récupération des billets</section>';
			}
		}else{
			$html = 'Cette catégorie n\'existe pas, veuillez réssayer votre appel plus tard. Merci<br />Hein quoi? ce n\'est pas un appel, ah oups...</section>';
		}
		return $html;		
	}
	
	private function listCats(){
		if(!empty($this->data)){
			$html = '<section><table><caption>Liste de toutes les catégories</caption><tr><th>Titre</th><th>Description</th></tr>';
			foreach ($this->data as $cat) {
				$html .= '<tr><td><a href="Blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td>
				<td>'.$cat->__get('description').'</a></td></td>';
			}
			$html .= '</section>';
		}else{
			$html = '<section>Catégories pas exister, toi contacter Adminstrateur, toi gentil, toi merci</section>';
		}
		return $html;
	}
	
	private function error(){
		return '<section><div class="error">$this->data</div></section>';
	}
}
