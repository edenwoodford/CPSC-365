<html><head>
<title> Movie Page </title>
   <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .comments, .ratings {
            flex: 1;
        }
        .comments {
            max-width: 50%;
        }
        .ratings {
            max-width: 50%;
        }
    </style>
	</head>
	<body>

<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';
if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];
    //display movie details eventually
	$movieProfile = ("SELECT * from Movies WHERE movie_id = :movie_id");
	$stmt =$pdo->prepare($movieProfile);
	$stmt -> bindParam(':movie_id', $movie_id);
	$stmt -> execute();
	$findMovie = $stmt -> fetch();
	//join betweeen movieGenres and Genres
	$movieGenres = "SELECT Genres.genre FROM MovieGenres JOIN Genres ON MovieGenres.genre_id = Genres.genre_id WHERE MovieGenres.movie_id = :movie_id";
	$stmt = $pdo->prepare($movieGenres);
	$stmt->bindParam(':movie_id', $movie_id);
	$stmt->execute();
	$genres = $stmt->fetchAll();
	$movieActors = "SELECT Actors.name FROM SharedMovies JOIN Actors ON SharedMovies.actor_id = Actors.actor_id WHERE SharedMovies.movie_id = :movie_id";
	$stmt =$pdo->prepare($movieActors);
	$stmt -> bindParam(':movie_id', $movie_id);
	$stmt -> execute();
	$actor = $stmt-> fetch();
	if ($findMovie) {
        echo "<h2>{$findMovie['title']}</h2>";
		$movie_id = $findMovie['movie_id'];
		$file_path = "uploads/{$movie_id}_thumb.jpeg";
		if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
		echo "{$findMovie['description']}<br>";
		echo '<div class="movie-detail-container">';
        echo "<p>Year: {$findMovie['year']}</p>";
		echo "<p>Genre(s): ";
		foreach ($genres as $genre) {
		echo " ";
	    echo "{$genre['genre']}";
		}
		echo "</p>";
		echo "Actor(s): ";
		echo "{$actor['name']}, ";
        echo "<p>Directed by: {$findMovie['director']}</p>";
        echo '</div>';
		}
	}
	?>
	 <div class="container">
     <div class="comments">
	<?php
	 if (isset($_POST['comment']) && isset($_SESSION['user_id'])) {
     $comment = htmlentities($_POST['comment'], ENT_QUOTES);
     $user_id = $_SESSION['user_id'];
     $stmt = $pdo->prepare("INSERT INTO Comments (movie_id, user_id, comment, date) VALUES (:movie_id, :user_id, :comment, NOW())");
     $stmt->bindParam(':movie_id', $movie_id);
     $stmt->bindParam(':user_id', $user_id);
     $stmt->bindParam(':comment', $comment);
     $stmt->execute();
	 header("Location: ?movie_id=$movie_id");
     exit();
    }
	$findComments = "SELECT Users.username, Comments.comment, Comments.date, Comments.user_id FROM Comments JOIN Users ON Comments.user_id = Users.user_id WHERE Comments.movie_id = :movie_id ORDER BY Comments.date DESC LIMIT 10";
    $stmt = $pdo->prepare($findComments);
    $stmt->bindParam(':movie_id', $movie_id);
    $stmt->execute();
    $comments = $stmt->fetchAll();
    echo "<h3>Comments:</h3>";
    foreach ($comments as $comment) {
    echo "<p>{$comment['username']}: ";
    echo htmlentities($comment['comment'], ENT_QUOTES) . " ";
	echo "(posted on {$comment['date']})</p>";
    if ($_SESSION['user_id'] != $comment['user_id']) {
	?>
	<form action="addFriend.php" method="post">
	<input type="submit" value="Add Friend" class="nostyle">
	</form>
	<?php
    }
    }
//ex: echo '<b> Latest Comment: </b>''.htmlentities($_POST['comment'],ENT_QUOTES).'<br>;
    if (isset($_SESSION['user_id'])) {
        echo '<form action="" method="post">';
        echo '<textarea name="comment" required></textarea><br>';
        echo '<input type="submit" value="Leave a Comment">';
        echo '</form>';
    } 
	?>
	</div>
    <div class="ratings">
	<?php
	//this is checking to see if the same user has already rated this movie
	if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT score FROM Ratings WHERE user_id = :user_id AND movie_id = :movie_id");
	$stmt -> bindParam(':movie_id', $movie_id);
	$stmt -> bindParam(':user_id', $user_id);
    $stmt->execute();
    $prevRating = $stmt->fetchColumn();
    if ($prevRating != false) {
        echo "<p>Your rating: $prevRating</p>";
    } else {
?>
        <form action="rating.php" method="post">
            <fieldset><legend>Review This Movie</legend>	
                <p><label for="rating">Rating<br></label>
                    <input type="radio" name="score" value="1" /> 1 
                    <input type="radio" name="score" value="2" /> 2
                    <input type="radio" name="score" value="3" /> 3 
                    <input type="radio" name="score" value="4" /> 4 
                    <input type="radio" name="score" value="5" /> 5
                </p>
                <input type="hidden" name="movie_id" value="
				<?php 
				echo $movie_id; 
				?>">
                <p><input type="submit" value="Submit Review"></p>
            </fieldset>
        </form>
<?php
  }
 }
}
?>
</div>
</div>
</body>

</html>

