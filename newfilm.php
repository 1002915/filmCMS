<?php 
	$collab = 1;
?>

	<link rel='stylesheet' type='text/css' href='css/tatiana_styles.css'>

	<script src="js/jquery-2.2.2.min.js"></script>
	<script src="js/form-validator/jquery.form-validator.js"></script>
	

<h2>Link Your Video</h2>
<p>Please copy and paste the link from youtube or vimeo</p>

<form method="POST" action="#">
	<input type="hidden" name="function" value="new_project">

	<input type="text" id='new_video_link' name="video_link" data-validation="youtube">

	<div class='display_video'>
		<iframe class="preview-video" width="960" height="540" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	</div>

	<h3>Title:</h3><br>
	<input type="text" name="title" data-validation="required" data-validation="length" data-validation-length="max250"><br>

	<h3>Synopsis</h3><br>
	<input type="text" name="synopsis" data-validation="required" data-validation="length" data-validation-length="max250"><br>

	<h3>Collaborator 1 First Name</h3><br>
	<input type="text" name="collab[1][firstname]"><br>
	<h3>Collaborator 1 Last Name</h3><br>
	<input type="text" name="collab[1][lastname]"><br>
	<h3>Collaborator 1 Role</h3><br>
	<input type="text" name="collab[1][role]"><br>
	<h3>Collaborator 1 Email</h3><br>
	<input type="text" name="collab[1][email]"><br>
	
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

	<script>
		$.validate();

		$("#new_video_link").on('input', function () {
		    var videolink = $('#new_video_link').val();

		    var str = "youtube";

			if(videolink.indexOf(str) > -1){
				var videolinkiframe = videolink.replace("watch?v=", "v/");
			} else {
				var videolinkiframe = videolink.replace("//", "//player.");
		    	var videolinkiframe = videolinkiframe.replace(".com", ".com/video");
		    	var videolinkiframe = videolinkiframe.concat("?badge=0");
			}

		    $(".preview-video").attr("src", videolinkiframe);
		});

    </script>

