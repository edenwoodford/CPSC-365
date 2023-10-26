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
<title> Administrator Page</title> 
</head> 
<h1> Administrator Page</h1> 
Add a new movie here! <br>
Note: all fields are required except actor names and extra genres <br> <br> 
<form action="doadmin.php" method= "POST" enctype="multipart/form-data">
<label for="title">Movie Title:<br></label>
<input type="text" name="title" required><br>    
<label for="description">Description:<br></label>
<textarea name="description" required></textarea><br>        
<label for="year">Release Year:<br></label>
<input type="text" name="year" required><br>
 <br> Movie Poster: <br>
<input type="file" name="upload" accept= ".jpg">
<label for="genre1"><br>Genre 1:<br></label>
<select name="genre1" >
  <option disabled selected value> -- select an option -- </option>
  <option value="1">Action</option>
  <option value="2">Comedy</option>
  <option value="3">Drama</option>
  <option value="4">Romance</option>
  <option value="5">True Crime</option>
  <option value="6">Sitcom</option>
  <option value="7">Sci-Fi</option>
  <option value="8">Horror</option>
  <option value="9">Mystery</option>
  <option value="10">Western</option>
  <option value="11">Documentary</option>
  <option value="12">Animation</option>
  <option value="13">Fantasy</option>
  <option value="14">Historical</option>
  <option value="15">Musical</option>
  <option value="16">War</option>
  <option value="17">Adventure</option>
  <option value="18">Family</option>
</select><br>
<label for="genre2"><br>Genre 2:<br></label>
<select name="genre2">
  <option disabled selected value> -- select an option -- </option>
  <option value="1">Action</option>
  <option value="2">Comedy</option>
  <option value="3">Drama</option>
  <option value="4">Romance</option>
  <option value="5">True Crime</option>
  <option value="6">Sitcom</option>
  <option value="7">Sci-Fi</option>
  <option value="8">Horror</option>
  <option value="9">Mystery</option>
  <option value="10">Western</option>
  <option value="11">Documentary</option>
  <option value="12">Animation</option>
  <option value="13">Fantasy</option>
  <option value="14">Historical</option>
  <option value="15">Musical</option>
  <option value="16">War</option>
  <option value="17">Adventure</option>
  <option value="18">Family</option>
</select><br>
<label for="genre3"><br>Genre 3:<br></label>
<select name="genre3" >
  <option disabled selected value> -- select an option -- </option>
  <option value="1">Action</option>
  <option value="2">Comedy</option>
  <option value="3">Drama</option>
  <option value="4">Romance</option>
  <option value="5">True Crime</option>
  <option value="6">Sitcom</option>
  <option value="7">Sci-Fi</option>
  <option value="8">Horror</option>
  <option value="9">Mystery</option>
  <option value="10">Western</option>
  <option value="11">Documentary</option>
  <option value="12">Animation</option>
  <option value="13">Fantasy</option>
  <option value="14">Historical</option>
  <option value="15">Musical</option>
  <option value="16">War</option>
  <option value="17">Adventure</option>
  <option value="18">Family</option>
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





