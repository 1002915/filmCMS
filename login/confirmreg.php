<?php
session_start();

include('../connection.php');

$getemailconfirm = $_GET['code'];

$idconfirm = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = '$idconfirm'";

$result = mysqli_query($mysqli, $sql);

$row = mysqli_fetch_row($result);

$databasekey = $row[8];



if ($databasekey == $getemailconfirm) {

	$verifiedupdate = "UPDATE users SET verified='1' WHERE id = '$idconfirm'";

if ($mysqli->query($verifiedupdate) === TRUE) {
	echo "updated! Thank you for registering. click <a href='login.php'>HERE</a> to login.";
}


} else {

	echo 'nah';
}




?>