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
					return_academic_feedback
					save_film_history
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
					$data = array();

					while($stmt->fetch()) {
						$data[] = array(
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
						$target = $_POST['target']; // film id

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
						$data = array();
						
						while($stmt->fetch()) {
							$data[] = array(
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
						$target = $_POST['target']; // any search term entered
						$searchstring = "%".$target."%";
						$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, AVG(rating) AS average_rating, users.first_name, users.last_name, location, collaborators.first_name, collaborators.last_name, role FROM film, rating, users, campus, collaborators WHERE film.id = rating.film_id AND film.user_id = users.id AND users.campus_id = campus.id AND collaborators.film_id=film.id AND title LIKE ? OR synopsis LIKE ? OR first_name LIKE ? OR last_name LIKE ?";
						if(!$stmt = $mysqli->prepare($sql)){
							echo "prepare failed";
						}
						if(!$stmt->bind_param('ssss', $searchstring, $searchstring, $searchstring, $searchstring)) {
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $average_rating, $first_name, $last_name, $location, $collab_first_name, $collab_last_name, $role)) {
							echo "binding results failed";
						}
						$data = array();
						
						while($stmt->fetch()) {
							$data[] = array(
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
								"campus" => $location,
								"collab_first_name" => $collab_first_name,
								"collab_last_name" => $collab_last_name,
								"role" => $role
							);
						} // end while

						$stmt->close();

					} // end if target isset

				break; //end search project





				case "update_project":

					if(!isset($_POST['target'], $_POST['title'], $_POST['synopsis'], $_POST['video_link'], $_POST['cover_image'], $_POST['runtime'], $_POST['published'], $_POST['active'])){
						$errormsg = "Project was unable to be created. Please make sure you have filled in every field.";
					} else {
						$target = $_POST['target']; //film id
						$title = $_POST['title'];
						$synopsis = $_POST['synopsis'];
						$video_link = $_POST['video_link'];
						$cover_image = $_POST['cover_image'];
						$runtime = $_POST['runtime'];
						//$user_id = $_POST['user_id'];
						$published = $_POST['published'];
						$active = $_POST['active'];

						$sql = "UPDATE film SET title = ?, synopsis = ?, video_link = ?, cover_image = ?, runtime = ?, published = ?, active = ? WHERE film.id = ?";
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



						// collaborator mess

						$collab = $_POST['collab'];

						// loop through collaborators currently listed for that film
						
						$sql = "SELECT id, first_name, last_name, role, email FROM collaborators WHERE film_id = ?";
						if(!$stmt = $mysqli->prepare ($sql)){
							echo "prepare failed";
						}
						if(!$stmt->bind_param("i", $target)){
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}

						$res = $stmt->get_result();
						
						// loop through sql response
						while($row = $res->fetch_assoc()){
							$found = 0;

							//loop through collabs input in form
							foreach($collab as $k => $collabrow){
								$rowcompare = array_slice($row, 1);

								// if current collab loop matches sql response
								if($collabrow == $rowcompare){
									$found = 1;
									unset($collab[$k]);
								} else {
									//add to delete array -> value should be the id
									$delete = array(
										"id" => $row['id']
									);
								} // end else 
								
							} // end foreach

 						} // end while

 						if($delete > 0){
 							foreach($delete as $rowtodelete) {
 								$sql = "DELETE FROM collaborators WHERE id = ?";
 								$stmt = $mysqli->prepare($sql);
 								$stmt->bind_param("i", $rowtodelete);
 								$stmt->execute();
 								$stmt->close();
 							}
 						}
 						
 						if($collab > 0){
 							foreach($collab as $collabtoadd){
 								$film_id = $target;
 								$first_name = $collabtoadd['first_name'];
 								$last_name = $collabtoadd['last_name'];
 								$role = $collabtoadd['role'];
 								$email = $collabtoadd['email'];

 								$sql = "INSERT INTO collaborators(film_id, first_name, last_name, role, email) VALUES (?,?,?,?,?)";
 								if(!$stmt = $mysqli->prepare ($sql)) {
									echo "prepare failed";
								}
								if(!$stmt->bind_param("issss", $film_id, $first_name, $last_name, $role, $email)){
									echo "binding param failed";
								}
								if(!$stmt->execute()){
									echo "execute failed";
								}
								$stmt->close();

 							} // end foreach

 						} // end if collabs to add

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


						// Insert film details
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

						$target = $mysqli->insert_id; // film id

						$stmt->close();

						// Insert collaborators

						$collab = $_POST['collab'];

						foreach($collab as $value=>$data) {
						     $collab_fn = $data['firstname'];
						     $collab_ln = $data['lastname'];
						     $collab_role = $data['role'];
						     $collab_email = $data['email'];

						     $sql = "INSERT INTO collaborators (film_id, first_name, last_name, role, email) VALUES (?,?,?,?,?)";
						     if(!$stmt = $mysqli->prepare ($sql)){
						     	echo "prepare failed";
						     }
						     if(!$stmt->bind_param("issss", $target, $collab_fn, $collab_ln, $collab_role, $collab_email)){
						     	echo "binding param failed";
						     }
						     if(!$stmt->execute()){
						     	echo "execute failed";
						     }
						     $stmt->close();
						}

					} //end if isset all post variables

				break; // end new project











				case "hide_project":
					if(!isset($_POST['target'])){
						$errormsg = "Please select whether the project is active or not";
					} else {
						$target = $_POST['target']; // film id
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
						$target = $_POST['target']; // film id
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
						$target = $_POST['target']; // film id
						$user_id = $_POST['user_id'];
						$feedback_1 = $_POST['feedback_1'];
						$feedback_2 = $_POST['feedback_2'];
						$feedback_3 = $_POST['feedback_3'];

						$sql = "INSERT INTO academic (film_id, user_id, feedback_1, feedback_2, feedback_3) VALUES (?,?,?,?,?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("iisss", $target, $user_id, $feedback_1, $feedback_2, $feedback_3)) {
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						if(!$stmt->bind_result($film_id, $user_id, $feedback_1, $feedback_2, $feedback_3)){
							echo "binding result failed";
						}
						$stmt->close();

					} // end if target is set
				
				break; // end add academic feedback




				case "return_academic_feedback":
					$target = $_POST['target']; // campus id based on teacher making request
					$sql = "SELECT campus.location, users.first_name, users.last_name, academic.feedback_1, academic.feedback_2, academic.feedback_3 FROM 
					((academic INNER JOIN film ON academic.film_id = film.id) INNER JOIN users ON film.user_id = users.id) INNER JOIN campus ON users.campus_id = campus.id WHERE campus.id=?";
							
					if(!$stmt = $mysqli->prepare ($sql)) {
						echo "prepare failed";
					}
					if(!$stmt->bind_param("i", $target)) {
						echo "binding param failed";
					}
					if(!$stmt->execute()){
						echo "execute failed";
					}
					if(!$stmt->bind_result($location, $first_name, $last_name, $feedback_1, $feedback_2, $feedback_3)){
						echo "binding result failed";
					}
					$res = $stmt->get_result();
					$rows = $res->fetch_all();
					$stmt->close();
					

					// output array as csv file
					$output = fopen("php://output", 'w') or die("Could not open php://output");
					header("Content-Type:application/csv");
					header("Content-Disposition:attachment;filename=studentfeedback.csv");
					fputcsv($output, array('Location','First name','Last name','Feedback 1','Feedback 2','Feedback 3'));
					foreach($rows as $row){
						fputcsv($output, $row);
					}
					fclose($output) or die("Could not close php://output");
					die();
					
				break; // end return academic feedback




				case "save_film_history":
					$target = $_POST['target'] //film id

				break;





				$data = json_encode($data);
				echo $data;

			} // end switch

	} //end if function not empty

	
?>