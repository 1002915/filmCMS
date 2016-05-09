<?php 
	require "connection.php";

	if(!empty($_POST['function'])) {

			$function = $_POST['function'];
			$errormsg = "";

			/*
				Available Functions:
					return_all_projects
					return_project
					return_user_project
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
					$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, location FROM film, campus, users WHERE film.user_id = users.id AND users.campus_id = campus.id AND published = 1 AND active = 1";

					if(!$stmt = $mysqli->prepare ($sql)){
						echo "prepare failed";
					}
					if(!$stmt->execute()){
						echo "execute failed";
					}
					$stmt->store_result();
					if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $location)) {
						echo "binding results failed";
					}
					
					$data = array();

					while($stmt->fetch()) {

						$sql = "SELECT AVG(rating) AS average_rating FROM rating WHERE film_id = ?";

						if(!$stmt2 = $mysqli->prepare ($sql)){
							echo "prepare failed";
						}
						if(!$stmt2->bind_param("i", $id)){
							echo "bind param failed";
						}
						if(!$stmt2->execute()){
							echo "execute failed";
						}
						$stmt2->store_result();
						if(!$stmt2->bind_result($average_rating)) {
							echo "binding results failed";
						}

						while($stmt2->fetch()) {
							$rating = $average_rating;
						}

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
							"campus" => $location,
							"average_rating" => $rating
						);
					}

				break; // end return all projects




				case "return_project":
					if(!isset($_POST['target'])){
						$errormsg = "No film has been selected";
					} else {
						$target = $_POST['target']; // film id

						$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, location FROM film, users, campus WHERE film.user_id = users.id AND users.campus_id = campus.id AND film.id = ? AND film.published = 1";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("i", $target)){
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failied";
						}
						$stmt->store_result();
						if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $location)) {
							echo "binding results failed";
						}
						$data = array();
						
						while($stmt->fetch()) {

							$sql = "SELECT collaborators.first_name, collaborators.last_name, collaborators.role, collaborators.email FROM collaborators WHERE collaborators.film_id = ?";
							if(!$stmt2 = $mysqli->prepare ($sql)) { 
								echo "stmt2 prepare failed";
							}
							if(!$stmt2->bind_param("i", $id)){
								echo "stmt2 binding param failed";
							}
							if(!$stmt2->execute()){
								echo "stmt2 execute failied";
							}
							$stmt2->store_result();
							if(!$stmt2->bind_result($first_name, $last_name, $role, $email)) {
								echo "stmt2 binding results failed";
							}

							$collab = array();

							while($stmt2->fetch()){
								$collab[] = array(
									"first_name" => $first_name,
									"last_name" => $last_name,
									"role" => $role,
									"email" => $email
								);
							}

							$stmt2->close();

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
								"campus" => $location,
								"collab" => $collab
							);
						} // end while

						$stmt->close();

					} // end if target is set

				break; // end return single project




				case "return_edit_project":
					if(!isset($_POST['target'])){
						$errormsg = "No film has been selected";
					} else {
						$target = $_POST['target']; // film id

						$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, location FROM film, users, campus WHERE film.user_id = users.id AND users.campus_id = campus.id AND film.id = ?";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("i", $target)){
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failied";
						}
						$stmt->store_result();
						if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $location)) {
							echo "binding results failed";
						}
						$data = array();
						
						while($stmt->fetch()) {

							$sql = "SELECT collaborators.first_name, collaborators.last_name, collaborators.role, collaborators.email FROM collaborators WHERE collaborators.film_id = ?";
							if(!$stmt2 = $mysqli->prepare ($sql)) { 
								echo "stmt2 prepare failed";
							}
							if(!$stmt2->bind_param("i", $id)){
								echo "stmt2 binding param failed";
							}
							if(!$stmt2->execute()){
								echo "stmt2 execute failied";
							}
							$stmt2->store_result();
							if(!$stmt2->bind_result($first_name, $last_name, $role, $email)) {
								echo "stmt2 binding results failed";
							}

							$collab = array();

							while($stmt2->fetch()){
								$collab[] = array(
									"first_name" => $first_name,
									"last_name" => $last_name,
									"role" => $role,
									"email" => $email
								);
							}

							$stmt2->close();

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
								"campus" => $location,
								"collab" => $collab
							);
						} // end while

						$stmt->close();

					} // end if target is set

				break; // end return single project




				case "return_user_project":
					if(!isset($_POST['target'])){
						$errormsg = "No user has been selected";
					} else {
						$target = $_POST['target']; // user id

						$sql = "SELECT film.id, title, synopsis, video_link, cover_image, runtime, user_id, published, active, location FROM film, users, campus WHERE film.user_id = users.id AND users.campus_id = campus.id AND users.id = ? AND active = 1";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("i", $target)){
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failied";
						}
						$stmt->store_result();
						if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active, $location)) {
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
						$campus = $_POST['campus'];
						if ($campus != "all") {
							$campus = ' AND campus.id = "'.$campus.'"';
						} else {
							$campus = '';
						}
						if ($target != '') {
							$searchstring = "%".$target."%";
						} else {
							$searchstring = '%';
						}
						$sql = "SELECT DISTINCT film.id, film.title, film.synopsis, film.video_link, film.cover_image, film.runtime, film.published, film.active, campus.location, campus.ID, users.id 
						FROM film, campus, users, collaborators 
						WHERE film.title Like ? AND film.user_id = users.ID AND film.ID = collaborators.film_id AND campus.ID = users.campus_id AND published = 1 AND active = 1".$campus."
						OR collaborators.first_name Like ? AND film.user_id = users.ID AND film.ID = collaborators.film_id AND campus.ID = users.campus_id AND published = 1 AND active = 1".$campus."
						OR film.synopsis Like ? AND film.user_id = users.ID AND film.ID = collaborators.film_id AND campus.ID = users.campus_id AND published = 1 AND active = 1".$campus."
						OR collaborators.last_name Like ? AND film.user_id = users.ID AND film.ID = collaborators.film_id AND campus.ID = users.campus_id AND published = 1 AND active = 1".$campus;

						if(!$stmt = $mysqli->prepare($sql)){
							echo "prepare failed";
						}
						if(!$stmt->bind_param('ssss', $searchstring, $searchstring, $searchstring, $searchstring)) {
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						$stmt->store_result();
						if(!$stmt->bind_result($id, $title, $synopsis, $video_link, $cover_image, $runtime, $published, $active, $location, $campus_id, $user_id)) {
							echo "binding results failed";
						}
						$data = array();
						
						while($stmt->fetch()) {

							$sql = "SELECT AVG(rating) AS average_rating FROM rating WHERE film_id = ?";

							if(!$stmt2 = $mysqli->prepare ($sql)){
								echo "prepare failed";
							}
							if(!$stmt2->bind_param("i", $id)){
								echo "bind param failed";
							}
							if(!$stmt2->execute()){
								echo "execute failed";
							}
							$stmt2->store_result();
							if(!$stmt2->bind_result($average_rating)) {
								echo "binding results failed";
							}

							while($stmt2->fetch()) {
								$rating = $average_rating;
							}


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
								"campus" => $location,
								"campus_id" => $campus_id,
 								"average_rating" => $rating
							);
						} // end while

						$stmt->close();

					} // end if target isset

					//var_dump($data);

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
						$user_id = $_POST['user_id'];
						$published = $_POST['published'];
						$active = $_POST['active'];

						$sql = "UPDATE film SET title = ?, synopsis = ?, video_link = ?, cover_image = ?, runtime = ?, published = ?, active = ? WHERE film.id = ? AND user_id = ?";
						if(!$stmt = $mysqli->prepare ($sql)) {
							$action = "Update project prepare failed";
						}
						if(!$stmt->bind_param("sssssiiii", $title, $synopsis, $video_link, $cover_image, $runtime, $published, $active, $target, $user_id)){
							$action = "Update project binding param failed";
						}
						if(!$stmt->execute()){
							$action = "Update project execute failed";
						}
						else {
							$action = "Project updated";
						}

						$data = $target;

						$stmt->close();



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
						$delete = [];
						$existing = [];
						
						// loop through sql response
						while($row = $res->fetch_assoc()){

							$found = 0;

							//loop through collabs input in form
							foreach($collab as $k => $collabrow){

								$rowcompare = array_slice($row, 1);

								// if current collab loop matches sql response
								if($collabrow == $rowcompare){
									$found = 1;

									array_push($existing, $row['id']);
									
									unset($collab[$k]);
								} 

								// if current collab loop DOES NOT match sql response
								else {
									
									print_r($rowcompare);
									array_push($delete, $row['id']);
								
								} // end else 
								
							} // end foreach

 						} // end while

 						echo "delete array: ";
 						print_r($delete);

 						echo "existing array: ";
 						print_r($existing);


 						$result = array_diff($delete, $existing);
 						print_r($result);

 						echo "collabs to add: ";
 						print_r($collab);

 						if($result > 0){
 							foreach($result as $rowtodelete) {
 								echo "row to delete: ".$rowtodelete." - ";
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
									$action = "inserting collaborators prepare failed";

								}
								if(!$stmt->bind_param("issss", $film_id, $first_name, $last_name, $role, $email)){
									$action = "Insert collaborators binding param failed";
								}
								if(!$stmt->execute()){
									$action = "Insert collaborators execute failed";
								} 
								else {
									$action = 'Collaborators updated';
								}
								$stmt->close();

 							} // end foreach

 						} // end if collabs to add




 						// Film history
						$sql  = "INSERT INTO film_history (film_id, user_id, time_now, user_action) VALUES (?,?,NOW(),?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("iis", $target, $user_id, $action)){
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



						// Insert film details
						$sql  = "INSERT INTO film (title, synopsis, video_link, cover_image, runtime, user_id, published, active) VALUES (?,?,?,?,?,?,?,?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							$action =  "Insert new film prepare failed";
							echo "prepare failed";
						}
						if(!$stmt->bind_param("sssssiii", $title, $synopsis, $video_link, $cover_image, $runtime, $user_id, $published, $active)){
							$action =  "Insert new film binding param failed";
							echo "bind param failed";
						}
						if(!$stmt->execute()){
							$action =  "Insert new film execute failed";
							echo "execute failed";
						} 
						else {
							$action = "New film inserted";
						}

						$target = $mysqli->insert_id; // film id

						$data = $target;

						$stmt->close();



						// Insert collaborators
						$collab = $_POST['collab'];
						foreach($collab as $i=>$v) {
							if(!empty($v['first_name'] && $v['last_name'] && $v['role'] && $v['email'])){
								$collab_fn = $v['first_name'];
							     $collab_ln = $v['last_name'];
							     $collab_role = $v['role'];
							     $collab_email = $v['email'];

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
						}



						// Insert into film history
						$sql  = "INSERT INTO film_history (film_id, user_id, time_now, user_action) VALUES (?,?,NOW(),?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("iis", $target, $user_id, $action)){
							echo "binding param failed";
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
						$target = $_POST['target']; // film id
						$active = $_POST['active'];	
						$sql = "UPDATE film SET active = ? WHERE id = ?";
						if(!$stmt = $mysqli->prepare($sql)) {
							$action = "hiding film prepare failed";
						}
						if(!$stmt->bind_param("ii", $active, $target)){
							$action = "hiding film binding param failed";
						}
						if(!$stmt->execute()){
							$action = "hiding film execute failed";
						}
						else {
							$action = "Film hidden";
						}
						$stmt->close();


						
						// Insert into film history
						
						$sql  = "INSERT INTO film_history (film_id, user_id, time_now, user_action) VALUES (?,?,NOW(),?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("iis", $target, $user_id, $action)){
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

						$sql = "INSERT INTO rating (rating, ip, film_id) VALUES (?,?,?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							$action =  "add rating prepare failed";
						}
						if(!$stmt->bind_param("isi", $rating, $ip, $target)) {
							$action = "add rating binding param failed";
						}
						if(!$stmt->execute()){
							$action = "add rating execute failed";
						}

						else {
							$action = "Add rating successful";
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
						$feedback_4 = $_POST['feedback_4'];
						$feedback_5 = $_POST['feedback_5'];

						$sql = "INSERT INTO academic (film_id, user_id, feedback_1, feedback_2, feedback_3, feedback_4, feedback_5) VALUES (?,?,?,?,?,?,?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							$action =  "Inserting film feedback prepare failed";
						}
						if(!$stmt->bind_param("iisssss", $target, $user_id, $feedback_1, $feedback_2, $feedback_3, $feedback_4, $feedback_5)) {
							$action =  "Inserting film feedback binding param failed";
						}
						if(!$stmt->execute()){
							$action =  "Inserting film feedback execute failed";
						}
						if(!$stmt->bind_result($film_id, $user_id, $feedback_1, $feedback_2, $feedback_3,  $feedback_4, $feedback_5)){
							$action =  "Inserting film feedback binding result failed";
						} 
						else {
							$action = "Film feedback submitted";
						}
						$stmt->close();




						// Film history
 						
						$sql  = "INSERT INTO film_history (film_id, user_id, time_now, user_action) VALUES (?,?,NOW(),?)";
						if(!$stmt = $mysqli->prepare ($sql)) {
							echo "prepare failed";
						}
						if(!$stmt->bind_param("iiss", $target, $user_id, $action)){
							echo "binding param failed";
						}
						if(!$stmt->execute()){
							echo "execute failed";
						}
						$stmt->close();

					} // end if target is set
				
				break; // end add academic feedback




				case "return_academic_feedback":
					$target = $_POST['target']; // campus id based on teacher making request
					$sql = "SELECT campus.location, film.id, film.title, academic.feedback_1, academic.feedback_2, academic.feedback_3, academic.feedback_4, academic.feedback_5 FROM 
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

					$stmt->store_result();
					if(!$stmt->bind_result($location, $film_id, $title, $feedback_1, $feedback_2, $feedback_3, $feedback_4, $feedback_5)) {
						echo "binding results failed";
					}
					
					$data = array();

					while($stmt->fetch()) {

						$sql = "SELECT collaborators.first_name, collaborators.last_name FROM collaborators WHERE collaborators.film_id = ?";
						if(!$stmt2 = $mysqli->prepare ($sql)) { 
							echo "stmt2 prepare failed";
						}
						if(!$stmt2->bind_param("i", $film_id)){
							echo "stmt2 binding param failed";
						}
						if(!$stmt2->execute()){
							echo "stmt2 execute failied";
						}
						$stmt2->store_result();

						if(!$stmt2->bind_result($first_name, $last_name)) {
							echo "stmt2 binding results failed";
						}

						//concat collabs

						$collab = array();

						while($stmt2->fetch()){
							$collab[] = array(
								"first_name" => $first_name,
								"last_name" => $last_name,
							);

						}

						$collab_out = implode(" & ",array_map(function($a) {return implode(" ",$a);},$collab));

						$stmt2->close();

						$data[] = array(
							"location" => $location,
							"title" => $title,
							"collab" => $collab_out,
							"feedback_1" => $feedback_1,
							"feedback_2" => $feedback_2,
							"feedback_3" => $feedback_3,
							"feedback_4" => $feedback_4, 
							"feedback_5" => $feedback_5
						);
					}
					
					//$res = $stmt->get_result();
					//$rows = $res->fetch_all();
					$stmt->close();
					
					
					// output array as csv file
					$output = fopen("php://output", 'w') or die("Could not open php://output");
					header("Content-Type:application/csv");
					header("Content-Disposition:attachment;filename=studentfeedback.csv");
					fputcsv($output, array('Location','Film Title','Film Makers','What was the filmmakers objective when making this documentary?','How would you describe the quality of the cinematography?','How would you describe the quality of the audio', 'How did the editing/structure of this documentary help establish character and plot?', 'What were the most and least engaging elements of this documentary and why?'));
					foreach($data as $row){
						fputcsv($output, $row);
					}
					fclose($output) or die("Could not close php://output");
					die();
					
				break; // end return academic feedback

			} // end switch



			$data = json_encode($data);
			echo $data;
			if(empty($data)){
				$errormsg = "You haven't typed anything!";
			}
		

	} //end if function not empty

	
?>