
<?php
session_start();
REQUIRE 'dbconnect.php';
dbConnect();

//check for repeat movies (based on matching title and year)
$stmt = $pdo->prepare("SELECT * FROM Movies WHERE title = :title AND year = :year");
$stmt->bindParam(':title', $_POST['title']);
$stmt->bindParam(':year', $_POST['year']);
$stmt->execute();
$checkMovies= $stmt->fetch();

if ($checkMovies) {
    echo 'Movie already existas';
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
	//$upload = $_POST['upload'];
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description );
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':director',$director);
	//$stmt->bindParam(':upload', $upload);
    $stmt->execute();
    $movie_id = $pdo->lastInsertId();

if (isset($_FILES['upload'])) {
	//var_dump($_FILES['upload']);
	//we are using movie_id to name the images
	if ($_FILES ['upload']['error']  != UPLOAD_ERR_OK)
	{
		echo 'error uploading file';
		exit();
	}
	$finfo = new finfo (FILEINFO_MIME_TYPE);
	$ftype = $finfo->file ($_FILES['upload']['tmp_name']);
	if ($ftype != "image/jpeg")
	{
			echo 'error invalid file type';
			exit();
	}else {
        $upload_dir = 'uploads/';
		//name of my folder
        $filename = $upload_dir . $movie_id . '.jpeg';
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $filename)) {
            echo 'File uploaded successfully';
        } else {
            echo 'Error moving uploaded file';
            exit();
        }
	$image = imagecreatefromjpeg ($filename);
	$width = imagesx ($image);
	$height = imagesy ($image);
	$targetWidth = 250;
	$targetHeight = floor ($height * ($targetWidth/$width));
	
	$thumbnail = imagecreatetruecolor ($targetWidth, $targetHeight);
	imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
	imagejpeg ($thumbnail, "movieposter.jpg");
    }
}

//loop handling a max of 3 genres
//make sure to check for empty
for ($i = 1; $i <= 3; $i++) {
    if (isset($_POST['genre' . $i]) && $_POST['genre' . $i] > 0) {
        $genre_id = $_POST['genre' . $i];
        $addGenre = 'SELECT * FROM Genres WHERE genre_id = :genre_id';
        $stmt = $pdo->prepare($addGenre);
        $stmt->bindParam(':genre_id', $genre_id);
        $stmt->execute();
        $genreExists = $stmt->fetch();
        if ($genreExists) {
			$linkToMovie = "INSERT INTO MovieGenres (movie_id, genre_id) VALUES (:movie_id, :genre_id)";
            $stmt = $pdo->prepare($linkToMovie);
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
	 $addNewActors = "SELECT actor_id FROM Actors WHERE name = :name";
     $stmt = $pdo->prepare($addNewActor);
     $stmt->bindParam(':name', $_POST['actor' . $i]);
     $stmt->execute();
     $actor_id = $stmt->fetch()['actor_id'];
}
	$sharedMovies = "INSERT INTO SharedMovies (movie_id, actor_id) VALUES (:movie_id, :actor_id)";
     $stmt = $pdo->prepare($sharedMovies);
     $stmt->bindParam(':movie_id', $movie_id);
     $stmt->bindParam(':actor_id', $actor_id);
     $stmt->execute();
    }
}
echo 'movie added';
header("Location: index.php");
}
?>
