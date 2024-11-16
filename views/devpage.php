<?php
require_once '../controllers/UserController.php';
require_once '../handlers/Session.php';
require_once '../handlers/Message.php';

Session::start();
Session::set('currentpage', 'register');



// Retrieve messages
$successMessage = '';
$errorMessages = [];
if ($messages = Message::getMessages()) {
    foreach ($messages as $message) {
        if ($message['type'] === 'success') {
            $successMessage .= '<p class="success-message">' . htmlspecialchars($message['text']) . '</p>';
        } elseif ($message['type'] === 'error') {
            $errorMessages[] = '<p class="error-message">' . htmlspecialchars($message['text']) . '</p>';
        }
    }
}

// Retrieve form data for pre-filling
$form_data = Session::get('form_data', []);
Session::remove('form_data');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Include your CSS files here -->
</head>
<body>

<h1>Register</h1>

<?php
// Display success message
if (!empty($successMessage)) {
    echo $successMessage;
}

// Display error messages
if (!empty($errorMessages)) {
    foreach ($errorMessages as $errorMessage) {
        echo $errorMessage;
    }
}
?>

<!-- Registration Form -->
<form action="registration_process.php" method="post">

    <label for="user_name">Username:</label>
    <input type="text" name="user_name" id="user_name" value="<?php echo htmlspecialchars($form_data['user_name'] ?? ''); ?>" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Register</button>
</form>




</body>


<!-- login_form.php -->
 log
<form action="../controllers/db_insert.php" method="post">
    <label for="user_name">Username:</label>
    <input type="text" name="user_name" id="user_name" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Register</button>
</form>


<?php $content = ob_get_clean(); // Store buffered content into $content ?>
<?php $title = 'Home'; // Set the page title ?>
<?php include 'layout.php'; // Include the layout ?>