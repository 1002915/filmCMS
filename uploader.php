<?php 

require_once('ImageManipulator.php');

$id = $_SESSION['id'];

$user_directory = 'uploads/'.$id;
// If the file is sent, create a directory with the users' ID. //
if (isset($_FILES['file']['name'])) { 

	$image_name = $_FILES['file']['name'];

    $image_name = str_replace(' ', '_', $image_name);
}

if (!file_exists($user_directory)) { 

    mkdir($user_directory, 0777, true);
}
// If a file is sent, check that it's an image. //
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];

    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');

    $fileExtension = strrchr($_FILES['file']['name'], ".");

    if (in_array($fileExtension, $validExtensions)) {
// Call the ImageManipulator and set height/width to 960*540px. //    	
        $manipulator = new ImageManipulator($_FILES['file']['tmp_name']);

        $newImage = $manipulator->resample(960, 540);
// Save the edited image to the users' folder. //
        $manipulator->save('uploads/' . $id . '/' . $image_name . $_FILES['fileToUpload']['name']);

    }   

}

?>