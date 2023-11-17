<?php
session_start();
require 'dbconnect.php';
dbConnect();

if (isset($_SESSION['user_id']) && isset($_POST['bio'])) {
    $user_id = $_SESSION['user_id'];
    $bio = $_POST['bio']; 
    $stmt = $pdo->prepare("UPDATE Users SET bio = ? WHERE user_id = ?");
    $stmt->bindParam(1, $bio);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();

    header("Location: profile.php");
} else {
    echo ' could not add bio';
}
?>
