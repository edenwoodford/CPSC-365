//deleteMovie.php
<?php
REQUIRE 'dbconnect.php';
dbConnect();
$title = $_POST['title'];
$findMovie ='SELECT * FROM Movies where title = :title';
$stmt= $pdo-> prepare($findMovie);
$stmt->bindParam(':title', $title);
$stmt->execute();
$row = $stmt -> fetch();
if ($row) {
   $deleteMovie = 'DELETE FROM Movies WHERE title = :title';
   $stmt = $pdo-> prepare($deleteMovie);
   $stmt->bindParam(':title', $title);
   $stmt->execute();
   echo "movie was deleted from the database";
   header('Location: admin.php');
}
else {
	echo 'Movie title does not exist';
}

?>