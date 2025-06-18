<?php

require_once __DIR__ . '/../core/Database.php';

class TagModel {
	private $pdo;

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function fetchTags(){
		$query = $this->pdo->prepare("SELECT name FROM tags");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_COLUMN); 
	}
}
