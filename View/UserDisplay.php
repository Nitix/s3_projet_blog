<?php

/**
 * Gére l'affichage de l'utilisateur
 */
class UserDisplay extends Display
{
	/**
	 * Données données par le controller
	 */
	private $data;	
	
	/**
	 * Contructeur avec les données à afficher
	 */
	public function __construct($data) {
		$this->data = $data;
	} 
	
	/**
	 * Supprimer le menu de gauche, non nécessaire pour la connexion
	 * @return String vide
	 */
	protected function generateLeftMenu()
	{
		return '';
	}
	
	/**
	 * Supprimer le menu de droite, non nécessaire pour la connexion
	 * @return String vide
	 * 
	 */	
	protected function generateRightMenu()
	{
		return '';
	}
	
	/**
	 * Prépare l'affichage de la page de connexion
	 * @return String contenu à afficher
	 * 
	 */
	protected function login(){
		$html = '<section class=login><h1>Connexion</h1>';

		if(!empty($this->data['error']))
			$html .= '<div>'.$this->data['error'].'</div>';
		$html .= '<form method="post" action="Utilisateur.php?a=loginSend">
			<div class="form-group">
			<label for="speudo">speudo</label><br />
			<input required autofocus class=speudo type="text" id="speudo" name="speudo" value="'.$this->data['speudo'].'"/><br />
			<label for="password">mot de passe</label><br />
			<input required class=password type="password" id="password" name="password"/><br />
			</div>
			<input type="submit" class="btn btn-default" value="Se connecter" />
			</form></section>';
			return $html;
	}
	
	/**
	 * Prépare l'affichage de la page de confirmation de connexion
	 * @return String contenu à afficher
	 */
	protected function connectOK(){
		return '<section class="login col-xs-12">Bienvenue '.$this->data.'<br /><br />Vous êtes maintenant connecté sur le site<br /><br /><a href ="Blog.php">Retour au site</a></section>';		
	}
	
	/**
	 * Prépare l'affichage de la page d'enregistrement
	 * @return String contenu à afficher
	 */
	protected function register(){
		$html = '<section class=login><h1>Enregistrement</h1>';
		if(!empty($this->data['error']))
			$html .= '<div>'.$this->data['error'].'</div>';
		$html .= '<form id="form" method="post" action="Utilisateur.php?a=registerSend" onsubmit="return checkPassword()">
			<div class="form-group">
			<div style="display: hidden" id="passworderror"></div>
			<label for="speudo">speudo</label><br />
			<input required autofocus class=speudo type="text" id="speudo" name="speudo" value="'.$this->data['speudo'].'"/><br />
			<label for="email">email</label><br />
			<input required autofocus class=email type="text" id="email" name="email" value="'.$this->data['email'].'"/><br />
			<label for="password">mot de passe</label><br />
			<input required class=password type="password" id="password" name="password"/><br />
			</div>
			<input type="submit" class="btn btn-default" value="S\'enregistrer"/>
			</form></section><script>
			 function checkPassword(){
			 	var policy = '.$this->data['js'].';
			  	var result = policy(document.getElementById("password").value);
				if (!result.result) {
					ele = document.getElementById("passworderror");
					var mess = "";
					result.messages.forEach(function(entry) {
						mess += entry.message + "<br />";
					});
					ele.innerHTML= mess;
					ele.style.display="block";
					return false;
				}else{
					return true;
				}
			 }
			</script>';
			return $html;
	}

	/**
	 * Prépare l'affichage de la page de confirmation d'enregistrement
	 * @return String contenu à afficher
	 */
	protected function registerOK(){
		return '<section class="login col-xs-12">Bienvenue '.$this->data.'<br /><br />Vous êtes maintenant enregistré sur le site<br /><br /><a href ="Blog.php">Retour au site</a></section>';		
	}

	/**
	 * Prépare l'affichage de la page de confirmation d'enregistrement
	 * @return String contenu à afficher
	 */
	protected function logout(){
		return '<section class="login col-xs-12">Vous êtes deconnectés<br /><br /><a href ="Blog.php">Retour au site</a></section>';		
	}
}
