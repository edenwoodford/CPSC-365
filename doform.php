<html>
<head><title>Processing Form</title></head>
<body>
<?php
require 'dbconnect.php';
dbConnect ();

$username = $_POST['username'];
$password = $_POST['password'];

if (strlen($username) <= 5) {
    echo 'Username must be greater than 5 characters.';
} elseif (strlen($password) <= 7) {
    echo 'Password must be greater than 8 characters.';
} else {
    $checkUser = "SELECT * FROM Users WHERE username = :username";
    $stmt1 = $pdo->prepare($checkUser);
    $stmt1->bindParam(':username', $username);
    $stmt1->execute();
    $row = $stmt1->fetch();

    if ($row) {
        echo '<br>'.'This username already exists';
    } else {
        $sql = 'INSERT INTO Users (username, password) VALUES (:username, :password)';
        $stmt = $pdo->prepare($sql);
        $encryptedPass = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $encryptedPass);
        $stmt->execute();
        echo '<br>'."User Registered";
        header("Location: userlogin.php");
    }
}
?>
</body>
</html>
