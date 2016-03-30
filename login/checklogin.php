<?php
session_start();
include('connection.php');


$email = $_POST['email']; 

$password = $_POST['password_hash']; 

echo $email;

echo $password;

$sql = "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($mysqli, $sql);

$row = mysqli_fetch_row($result);

$databasekey = $row[6];

echo $databasekey . '<BR>';

echo $row[5];


if (password_verify($password, $databasekey)) {
    
    echo 'Password is valid! setting session...done.';

    $_SESSION['email'] = $_POST['email'];
        
    $_SESSION['password_hash'] = $_POST['password_hash'];

    header('Location: login.php');

} else {
    echo 'Invalid password.';
}

?>