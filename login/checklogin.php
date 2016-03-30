<?php
include('connection.php');

// username and password sent from form 
$email=$_POST['email']; 
$password=$_POST['password_hash']; 

// To protect MySQL injection (more detail about MySQL injection)
$email = stripslashes($email);
$password = stripslashes($password);
$email = mysqli_real_escape_string($mysqli, $email);
$password = mysqli_real_escape_string($mysqli, $password);
$sql="SELECT * FROM users WHERE email='$email' and password_hash='$password'";
$result=mysqli_query($mysqli, $sql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['email']= "email";
$_SESSION['password_hash']= "password_hash";

header("location:login_success.php");
}
else {
echo "Wrong Username or Password";
}
?>

// Query the database for username and password
// ...

if(password_verify($password, $hashed_password)) {
    // If the password inputs matched the hashed password in the database
    // Do something, you know... log them in.
} 

// Else, Redirect them back to the login page.