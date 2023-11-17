<?php
session_start();
require 'dbconnect.php';
dbConnect();
if (isset($_SESSION['user_id']) && isset($_POST['comment_id'])) {
    $user_id = $_SESSION['user_id'];
    $comment_id = $_POST['comment_id'];
	$comment = "SELECT * FROM Comments WHERE comment_id = :comment_id";
    $stmt = $pdo->prepare($comment);
    $stmt->bindParam(':comment_id', $comment_id);
    $stmt->execute();
    $comment = $stmt->fetch();
    if ($comment) {
	$deleteComment = "DELETE FROM Comments WHERE comment_id = :comment_id";
        $stmt = $pdo->prepare($deleteComment);
        $stmt->bindParam(':comment_id', $comment_id);
        $stmt->execute();
        header('Location: moviePage.php');
        exit;
    } else {
        echo "you cannot delete tihs comment!";
    }
} 
?>
