<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';


if (isset($_GET['title'])) {
    $title = $_GET['title'];
    $userSearch = "SELECT * FROM Movies WHERE title LIKE :title";
    $stmt = $pdo->prepare($userSearch);
    $stmt->bindValue(':title', "%$title%");
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $movie) {
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
}
else {
	header("Location: index.php");
}
//eventually i can put an error image

?>
