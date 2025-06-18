<?php
session_start();

require_once BASE_PATH . '/controllers/UserController.php';
require_once BASE_PATH . '/controllers/TagController.php';
require_once BASE_PATH . '/controllers/UserImageController.php';
require_once BASE_PATH . '/controllers/CommentController.php';
require_once BASE_PATH . '/core/Auth.php';

$userController = new UserController();
$userImageController = new UserImageController();
$commentController = new CommentController();
$tagController = new TagController();

$render = $GLOBALS['render'];

// Home Page (guest only)
$router->get('/', function () use ($render, $tagController) {
    redirectIfAuthenticated();

    $tags = $tagController->handleFetchTags();
    $render->view('home', [
        'title' => 'Photoim',
        'tags' => $tags
    ]);
});

// Register
$router->get('/register', function () use ($render) {
    redirectIfAuthenticated();
    $render->setLayout('layouts/auth');
    $render->view('auth/register', ['title' => 'Register Now']);
});
$router->post('/register', fn () => (new UserController())->handleRegister());

// Login
$router->get('/login', function () use ($render) {
    redirectIfAuthenticated();
    $render->setLayout('layouts/auth');
    $render->view('auth/login', ['title' => 'Login Now']);
});
$router->post('/login', fn () => (new UserController())->handleLogin());

// Logout
$router->get('/logout', fn () => (new UserController())->handleLogout());

// Feed Page
$router->get('/feed', function () use ($render, $tagController, $userImageController, $userController) {
    requireAuth();

    $selectedTag = $_GET['tag'] ?? null;

    $tags = $tagController->handleFetchTags();
    $images = $userImageController->handleFetchImages($selectedTag);
    $currentUser = $userController->getCurrentUser();

    $pinnedImages = $userImageController->handleFetchPinnedImagesByUser($currentUser['id']);
	$currentUser['pinned_images'] = $pinnedImages;

    $render->setLayout('layouts/protected');
    $render->view('protected/feed', [
        'title' => 'Feed',
        'tags' => $tags,
        'images' => $images,
        'selectedTag' => $selectedTag,
        'user' => $currentUser
    ]);
});

$router->get('/search', function () use ($render, $userImageController, $tagController, $userController) {
    requireAuth();

    $query = $_GET['q'] ?? '';
    $images = [];

    if (!empty($query)) {
        $images = $userImageController->handleSearchByTitle($query);
    }

    $tags = $tagController->handleFetchTags();
    $currentUser = $userController->getCurrentUser();

    $pinnedImages = $userImageController->handleFetchPinnedImagesByUser($currentUser['id']);
    $currentUser['pinned_images'] = $pinnedImages;

    $render->setLayout('layouts/protected');
    $render->view('protected/feed', [
        'title' => 'Search Results',
        'tags' => $tags,
        'images' => $images,
        'selectedTag' => null,
        'user' => $currentUser,
        'query' => $query
    ]);
});


$router->post('/toggle-pin', fn () => (new UserImageController())->handleTogglePin());

// Create Post
$router->get('/creation-post', function () use ($render, $tagController) {
    requireAuth();

    $tags = $tagController->handleFetchAssociativeTags();
    $render->setLayout('layouts/protected');
    $render->view('protected/creation_post', [
        'title' => 'Create Post',
        'tags' => $tags
    ]);
});
$router->post('/creation-post', fn () => (new UserImageController())->handlePost());

// Profile
$router->get('/profile', function () use ($render, $userController, $userImageController) {
    requireAuth();

    $currentUser = $userController->getCurrentUser();
    $images = $userImageController->handleFetchImagesByUserId($_SESSION['user_id']);

    $pinnedImages = $userImageController->handleFetchPinnedImages($_SESSION['user_id']);

    $render->setLayout('layouts/protected');
    $render->view('protected/profile', [
        'title' => 'Profile',
        'user' => $currentUser,
        'images' => $images,
        'pinnedImages' => $pinnedImages
    ]);
});

$router->post('/profile/update', fn () => (new UserController())->handleUpdate());


// Comments Page
$router->get('/comments', function () use ($render, $userController, $userImageController, $commentController) {
    requireAuth();

    $imageId = $_GET['image_id'] ?? null;

    if(!isset($_GET['image_id'])){
        header('Location: ' . basePath('/feed'));
        exit;
    }

    $comments = $commentController->handleFetchCommentByImageId($imageId);
    $imageDetails = $userImageController->handleFetchImageById($imageId);
    $userData = $userController->getCurrentUser();

    $render->setLayout('layouts/view');
    $render->view('protected/comments', [
        'title' => 'View Image',
        'imagePath' => $imageDetails['image_path'],
        'imageDetails' => $imageDetails,
        'comments' => $comments,
        'userData' => $userData
    ]);
});
$router->post('/comments', fn () => (new CommentController())->handleCreateComment());
