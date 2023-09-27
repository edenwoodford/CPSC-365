<html>  
<head> 
<title> Dashboard </title> 
</head> 
<body>  
<h1> Main Page </h1> 
<form action="logout.php" method="POST">
<input type="submit" value="Logout">
</form>
<?php
	session_start();
	if (isset($_SESSION['user_id']))
	{
	//user is logged in
	}
	else{
	//user is not logged in
	}

?>
</body>
</html>

