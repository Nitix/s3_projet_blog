<?php

abstract class Controller {
	
	public static function callAction(){
		if(isset($_GET['a'])){
			if(in_array($_GET['a'], static::$actions))
				return static::$actions[$_GET['a']];
			else 
				return 'home';
		}else{
			return 'home';
		}
	}
}
