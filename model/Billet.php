<?php

/**
 * File : Billet.php
 *
 * @author G. Pierson, J. Mahout
 *
 *
 * @package blog
 */

/**
 *  La classe Billet
 *
 *  La Classe Billet  realise un Active Record sur la table billet
 *
 *
 *  @package blog
 */
class Billet {

	/**
	 *  Identifiant du billet
	 *  @access private
	 *  @var integer
	 */
	private $id;

	/**
	 *  libelle du billet
	 *  @access private
	 *  @var String
	 */
	private $titre;

	/**
	 *  body du billet
	 *  @access private
	 *  @var String
	 */
	private $body;
	
	/**
	 *  Categorie du billet
	 *  @access private
	 *  @var integer
	 */
	private $cat_id;

	/**
	 *  date du billet
	 *  @access private
	 *  @var String
	 */
	private $date;


	/**
	 *  Constructeur de Billet
	 *
	 *  fabrique un nouveau billet vide
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
				   titre  " . $this -> titre . ":
				   body" . $this -> body .":
				   cat_id  " . $this -> cat_id . ":
				   date  " . $this -> date;
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
	 *   fonction de modification des attributs d'un objet.
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

		$query = $c -> prepare("update billets set titre= ?, body= ?, cat_id = ?, date = ?
				                   where id=?");

		/*
		 * liaison des paramêtres :
		 */
		$query -> bindParam(1, $this -> titre, PDO::PARAM_STR);
		$query -> bindParam(2, $this -> body, PDO::PARAM_STR);
		$query -> bindParam(3, $this -> cat_id, PDO::PARAM_INT);
		$query -> bindParam(4, $this -> date, PDO::PARAM_STR);
		$query -> bindParam(5, $this -> id, PDO::PARAM_INT);

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

		$query = $c -> prepare("delete from billets where id=?");

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

		$query = $c -> prepare("insert into billets(titre, body, cat_id, date) VALUES (:titre, :body, :cat_id, :date)");

		$query -> bindParam(":titre", $this -> titre, PDO::PARAM_STR);
		$query -> bindParam(":body", $this -> body, PDO::PARAM_STR);
		$query -> bindParam(":cat_id", $this -> cat_id, PDO::PARAM_INT);
		$query -> bindParam(":date", $this -> date, PDO::PARAM_STR);

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
	 *   @return Categorie renvoie un objet de type Categorie
	 */
	public static function findById($id) {

		$c = Base::getConnection();
		$query = $c -> prepare("select * from billets where id=?");
		$query -> bindParam(1, $id, PDO::PARAM_INT);
		$dbres = $query -> execute();
		
		$row = $query->fetch(PDO::FETCH_BOTH);
		if(!$row)
			throw new Exception("Aucune donnée trouvée", 50);
			
		$billet= new Billet();
		$billet-> __set('id', $row['id']);
		$billet-> __set('body', $row['body']);
		$billet-> __set('titre', $row['titre']);
		$billet-> __set('cat_id', $row['cat_id']);
		$billet-> __set('date', $row['date']);
		return $billet;
	}

	/**
	 *   Finder All
	 *
	 *   Renvoie toutes les lignes de la table categorie
	 *   sous la forme d'un tableau d'objet
	 *
	 *   @static
	 *   @return Array renvoie un tableau de categorie
	 */

	public static function findAll() {

		$c = Base::getConnection();
		$query = $c -> prepare("select * from billets");
		$rowbres = $query -> execute();
		
		$cats = array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$billet = new Billet();
			$billet-> __set('id', $row['id']);
			$billet-> __set('body', $row['body']);
			$billet-> __set('titre', $row['titre']);
			$billet-> __set('cat_id', $row['cat_id']);
			$billet-> __set('date', $row['date']);
			$billets[] = $billet;
		}
		if(empty($billets))
			throw new Exception("Aucune donnée trouvée", 51);
		return $billets;
	}

	public static function findByTitre($titre) {
		$c = Base::getConnection();
		$query = $c -> prepare("select * from billets where titre = :titre");
		$query -> bindParam(":titre", $titre, PDO::PARAM_STR);
		$dbres = $query -> execute();

		$billets = array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$billet = new Billet();
			$billet-> __set('id', $row['id']);
			$billet-> __set('body', $row['body']);
			$billet-> __set('titre', $row['titre']);
			$billet-> __set('cat_id', $row['cat_id']);
			$billet-> __set('date', $row['date']);
			$billets[] = $billet;
		}
		if(empty($billets))
			throw new Exception("Aucune donnée trouvée", 52);			
		return $billets;
	}

	public static function findByCat_ID($id) {
		$c = Base::getConnection();
		$query = $c -> prepare("select * from billets where cat_id = :cat_id");
		$query -> bindParam(":cat_id", $id, PDO::PARAM_INT);
		$dbres = $query -> execute();

		$billets = array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$billet = new Billet();
			$billet-> __set('id', $row['id']);
			$billet-> __set('body', $row['body']);
			$billet-> __set('titre', $row['titre']);
			$billet-> __set('cat_id', $row['cat_id']);
			$billet-> __set('date', $row['date']);
			$billets[] = $billet;
		}
		if(empty($billets))
			throw new Exception("Aucune donnée trouvée", 53);
		return $billets;
	}
	

	public static function findLastLimited($nb){
		$c = Base::getConnection();
		$query = $c -> prepare("select * from billets order by date LIMIT :nb");
		$query -> bindParam(":nb", $nb, PDO::PARAM_INT);
		$dbres = $query -> execute();

		$billets = array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$billet = new Billet();
			$billet-> __set('id', $row['id']);
			$billet-> __set('body', $row['body']);
			$billet-> __set('titre', $row['titre']);
			$billet-> __set('cat_id', $row['cat_id']);
			$billet-> __set('date', $row['date']);
			$billets[] = $billet;
		}
		if(empty($billets))
			throw new Exception("Aucune donnée trouvée", 54);
		return $billets;
	}
}
