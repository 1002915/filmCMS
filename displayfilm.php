<?php 

	if(isset($_POST['user_id'])){
		$userid = $_POST['user_id'];

		require('overlord.php');
	} else {
		header('location: newfilm.php');
	}


	include('header.php');
?>

<script>


</script>

<div id="displayvideo"></div>