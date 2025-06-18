<?php

class Database {
	public $connection;

	public function __construct(){
		$config = require BASE_PATH . '/config/db.php';

		$type = strtolower($config['type']);
		$host = $config['host'];
		$db = $config['dbname'];
		$user = $config['user'];
		$password = $config['password'];

		if($type === 'pdo'){
			try{
				$this->connection = new PDO("mysql:host=$host;dbname=$db;", $user, $password);

				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				die('Connection failed ' . $e->getMessage());
			}
		} else {
			die("Unsupported DB type: " . $type);
		}
	}	
}