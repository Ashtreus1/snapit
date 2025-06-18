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

	public function fetchAllTags(){
		$stmt = $this->pdo->query("SELECT id, name FROM tags ORDER BY name ASC");
		return $stmt->fetchAll(PDO::FETCH_ASSOC); 
	}
}
