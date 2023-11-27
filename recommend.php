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
$query = "SELECT Movies.movie_id, Movies.title, Movies.description, Movies.year, Movies.director, COUNT(Ratings.rating_id) as ratings FROM Movies 
          LEFT JOIN Ratings ON Movies.movie_id = Ratings.movie_id GROUP BY Movies.movie_id ORDER BY AVG(Ratings.score) DESC LIMIT 10;";
//top 10 movies
$stmt = $pdo->prepare($query);
$stmt->execute();
$movies = $stmt->fetchAll();

foreach ($movies as $showMovies) {
	echo '<ul>';
	
    echo "<div class='movie-info'>";	
    $movie_id = $showMovies['movie_id'];
    $file_path = "uploads/{$movie_id}_thumb.jpeg";
    if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
    } 		
	$url = "moviePage.php?movie_id={$movie_id}";
	$tag = "<h1> <a href='{$url}'>{$showMovies['title']}</a></h1>";
	echo $tag;
	$findAvg = "SELECT AVG(score) AS average_rating FROM Ratings WHERE movie_id = :movie_id";
	$average = $pdo->prepare($findAvg);    
    $average->bindParam(':movie_id', $movie_id);
	$average->execute();
	$average = $average->fetchColumn();
if ($average !== null) {
    echo "<p>Average Rating: " . number_format($average, 1) . "</p>";
} else {
    echo "<p>No ratings yet.</p>";
}	
	echo "</div>";
	echo "</ul>";
}

?>
</body>
</html>