<?php 

require "header.php";

?>

<h2>Link Your Video</h2>
<p>Please copy and paste your url into the field below</p>

<form method="POST" action="#">
	<input type="hidden" name="function" value="new_project">
	<input type="text" name="video_link">
	

	<h3>Title:</h3><br>
	<input type="text" name="title"><br>
	<h3>Synopsis</h3><br>
	<input type="text" name="synopsis"><br>
	<h3>Video Link</h3><br>
	
	<h3>Cover Image</h3><br>
	<input type="text" name="cover_image"><br>
	<h3>Runtime</h3><br>
	<input type="text" name="runtime"><br>
	<h3>User ID</h3><br>
	<input type="text" name="user_id"><br>
	<h3>Published</h3><br>
	<input type="text" name="published"><br>
	<h3>Active</h3><br>
	<input type="text" name="active"><br>

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
	<input type="submit">


</form>