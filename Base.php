<?php

include ('database.php');
class Base {
	
	public static $db;

	static public function getConnection() {
		if (isset($db)) {
			return $db;
		} else {
			try {
				$database = new Database();
				$dsn = "mysql:host=$database->host;dbname=$database->database";
				$db = new PDO($dsn, $database -> user, $database -> password, array(PDO::ATTR_ERRMODE => true, PDO::ERRMODE_EXCEPTION => true, PDO::ATTR_PERSISTENT => true));
				$db -> exec("SET CHARACTER SET utf8");
				return $db;
			} catch(PDOException $e) {
				echo $e -> getMessage();
				exit();
			}
		}

	}

}
