<?php ob_start(); // Start output buffering 
require_once '../controllers/usercontroller.php';
Session::start();
Session::set('currentpage','home');
?>
<h1>
<?php ?>
</h1>

<section class="features">
    <h2>Which game do you need a server for?</h2>
    <div class="card-container">
        <button class="card">
            <h3>Minecraft</h3>
            <p>We have modded servers too!</p>
        </button>
        <button class="card">
            <h3>Rust</h3>
            <p>Rust game server</p>
        </button>
        <button class="card">
            <h3>Ark</h3>
            <p>Select any Ark world or upload your own!</p>
        </button>
    </div>
</section>



<p>
get your servers here!</p>

<?php $content = ob_get_clean(); // Store buffered content into $content ?>
<?php $title = 'Home'; // Set the page title ?>
<?php include 'layout.php'; // Include the layout ?>