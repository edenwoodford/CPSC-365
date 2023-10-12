<?php
session_start();
require ('header.php');
?>
<html>  
<head> 
<title> Dashboard </title> 
</head> 
<h1> Film & Friends </h1> 
<style>
body {
	background-color: paleturquoise;
}
</style>
<?php
	if(isset($_SESSION['admin']) && $_SESSION['admin']) {
		//user is an admin
	echo '<form action= "admin.php" method= "POST">';
	echo '<input type= "submit" value="Go to Admin Page">';
	echo '</form>';
	}
    if (isset($_SESSION['user_id'])) {
        //User is logged in
        echo '<form action="logout.php" method="POST">';
        echo '<input type="submit" value="Logout">';
        echo '</form>';
    } else {
        //User is not logged in
        echo '<form action="register.php" method="post">';
        echo '<input type="submit" value="Register">';
        echo '</form>';
        echo '<form action="userlogin.php" method="post">';
        echo '<input type="submit" value="Login">';
        echo '</form>';
    }
	require ('footer.php');
    ?>
</html>

