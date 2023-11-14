
<html>
<body>

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
    if ($user) {
        echo "<h1>Welcome to {$user['username']}'s page!</h1>";
$file_path = "uploads/{$user_id}_profile.jpeg";
if (file_exists($file_path)) {
    echo "<img src='{$file_path}'/><br>";
} else {
    $file_path = "uploads/no_profile.jpg";
    echo "<img src='{$file_path}'/><br>";
}
}
?>
<form action="profilePic.php" method= "POST" enctype="multipart/form-data">
<input type="file" name="upload" accept= ".jpg">
<input type="submit" value= "Update Profile Picture"> <br> 
</form>
<?php
   $findRequest = "SELECT FriendList.friendList_id, Friends.user_id1, Friends.user_id2 
                    FROM FriendList 
                    JOIN Friends ON FriendList.friend_id = Friends.friend_id 
                    WHERE (Friends.user_id1 = ? OR Friends.user_id2 = ?) 
                    AND FriendList.pending = 1";
    $stmt = $pdo->prepare($findRequest);
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    $requests = $stmt->fetchAll();

    foreach ($requests as $request) {
        $sender_id = ($request['user_id1'] == $user_id) 
		? $request['user_id2'] : $request['user_id1'];
        $findUsername = "SELECT username FROM Users WHERE user_id = ?";
        $stmt = $pdo->prepare($findUsername);
        $stmt->bindParam(1, $sender_id);
        $stmt->execute();
        $username = $stmt->fetchColumn();
        echo "<form class='friend-request-form'>";
        echo "<p>Request from: " . $username . "</p>";
        echo "<input type='hidden' name='friendList_id' value='" . $request['friendList_id'] . "'>";
        echo "<button type='button' data-action='Accept' data-id='" . $request['friendList_id'] . "'>Accept</button>";
        echo "<button type='button' data-action='Reject' data-id='" . $request['friendList_id'] . "'>Reject</button>";
        echo "</form>";
    }
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $fetchComments = "SELECT Comments.*, Users.username
                      FROM Comments
                      JOIN Users ON Comments.user_id = Users.user_id
                      JOIN FriendList ON (FriendList.user_id = Users.user_id OR FriendList.friend_id = Users.user_id)
                      WHERE (FriendList.user_id = ? OR FriendList.friend_id = ?)
                      AND FriendList.pending = 0 AND FriendList.accepted = 1
                      ORDER BY Comments.date DESC LIMIT 10";
    $stmt = $pdo->prepare($fetchComments);
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    $comments = $stmt->fetchAll();

    foreach ($comments as $comment) {
        echo "<div class='comment'>";
        echo "<p>" . $comment['username'] . " commented on Movie ID: " . $comment['movie_id'] . "</p>";
        echo "<p>" . $comment['comment'] . "</p>";
        echo "<p>Comment Date: " . $comment['date'] . "</p>";
        echo "</div>";
    }
}

?>
<script type="text/javascript" src="jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="friendResponse.js"></script>
<?php
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
	$sql = "SELECT U.username FROM Users U JOIN FriendList FL ON (U.user_id = FL.user_id OR U.user_id = FL.friend_id)JOIN Friends F ON FL.friend_id = F.friend_id WHERE (F.user_id1 = :user_id OR F.user_id2 = :user_id) AND FL.accepted = 1 AND U.user_id != :user_id";
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
?>
</body>
</html>

