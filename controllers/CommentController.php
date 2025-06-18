<?php

require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';

class CommentController {
	private $pdo;
	private $commentModel;

	public function __construct(){
		$this->pdo = new Database();
		$this->commentModel = new CommentModel($this->pdo->connection);
	}

	public function handleFetchCommentByImageId($imageId){
		return $this->commentModel->fetchCommentByImageId($imageId);
	}

	public function handleCreateComment() {
		requireAuth();

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'], $_GET['image_id'])) {
			$userId = $_SESSION['user_id'];
			$imageId = $_GET['image_id'];
			$message = trim($_POST['comment']);

			if (!empty($message)) {
				$this->commentModel->insertComment($userId, $imageId, $message);
			}
			header("Location: " . basePath("/comments?image_id=" . $imageId));
			exit;
		}
	}
}
