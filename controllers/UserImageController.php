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

	public function handleFetchImageById($imageId){
		return $this->userImageModel->fetchImageById($imageId);
	}

	public function handleFetchImagesByUserId($userId) {
		return $this->userImageModel->fetchImagesByUserId($userId);
	}


	public function handlePost(){
		requireAuth();

		$userId = $_SESSION['user_id'];
		$title = $_POST['title'];
		$description = $_POST['description'] ?? '';
		$tagId = $_POST['tag_id'] ?? null;

		$image = $_FILES['image'] ?? null;

		if(!$image || $image['error'] !== UPLOAD_ERR_OK){
			$_SESSION['error'] = 'Image upload failed';
			header('Location: ' . basePath('/creation-post?error=ImageUpload'));
			exit;
		}

		$targetDir = 'uploads/';
		if(!is_dir($targetDir)){
			mkdir($targetDir, 0777, true);
		}

		$filename = uniqid() . '_' . basename($image['name']);
		$targetFile = $targetDir . $filename;

		if(!move_uploaded_file($image['tmp_name'], $targetFile)){
			$_SESSION['error'] = 'Failed to move uploaded image';
			header('Location: ' . basePath('/creation-post?error=FailedMoveImage'));
			exit;
		}

		$success = $this->userImageModel->createImage($userId, $title, $description, $targetFile, $tagId);

		if($success){
			header('Location: ' . basePath('/feed'));
			exit;
		}else{
			$_SESSION['error'] = 'Failed to save post to database';
			header('Location: ' . basePath('/creation-post?error=FailedToSave'));
			exit;
		}
	}

	public function handleTogglePin() {
		requireAuth();
		$userId = $_SESSION['user_id'];
		$imageId = $_POST['image_id'];

		if ($this->userImageModel->hasUserPinned($userId, $imageId)) {
			$this->userImageModel->unpinImage($userId, $imageId);
		} else {
			$this->userImageModel->pinImage($userId, $imageId);
		}

		header("Location: " . basePath('/feed'));
		exit;
	}

	public function handleFetchPinnedImages($userId) {
		return $this->userImageModel->fetchPinnedImagesByUser($userId);
	}

	public function handleFetchPinnedImagesByUser($userId) {
		return $this->userImageModel->fetchPinnedImagesByUserId($userId);
	}

	public function handleSearchByTitle($title)
	{
	    return $this->userImageModel->searchImagesByTitle($title);
	}

}
