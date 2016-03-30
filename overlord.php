<?php 
	require "connection.php";

	if(!empty($_POST['function'])) {

			$function = $_POST['function'];
			$errormsg = "";

			/*
				Available Functions:
					return_all_projects
					return_project
					search_project
					upddate_project
					new_project
					hide_project
					add_rating
					add_academic_feedback
			*/
			
			switch($function){

				case "return_all_projects":
					$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, AVG(rating) AS average_rating, first_name, last_name, location FROM film, rating, users, campus WHERE film.id = rating.film_id AND film.user_id = users.id AND users.campus_id = campus.id";

					if(!$stmt = $mysqli->prepare ($sql)){
						echo "prepare failed";
					}
					if(!$stmt->execute()){
						echo "execute failed";
					}
					
					if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $average_rating, $first_name, $last_name, $location)) {
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
							"active" => $active,
							"average_rating" => $average_rating,
							"first_name" => $first_name,
							"last_name" => $last_name,
							"campus" => $location
						);
					}

				break; // end return all projects





				case "return_project":
					if(!isset($_POST['target'])){
						$errormsg = "No film has been selected";
					} else {
						$target = $_POST['target'];

						$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, AVG(rating) AS average_rating, first_name, last_name, location FROM film, rating, users, campus WHERE film.id = rating.film_id AND film.user_id = users.id AND users.campus_id = campus.id AND film.id = ?";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("i", $target)){
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failied";
						}
						if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $average_rating, $first_name, $last_name, $location)) {
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
								"active" => $active,
								"average_rating" => $average_rating,
								"first_name" => $first_name,
								"last_name" => $last_name,
								"campus" => $location
							);
						} // end while

						$stmt->close();

					} // end if target is set

				break; // end return single project




				case "search_project":
					if(!isset($_POST['target'])){
						$errormsg = "You haven't searched for anything";
					} else {
						$target = $_POST['target'];
						$searchstring = "%".$target."%";
						$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, AVG(rating) AS average_rating, first_name, last_name, location FROM film, rating, users, campus WHERE film.id = rating.film_id AND film.user_id = users.id AND users.campus_id = campus.id AND title LIKE ? OR synopsis LIKE ? OR first_name LIKE ? OR last_name LIKE ?";
						if(!$stmt = $mysqli->prepare($sql)){
							echo "prepare failed";
						}
						if(!$stmt->bind_param('ssss', $searchstring, $searchstring, $searchstring, $searchstring)) {
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $average_rating, $first_name, $last_name, $location)) {
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
								"active" => $active,
								"average_rating" => $average_rating,
								"first_name" => $first_name,
								"last_name" => $last_name,
								"campus" => $location
							);
						} // end while

						$stmt->close();

					} // end if target isset

				break; //end search project





				case "update_project":

					if(!isset($_POST['target'], $_POST['title'], $_POST['synopsis'], $_POST['video_link'], $_POST['cover_image'], $_POST['runtime'], $_POST['user_id'], $_POST['published'], $_POST['active'])){
						$errormsg = "Project was unable to be created. Please make sure you have filled in every field.";
					} else {
						$target = $_POST['target'];
						$title = $_POST['title'];
						$synopsis = $_POST['synopsis'];
						$video_link = $_POST['video_link'];
						$cover_image = $_POST['cover_image'];
						$runtime = $_POST['runtime'];
						$user_id = $_POST['user_id'];
						$published = $_POST['published'];
						$active = $_POST['active'];

						$sql = "UPDATE film SET title = ?, synopsis = ?, video_link = ?, cover_image = ?, runtime = ?, published = ?, active = ? WHERE film.user_id = users.id AND film.id = ?";
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

					} //end if isset all post variables
					
				break; // end update project





				case "new_project":
					if(!isset($_POST['title'], $_POST['synopsis'], $_POST['video_link'], $_POST['cover_image'], $_POST['runtime'], $_POST['user_id'], $_POST['published'], $_POST['active'])){
						$errormsg = "Project was unable to be created. Please make sure you have filled in every field.";
					} else {
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


						// Insert collaborators

						// FIX EVERYTHING HERE!!!
						$sql = "SELECT id FROM film WHERE ?????????"

						$colab = $_POST['collab'];
						$sql = "INSERT INTO collaborators (film_id, first_name, last_name, role, email) VALUES";
						$format = " ('%d', '%s', '%s', '%s', '%s'),";

						foreach($colab as $row) {
						    $sql .= sprintf($format, $target, $row[0], $row[1], $row[2], $row[3]);
						}
						$sql = rtrim($sql, ',');

						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						$stmt->close();

					} //end if isset all post variables

				break; // end new project











				case "hide_project":
					if(!isset($_POST['target'])){
						$errormsg = "Please select whether the project is active or not";
					} else {
						$target = $_POST['target'];
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

					} // end if target is set

				break; // end hide project




				case "add_rating":
					if(!isset($_POST['target'], $_POST['rating'], $_POST['ip'])){
						$errormsg = "Please select whether the project is active or not";
					} else {
						$target = $_POST['target'];
						$rating = $_POST['rating'];
						$ip = $_POST['ip'];

						$sql = "INSERT INTO rating (rating, IP, film_id) VALUES (?,?,?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("isi", $rating, $ip, $target)) {
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						if(!$stmt->bind_result($rating, $ip, $film_id)){
							echo "binding result failed";
						}
						$stmt->close();

					} // end of if target is set

				break;//end add rating




				case "add_academic_feedback":
					if(!isset($_POST['target'], $_POST['user_id'])){
						$errormsg = "Please select whether the project is active or not";
					} else {
						$target = $_POST['target'];
						$user_id = $_POST['user_id'];
						$q1 = $_POST['q1'];
						$q2 = $_POST['q2'];
						$q3 = $_POST['q3'];

						$sql = "INSERT INTO academic (user_id, film_id) VALUES (?,?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("ii", $user_id, $target)) {
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						if(!$stmt->bind_result($user_id, $film_id)){
							echo "binding result failed";
						}
						$stmt->close();

					} // end if target is set
				
				break; // end add academic feedback

			} // end switch

	} //end if function not empty
	
?>