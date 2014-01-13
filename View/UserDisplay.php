<?php

class UserDisplay extends Display
{
	private $data;	
	
	public function __construct($data) {
		$this->data = $data;
	} 
	
	protected function listUsers()
	{
		if(!empty($this->data)){
			$html = '<section><h2>Liste de tous les Utilisateurs</h2><ul>';
			foreach ($this->data as $user) {
				$html .= '<li><a href="Utilisateur.php?a=detail&amp;id='.$user->__get('id').'">'.$user->__get('speudo').
				'</a></li>';
			}
			$html .= '</ul></section>';
		}else{
			$html = '<section>Il n\'y aucun utilisateur pour l\'instant, hmm, si tu es admin, et que tu as accès a cette info, tu devrais revoir ton système</section>';
		}
		return $html;
	}
	
	
	protected function user()
	{
		$user = $this->data;
		if(!empty($user)){
			$html = '<section><h2>'.$user->__get('speudo').
				'</h2>Rang : '.User::rang($user->__get('level')).'<br />';
				try{
					$billets = Billet::findByUSer_ID($user->__get('id'));
					if(!empty($billets))
						$html .= '<a href="Blog.php?a=autor&amp;id='.$user->__get('id').'">Voir tout ses posts</a></section>';
				}catch(Exception $e){
					$html .= "C'est ma faute, me tape pas :'(...</section>";
				}
		}else{
			$html = '<section>Ah oui voici l\'utilisateur! ah non ce n\'était qu\'une illusion :(</section>';
		}
		return $html;
	}
	
}