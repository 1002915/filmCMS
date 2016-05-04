<?php 
if(session_id() == '') {
    session_start();
}

include('connection.php');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email']; 
$campus_id = $_POST['campus_id'];

if(isset($_POST['campus_id'])) {

	$_SESSION['campus_id'] = $_POST['campus_id'];
}

$id = $_SESSION['id'];

$sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', campus_id = '$campus_id' WHERE id = '$id'";

$result = mysqli_query($mysqli, $sql);

if ($mysqli->query($sql) === TRUE) {

	$_SESSION['first_name'] = $_POST['first_name'];
	$_SESSION['last_name'] = $_POST['last_name'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['campus_id'] = $_POST['campus_id'];

    header("location:profile.php");

} else {
    echo "Error updating record: " . $mysqli->error;
}

?>