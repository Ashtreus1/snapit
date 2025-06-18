<?php

require_once __DIR__ . '/../core/Database.php';

class CommentModel {
	private $pdo;

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

}
