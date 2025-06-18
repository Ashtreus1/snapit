<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/UserImageModel.php';

class UserImageController
{
	private $userImageModel;

	public function __construct()
	{
		$pdo = new Database();
		$this->userImageModel = new UserImageModel($pdo->connection);
	}

	public function handleFetchImages($tag = null)
	{
		return $this->userImageModel->fetchAllImages($tag);
	}
}
