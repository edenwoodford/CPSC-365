<html>
 <head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="header">

    <?php
	//file path "C:\Users\edenw\OneDrive\Desktop\UniServerZ\www\images\film&friends.png"
	    $imageName = "film&friends.png";
	    $imagePath = "uploads/" . $imageName;
		echo "<img src='" . $imagePath . "'>";
        echo '<form action="index.php" method="post">';
        echo '<input type="submit" value="Go Home">';
        echo '</form>';
		echo '<form action="searchPage.php" method="get">';
		echo '<input name ="title" type= "text" placeholder= "type here">';
		echo '<input type="submit" value="Search">';
		echo '</form>';
        if(isset($_SESSION['admin'])) {
            echo '<form action="admin.php" method="POST">';
            echo '<input type="submit" value="Admin Page">';
            echo '</form>';
        }

        if (isset($_SESSION['user_id'])) {
            echo '<form action="logout.php" method="POST">';
            echo '<input type="submit" value="Logout">';
            echo '</form>';
			echo '<form action ="profile.php" method = "POST">';
			echo '<input type = "submit" value ="Profile Page">';
			echo '</form>';
        } 
		else {
            echo '<form action="register.php" method="post">';
            echo '<input type="submit" value="Register">';
            echo '</form>';
            echo '<form action="userlogin.php" method="post">';
            echo '<input type="submit" value="Login">';
            echo '</form>';
        }	
    ?>
</div>
