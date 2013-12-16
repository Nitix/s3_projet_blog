<?php

include('database.php');
class Base
{
	static public function getConnection(){
		try {
			$database = new Database();
			$dsn="mysql:host=$database->host;dbname=$database->database";
			$db = new PDO($dsn, $database->user, $database->password, array(
				PDO::ERRMODE_EXCEPTION=>true,
				PDO::ATTR_PERSISTENT => true)
			);
			return $db;
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}
}
		