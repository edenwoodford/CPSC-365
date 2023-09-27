<html>  
<head> 
<title> Dashboard </title> 
</head> 
<body>  
<h1> Main Page </h1> 

<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        // User is logged in
        echo '<form action="logout.php" method="POST">';
        echo '<input type="submit" value="Logout">';
        echo '</form>';
    } else {
        // User is not logged in
        echo '<form action="register.php" method="post">';
        echo '<input type="submit" value="Register">';
        echo '</form>';
        echo '<form action="userlogin.php" method="post">';
        echo '<input type="submit" value="Login">';
        echo '</form>';
    }
    ?>
</body>

</html>

