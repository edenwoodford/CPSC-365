<?php
session_start();
REQUIRE 'dbconnect.php';
dbConnect();
$score = $_POST['score'];
$movie_id = $_POST['movie_id'];
$user_id = $_SESSION['user_id'];
$score = (int)$score;
$movie_id = (int)$movie_id;
$user_id = (int)$user_id;
//allowing one rate per user per movie
$checkRatings = "SELECT * FROM Ratings WHERE user_id = :user_id AND movie_id = :movie_id";
$stmt = $pdo->prepare($checkRatings);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':movie_id', $movie_id);
$stmt->execute();
if($stmt->fetch()) {
    echo "already rated this!";
} 
else {
//insert into database
$rate = 'INSERT INTO Ratings (score, user_id, movie_id) VALUES (:score, :user_id, :movie_id)';
$stmt = $pdo->prepare($rate);
$stmt->bindParam(':score', $score);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':movie_id', $movie_id);
$stmt->execute();
echo ' rating added! ';
//find avg
$averageRatings = "SELECT AVG(score) as avgScore FROM Ratings WHERE movie_id = :movie_id";
$stmt = $pdo->prepare($averageRatings);
$stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
$stmt->execute();
$findRating = $stmt->fetch();
$averageRating = $findRating['avgScore'];
header ("Location: moviePage.php");
}

//$sql2 = 'INSERT INTO Ratings (user_id) VALUES (:user_id)';
//$stmt = $pdo-> prepare($sql2);
header ("Location: index.php");
?>
