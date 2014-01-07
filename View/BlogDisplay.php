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
	<html>
		<head>
			<title>Projet Blog</title>
			<link rel="stylesheet" href="css/site.css"/>
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
			'</h2><p>'.$billet->__get('body').'</p>Catégorie : <a href="blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></article></section>';
		return $html;
	}
	
	private function listBillets()
	{
		$html = '<section><table><caption>Liste de tous les billets</caption><tr><th>Titre</th><th>Catégorie</th></tr>';
		foreach ($this->data as $billet) {
			$cat = Categorie::findById($billet->__get('cat_id'));
			$html .= '<tr><td><a href="blog.php?a=detail&id='.$billet->__get('id').'">"'.$billet->__get('titre').
			'</a></td><td><a href="blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td></tr>';
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
				$html .= '<a href="blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a><br />';
			}
		}catch(Exception $e){
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= '</nav>';
		return $html;
	}
	
	private function generateRightMenu()
	{
		$html = '<nav>Liste des 10 derniers billets<br />';
		try{
			$billets = Billet::findLastLimited(10);
			foreach ($billets as $billet) {
					$html .= '<a href="blog.php?a=detail&id='.$billet->__get('id').'">'.$billet->__get('titre').'</a><br />';
			}
		}catch(Exception $e){
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= '</nav>';
		return $html;
	}
	private function catDetail(){
		$cat = Categorie::findById($this->data[0]->__get('id'));
		$html = '<section><p>Liste de tous les billets dans la catégorie '.$cat->__get('titre').'</p>Desciption : '.$cat->__get('description').'<br /><ul>';
		foreach ($this->data as $billet) {
			$html .= '<li><a href="blog.php?a=detail&id='.$billet->__get('id').'">"'.$billet->__get('titre').'</a></li>';
		}
		$html .= '</ul></section>';
		return $html;		
	}
	
	private function allCat(){
		$html = '<section><table><caption>Liste de toutes les catégories</caption><tr><th>Titre</th><th>Description</th></tr>';
		foreach ($this->data as $billet) {
			$cat = Categorie::findById($billet->__get('cat_id'));
			$html .= '<tr><td><a href="blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td>
			<td>'.$cat->__get('description').'</a></td></td>';
		}
		$html .= '</section>';
		return $html;
	}
	
	private function error(){
		return $this->data;
	}
}
