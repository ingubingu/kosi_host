<?php
// admin.php

require_once '../handlers/Session.php';
require_once '../handlers/AuthHelper.php';
require_once '../controllers/UserController.php';

Session::start();
AuthHelper::ensureAuthenticated();

// Ensure the user has admin privileges
if (Session::get('user')['role'] !== 'admin') {
    // Redirect to the account page if not an admin
    header('Location: account.php');
    exit;
}

$userName = htmlspecialchars(Session::get('user')['user_name']);

ob_start();
?>

<h1>Welcome, <?php echo $userName; ?>!</h1>

<!-- Admin Panel Content -->
<div id="adminPanelContainer">
    <?php include '../includes/admin_panel.php'; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Admin Panel';
include '../views/layout.php';
?>
