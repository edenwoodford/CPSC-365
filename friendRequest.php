<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user1 = $_POST['friend1'];
    $user2 = $_POST['friend2'];

    $pdo->beginTransaction();
    try {
        $addFriend = "INSERT INTO Friends (user_id1, user_id2) VALUES (?, ?)";
        $stmt = $pdo->prepare($addFriend);
        $stmt->bindParam(1, $user1);
        $stmt->bindParam(2, $user2);
        $stmt->execute();
        
        $friendsId = $pdo->lastInsertId();
        
        $pending = "INSERT INTO FriendList (friend_id, user_id, pending, accepted, denied) VALUES (?, ?, 1, 0, 0)";
        $stmt = $pdo->prepare($pending);
        $stmt->bindParam(1, $friendsId);
        $stmt->bindParam(2, $user1);
        $stmt->execute();

    $pdo->commit();
    echo json_encode(['success' => true]); 
} catch (PDOException $e) {
    $pdo->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
}
?>