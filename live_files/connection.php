<?php

$dbhost = "localhost";
$dbusername = "docoloco_loco";
$dbpassword = "cR2uKcXVNtbQ";
$dbname = "docoloco_c9";

$mysqli = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($mysqli->connect_error){
	die("Connection failed: " . $mysqli->connect_error);
}

?>