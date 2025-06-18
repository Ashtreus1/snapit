<?php

require_once __DIR__ . '/../core/Database.php';

class CommentModel {
	private $pdo;

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function fetchCommentByImageId($imageId) {
		$stmt = $this->pdo->prepare("
			SELECT comments.*, users.username
			FROM comments
			JOIN users ON comments.user_id = users.id
			WHERE image_id = ?
			ORDER BY created_at DESC
		");
		$stmt->execute([$imageId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insertComment($userId, $imageId, $message) {
		$stmt = $this->pdo->prepare("INSERT INTO comments (user_id, image_id, message) VALUES (?, ?, ?)");
		return $stmt->execute([$userId, $imageId, $message]);
	}
}
