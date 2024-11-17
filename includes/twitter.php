<?php
// Load Composer's autoloader
require "../vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

// Twitter API credentials
define('API_KEY', 'IxcYk4CkchNxd6qdKbc4wcw1a');
define('API_SECRET_KEY', 'IxcYk4CkchNxd6qdKbc4wcw1a');
define('ACCESS_TOKEN', '892904055177138176-gf2GFXE41ngT5uFNpofuzZ82bH7vp0R');
define('ACCESS_TOKEN_SECRET', 'RkGQBYOng5Ilz2ZnLYO7lqHtVmqnehNRxE5W7xsocH2Jh');

// Create TwitterOAuth object
$twitterOAuth = new TwitterOAuth(API_KEY, API_SECRET_KEY, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// Define the hashtag or query to search for
$query = '#javascript'; // Replace with your desired hashtag or keyword

// Fetch tweets from Twitter API (you can adjust the parameters as needed)
$tweets = $twitterOAuth->get('search/tweets', [
    'q' => $query,
    'count' => 10, // Number of tweets to fetch
    'result_type' => 'recent' // Get recent tweets
]);

// Check if we got a valid response
if (isset($tweets->statuses)) {
    // Connect to MySQL
    $mysqli = new mysqli('localhost', 'root', '', 'tweet_tracker');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    // Insert each tweet into the database
    foreach ($tweets->statuses as $tweet) {
        $tweet_id = $mysqli->real_escape_string($tweet->id_str);
        $author = $mysqli->real_escape_string($tweet->user->screen_name);
        $tweet_text = $mysqli->real_escape_string($tweet->text);
        
        $sql = "INSERT INTO tweets (tweet_id, author, tweet_text) VALUES ('$tweet_id', '$author', '$tweet_text')";
        
        if ($mysqli->query($sql) === TRUE) {
            echo "Tweet stored successfully: $author<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }

    $mysqli->close();
} else {
    echo "No tweets found.";
}
?>
