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
<p class = "rizz">


Rizzing up gyatts in ohio till I grimace on my shake</p>


<?php $content = ob_get_clean(); // Store buffered content into $content ?>
<?php $title = 'Rizz'; // Set the page title ?>
<?php include 'layout.php'; // Include the layout ?>
