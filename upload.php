<?php
session_start();

include('connection.php');

$ds = DIRECTORY_SEPARATOR;

$id = $_SESSION['id'];

$user_directory = 'uploads/'.$id;

$image_name = $_FILES['file']['name'];

/*$sql = "UPDATE film SET cover_image = '$image_name' WHERE id = '$id'";

$result = mysqli_query($mysqli, $sql);

if ($mysqli->query($sql) === TRUE) {

    echo "Record updated successfully. click <a href='index.php'>here</a> to return to the home screen.";

} else {

    echo "Error updating record: " . $mysqli->error;
} */

if (!file_exists($user_directory)) {

    mkdir($user_directory, 0777, true);
}
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];
      
    $targetPath = dirname( __FILE__ ) . $ds. $user_directory . $ds;
     
    $targetFile =  $targetPath. $_FILES['file']['name'];
 
    move_uploaded_file($tempFile,$targetFile);

   $_SESSION['user_photo'] = 'uploads/'.$id.'/'.$_FILES['file']['name'];
     
}
?>
