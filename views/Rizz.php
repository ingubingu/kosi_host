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


<img class = "skibidi" src="rizz.jpg" alt="Description of the image" width="800" height="800">

<img class = "truth" src="ttruth.jpg" alt="Description of the image" width="600" height="2000">

<img class = "twt" src="https://pbs.twimg.com/media/Gcl8VDUa8AALz4g?format=jpg&name=4096x4096" alt="Description of the image" width="600" height="2000">
<?php $content = ob_get_clean(); // Store buffered content into $content ?>
<?php $title = 'Rizz'; // Set the page title ?>
<?php include 'layout.php'; // Include the layout ?>
<?php include '..includes/twitter.php'; // Include the layout ?>
