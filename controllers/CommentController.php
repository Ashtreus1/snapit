<?php

require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../core/Database.php';

class CommentController {
	private $pdo;
	private $commentModel;

	public function __construct(){
		$this->pdo = new Database();
		$this->commentModel = new CommentModel($this->pdo->connection);
	}
}
