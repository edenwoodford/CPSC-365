<?php
session_start();
require 'dbconnect.php';
dbConnect();
require 'header.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requester_id = $_POST['friend1'];
    $addressee_id = $_POST['friend2'];

    try {
        $addRequest = "INSERT INTO FriendRequests (requester_id, addressee_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($addRequest);
        $stmt->bindParam(1, $requester_id);
        $stmt->bindParam(2, $addressee_id);
        $stmt->execute();
        
        echo json_encode(['success' => true]); 
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>