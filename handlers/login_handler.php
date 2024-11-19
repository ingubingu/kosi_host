<?php
// login_handler.php

require_once '../controllers/UserController.php';
require_once 'Session.php';
require_once 'Message.php';

Session::start();

// Collect form data
$user_name = $_POST['user_name'] ?? '';
$password  = $_POST['password'] ?? '';

// Authenticate user
$userController = new UserController();
$user = $userController->login($user_name, $password);

header('Content-Type: application/json');

if ($user) {
    // Successful login
    $response = [
        'success' => true,
        'message' => 'Login successful.'
    ];
    // Add successful login message
    Message::addMessage('You have been successfully logged in.', 'success');
} else {
    // Login failed
    $response = [
        'success' => false,
        'error' => 'Invalid username or password.'
    ];
}

echo json_encode($response);
exit;
?>
