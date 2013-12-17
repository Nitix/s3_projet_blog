<?php

include 'Billet.php';
include 'Base.php';
include 'Categorie.php';

$display = new Display();
$left = $display->getLeftMenu();
$right = $display->getRightMenu();
$body = $display->getBillet(4);
$display->displayPage($body, $left, $right);


class Display
{
	
	public function __construct() {}
	
	public function displayPage($body, $left= '', $right =''){
	echo '<!DOCTYPE html>
	<html>
		<head>
			<title>Projet Blog</title>
			<link rel="stylesheet" href="css/site.css"/>
		</head>
		<body>
			'.$left.$body.$right.'
			<footer>Ecris par Guillaume Pierson et Jordane Mahout</footer>
		</body>
	</html>';
	}
	
	public function getBillet($id)
	{
		$html = '<section><article>';
		try{
			$billet = Billet::findById($id);
			var_dump($billet);
			$cat = Categorie::findById($billet->__get('cat_id'));
			$html .= '<h2>'.$billet->__get('titre').
				'</h2><p>'.$billet->__get('body').'</p><a href="blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('description').'</a>';
		}catch(Exception $e){
			$html .= '<p>'. $e->getMessage().'</p>';
		}
		$html .= '</article>';
		return $html;
	}
	
	public function getAllBillets()
	{
		try{
			$billets = Billet::findAll();
			$html = '<section><table><caption>Liste de tous les billets</caption><tr><th>Titre</th><th>Catégorie</th></tr>';
			foreach ($billets as $billet) {
				$cat = Categorie::findById($billet->__get('cat_id'));
				$html .= '<tr><td><a href="blog.php?a=detail&id'.$billet->__get('id').'">"'.$billet->__get('titre').
				'</a></td><td><a href="blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('description').'</a></td></td>';
			}
			$html .= '</section>';
		}catch(Exception $e){
			$html = '<section>'. $e->getMessage().'</section>';
		}
		return $html;
	}
	
	public function getLeftMenu()
	{
		$html = '<nav>';
		try{
			$cats = Categorie::findAll();
			foreach ($cats as $cat) {
				$html .= '<a href="blog.php?a=cat&id='.$cat->__get('id').'">'.$cat->__get('description').'</a><br />';
			}
		}catch(Exception $e){
			$html .= $e->getMessage();
		}
		$html .= '</nav>';
		return $html;
	}
	
	public function getRightMenu()
	{
		$html = '<nav>';
		try{
			$billets = Billet::findAll();
			foreach ($billets as $billet) {
				$html .= '<a href="blog.php?a=detail&id'.$billet->__get('id').'">"'.$billet->__get('titre').'</a><br />';
			}
		}catch(Exception $e){
			$html .= $e->getMessage();
		}		
		$html .= '</nav>';
		return $html;
	}
}
