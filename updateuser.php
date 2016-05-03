<?php
include('header.php');

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
    echo "Record updated successfully. click <a href='index.php'>here</a> to return to the home screen.";
} else {
    echo "Error updating record: " . $mysqli->error;
}

include('footer.php');