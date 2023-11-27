<?php
session_start();
require 'dbconnect.php';
dbConnect();
?>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="movieStyles.css">
</head>
<body>

<?php 
require 'header.php'; 

$displayMovie = 'SELECT * FROM Movies ORDER BY dateAdded DESC LIMIT 10';
$stmt = $pdo->query($displayMovie);

while ($showMovies = $stmt->fetch()) {
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
    echo "<p>{$showMovies['description']}</p>";
    echo "<p>Year: {$showMovies['year']}</p>";
    $directors = 'SELECT Directors.name FROM Directors JOIN SharedDirectors ON Directors.director_id = SharedDirectors.director_id WHERE SharedDirectors.movie_id = :movie_id';
    $stmt2 = $pdo->prepare($directors);
    $stmt2->bindParam(':movie_id', $movie_id);
    $stmt2->execute();
    
    echo "<p>Directed By: ";
$firstDirector = true;
    while ($director = $stmt2->fetch()) {
        if (!$firstDirector) {
            echo ', ';
        }
        echo $director['name'];
        $firstDirector = false;
    }
    echo "</p>";
	echo '</ul>';
    echo "</div>";
}

?>
</body>
</html>