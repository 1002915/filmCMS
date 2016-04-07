<?php 
include('header.php');
include('connection.php');

if (isset($_GET['code'])) {

$confirmation = $_GET['code'];

$id = $_GET['id'];

}

?>

<p>Reset your Password</p>
	<form action="resetlink.php" method="post" >
	    <input type='hidden' name='submitted' id='post_confirmation' value='<?php echo $confirmation?>'/>
	    <input type='hidden' name='post_id' id='post_id' value='<?php echo $id?>'/>
	    <input type='password' name='password' id='password' maxlength="50" placeholder="password"/><br/>
	    <input type='password' name='verify_password' id='verify_password' maxlength="50" placeholder="verify password"/><br/>
	    <input type='submit' name='Submit' value='Submit' />
	</form>

<?php

if (isset($_POST['password'])){ 

$updated_password = $_POST['password'];

$post_id = $_POST['post_id'];

$hashed_password = password_hash($updated_password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password_hash ='$hashed_password' WHERE id='$post_id'";

if ($mysqli->query($sql) === TRUE) {
    echo "Record updated successfully. click <a href='login.php'>here</a> to return to the login screen.";
} else {
    echo "Error updating record: " . $mysqli->error;
}
} else {
	echo 'please update your password';
}
include('footer.php');
?>