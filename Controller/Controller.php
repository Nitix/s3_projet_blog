<?php

abstract class Controller {
	
	public static function callAction($requete){
		if(isset($requete['a'])){
			return static::$actions[$requete['a']];
		}else{
			return 'listAction';
		}
	}
}
