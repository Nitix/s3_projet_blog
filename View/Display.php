<?php

abstract class Display{
	
	abstract public function displayPage($action);
	
	protected function generateLeftMenu()
	{
		$html = '<nav id="leftmenu">Les Catégories<br />'; 
		try{
			$cats = Categorie::findAll();
			foreach ($cats as $cat) {
				$html .= '<a href="Blog.php?a=cat&amp;id='.$cat->__get('id').'">'.$cat->__get('titre').'</a><br />';
			}
		}catch(Exception $e){
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
			$html .= 'Erreur à la récupération des catégories';
		}
		$html .= '</nav>';
		return $html;
	}
	
		
	protected function error(){
		return '<section><div class="error">$this->data</div></section>';
	}

}
