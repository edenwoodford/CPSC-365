<?php
session_start();
require 'dbconnect.php';
dbConnect();
header('Content-Type: application/json');

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'], $_POST['action'])) {
    $requestId = $_POST['request_id'];
    $action = $_POST['action'];
    $pdo->beginTransaction();
    try {
        if ($action == 'Accept') {
            $stmt = $pdo->prepare("UPDATE FriendRequests SET pending = FALSE, accepted = TRUE WHERE request_id = ?");
        } else {
            $stmt = $pdo->prepare("UPDATE FriendRequests SET pending = FALSE, denied = TRUE WHERE request_id = ?");
        }
        $stmt->bindParam(1, $requestId);
        $stmt->execute();
        $pdo->commit();
        $response['success'] = true;
    } catch (PDOException $e) {
        $pdo->rollback();
        $response['error'] = $e->getMessage();
    }
} else {
    $response['error'] = 'Invalid request';
}

echo json_encode($response);
?>
