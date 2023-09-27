<?php
REQUIRE 'dbconnect.php';
dbConnect();

$username = $_POST["username"];
$password = $_POST["password"];
$checkUsername = "SELECT * FROM Users WHERE username = :username";
$stmt = $pdo->prepare($checkUsername);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC); 
//??
if (!$user) {
     echo 'User is not found';
} else {
	$storedPassword = $user['password'];
	if (password_verify($password, $storedPassword)) {
	    session_start();
		session_regenerate_id(true);
		$_SESSION['user_id'] = $user['user_id']; 
			echo 'Login Successful';
			header("Location: index.php");
			exit();
		
	} else {
      echo 'Incorrect username or password';
	  header("Location: userlogin.php");
	  exit();
}
}

?>
