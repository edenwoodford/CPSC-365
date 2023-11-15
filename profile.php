
<html>
<body>
    <link rel="stylesheet" href="styles.css">
<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';
    $user_id = $_SESSION['user_id'];
	if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT username FROM Users WHERE user_id = ?");
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $user = $stmt->fetch();
echo '<div class="profile-container">';
    if ($user) {
    echo "<h1>Welcome to {$user['username']}'s page!</h1>";
$file_path = "uploads/{$user_id}_profile.jpeg";
if (file_exists($file_path)) {
    echo "<img src='{$file_path}'/><br>";
} else {
    $file_path = "uploads/no_profile.jpg";
    echo "<img src='{$file_path}'/><br>";

}
}echo '<div class="friends-list">';
$sql = "SELECT u.username FROM Users u JOIN FriendRequests fr ON fr.accepted = true AND (fr.requester_id = :user_id OR fr.addressee_id = :user_id) WHERE (u.user_id = fr.requester_id OR u.user_id = fr.addressee_id) AND u.user_id != :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$friends = $stmt->fetchAll();
echo "<h2>Friends:</h2>";
echo "<ul>";
foreach ($friends as $friend) {
    echo "<li>" . ($friend['username']) . "</li>";
}
echo "</ul>";
echo "</div>";
echo '</div>';
?>
<form action="profilePic.php" method= "POST" enctype="multipart/form-data">
<input type="file" name="upload" accept= ".jpg">
<input type="submit" value= "Update Profile Picture"> <br> 
</form>
<?php
    $findRequest = "SELECT request_id, requester_id, addressee_id 
                    FROM FriendRequests 
                    WHERE (requester_id = ? OR addressee_id = ?) 
                    AND pending = 1";
    $stmt = $pdo->prepare($findRequest);
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    $requests = $stmt->fetchAll();

    foreach ($requests as $request) {
        $sender_id = ($request['requester_id'] == $user_id) ? $request['addressee_id'] : $request['requester_id'];
        $findUsername = "SELECT username FROM Users WHERE user_id = ?";
        $stmt = $pdo->prepare($findUsername);
        $stmt->bindParam(1, $sender_id);
        $stmt->execute();
        $username = $stmt->fetchColumn();
        echo "<form class='friend-request-form'>";
        echo "<p>Request from: " . $username . "</p>";
        echo "<input type='hidden' name='request_id' value='" . $request['request_id'] . "'>";
        echo "<button type='button' data-action='Accept' data-id='" . $request['request_id'] . "'>Accept</button>";
        echo "<button type='button' data-action='Reject' data-id='" . $request['request_id'] . "'>Reject</button>";
        echo "</form>";
		echo '</div>';
    }
}

echo '<div class="activity-container">';
echo '<div class="recent-comments">';
if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
    $fetchComments = "SELECT Comments.*, Users.username, Movies.title FROM Comments 
                      JOIN Users ON Comments.user_id = Users.user_id
                      JOIN Movies ON Comments.movie_id = Movies.movie_id
                      WHERE Comments.user_id = ?
                      ORDER BY Comments.date DESC LIMIT 10";
    $stmt = $pdo->prepare($fetchComments);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $comments = $stmt->fetchAll();

    echo '<h2>Your Recent Comments</h2>';
    foreach ($comments as $comment) {
        echo "<div class='comments'>";
        echo htmlentities($comment['username']) . " commented on " . htmlentities($comment['title']) . "";
        echo ": " . htmlentities($comment['comment']) . "";
        echo " <br> Commented On: " . htmlentities($comment['date']) . "";
        echo "</div>";
    }
}

echo '<div class="recent-ratings">';
    $findRates= "SELECT Movies.title, Ratings.score FROM Ratings JOIN Movies ON Ratings.movie_id = Movies.movie_id WHERE Ratings.user_id = ? ORDER BY Ratings.rating_id DESC LIMIT 10";
    $stmt = $pdo->prepare($findRates);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $ratedMovies = $stmt->fetchAll();
    echo "<h2>Recently Rated Movies:</h2>";
    echo "<ul>";
    foreach ($ratedMovies as $movie) {
        echo "<li>" . ($movie['title']) . " - Rating: " . $movie['score'] . "</li>";
    }
	echo "</ul>";
	echo '</div>';
	echo '</div>';

?>
<script type="text/javascript" src="jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="friendResponse.js"></script>
</body>
</html>

