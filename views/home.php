<?php ob_start(); // Start output buffering 
require_once '../handlers/Session.php';
require_once '../handlers/Message.php';
Session::start();
Session::set('currentpage','home');
// Retrieve messages
$messages = Message::getMessages();
?>

<h1>
<?php  ?>
</h1>
<p>


This is the home page! currently under development...</p>


<?php $content = ob_get_clean(); // Store buffered content into $content ?>
<?php $title = 'Home'; // Set the page title ?>
<?php include 'layout.php'; // Include the layout ?>