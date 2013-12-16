<?php
	
class AdminController
{

	private $actions = array(
		'AddM' => 'AddM',
		'saveM' => 'saveM',
		'addC' => 'addC',
		'saveC' => 'saveC'
	);

	public function callAction($requete){
		if(isset($requete['a'])){
			$action = $this->actions[$requete['a']];
		}
	}
}