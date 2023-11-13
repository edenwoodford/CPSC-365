<?php
session_start();
require 'dbconnect.php';
dbConnect();
?>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php 
require 'header.php'; 
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

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
                      ORDER BY Comments.date DESC
                      LIMIT 10";
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
$displayMovie = 'SELECT * FROM movies ORDER BY dateAdded DESC LIMIT 10';
$stmt = $pdo->query($displayMovie);

while ($showMovies = $stmt->fetch()) {
    $movie_id = $showMovies['movie_id'];
    $file_path = "uploads/{$movie_id}_thumb.jpeg";
    if (file_exists($file_path)) {
        echo "<img src='{$file_path}'/><br>";
    } 						//using current movie_id
	$url = "moviePage.php?movie_id={$movie_id}";
	$tag = "<h1> <a href='{$url}'>{$showMovies['title']}</a></h1>";
	echo $tag;
    echo "<p>{$showMovies['description']}<p>";
    echo "<p>Directed By: {$showMovies['director']}<p>";
	echo "<p>Year: {$showMovies['year']}</p><br>";
}
?>
</body>
</html>