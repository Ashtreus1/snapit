<?php

require_once __DIR__ . '/../core/Database.php';

class UserImageModel
{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function fetchAllImages($tag = null)
	{
		$sql = "SELECT users_images.*, users.username 
		        FROM users_images 
		        JOIN users ON users.id = users_images.user_id";

		$params = [];

		if ($tag !== null) {
			$sql .= " JOIN tags ON tags.id = users_images.tag_id WHERE tags.name = ?";
			$params[] = $tag;
		}

		$sql .= " ORDER BY users_images.created_at DESC";

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
