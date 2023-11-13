//deleteComment.php
<?php
REQUIRE 'dbconnect.php';
dbConnect();
$findComment ='SELECT * FROM Movies WHERE title =:title';
$stmt= $pdo-> prepare($findComment);
$stmt->bindParam('username', :username);
$stmt->execute();
if 
//i will do this later

?>