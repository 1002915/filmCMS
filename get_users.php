<?php

	include('connection.php');

	// IF ONE WAS TO SEARCH FOR THE NAME OF A PARTICULAR FILM TITLE
	if(isset($_POST['search']) && $_POST['search']){
	$sql = "SELECT * FROM film WHERE title LIKE '%".$_POST['search']."%'";

	/* Prepare statement */
		$stmt = $mysqli->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
		}
		   
	/* Execute statement */
		$stmt->execute();
	
	while($data = $stmt -> fetch()){?>
		<div>
			<img scr="<?php echo $data['cover_image']; ?>" alt='coverImg' class='coverImage'><br>
			<span><?php echo $data['title']; ?></span><br>
			<span class='runTime'><?php echo $data['runtime']; ?></span><br>
			<span><?php echo $data['synopsis']; ?></span><br>
		</div>

	<?php 
	}
}else {
	echo "type in film title";
}