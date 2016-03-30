<?php 
	require "connection.php";

	$function = $_POST['function'];
	$target = $_POST['target'];

	/*
		Available Functions:
			return_all_projects
			return_project
			upddate_project
			new_project
			hide_project
	*/
	
	switch($function){

		case "return_all_projects":
			$sql = "SELECT * FROM film";
			$result = $mysqli->query($sql);

			while ($results = $result->fetch_assoc()) {
				$data = array(
					"id" => $results['id'],
					"title" => $results['title'],
					"synopsis" => $results['synopsis'],
					"video_link" => $results['video_link'],
					"cover_image" => $results['cover_image'],
					"runtime" => $results['runtime'],
					"user_id" => $results['user_id'],
					"published" => $results['published'],
					"active" => $results['active']
				);
			}
		break;

		case "return_project";
			$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active FROM film, users WHERE film.user_id = users.id AND film.id = ?";
			if(!$stmt = $mysqli->prepare ($sql)) {
				echo "prepare failed";
			}
			if(!$stmt->bind_param("i", $target)){
				echo "binding param failed";
			}
			if(!$stmt->execute()){
				echo "execute failied";
			}
			if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active)) {
				echo "binding results failed";
			}
			
			while($stmt->fetch()) {
				$data = array(
					"id" => $id,
					"title" => $title,
					"synopsis" => $synopsis,
					"video_link" => $video_link,
					"cover_image" => $cover_image,
					"runtime" => $runtime,
					"user_id" => $user_id,
					"published" => $published,
					"active" => $active
				);
			}

		break;

		case "update_project";
			$title = $_POST['title'];
			$synopsis = $_POST['synopsis'];
			$video_link = $_POST['video_link'];
			$cover_image = $_POST['cover_image'];
			$runtime = $_POST['runtime'];
			$user_id = $_POST['user_id'];
			$published = $_POST['published'];
			$active = $_POST['active'];

			$sql = "UPDATE film SET title = ?, synopsis = ?, video_link = ?, cover_image = ?, runtime = ?, user_id = ?, published = ?, active = ? WHERE id = ?";
			if(!$stmt = $mysqli->prepare ($sql)) {
				echo "prepare failed";
			}
			if(!$stmt->bind_param("ssssiiii", $title, $synopsis, $video_link, $cover_image, $runtime, $published, $active, $target)){
				echo "binding param failed";
			}
			if(!$stmt->execute()){
				echo "execute failed";
			}
			$stmt->close();



/*
			$sql = "SELECT id, title, synopsis, video_link, cover_image, runtime, published, active FROM film WHERE id = ?";
			if(!$stmt = $mysqli->prepare ($sql)) {
				echo "prepare failed";
			}
			if(!$stmt->bind_param("i", $target)){
				echo "binding param failed";
			}
			if(!$stmt->execute()){
				echo "execute failied";
			}
			if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $published, $active)) {
				echo "binding results failed";
			}
			
			while($stmt->fetch()) {
				$data = array(
					"id" => $id,
					"title" => $title,
					"synopsis" => $synopsis,
					"video_link" => $video_link,
					"cover_image" => $cover_image,
					"runtime" => $runtime,
					"user_id" => $user_id,
					"published" => $published,
					"active" => $active
				);
			}*/
			
		break;

		case "new_project";
			$title = $_POST['title'];
			$synopsis = $_POST['synopsis'];
			$video_link = $_POST['video_link'];
			$cover_image = $_POST['cover_image'];
			$runtime = $_POST['runtime'];
			$user_id = $_POST['user_id'];
			$published = $_POST['published'];
			$active = $_POST['active'];

			$sql  = "INSERT INTO film (title, synopsis, video_link, cover_image, runtime, user_id, published, active) VALUES (?,?,?,?,?,?,?,?)";
			if(!$stmt = $mysqli->prepare ($sql)) {
				echo "prepare failed";
			}
			if(!$stmt->bind_param("ssssiiii", $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active)){
				echo "binding param failed";
			}
			if(!$stmt->execute()){
				echo "execute failed";
			}
			$stmt->close();

			break;

		case "hide_project";
			$active = $_POST['active'];
			$sql = "UPDATE film SET active = ? WHERE id = ?";
			if(!$stmt = $mysqli->prepare($sql)) {
				echo "prepare failed";
			}
			if(!$stmt->bind_param("ii", $active, $target)){
				echo "binding param failed";
			}
			if(!$stmt->execute()){
				echo "execute failed";
			}
			$stmt->close();
			break;
	}	
	
?>