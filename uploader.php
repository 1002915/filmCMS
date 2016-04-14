<?php 

$ds = DIRECTORY_SEPARATOR;

$id = $_SESSION['id'];

$user_directory = 'uploads/'.$id;

if (isset($_FILES['file']['name'])) { 
	$image_name = $_FILES['file']['name'];}

if (!file_exists($user_directory)) {

    mkdir($user_directory, 0777, true);
}
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];
      
    $targetPath = dirname( __FILE__ ) . $ds. $user_directory . $ds;
     
    $targetFile =  $targetPath. $_FILES['file']['name'];
 
    move_uploaded_file($tempFile,$targetFile);

if (isset($_FILES['file']['name'])) {
   $upload_file_path = 'uploads/'.$id.'/'.$_FILES['file']['name'];
      json_encode($upload_file_path);
}}

?>