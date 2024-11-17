<?php
require_once '../controllers/UserController.php';

$AU = new UserController();
// *****LIVE admin panel for LIVE SEARCH******
if (isset($_POST['searchQuery'])) {
    // Handle AJAX search request
    $searchQuery = strtolower(trim($_POST['searchQuery']));
    $users = $AU->getAllUsers();

    // Filter users based on the search query
    foreach ($users as $user) {
        if (strpos(strtolower($user), $searchQuery) !== false) {
            $age = $AU->displayAccountAge($user);
            echo '<div class="user-container" data-username="' . htmlspecialchars($user) . '">
                    <div class="user-controls">
                        <span>' . htmlspecialchars($user) . '</span>
                        <button class="button" id="addinstance">add instance</button>
                        <button class="button">remove instance</button>
                        <button class="button">delete user</button>
                        <button class="button">edit user</button>
                    </div>
                </div>';
        }
    }
    exit; // Stop further script execution
}

// *****Default admin panel for initial loading******
$users = $AU->getAllUsers();

?>

<h1>ADMIN PANEL</h1>
<input type="text" id="searchInput" class="search-bar" placeholder="Search for users...">
<div id="userList">
    <?php foreach ($users as $user) : ?>
        <?php $age = $AU->displayAccountAge($user); ?>
        <div class="user-container" data-username="<?php echo htmlspecialchars($user); ?>">
            <div class="user-controls">
                <span><?php echo ' username: ' . htmlspecialchars($user) . ', id: '. htmlspecialchars($AU->getId($user)); ?></span>
                <button id="addInstanceButton" class="button">add instance</button>
                <button class="button">remove instance</button>
                <button class="button">delete user</button>
                <button class="button">edit user</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="userDetailsModal" class="modal" style="display: none;">
    <div class="modal-content">
        <!-- User details will be loaded here -->
    </div>
</div>
