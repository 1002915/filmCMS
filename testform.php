<?php
	require "overlord.php";
?>

<form method="POST" action="#">
	<h2>Search</h2>
	<input type='hidden' name='function' value='search_project'>
	<input type='text' name='target'>
	<input type="submit">
</form>







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







<form method="POST" action="#">
	<h2>Rate a project</h2>
	<input type="hidden" name="function" value="add_rating">
	<h3>Film Id:</h3><br>
	<input type="number" name="target">
	<h3>Rating</h3><br>
	<input type="text" name="active"><br>
	<input type="submit">
</form>







<form method="POST" action="#">
	<h2>Provide Academic Feedback</h2>
	<input type="hidden" name="function" value="add_academic_feedback">
	<h3>Film Id:</h3><br>
	<input type="number" name="target">
	<h3>Question 1</h3><br>
	<input type="text" name="q1"><br>
	<h3>Question 2</h3><br>
	<input type="text" name="q2"><br>
	<h3>Question 3</h3><br>
	<input type="text" name="q3"><br>
	<input type="submit">
</form>






	
	<table>
		<thead>
			<tr>
				<td>
					<h4>id</h4>
				</td>
				<td>
					<h4>Title</h4>
				</td>
				<td>
					<h4>Synopsis</h4>
				</td>
				<td>
					<h4>Video Link</h4>
				</td>
				<td>
					<h4>Cover Image</h4>
				</td>
				<td>
					<h4>Runtime</h4>
				</td>
				<td>
					<h4>User ID</h4>
				</td>
				<td>
					<h4>Published</h4>
				</td>
				<td>
					<h4>Active</h4>
				</td>
				<td>
					<h4>Average Rating</h4>
				</td>
				<td>
					<h4>First Name</h4>
				</td>
				<td>
					<h4>Last Name</h4>
				</td>
				<td>
					<h4>campus</h4>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php echo $data['id']; ?>
				</td>
				<td>
					<?php echo $data['title']; ?>
				</td>
				<td>
					<?php echo $data['synopsis']; ?>
				</td>
				<td>
					<?php echo $data['video_link']; ?>
				</td>
				<td>
					<?php echo $data['cover_image']; ?>
				</td>
				<td>
					<?php echo $data['runtime']; ?>
				</td>
				<td>
					<?php echo $data['user_id']; ?>
				</td>
				<td>
					<?php echo $data['published']; ?>
				</td>
				<td>
					<?php echo $data['active']; ?>
				</td>
				<td>
					<?php echo $data['average_rating']; ?>
				</td>
				<td>
					<?php echo $data['first_name']; ?>
				</td>
				<td>
					<?php echo $data['last_name']; ?>
				</td>
				<td>
					<?php echo $data['campus']; ?>
				</td>
			</tr>
		</tbody>
	</table>
	
