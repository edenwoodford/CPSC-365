<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $friendListId = $_POST['friendList_id'];
    $pdo->beginTransaction();
    try {
        $acceptFriend = "UPDATE FriendList SET pending = 0, accepted = 1, denied = 0 WHERE friendList_id = ?";
        $stmt = $pdo->prepare($acceptFriend);
        $stmt->execute([$friendListId]);

        $pdo->commit();
        echo json_encode(['success' => true]);

    } catch (PDOException $e) {
        $pdo->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>