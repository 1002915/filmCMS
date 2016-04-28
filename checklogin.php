<?php
session_start();

include('connection.php');

$email = $_POST['email']; 

$password = $_POST['password_hash']; 

$sql = "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($mysqli, $sql);

$row = mysqli_fetch_row($result);

// The following variables grab users details so we can set them to a $_SESSION to be call on later.
$id = $row[0];
$campus_id = $row[1];
$first_name = $row[2];
$last_name = $row[3];
$user_type = $row[4];
$email = $row[5];
$databasekey = $row[6];


if (password_verify($password, $databasekey)) {
    
	$_SESSION['id'] = $id;
	$_SESSION['campus_id'] = $campus_id;
	$_SESSION['first_name'] = $first_name;
	$_SESSION['last_name'] = $last_name;
	$_SESSION['user_type'] = $user_type;
	$_SESSION['email'] = $email;
	$_SESSION['databasekey'] = $databasekey;

    header('Location: index.php');
    

} else {
	$_SESSION['errors'] = array("Your username or password was incorrect.");
	//header('Location: login.php');
    //echo 'Invalid password for ' . $email . ' Please try again. <a href="login.php">BACK</a>';
	
}

?>