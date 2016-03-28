<?php

$dbhost = "localhost";
$dbusername = "mattyjneal";
$dbpassword = "";
$dbname = "c9";

$mysqli = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($mysqli->connect_error){
	die("Connection failed: " . $mysqli->connect_error);
}

?>