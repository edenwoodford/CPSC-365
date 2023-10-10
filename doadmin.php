
<?php
session_start();
REQUIRE 'dbconnect.php';
dbConnect();
$errormessage = '';
//check for repeat movies (based on matching title and year)
$stmt = $pdo->prepare("SELECT * FROM Movies WHERE title = :title AND year = :year");
$stmt->bindParam(':title', $_POST['title']);
$stmt->bindParam(':year', $_POST['year']);
$stmt->execute();
$checkMovies= $stmt->fetch();

if ($checkMovies) {
    $errormessage= 'Movie already exists';
	header("Location: admin.php");
	exit();
}

else {
	$addMovie = 'INSERT INTO Movies (title, description, year, director) VALUES (:title, :description, :year, :director)';
	$stmt = $pdo->prepare($addMovie);
	$title = $_POST['title'];
	$description = $_POST['description'];
	$year= $_POST['year'];
	$director = $_POST['director'];
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description );
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':director',$director);
    $stmt->execute();
    $movie_id = $pdo->lastInsertId();
//loop handling a max of 3 genres
//make sure to check for empty
for ($i = 1; $i <= 4; $i++) {
    if (isset($_POST['genre' . $i]) && $_POST['genre' . $i] > 0) {
        $genre_id = $_POST['genre' . $i];
        $addGenre = 'SELECT * FROM Genres WHERE genre_id = :genre_id';
        $stmt = $pdo->prepare($addGenre);
        $stmt->bindParam(':genre_id', $genre_id);
        $stmt->execute();
        $genreExists = $stmt->fetch();
        if ($genreExists) {
            $stmt = $pdo->prepare("INSERT INTO MovieGenres (movie_id, genre_id) VALUES (:movie_id, :genre_id)");
            $stmt->bindParam(':movie_id', $movie_id);
            $stmt->bindParam(':genre_id', $genre_id);
            $stmt->execute();
        }
    }
}
//for loop handling up to 3 actors
for ($i = 1; $i <= 3; $i++) {
  if (!empty($_POST['actor' . $i])) {
    $addActor = 'INSERT IGNORE INTO Actors (name) VALUES (:name)';
     $stmt = $pdo->prepare($addActor);
     $stmt->bindParam(':name', $_POST['actor' . $i]);
     $stmt->execute();
     $actor_id = $pdo->lastInsertId();
if($actor_id == 0) {
     $stmt = $pdo->prepare("SELECT actor_id FROM Actors WHERE name = :name");
     $stmt->bindParam(':name', $_POST['actor' . $i]);
     $stmt->execute();
     $actor_id = $stmt->fetch()['actor_id'];
}
     $stmt = $pdo->prepare("INSERT INTO SharedMovies (movie_id, actor_id) VALUES (:movie_id, :actor_id)");
     $stmt->bindParam(':movie_id', $movie_id);
     $stmt->bindParam(':actor_id', $actor_id);
     $stmt->execute();
    }
}

echo 'movie added';
header("Location: index.php");
}
?>
