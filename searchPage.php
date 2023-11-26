<html>
<head> <title> Search Results </title>
<link rel="stylesheet" href="movieStyles.css"> </head>
<body>

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
        echo "<div class='movie-info'>";		
        $movie_id = $movie['movie_id'];
        $file_path = "uploads/{$movie_id}_thumb.jpeg";
        if (file_exists($file_path)) {
            echo "<img src='{$file_path}'/><br>";
        }
        $url = "moviePage.php?movie_id={$movie_id}";
        echo "<h1> <a href='{$url}'>{$movie['title']}</a></h1>";
		echo "<p>{$movie['description']}</p>";
	$directors = 'SELECT Directors.name FROM Directors JOIN SharedDirectors ON Directors.director_id = SharedDirectors.director_id WHERE SharedDirectors.movie_id = :movie_id';
    $stmt = $pdo->prepare($directors);
    $stmt->bindParam(':movie_id', $movie_id);
    $stmt->execute();
    echo "<p>Directed By: ";
	$firstDirector = true;
    while ($director = $stmt->fetch()) {
        if (!$firstDirector) {
            echo ', ';
        }
        echo $director['name'];
        $firstDirector = false;
    }
    echo "</p>";
		echo "<p>Year: {$movie['year']}</p>";
		echo "</div>";
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
</body>
</html>
