<?php 
	require 'overlord.php';
?>

	<link rel='stylesheet' type='text/css' href='css/tatiana_styles.css'>

	<script type="text/javascript" src="js/jquery-2.2.2.min.js"></script>
	
	<script>
		$(document).ready(function(){
			$('#new_video_link').on('input', function(){
				var input= $(this);
				var re= /http:\/\/(?:www.)?(?:(vimeo).com\/(.*)|(youtube).com\/watch\?v=(.*?)&)/
				var is_video = re.test(input.val());
				if(is_video){
					input.removeClass("invalid").addClass("valid");
				}
				else {
					input.removeClass("valid")}.addClass("invalid");
				}
			});
		});
	</script>


<h2>Link Your Video</h2>
<p>Please copy and paste your url into the field below</p>

<form method="POST" action="#">
	<input type="hidden" name="function" value="new_project">
	<input type="text" id='new_video_link' name="video_link"><button>Upload</button>

	<div class='display_video'>
	</div>

	<h3>Title:</h3><br>
	<input type="text" name="title"><br>
	<h3>Synopsis</h3><br>
	<input type="text" name="synopsis"><br>

	<h3>Collaborator 1 First Name</h3><br>
	<input type="text" name="collab[1][firstname]"><br>
	<h3>Collaborator 1 Last Name</h3><br>
	<input type="text" name="collab[1][lastname]"><br>
	<h3>Collaborator 1 Role</h3><br>
	<input type="text" name="collab[1][role]"><br>
	<h3>Collaborator 1 Email</h3><br>
	<input type="text" name="collab[1][email]"><br>

	<h3>Collaborator 2 First Name</h3><br>
	<input type="text" name="collab[2][firstname]"><br>
	<h3>Collaborator 2 Last Name</h3><br>
	<input type="text" name="collab[2][lastname]"><br>
	<h3>Collaborator 2 Role</h3><br>
	<input type="text" name="collab[2][role]"><br>
	<h3>Collaborator 2 Email</h3><br>
	<input type="text" name="collab[2][email]"><br>

	
	<h3>Cover Image</h3><br>
	<input type="text" name="cover_image"><br>
	<h3>Published</h3><br>
	<input type="text" name="published"><br>


	<!-- automatically filled in-->
	<h3>Runtime</h3><br>
	<input type="text" name="runtime"><br>
	<h3>User ID</h3><br>
	<input type="text" name="user_id"><br>
	<h3>Active</h3><br>
	<input type="text" name="active"><br>


	<input type="submit">


</form>