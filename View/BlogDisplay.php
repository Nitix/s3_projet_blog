<?php

class BlogDisplay extends Display
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
	 * Prépare l'affichage de la page détaillé d'un billet et affiche les commentaires
	 * @return String contenu à afficher
	 * 
	 */
	protected function billet()
	{
		$billet = $this->data;
		if(!empty($billet)){
			try{
				$cat = Categorie::findById($billet->__get('cat_id'));
				$autor = User::findById($billet->__get('user_id'));
				$html = '<section><article><h2>'.$billet->__get('titre').
					'</h2><p>'.nl2br($billet->__get('body')).'</p>
					Date : '.date("d/m/y G:i", strtotime($billet->__get('date'))).'<br />
					Auteur : <a href="Blog.php?a=detailUser&amp;id='.$autor->__get('id').'">'.$autor->__get('speudo').'</a><br />
					Catégorie : <a href="Blog.php?a=cat&amp;id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></article>';
				if(isset($_SESSION['id'])){
					$html .= '<hr /><div><form method="post" action="Blog.php?a=saveComment">
					<input type="hidden" name="jeton" value="'.$_SESSION['jeton'].'" />
					<input type="hidden" name="id" value="'.$billet->__get('id').'" />
					<textarea class=comment name="contenu" required></textarea>
					<input type="submit" value="Commenter" />
					</form>';
				}
				$comments = Comment::findByBillet_ID($billet->__get('id'));
				foreach ($comments as $comment) {
					$user = User::findById($comment->__get('user_id'));
					$html .= '<hr />';
					if(!empty($user)){
					$html .= 'Commenteur : <a href="Blog.php?a=detailUser&amp;id='.$comment->__get('user_id').'">'.$user->__get('speudo').'</a>
					<p>'.nl2br($comment->__get('contenu')).'</p>';
					}else{
						$html .= 'Commenteur : Supprimé <br /><p>'.nl2br($comment->__get('contenu')).'</p>';
					}
				}
				$html .= '</section>';	
			}catch(Exception $e){
				if(DEBUG)
					throw $e; 
				$html = '<section>Peut pas chercher catégorie/utilisateur pour billet</section>';
			}
		}else{
			$html = '<section>Hmm, il semblerait que ce billet n\'existe pas, ou qu\'il a été supprimé, 
				ou as-tu essayé de hacker, ou serait-ce une mauvaise programmation, je ne le saurai jamais, en tout cas il n\'y a pas le billet demandé.</section>';
		}
		return $html;
	}
	
	/**
	 * Prépare l'affichage de la page de la liste des billets
	 * @return String contenu à afficher
	 * 
	 */
	protected function listBillets()
	{
		if(!empty($this->data)){
			$html = '<section><table><caption>Liste de tous les billets</caption><tr><th>Titre</th><th>Catégorie</th></tr>';
			foreach ($this->data as $billet) {
				try{
					$cat = Categorie::findById($billet->__get('cat_id'));
					$html .= '<tr><td><a href="Blog.php?a=detail&amp;id='.$billet->__get('id').'">'.$billet->__get('titre').
					'</a></td><td><a href="Blog.php?a=cat&amp;id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td></tr>';
				}catch(Exception $e){
					if(DEBUG)
						throw $e; 
					$html = '<section>Je suis dans l\'incapacité de chercher les catégories des billets, je me suis désolé</section>';
				}
			}
			$html .= '</table></section>';
		}else{
			$html = '<section>Il n\'y aucun billet pour l\'instant, hmm, si tu es admin, tu pourrais en créer, si tu ne l\'est pas reviens plus tard, je suis désolé :(</section>';
		}
		return $html;
	}
	
	/**
	 * Prépare l'affichage de la page détailllé de la catégorie 
	 * @return String contenu à afficher
	 * 
	 */
	protected function catDetail(){
		if(!empty($this->data)){
			$html = '<section><p>Liste de tous les billets dans la catégorie '.$this->data->__get('titre').'</p>Desciption : '.$this->data->__get('description').'<br />';
			try{
				$billets = Billet::findByCat_ID($this->data->__get('id'));
				if(!empty($billets)){
					$html .= '<ul>';
					foreach ($billets as $billet) {
						$html .= '<li><a href="Blog.php?a=detail&amp;id='.$billet->__get('id').'">'.$billet->__get('titre').'</a></li>';
					}
					$html .= '</ul></section>';
				}else{
					$html .= '<br /><div class="notFound">Il semblerait qu\'il n\'y aucun billet</div></section>';
				}
			}catch(Exception $e){
				if(DEBUG)
					throw $e; 
				$html .= 'Erreur à la récupération des billets</section>';
			}
		}else{
			$html = 'Cette catégorie n\'existe pas, veuillez réssayer votre appel plus tard. Merci<br />Hein quoi? ce n\'est pas un appel, ah oups...</section>';
		}
		return $html;		
	}
	
	/**
	 * Prépare l'affichage de la page de la liste des catégorie
	 * @return String contenu à afficher
	 * 
	 */
	protected function listCats(){
		if(!empty($this->data)){
			$html = '<section><table><caption>Liste de toutes les catégories</caption><tr><th>Titre</th><th>Description</th></tr>';
			foreach ($this->data as $cat) {
				$html .= '<tr><td><a href="Blog.php?a=cat&amp;id='.$cat->__get('id').'">'.$cat->__get('titre').'</a></td>
				<td>'.$cat->__get('description').'</a></td></td>';
			}
			$html .= '</table></section>';
		}else{
			$html = '<section>Catégories pas exister, toi contacter Adminstrateur, toi gentil, toi merci</section>';
		}
		return $html;
	}
	
	/**
	 * Prépare l'affichage de la page de la liste des billets d'un auteur
	 * @return String contenu à afficher
	 * 
	 */
	protected function autor(){
		if(!empty($this->data)){
			$html = '<section><p>Liste de tous les billets de l\'auteur '.$this->data->__get('speudo').'</p><br />';
			try{
				$billets = Billet::findByUser_ID($this->data->__get('id'));
				if(!empty($billets)){
					$html .= '<ul>';
					foreach ($billets as $billet) {
						$html .= '<li><a href="Blog.php?a=detail&amp;id='.$billet->__get('id').'">'.$billet->__get('titre').'</a></li>';
					}
					$html .= '</ul></section>';
				}else{
					$html .= '<br /><div class="notFound">Il semblerait qu\'il n\'y aucun billet</div></section>';
				}
			}catch(Exception $e){
				if(DEBUG)
					throw $e; 
				$html .= 'Erreur à la récupération des billets</section>';
			}
		}else{
			$html = '<section>Cet utilisateur n\'existe pas, vous voulez voir des fantômes ? O_O</section>';
		}
		return $html;		
	}

	/**
	 * Prépare l'affichage de la page d'accueil
	 * @return String contenu à afficher
	 * 
	 */
	protected function last10billets()
	{
		if(!empty($this->data)){
			$html = '<section>';
			$first = true;
			foreach ($this->data as $billet) {
				if(!$first)
					$html .= '<hr />';
				$html .= '<article><a href="Blog.php?a=detail&amp;id='.$billet->__get('id').'"><h2>'.$billet->__get('titre').
					'</h2></a><p>'.nl2br($billet->__get('body')).'</p></article>';
				$first = false;
			}
			$html .= '</section>';
		}else{
			$html = '<section>Pas de billets, admin pas faire beaulot, moi pas content :p</section>';
		}
		return $html;
	}

	/**
	 * Prépare l'affichage de la page de la liste des utilisateurs
	 * @return String contenu à afficher
	 * 
	 */
	protected function listUsers()
	{
		if(!empty($this->data)){
			$html = '<section><h2>Liste de tous les Utilisateurs</h2><ul>';
			foreach ($this->data as $user) {
				$html .= '<li><a href="Blog.php?a=detailUser&amp;id='.$user->__get('id').'">'.$user->__get('speudo').
				'</a></li>';
			}
			$html .= '</ul></section>';
		}else{
			$html = '<section>Il n\'y aucun utilisateur pour l\'instant, hmm, si tu es admin, et que tu as accès a cette info, tu devrais revoir ton système</section>';
		}
		return $html;
	}
	
	/**
	 * Prépare l'affichage de la page détaillé d'un utilisateur
	 * @return String contenu à afficher
	 * 
	 */
	protected function user()
	{
		$user = $this->data;
		if(!empty($user)){
			$html = '<section><h2>'.$user->__get('speudo').
				'</h2>Rang : '.User::rang($user->__get('level')).'<br />
				email : '.$user->__get('email').'<br />';
				try{
					$billets = Billet::findByUSer_ID($user->__get('id'));
					if(!empty($billets))
						$html .= '<a href="Blog.php?a=autor&amp;id='.$user->__get('id').'">Voir tout ses posts</a>';
				}catch(Exception $e){
					$html .= "C'est ma faute, me tape pas :'(...";
				}
				$html .= "</section>";
		}else{
			$html = '<section>Ah oui voici l\'utilisateur! ah non ce n\'était qu\'une illusion :(</section>';
		}
		return $html;
	}
	
	/**
	 * Prépare l'affichage de la page de confirmation d'enregistrement du commentaire
	 * @return String contenu à afficher
	 * 
	 */
	protected function commentEnregistre(){
		return '<section>Commentaire enregistré</section>';
	}
}
