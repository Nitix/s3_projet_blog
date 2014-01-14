<?php

/**
 *
 *  La Classe USer realise un Active Record sur la table user
 *
 *
 *  @package blog
 */
class User {

	private static $rang = array(
		0 => 'Membre',
		1 => 'Adminstrateur'
	 );

	/**
	 *  Identifiant de l'user
	 *  @access private
	 *  @var integer
	 */
	private $id;

	/**
	 *  Speudo de l'user
	 *  @access private
	 *  @var String
	 */
	private $speudo;
	
	/**
	 *  Email de l'utilisateur
	 *  @access private
	 *  @var String
	 */
	 private $email;

	/**
	 *  Mot de passe de l'user 
	 *  @access private
	 *  @var String
	 */
	private $password;
	
	/**
	 *  level de l'user
	 *  @access private
	 *  @var integer
	 */
	private $level;
	
	/**
	 * Sel du mot de passe
	 */
	 private $salt;

	/**
	 *  Constructeur de Uer
	 *
	 *  fabrique un nouvel utilisateur vide
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
				   speudo  " . $this -> titre . ":
				   level  " . $this -> level;
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

		$query = $c -> prepare("update user set speudo= ?, password= ?, level = ?, salt = ?, email = ?
				                   where id=?");

		/*
		 * liaison des paramêtres :
		 */
		$query -> bindParam(1, $this -> speudo, PDO::PARAM_STR);
		$query -> bindParam(2, $this -> password, PDO::PARAM_STR);
		$query -> bindParam(3, $this -> level, PDO::PARAM_INT);
		$query -> bindParam(4, $this -> salt, PDO::PARAM_STR);
		$query -> bindParam(5, $this -> email, PDO::PARAM_STR);
		$query -> bindParam(6, $this -> id, PDO::PARAM_INT);

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

		$query = $c -> prepare("delete from user where id=?");

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

		$query = $c -> prepare("insert into user(speudo, password, level, salt) VALUES (:speudo, :password, :level, :salt)");

		$query -> bindParam(":speudo", $this -> speudo, PDO::PARAM_STR);
		$query -> bindParam(":password", $this -> password, PDO::PARAM_STR);
		$query -> bindParam(":level", $this -> level, PDO::PARAM_INT);
		$query -> bindParam(":salt", $this -> salt, PDO::PARAM_STR);

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
	 *   @return Categorie renvoie un objet de type User
	 */
	public static function findById($id) {

		$c = Base::getConnection();
		$query = $c -> prepare("select * from user where id=?");
		$query -> bindParam(1, $id, PDO::PARAM_INT);
		$dbres = $query -> execute();
		
		$row = $query->fetch(PDO::FETCH_BOTH);
		if(empty($row))
			return null;
			
		$user = new User();
		$user->__set('id', $row['id']);
		$user->__set('speudo', $row['speudo']);
		$user->__set('password', $row['password']);
		$user->__set('level', $row['level']);
		$user->__set('salt', $row['salt']);
		
		return $user;
	}

	/**
	 *   Finder All
	 *
	 *   Renvoie toutes les lignes de la table categorie
	 *   sous la forme d'un tableau d'objet
	 *
	 *   @static
	 *   @return Array renvoie un tableau de user
	 */

	public static function findAll() {

		$c = Base::getConnection();
		$query = $c -> prepare("select * from user");
		$rowbres = $query -> execute();
		
		$users= array();
		while($row = $query->fetch(PDO::FETCH_BOTH)){
			$user = new User();
			$user->__set('id', $row['id']);
			$user->__set('speudo', $row['speudo']);
			$user->__set('password', $row['password']);
			$user->__set('level', $row['level']);
			$user->__set('salt', $row['salt']);
			$users[] = $user;
		}
		return $users;
	}
	
	/**
	 *   Finder sur Speudo
	 *
	 *   Retrouve la ligne de la table correspondant au ID passé en paramètre,
	 *   retourne un objet
	 *
	 *   @static
	 *   @param integer $id OID to find
	 *   @return Categorie renvoie un objet de type User
	 */
	public static function findBySpeudo($speudo) {

		$c = Base::getConnection();
		$query = $c -> prepare("select * from user where lower(speudo)=lower(?)");
		$query -> bindParam(1, $speudo, PDO::PARAM_STR);
		$dbres = $query -> execute();
		
		$row = $query->fetch(PDO::FETCH_BOTH);
		if(empty($row))
			return null;
			
		$user = new User();
		$user->__set('id', $row['id']);
		$user->__set('speudo', $row['speudo']);
		$user->__set('password', $row['password']);
		$user->__set('level', $row['level']);
		$user->__set('salt', $row['salt']);
		
		return $user;
	}
	
	public static function rang($level = 0){
		if(array_key_exists($level, self::$rang))
			return self::$rang[$level];
		else 
			return self::$rang[0];
	}
	
}
