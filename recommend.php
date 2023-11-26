<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php'; 

?>
<html>
<head>
    <title>Recommendations</title>
    <link rel="stylesheet" href="movieStyles.css">
</head>
<body>

<?php 
$user_id = $_SESSION['user_id'];
$query =" SELECT Movies.movie_id, Movies.title, Movies.description, Movies.year, Movies.director, COUNT(Ratings.rating_id) as ratings FROM Movies
LEFT JOIN Ratings ON Movies.movie_id = Ratings.movie_id GROUP BY Movies.movie_id
ORDER BY ratings DESC LIMIT 10";

$stmt = $pdo->prepare($query);
$stmt->execute();
$movies = $stmt->fetchAll();
foreach ($movies as $showMovies) {
    echo "<div class='movie-info'>";	
    $movie_id = $showMovies['movie_id'];
    $file_path = "uploads/{$movie_id}_thumb.jpeg";
    if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
    } 		
	$url = "moviePage.php?movie_id={$movie_id}";
	$tag = "<h1> <a href='{$url}'>{$showMovies['title']}</a></h1>";
	echo $tag;
    echo "<p>{$showMovies['description']}</p>";
    echo "<p>Directed By: {$showMovies['director']}</p>";
    echo "<p>Year: {$showMovies['year']}</p>";
	echo "</div>";
}

?>
</body>
</html>