<html><head>
<title> Movie Page </title>
    <link rel="stylesheet" href="styles.css">
	</head>
	<body>

<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';
if (isset($_SESSION['user_id'])) {
$user_id = $_SESSION['user_id'];
}
if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];
	$movieProfile = ("SELECT * from Movies WHERE movie_id = :movie_id");
	$stmt =$pdo->prepare($movieProfile);
	$stmt -> bindParam(':movie_id', $movie_id);
	$stmt -> execute();
	$findMovie = $stmt -> fetch();
	$movieGenres = "SELECT Genres.genre FROM MovieGenres JOIN Genres ON MovieGenres.genre_id = Genres.genre_id WHERE MovieGenres.movie_id = :movie_id";
	$stmt = $pdo->prepare($movieGenres);
	$stmt->bindParam(':movie_id', $movie_id);
	$stmt->execute();
	$genres = $stmt->fetchAll();
	$movieActors = "SELECT Actors.name FROM SharedMovies JOIN Actors ON SharedMovies.actor_id = Actors.actor_id WHERE SharedMovies.movie_id = :movie_id";
	$stmt =$pdo->prepare($movieActors);
	$stmt -> bindParam(':movie_id', $movie_id);
	$stmt -> execute();
	$actors = $stmt-> fetchAll();
	if ($findMovie) {
        echo "<h2>{$findMovie['title']}</h2>";
		$movie_id = $findMovie['movie_id'];
		$file_path = "uploads/{$movie_id}_thumb.jpeg";
		if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
		?>
		<fieldset> <legend> Description </legend><p class="description">
		<?php
		echo "{$findMovie['description']}<br>";
		?>
		</p></fieldset>
		<?php
        echo "<p>Year: {$findMovie['year']}</p>";
		echo "<p>Genre(s): ";
		foreach ($genres as $genre) {
		echo " ";
	    echo "{$genre['genre']}";
		echo ", ";
		}
		echo "</p>";
		echo "Actor(s): ";
		foreach ($actors as $actor) {
		echo "{$actor['name']}, ";
		}
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
	$findComments = "SELECT Users.username, Comments.comment, Comments.date, Comments.user_id FROM Comments
	JOIN Users ON Comments.user_id = Users.user_id WHERE Comments.movie_id = :movie_id ORDER BY Comments.date DESC LIMIT 10";
    $stmt = $pdo->prepare($findComments);
    $stmt->bindParam(':movie_id', $movie_id);
    $stmt->execute();
    $comments = $stmt->fetchAll();
    echo "<h3>Comments:</h3>";
    foreach ($comments as $comment) {
    echo "<p>{$comment['username']}: ";
    echo htmlentities($comment['comment'], ENT_QUOTES) . " ";
	echo "(posted on {$comment['date']})</p>";
	if (isset($_SESSION ['user_id'])){
    if (($_SESSION['user_id'] != $comment['user_id']))  {
$sql = "SELECT COUNT(*) FROM FriendList 
        JOIN Friends ON FriendList.friend_id = Friends.friend_id
        WHERE ((Friends.user_id1 = :currentUser AND Friends.user_id2 = :otherUser) 
        OR (Friends.user_id1 = :otherUser AND Friends.user_id2 = :currentUser))
        AND FriendList.pending = 1";
//this finds where the sender has already set a pending request to the receiver
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':currentUser', $_SESSION['user_id']);
$stmt->bindParam(':otherUser', $comment['user_id']);
$stmt->execute();
$requestExists = $stmt->fetchColumn() > 0;
        if (!$requestExists) {
			//and then doesnt display this form again
	?>
<form id="addFriendForm">
<input type="button" id="addFriendButton" value="Add Friend" 
        data-friend1="<?php echo $_SESSION['user_id']; ?>" 
        data-friend2="<?php echo $comment['user_id']; ?>" />
</form>
<script type="text/javascript" src="jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="friendJS.js"></script>

	<?php
	  }
	}
  }
}
//ex: echo '<b> Latest Comment: </b>''.htmlentities($_POST['comment'],ENT_QUOTES).'<br>;
    if (isset($_SESSION['user_id'])) {
        echo '<form action="" method="post">';
        echo '<textarea name="comment" required></textarea><br>';
        echo '<input type="submit" value="Leave a Comment">';
		echo '<input type="hidden" id = "friend2id" name= "friend2id">';
		echo '</form>';
    } 
	?>
	</div>
    <div class="ratings">
	<?php
	//this is checking to see if the same user has already rated this movie
	if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$find = "SELECT score FROM Ratings WHERE user_id = :user_id AND movie_id = :movie_id";
    $stmt = $pdo->prepare($find);
	$stmt -> bindParam(':movie_id', $movie_id);
	$stmt -> bindParam(':user_id', $user_id);
    $stmt->execute();
    $prevRating = $stmt->fetchColumn();
    if ($prevRating) {
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
