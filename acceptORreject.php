<?php
session_start();
require 'dbconnect.php';
dbConnect();
header('Content-Type: application/json');

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['friendList_id'], $_POST['action'])) {
    $friendListId = $_POST['friendList_id'];
    $action = $_POST['action'];
    $pdo->beginTransaction();
    try {
        if ($action == 'Accept') {
            $stmt = $pdo->prepare("UPDATE FriendList SET pending = 0, accepted = 1 WHERE friendList_id = ?");
        } else {
            $stmt = $pdo->prepare("UPDATE FriendList SET pending = 0, denied = 1 WHERE friendList_id = ?");
        }
		$stmt -> bindParam(1, $friendListId);
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

        