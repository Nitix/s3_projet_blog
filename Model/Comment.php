<?php

/**
 * File : Comment.php
 *
 * @author G. Pierson, J. Mahout
 *
 *
 * @package blog
 */

/**
 *
 *  La Classe Comment  realise un Active Record sur la table comment
 *
 *
 *  @package blog
 */
class Comment {

	/**
	 *  Identifiant du commentaire
	 *  @access private
	 *  @var integer
	 */
	private $id;

	/**
	 *  contenu du commentaire
	 *  @access private
	 *  @var String
	 */
	private $contenu;
	
	/**
	 *  Comment du commentaire
	 *  @access private
	 *  @var integer
	 */
	private $billet_id;

	
	/**
	 * createur du post
	 * @access private
	 * @var int
	 */
	private $user_id;


	/**
	 *  Constructeur de Comment
	 *
	 *  fabrique un nouveau commentaire vide
	 */

	public function __construct() {
		// rien à faire
	}

	/**
	 *  Magic pour imprimer
	 *
	 *  Fonction Magic retournant une chaine de caracteres imprimable
	 *  pour imprimer facilement un Ouvrage
	 *
	 *  @return String
	 */
	public function __toString() {
		return "[" . __CLASS__ . "] id : " . $this -> id . ":
				   contenu" . $this -> contenu .":
				   billet_id  " . $this -> billet_id . ":
				   user_id  " . $this -> user_id;
	}

	/**
	 *   Getter magique
	 *
	 *   fonction d'acces aux attributs d'un objet.
	 *   Recoit en parametre le nom de l'attribut accede
	 *   et retourne sa valeur.
	 *
	 *   @param String $attr_name attribute name
	 *   @return mixed
	 */

	public function __get($attr_name) {
		if (property_exists(__CLASS__, $attr_name)) {
			return $this -> $attr_name;
		}
		$emess = __CLASS__ . ": unknown member $attr_name (getAttr)";
		throw new Exception($emess, 45);
	}

	/**
	 *   Setter magique
	 *
	 *   fonction de modifipostion des attributs d'un objet.
	 *   Recoit en parametre le nom de l'attribut modifie et la nouvelle valeur
	 *
	 *   @param String $attr_name attribute name
	 *   @param mixed $attr_val attribute value
	 *   @return mixed new attribute value
	 */
	public function __set($attr_name, $attr_val) {
		if (property_exists(__CLASS__, $attr_name)) {
			return $this -> $attr_name = $attr_val;
		}
		$emess = __CLASS__ . ": unknown member $attr_name (setAttr)";
		throw new Exception($emess, 46);

	}

