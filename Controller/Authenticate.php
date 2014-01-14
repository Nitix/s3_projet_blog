<?php

class Authenticate
{
	 // vérifier la conformité de $password avec la police
	 // si ok : hacher $password
	 // créer et sauvegarder l'utilisateur	
	public static function createUser ( $userName, $password, $level = 0 ) {
		if(!empty($userName) && !empty($password)){
			try{
				$user = User::findBySpeudo($userName);
				if(empty($user)){
					$policy = new \PasswordPolicy\Policy;
					$policy->contains('lowercase', $policy->atLeast(1));
					$policy->contains('uppercase', $policy->atLeast(1));
					$policy->contains('digit', $policy->atLeast(1));
					$policy->length($policy->atLeast(6));
					
					$res = $policy->test($password);
					if($res->result){
						$lib = new PasswordLib\PasswordLib();
						$token = $lib->getRandomToken(16);
						$hash = $lib->createPasswordHash($password.$token);
						$user = new User();
						$user->__set('speudo', $userName);
						$user->__set('password', $hash);
						$user->__set('level', $level);
						$user->__set('salt', $token);
						$user->insert();
					}else{
						$emess = 'Mot de passe trop simple.';
						throw new Exception($emess, 60);
					}
				}else{
					$emess = 'Speudo déjà utilisé.';
					throw new Exception($emess, 69);
				}
			}catch(Exception $e){
				if(DEBUG)
					throw $e;
				$emess = 'Erreur lors de la vérification du speudo, veuillez réessayer plus tard.';
				throw new Exception($emess, 61);
			}
		}else{
			$emess = 'Speudo ou mot de passe vide';
			throw new Exception($emess, 62);
		}
	}
	
	 // charger utilisateur $user
	 // vérifier $user->hash == hash($password)
	 // charger profil ($user->id)
	public static function checkLogin ( $username, $password ) {		
		$user = User::findBySpeudo($username);
		if(!empty($user)){
			$lib = new PasswordLib\PasswordLib();
			$boolean = $lib->verifyPasswordHash($password.$user->__get('salt'), $user->__get('password'));
			if($boolean){
				self::loadProfile($user);
			}else{
				$emess = 'Mot de passe ou utilisateur incorrect';
				throw new Exception($emess, 63);
			}				
		}else{
			$emess = 'Mot de passe ou utilisateur incorrect';
			throw new Exception($emess, 64);
		}
	}
	
	 // charger l'utilisateur et ses droits
	 // détruire la variable de session
	 // créer variable de session = profil chargé
	private static function loadProfile(User $user) {
		session_regenerate_id();
		$_SESSION['id'] 	= $user->__get('id');
		$_SESSION['speudo'] = $user->__get('speudo');
		$_SESSION['level']	= $user->__get('level');
	}
	//	 si Authentication::$profil['level] < $required
	// throw new AuthException ;
	public static function checkAccessRights ( $required ) {
		if(isset($_SESSION['level']) && $_SESSION['level'] > $required)
			return true;
		else {
			throw new Exception("Incorrect level", 99);
		}
	}
}
