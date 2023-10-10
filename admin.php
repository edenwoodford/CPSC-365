<?php
session_start();
REQUIRE 'dbconnect.php';
dbConnect();
require ('header.php');
if (!isset($_SESSION['admin'])) {
    header("Location: index.php"); 
	//not an admin, take to home
    exit();
//UPDATE Users SET admin = true WHERE username = 'whatever username';
//this is how to manually change a users admins status
}
?>
<html>  
<head> 
<title> Dashboard </title> 
</head> 
<h1> Administrator Page</h1> 
<style>
body {
	background-color: paleturquoise;
}
</style>
Add a new movie here! <br>
Note: all fields are required except actor names and extra genres <br> <br> 
<form action="doadmin.php" method= "POST">
<label for="title">Movie Title:<br></label>
<input type="text" name="title" required><br>    
<label for="description">Description:<br></label>
<textarea name="description" required></textarea><br>        
<label for="year">Release Year:<br></label>
<input type="text" name="year" required><br>
<label for="genre1">Genre 1:<br></label>
<select name="genre1" required>
    <option value="N/A">N/A</option>
    <option value="Action">Action</option>
    <option value="Comedy">Comedy</option>
    <option value="Drama">Drama</option>
    <option value="Romance">Romance</option>
    <option value="True Crime">True Crime</option>
    <option value="True Crime">Sitcom</option>
    <option value="Sci-Fi">Sci-Fi</option>
    <option value="Horror">Horror</option>
	<option value="Mystery">Mystery</option>
	<option value="Western">Western</option>
	<option value="Documentary">Documentary</option>
</select><br>
<label for="genre2">Genre 2:<br></label>
<select name="genre2" required>
    <option value="N/A">N/A</option>
    <option value="Action">Action</option>
    <option value="Comedy">Comedy</option>
    <option value="Drama">Drama</option>
    <option value="Romance">Romance</option>
    <option value="True Crime">True Crime</option>
    <option value="True Crime">Sitcom</option>
    <option value="Sci-Fi">Sci-Fi</option>
    <option value="Horror">Horror</option>
	<option value="Mystery">Mystery</option>
	<option value="Western">Western</option>
	<option value="Documentary">Documentary</option>
</select><br>
<label for="genre3">Genre 3:<br></label>
<select name="genre3" required>
    <option value="N/A">N/A</option>
    <option value="Action">Action</option>
    <option value="Comedy">Comedy</option>
    <option value="Drama">Drama</option>
    <option value="Romance">Romance</option>
    <option value="True Crime">True Crime</option>
    <option value="True Crime">Sitcom</option>
    <option value="Sci-Fi">Sci-Fi</option>
    <option value="Horror">Horror</option>
	<option value="Mystery">Mystery</option>
	<option value="Western">Western</option>
	<option value="Documentary">Documentary</option>
</select><br>
<label for="director">Director:<br></label>
<input type="text" name="director" required><br>        
<label for="actor1">Actor 1:</label>
<input type="text" name="actor1"><br>        
<label for="actor2">Actor 2:</label>
<input type="text" name="actor2"><br>       
<label for="actor3">Actor 3:</label>
<input type="text" name="actor3"><br>        
<input type="submit" value= "Add Movie"> <br> 
</form>
</body>
</html>





