<?php
require_once '../handlers/Session.php';
Session::start();

// Remove CSRF token generation
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title ?? 'kosi_host'); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class = "rizz2">

<!-- Header Section -->
<header>
    <nav class="navbar">
        <!-- Drawer Toggle Button (Menu Icon) -->
        <button class="button button--tertiary button--icon-only" data-controller="drawer-toggle">
            <!-- Replace with your own SVG icon if desired -->
            <!-- SVG icon code -->
        </button>

        <!-- Navigation Links -->
        <div class="navbar__items navbar__navigation">
            <a class="navbar__item" href="home.php">Home</a>
            <a class="navbar__item" href="servers.php">Servers</a>
            <a class="navbar__item" href="contact.php">Contact</a>
            <a class="navbar__item" href="devpage.php">Dev Page</a>
            <a class="navbar__item" href="devpage.php">rizz</a>
        </div>
        <div>
<?php
if (!empty($messages)) {
    foreach ($messages as $message) {
        echo '<p class="' . htmlspecialchars($message['type']) . '-message">' . htmlspecialchars($message['text']) . '</p>';
    }
}
?>
</div>
        <!-- User Actions (Login/Register or Account Links) -->
        <div class="navbar__actions">
            <?php if (Session::get('user')): ?>
                <a href="account.php" class="navbar__user">Account</a>
                <a href="../handlers/logout.php" class="navbar__user">Logout</a>
            <?php else: ?>
                <!-- Button to open the login/register modal -->
                <button class="navbar__user" id="log-in-button">
                    Sign Up or Log In
                </button>
            <?php endif; ?>
        </div>
    </nav>
</header>

<!-- Login/Register Modal -->
<div id="log-in-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-button" id="close-modal">&times;</span>
        
        <!-- Login Form -->
        <div id="login-form">
            <h2>Log In</h2>
            <p id="login-message" style="color: red;"></p>
            <form id="login-form-content" method="post">
                <!-- Removed CSRF token hidden input -->
                <label for="login-username">Username</label>
                <input type="text" id="login-username" name="user_name" required>
                
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" required>
                
                <button type="submit" class="button">Log In</button>
            </form>
            <p>Don't have an account? <a href="#" id="show-register">Register</a></p>
        </div>
        
        <!-- Register Form (Initially Hidden) -->
        <div id="register-form" style="display: none;">
            <h2>Register</h2>
            <p id="register-message" style="color: red;"></p>
            <form id="register-form-content" method="post">
                <!-- Removed CSRF token hidden input -->
                <label for="register-username">Username</label>
                <input type="text" id="register-username" name="user_name" required>

                <label for="register-password">Password</label>
                <input type="password" id="register-password" name="password" required>
                
                <button type="submit" class="button">Register</button>
            </form>
            <p>Already have an account? <a href="#" id="show-login">Log In</a></p>
        </div>
    </div>
</div>

<main class="main">
    <?php echo $content ?? ''; ?>
</main>

<footer>
    <p>&copy; <?php echo date('Y'); ?> kosi_host</p>
</footer>

<!-- Removed CSRF token script -->
<script src="../includes/login_modal.js"></script>

</body>
</html>
