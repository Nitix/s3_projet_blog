<?php

abstract class Controller {
	
	public static function callAction(){
		if(isset($_GET['a'])){
			return static::$actions[$_GET['a']];
		}else{
			return 'home';
		}
	}
}
