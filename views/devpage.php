<?php
require_once '../controllers/UserController.php';
require_once '../handlers/Session.php';
require_once '../handlers/Message.php';

Session::start();
Session::set('currentpage', 'devpage');

$messages = Message::getMessages();
?>
<?php ob_start(); // Start buffering ?>
<?php if (!empty($messages)): ?>
    <div class="messages">
        <?php foreach ($messages as $message): ?>
            <div class="message <?php echo $message['type']; ?>">
                <?php echo $message['text']; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Page</title>
    <style>
        .column-input {
            display: flex;
            margin-bottom: 10px;
        }
        .column-input input, .column-input select {
            margin-right: 10px;
        }
        .column-input button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Developer Page</h1>
    <form id="create-table-form" method="POST">
        <label for="table-name">Table Name:</label>
        <input type="text" id="table-name" name="table[name]" required><br><br>

        <div id="columns-container">
            <div class="column-input">
                <input type="text" name="table[columns][0][name]" placeholder="Column Name" required>
                <select name="table[columns][0][type]" required>
                    <option value="INT">INT</option>
                    <option value="VARCHAR(255)">VARCHAR(255)</option>
                    <option value="TEXT">TEXT</option>
                    <option value="DATE">DATE</option>
                    <option value="DATETIME">DATETIME</option>
                    <option value="BOOLEAN">BOOLEAN</option>
                    <!-- Add more types as needed -->
                </select>
                <button type="button" class="remove-column-button">Remove</button>
            </div>
        </div>

        <button type="button" id="add-column-button">Add Column</button><br><br>
        <button type="submit">Create Table</button>
    </form>

    <!-- Response Message Placeholder -->
    <div id="response-message"></div>

    <script src="../includes/devpage.js"></script>
</body>
</html>

<?php $content = ob_get_clean(); // Store buffered content into $content ?>
<?php $title = 'devpage'; // Set the page title ?>
<?php include 'layout.php'; // Include the layout ?>