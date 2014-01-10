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
			'.$this->generateLeftMenu().$body.$this->generateRightMenu().'<br />
			<footer>Ecris par Guillaume Pierson et Jordane Mahout</footer>
		</body>
	</html>';
	}
	
	private function billet()
	{
		$billet = $this->data;
		$cat = Categorie::findById($billet->__get('cat_id'));
		$html = '<section><article><h2>'.$billet->__get('titre').
			'</h2><p>'.$billet->__get('body').'</p>Catégorie : <a href="Blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></article></section>';
		return $html;
	}
	
	private function listBillets()
	{
		$html = '<section><table><caption>Liste de tous les billets</caption><tr><th>Titre</th><th>Catégorie</th></tr>';
		foreach ($this->data as $billet) {
			$cat = Categorie::findById($billet->__get('cat_id'));
			$html .= '<tr><td><a href="Blog.php?a=detail&id='.$billet->__get('id').'">'.$billet->__get('titre').
			'</a></td><td><a href="Blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td></tr>';
		}
		$html .= '</table></section>';
		return $html;
	}
	
	private function generateLeftMenu()
	{
		$html = '<nav>Les Catégories<br />';
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
			foreach ($billets as $billet) {
					$html .= '<a href="Blog.php?a=detail&id='.$billet->__get('id').'">'.$billet->__get('titre').'</a><br />';
			}
		}catch(Exception $e){
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= '</nav>';
		return $html;
	}
	private function catDetail(){
		$html = '<section><p>Liste de tous les billets dans la catégorie '.$this->data->__get('titre').'</p>Desciption : '.$this->data->__get('description').'<br /><ul>';
		$billets = Billet::findByCat_ID($this->data->__get('id'));
		if(!empty($billets)){
			foreach ($billets as $billet) {
				$html .= '<li><a href="Blog.php?a=detail&id='.$billet->__get('id').'">"'.$billet->__get('titre').'</a></li>';
			}
			$html .= '</ul></section>';
		}else{
			$html .= '<div class="notFound">Aucunde donnée trouvé</div>';
		}
		return $html;		
	}
	
	private function allCat(){
		$html = '<section><table><caption>Liste de toutes les catégories</caption><tr><th>Titre</th><th>Description</th></tr>';
		foreach ($this->data as $billet) {
			$cat = Categorie::findById($billet->__get('cat_id'));
			$html .= '<tr><td><a href="Blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td>
			<td>'.$cat->__get('description').'</a></td></td>';
		}
		$html .= '</section>';
		return $html;
	}
	
	private function error(){
		return $this->data;
	}
}
