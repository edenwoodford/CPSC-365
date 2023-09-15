<?php
function dbConnect()
{
//global $pdo;


try 

	{ 

	$pdo = new PDO('mysql:host=localhost;dbname=classicmodels', 'cpsc365','password'); 

	$pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

	$pdo -> exec ('SET NAMES "utf8"'); 

	} 

	catch (PDOException $e) 

	{ 

echo $e->getMessage (); 

exit (); 
	return $pdo;
	} 
}
?>