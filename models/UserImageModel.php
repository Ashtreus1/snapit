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

	public function fetchImageById($id) {
		$stmt = $this->pdo->prepare("SELECT users_images.*, users.username FROM users_images JOIN users ON users_images.user_id = users.id WHERE users_images.id = ?");
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function fetchImagesByUserId($userId) {
		$stmt = $this->pdo->prepare("
			SELECT users_images.*, users.username 
			FROM users_images 
			JOIN users ON users.id = users_images.user_id 
			WHERE users_images.user_id = ?
			ORDER BY users_images.created_at DESC
		");
		$stmt->execute([$userId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	public function createImage($userId, $title, $description, $imagePath, $tagId){
		$stmt = $this->pdo->prepare('insert into users_images (user_id, title, description, image_path, tag_id) values (?, ?, ?, ?, ?)');
		return $stmt->execute([$userId, $title, $description, $imagePath, $tagId]);
	}

	// Check if user has pinned a specific image
	public function hasUserPinned($userId, $imageId) {
		$stmt = $this->pdo->prepare("SELECT 1 FROM pinned_images WHERE user_id = ? AND image_id = ?");
		$stmt->execute([$userId, $imageId]);
		return $stmt->fetchColumn() !== false;
	}

	// Pin the image
	public function pinImage($userId, $imageId) {
		$stmt = $this->pdo->prepare("INSERT IGNORE INTO pinned_images (user_id, image_id) VALUES (?, ?)");
		return $stmt->execute([$userId, $imageId]);
	}

	// Unpin the image
	public function unpinImage($userId, $imageId) {
		$stmt = $this->pdo->prepare("DELETE FROM pinned_images WHERE user_id = ? AND image_id = ?");
		return $stmt->execute([$userId, $imageId]);
	}

	// Fetch all pinned images by user
	public function fetchPinnedImagesByUser($userId) {
		$stmt = $this->pdo->prepare("
			SELECT users_images.*, users.username 
			FROM pinned_images 
			JOIN users_images ON users_images.id = pinned_images.image_id 
			JOIN users ON users.id = users_images.user_id 
			WHERE pinned_images.user_id = ?
			ORDER BY pinned_images.created_at DESC
		");
		$stmt->execute([$userId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetchPinnedImagesByUserId($userId) {
		$stmt = $this->pdo->prepare("SELECT image_id FROM pinned_images WHERE user_id = ?");
		$stmt->execute([$userId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

}
