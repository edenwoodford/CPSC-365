<?php
require 'dbconnect.php';
dbConnect();
session_start();
?>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php 
require 'header.php'; 
?>

<h1>Film & Friends</h1>

<?php
$displayMovie = 'SELECT * FROM movies LIMIT 10';
$stmt = $pdo->query($displayMovie);

while ($showMovies = $stmt->fetch()) {
    $movie_id = $showMovies['movie_id'];
    $file_path = "uploads/{$movie_id}.jpeg";

    if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
    } 						//using current movie_id
	$url = "moviePage.php?movie_id={$movie_id}";
	$tag = "<h1> <a href='{$url}'>{$showMovies['title']}</a></h1>";
	echo $tag;
    echo "<br><p>{$showMovies['description']}<p>";
    echo "<p>Directed By: {$showMovies['director']}<p><br>";
}

require 'footer.php';
?>

</body>
</html>