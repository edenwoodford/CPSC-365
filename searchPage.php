<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';

if (isset($_GET['title'])) {
    $title = $_GET['title'];

    $movieSearch = "SELECT * FROM Movies WHERE title LIKE :title";
    $stmt = $pdo->prepare($movieSearch);
    $stmt->bindValue(':title', "%$title%");
    $stmt->execute();
    $movies = $stmt->fetchAll();

    $userSearch = "SELECT * FROM Users WHERE username LIKE :username";
    $stmt = $pdo->prepare($userSearch);
    $stmt->bindValue(':username', "%$title%");
    $stmt->execute();
    $users = $stmt->fetchAll();

    foreach ($movies as $movie) {
        $movie_id = $movie['movie_id'];
        $file_path = "uploads/{$movie_id}_thumb.jpeg";
        if (file_exists($file_path)) {
            echo "<img src='{$file_path}'/><br>";
        }
        $url = "moviePage.php?movie_id={$movie_id}";
        echo "<h1> <a href='{$url}'>{$movie['title']}</a></h1>";
        echo "<br><p>{$movie['description']}</p>";
        echo "<p>Directed By: {$movie['director']}</p><br>";
    }

    foreach ($users as $user) {
        $user_id = $user['user_id'];
        $url = "profile.php?user_id={$user_id}"; 
        echo "<h2><a href='{$url}'>{$user['username']}</a></h2>";
    }
}
else {
	header("Location: index.php");
}
?>