	/**
	 *   mise a jour de la ligne courante
	 *
	 *   Sauvegarde l'objet courant dans la base en faisant un update
	 *   l'identifiant de l'objet doit exister (insert obligatoire auparavant)
	 *   méthode privée - la méthode publique s'appelle save
	 *   @acess public
	 *   @return int nombre de lignes mises à jour
	 */
	public function update() {

		if (!isset($this -> id)) {
			throw new Exception(__CLASS__ . ": Primary Key undefined : cannot update");
		}

		$c = Base::getConnection();

		$query = $c -> prepare("update comment set contenu= ?, billet_id = ?, user_id= ?
				                   where id=?");

		/*
		 * liaison des paramêtres :
		 */
		$query -> bindParam(1, $this -> contenu, PDO::PARAM_STR);
		$query -> bindParam(2, $this -> billet_id, PDO::PARAM_INT);
		$query -> bindParam(3, $this -> user_id, PDO::PARAM_INT);
		$query -> bindParam(4, $this -> id, PDO::PARAM_INT);

		/*
		 * exécution de la requête
		 */

		return $query -> execute();

	}

	/**
	 *   Suppression dans la base
	 *
	 *   Supprime la ligne dans la table corrsepondant à l'objet courant
	 *   L'objet doit posséder un OID
	 */
	public function delete() {

		if (!isset($this -> id)) {
			throw new Exception(__CLASS__ . ": Primary Key undefined : cannot delete");
		}

		$c = Base::getConnection();

		$query = $c -> prepare("delete from comment where id=?");

		$query -> bindParam(1, $this -> id, PDO::PARAM_INT);

		return $query -> execute();
	}

	/**
	 *   Insertion dans la base
	 *
	 *   Insère l'objet comme une nouvelle ligne dans la table
	 *   l'objet doit posséder  un code_rayon
	 *
	 *   @return int nombre de lignes insérées
	 */
	public function insert() {

		$c = Base::getConnection();

		$query = $c -> prepare("insert into comment(contenu, billet_id, user_id) VALUES (:contenu, :billet_id, :user_id)");

		$query -> bindParam(":contenu", $this -> contenu, PDO::PARAM_STR);
		$query -> bindParam(":billet_id", $this -> billet_id, PDO::PARAM_INT);
		$query -> bindParam(":user_id", $this -> user_id, PDO::PARAM_INT);

		$res = $query -> execute();

		$this -> id = $c -> LastInsertId();

		return $res;
	}

	/**
	 *   Finder sur ID
	 *
	 *   Retrouve la ligne de la table correspondant au ID passé en paramètre,
	 *   retourne un objet
	 *
	 *   @static
	 *   @param integer $id OID to find
	 *   @return Comment renvoie un objet de type Comment
	 */
	public static function findById($id) {

		$c = Base::getConnection();
		$query = $c -> prepare("select * from comment where id=?");
		$query -> bindParam(1, $id, PDO::PARAM_INT);
		$dbres = $query -> execute();
		
		$row = $query->fetch(PDO::FETCH_BOTH);
		if(empty($row))
			return null;
			
		$commentaire= new Comment();
		$commentaire-> __set('id', $row['id']);
		$commentaire-> __set('contenu', $row['contenu']);
		$commentaire-> __set('billet_id', $row['billet_id']);
		$commentaire-> __set('user_id', $row['user_id']);
		return $commentaire;
	}

	/**
	 *   Finder All
	 *
	 *   Renvoie toutes les lignes de la table commets
	 *   sous la forme d'un tableau d'objet
	 *
	 *   @static
	 *   @return Array renvoie un tableau de commentaires
	 */

	public static function findAll() {

		$c = Base::getConnection();
		$query = $c -> prepare("select * from comment");
		$rowbres = $query -> execute();
		
		$commentaires = array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$commentaire = new Comment();
			$commentaire-> __set('id', $row['id']);
			$commentaire-> __set('contenu', $row['contenu']);
			$commentaire-> __set('billet_id', $row['billet_id']);
			$commentaire-> __set('user_id', $row['user_id']);
			$commentaires[] = $commentaire;
		}
		return $commentaires;
	}
	
	/**
	 *   Finder sur user_ID
	 *
	 *   Retrouve les lignes de la table correspondant au ID passé en paramètre,
	 *   retourne un objet
	 *
	 *   @static
	 *   @param integer $id OID to find
	 *   @return Array renvoie un tableau de categorie
	 */
	public static function findByUSer_ID($id) {
		$c = Base::getConnection();
		$query = $c -> prepare("select * from comment where user_id = :user_id");
		$query -> bindParam(":user_id", $id, PDO::PARAM_INT);
		$dbres = $query -> execute();

		$commentaires = array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$commentaire = new Comment();
			$commentaire-> __set('id', $row['id']);
			$commentaire-> __set('contenu', $row['contenu']);
			$commentaire-> __set('billet_id', $row['billet_id']);
			$commentaire-> __set('user_id', $row['user_id']);
			$commentaires[] = $commentaire;
		}
		return $commentaires;
	}

	/**
	 *   Finder sur post_ID
	 *
	 *   Retrouve les lignes de la table correspondant au ID passé en paramètre,
	 *   retourne un objet
	 *
	 *   @static
	 *   @param integer $id OID to find
	 *   @return Array renvoie un tableau de categorie
	 */
	public static function findByBillet_ID($id) {
		$c = Base::getConnection();
		$query = $c -> prepare("select * from comment where billet_id = :billet_id");
		$query -> bindParam(":billet_id", $id, PDO::PARAM_INT);
		$dbres = $query -> execute();

		$commentaires = array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$commentaire = new Comment();
			$commentaire-> __set('id', $row['id']);
			$commentaire-> __set('contenu', $row['contenu']);
			$commentaire-> __set('billet_id', $row['billet_id']);
			$commentaire-> __set('user_id', $row['user_id']);
			$commentaires[] = $commentaire;
		}
		return $commentaires;
	}
}
