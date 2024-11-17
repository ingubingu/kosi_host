<?php
// Connect to MySQL
$mysqli = new mysqli('localhost', 'root', '', 'tweet_tracker');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Fetch tweets from the database
$result = $mysqli->query("SELECT * FROM tweets ORDER BY created_at DESC");

// Display tweets
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='tweet'>";
        echo "<p><strong>@{$row['author']}</strong>: {$row['tweet_text']}</p>";
        echo "<p><small>Posted on: {$row['created_at']}</small></p>";
        echo "</div>";
    }
} else {
    echo "No tweets found.";
}

$mysqli->close();
?>
