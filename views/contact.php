<?php ob_start(); // Start output buffering 
require_once '../controllers/usercontroller.php';
Session::start();
Session::set('currentpage','home');
?>
<h1>
<?php  ?>
</h1>
<p>
contact us here!</p>

<?php $content = ob_get_clean(); // Store buffered content into $content ?>
<?php $title = 'Home'; // Set the page title ?>
<?php include 'layout.php'; // Include the layout ?>