<?php
	
class BlogController
{
	private $actions = array(
		'list' => 'listAction',
		'detail' => 'detailAction',
		'cat' => 'catAction'
	);
		
	
	public function listAction(){ }
	
	public function detailAction(){}
	
	public function catAction(){}
	
	public function callAction($requete){
		if(isset($requete['a'])){
			$action = $this->actions[$requete['a']];
		}
	}
}