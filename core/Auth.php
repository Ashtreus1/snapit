<?php

function requireAuth(){
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . basePath('/login'));
        exit;
    }
}

function redirectIfAuthenticated(){
    if (isset($_SESSION['user_id'])) {
        header('Location: ' . basePath('/feed'));
        exit;
    }
}
