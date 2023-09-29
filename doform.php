<html>
<head><title>Processing Form</title></head>
<body>
<?php
 
REQUIRE 'dbconnect.php';
dbConnect ();
echo 'You entered: '.$_POST['username'].'<br>';
echo 'Password: '.$_POST['password'];
$username = $_POST['username'];
$password = $_POST['password'];
    $checkUser = "SELECT * FROM Users WHERE username = :username";
	$stmt1 = $pdo->prepare($checkUser);
    $stmt1->bindParam(':username', $username);
    $stmt1->execute();
	$row = $stmt1 -> fetch();
if ($row) {
   echo ('<br>'.'This username already exists');
}
else {
//$row = $stmt->fetch(PDO::FETCH_ASSOC); when is this necessary? 
$sql = 'INSERT INTO Users (username, password) VALUES (:username, :password)'; 
$stmt = $pdo->prepare ($sql); 
$username= $_POST['username']; 
$password= $_POST['password']; 
$encryptedPass = password_hash ($password, PASSWORD_BCRYPT);
$stmt->bindParam (':username', $username); 
$stmt->bindParam (':password', $encryptedPass); 
$stmt->execute (); 
echo '<br>'."User Registered";
header("Location: userlogin.php"); 
}
?>
</body>
</html>



