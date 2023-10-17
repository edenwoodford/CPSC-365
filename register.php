<html
<head>
  <title>User Authentication</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div>
<h1>User Registration</h1>
<form action="doform.php" method="POST">
		  <input type="hidden" name="hiddenvalue" value="foo">
Username: <input type="text" name="username"><br>
Password: <input type="password" name= "password"> <br> 
		  <input type="submit" value="Submit">
</form>
<br>
Already have an account? 
<br>
<form action="userlogin.php" method="post">
	<input type="submit" value="Login">
</form>
<form action="index.php" method="post">
	<input type="submit" value="Continue as Guest">
	</form>
	<form action="pictures.php" method="post">
	<input type="submit" value="Practice pictures">
</form>
</div>
</body>
</html>
