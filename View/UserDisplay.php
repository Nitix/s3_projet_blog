<?php

class UserDisplay extends Display
{
	
	private $data;	
	
	public function __construct($data) {
		$this->data = $data;
	} 
	
	protected function generateLeftMenu()
	{
		return '';
	}
	
	protected function generateRightMenu()
	{
		return '';
	}
	
	protected function login(){
		$html = '<section class=login><h1>Connexion</h1>';

		if(!empty($this->data['error']))
			$html .= '<div>'.$this->data['error'].'</div>';
		$html .= '<form method="post" action="Utilisateur.php?a=loginSend">
			<label for="speudo">speudo</label><br />
			<input required autofocus class=speudo type="text" id="speudo" name="speudo" value="'.$this->data['speudo'].'"/><br />
			<label for="password">mot de passe</label><br />
			<input required class=password type="password" id="password" name="password"/><br />
			<input type="submit" value="Se connecter" />
			</form></section>';
			return $html;
	}
	
	protected function connectOK(){
		return '<section class="login">Bienvenue '.$this->data.'<br /><br />Vous êtes maintenant connecté sur le site<br /><br /><a href ="Blog.php">Retour au site</a></section>';		
	}
	
	protected function register(){
		$html = '<section class=login><h1>Enregistrement</h1>';
		if(!empty($this->data['error']))
			$html .= '<div>'.$this->data['error'].'</div>';
		$html .= '<form id="form" method="post" action="Utilisateur.php?a=registerSend" onsubmit="return checkPassword()">
			<div style="display: hidden" id="passworderror"></div>
			<label for="speudo">speudo</label><br />
			<input required autofocus class=speudo type="text" id="speudo" name="speudo" value="'.$this->data['speudo'].'"/><br />
			<label for="password">mot de passe</label><br />
			<input required class=password type="password" id="password" name="password"/><br />
			<input type="submit" value="S\'enregistrer"/>
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

	protected function registerOK(){
		return '<section class="login">Bienvenue '.$this->data.'<br /><br />Vous êtes maintenant enregistré sur le site<br /><br /><a href ="Blog.php">Retour au site</a></section>';		
	}
}
