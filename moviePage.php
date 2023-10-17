<html>

<?php
require 'dbconnect.php';
dbConnect();
require 'header.php';
if (isset($_GET['movie_id'])) { //post doesnt work
    $movie_id = $_GET['movie_id'];
	echo 'this is the movie details page';
    //display movie details eventually
	$movieProfile = ("SELECT * from Movies WHERE movie_id = :movie_id");
	$stmt =$pdo->prepare($movieProfile);
	$stmt -> bindParam(':movie_id', $movie_id);
	$stmt -> execute();
	$findMovie = $stmt -> fetch();
	if ($findMovie) {
		$movie_id = $findMovie['movie_id'];
		$file_path = "uploads/{$movie_id}.jpeg";
		if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
    } 	
}
}
?>

</html>

