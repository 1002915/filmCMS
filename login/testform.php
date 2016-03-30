<?php
	require "overlord.php";
?>

<form method="POST" action="#">
	<h2>Get all projects</h2>
	<input type='hidden' name='function' value='return_all_projects'>
	<input type="submit">
</form>

<form method="POST" action="#">
	<h2>Get ONE project (Insert film id)</h2>
	<input type="hidden" name="function" value="return_project">
	<input type="text" name="target">
	<input type="submit">
</form>

<form method="POST" action="#">
	<h2>Update a project</h2>
	<input type="hidden" name="function" value="update_project">
	<h3>Film Id:</h3><br>
	<input type="number" name="target">
	<h3>Title:</h3><br>
	<input type="text" name="title"><br>
	<h3>Synopsis</h3><br>
	<input type="text" name="synopsis"><br>
	<h3>Video Link</h3><br>
	<input type="text" name="video_link"><br>
	<h3>Cover Image</h3><br>
	<input type="text" name="cover_image"><br>
	<h3>Runtime</h3><br>
	<input type="text" name="runtime"><br>
	<h3>Published</h3><br>
	<input type="text" name="published"><br>
	<h3>Active</h3><br>
	<input type="text" name="active"><br>
	<input type="submit">
</form>


<form method="POST" action="#">
	<h2>Create a project</h2>
	<input type="hidden" name="function" value="new_project">
	<h3>Title:</h3><br>
	<input type="text" name="title"><br>
	<h3>Synopsis</h3><br>
	<input type="text" name="synopsis"><br>
	<h3>Video Link</h3><br>
	<input type="text" name="video_link"><br>
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
	<input type="submit">
</form>


<form method="POST" action="#">
	<h2>Hide a project</h2>
	<input type="hidden" name="function" value="hide_project">
	<h3>Film Id:</h3><br>
	<input type="number" name="target">
	<h3>Active</h3><br>
	<input type="text" name="active"><br>
	<input type="submit">
</form>

<?php

foreach($data as $value) {
	foreach($value as $val) {
		echo "<h4>ID</h4>".$value['id']."<br>";
		echo "<h4>Title</h4>".$value['title']."<br>";

	}
}
	echo "<h4>ID</h4>".$data['id']."<br>";
	echo "<h4>Title</h4>".$data['title']."<br>";
	echo "<h4>Synopsis</h4>".$data['synopsis']."<br>";
	echo "<h4>Video Link</h4>".$data['video_link']."<br>";
	echo "<h4>Cover Image</h4>".$data['cover_image']."<br>";
	echo "<h4>Runtime</h4>".$data['runtime']."<br>";
	echo "<h4>User ID</h4>".$data['user_id']."<br>";
	echo "<h4>Published</h4>".$data['published']."<br>";
	echo "<h4>Active</h4>".$data['active']."<br>";
	
?>