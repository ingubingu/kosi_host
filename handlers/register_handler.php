<?php
// register_handler.php

require_once '../controllers/UserController.php';
require_once '../handlers/Session.php';

Session::start();

// Collect form data
$user_name = $_POST['user_name'] ?? '';
$password  = $_POST['password'] ?? '';

// Validate Input
$errors = [];

// Validate Username
if (empty($user_name)) {
    $errors[] = 'Username is required.';
} elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $user_name)) {
    $errors[] = 'Username must be 3-20 characters and contain only letters, numbers, and underscores.';
}

// Validate Password
if (empty($password)) {
    $errors[] = 'Password is required.';
} elseif (strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 characters.';
}

// If there are validation errors
if (!empty($errors)) {
    $response = [
        'success' => false,
        'error' => implode(' ', $errors)
    ];
    echo json_encode($response);
    exit;
}

// Register user
$userController = new UserController();

try {
    $userController->register($user_name, $password);
    $response = [
        'success' => true,
        'message' => 'Registration successful!'
    ];
} catch (Exception $e) {
    // Handle exceptions from UserService
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;
?>
