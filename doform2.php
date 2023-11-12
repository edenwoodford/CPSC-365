<?php
session_start();
REQUIRE 'dbconnect.php';
dbConnect();
$username = $_POST["username"];
$password = $_POST["password"];
$checkUsername = "SELECT * FROM Users WHERE username = :username";
$stmt = $pdo->prepare($checkUsername);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(); 
//??
if (!$user) {
     echo 'User is not found';
} 
else {
	$storedPassword = $user['password'];
	if (password_verify($password, $storedPassword)) {
		session_regenerate_id(true);
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['admin'] = $user['admin'];
//admin???		
			echo 'Login Successful';
			header("Location: index.php");
			exit();
		
	} else {
      echo 'Incorrect username or password';
	  sleep(3);
	  header("Location: userlogin.php");
	  exit();
}
}

?>
