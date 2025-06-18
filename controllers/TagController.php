<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/TagModel.php';

class TagController {
	private $pdo;
	private $tagModel;

	public function __construct(){
		$this->pdo = new Database();
		$this->tagModel = new TagModel($this->pdo->connection);
	}

	public function handleFetchTags(){
		return $this->tagModel->fetchTags();
	}

	public function handleFetchAssociativeTags(){
		return $this->tagModel->fetchAllTags();
	}
}
