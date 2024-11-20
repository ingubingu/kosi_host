<?php
// account.php

require_once '../handlers/Session.php';
require_once '../handlers/AuthHelper.php';
require_once '../controllers/UserController.php';

Session::start();
AuthHelper::ensureAuthenticated();

$userController = new UserController();
$userData = Session::get('user');
$userName = htmlspecialchars($userData['user_name']);
$accountInfo = $userController->displayAccountAge($userName);

ob_start();
?>

<h1>Welcome, <?php echo $userName; ?></h1>

<?php if ($accountInfo): ?>
    <p>
        Account Age: 
        <?php echo $accountInfo['account_age_months']; ?> months,
        <?php echo $accountInfo['account_age_days']; ?> days,
        <?php echo $accountInfo['account_age_hours']; ?> hours,
        <?php echo $accountInfo['account_age_minutes']; ?> minutes
    </p>
<?php else: ?>
    <p>No account information found for this user.</p>
<?php endif; ?>

<?php if ($userData['role'] === 'admin'): ?>
    <button id="adminToggleButton">Admin Panel</button>
<?php endif; ?>
    <div class = "panelcontainer">
    <div id="adminPanel" style="display: none;" class = "adminPanel"></div>
    
<div class = "userdetails">
    <h2>Account Details</h2>
    <p>Username: <?php echo $userName; ?></p>
    <p>Role: <?php echo $userData['role']; ?></p>
</div>
</div>



<script src="../includes/admin_panel.js"></script>
<?php
$content = ob_get_clean();
$title = 'Account';
include '../views/layout.php';
?>
