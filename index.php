<?php
session_start();
require 'dbconnect.php';
dbConnect();
?>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php 
require 'header.php'; 

$displayMovie = 'SELECT * FROM Movies ORDER BY dateAdded DESC LIMIT 10';
$stmt = $pdo->query($displayMovie);

while ($showMovies = $stmt->fetch()) {
    $movie_id = $showMovies['movie_id'];
    $file_path = "uploads/{$movie_id}_thumb.jpeg";
    if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
    } 		
	$url = "moviePage.php?movie_id={$movie_id}";
	$tag = "<h1> <a href='{$url}'>{$showMovies['title']}</a></h1>";
	echo $tag;
    echo "<p>{$showMovies['description']}<p>";
    echo "<p>Directed By: {$showMovies['director']}<p>";
	echo "<p>Year: {$showMovies['year']}</p><br>";
}

?>
</body>
</html>