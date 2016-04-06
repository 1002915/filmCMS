<?php
session_start();

include('connection.php');

$email = $_POST['email']; 

$password = $_POST['password_hash']; 

$sql = "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($mysqli, $sql);

$row = mysqli_fetch_row($result);

$databasekey = $row[6];


if (password_verify($password, $databasekey)) {
    
    $_SESSION['email'] = $_POST['email'];
        
    $_SESSION['password_hash'] = $_POST['password_hash'];

    header('Location: index.php');

} else {
	$_SESSION['errors'] = array("Your username or password was incorrect.");
	header('Location: login.php');
    //echo 'Invalid password for ' . $email . ' Please try again. <a href="login.php">BACK</a>';
	
}

?>