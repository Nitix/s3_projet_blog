<?php

class Authenticate
{
	 // vérifier la conformité de $password avec la police
	 // si ok : hacher $password
	 // créer et sauvegarder l'utilisateur	
	public static function createUser ( $userName, $password ) {
		$policy = new \PasswordPolicy\Policy;
		$policy->contains('lowercase', $policy->atLeast(1));
		$policy->contains('uppercase', $policy->atLeast(1));
		$policy->contains('digit', $policy->atLeast(1));
		$policy->length($policy->atLeast(6));
		//$js = $policy->toJavaScript();
		//echo "var policy = $js;";
		
		$res = $policy->test($password);
	}
	
	 // charger utilisateur $user
	 // vérifier $user->hash == hash($password)
	 // charger profil ($user->id)
	public static function Authenticate ( $username, $password ) {

	}
	
	 // charger l'utilisateur et ses droits
	 // détruire la variable de session
	 // créer variable de session = profil chargé
	private static function loadProfile( $uid ) {

	}
	//	 si Authentication::$profil['level] < $required
	// throw new AuthException ;
	public static function checkAccessRights ( $required ) {

	}
}
