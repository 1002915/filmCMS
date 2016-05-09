<?php
	require "overlord.php";
?>

<form method="POST" action="#">
	<h2>Update a project</h2>
	<input type="hidden" name="function" value="update_project">
	<h3>Film Id:</h3><br>
	<input type="number" name="target">
	<h3>User Id:</h3><br>
	<input type="number" name="user_id">
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

	<h3>Collaborator 1 First Name</h3><br>
	<input type="text" name="collab[1][first_name]"><br>
	<h3>Collaborator 1 Last Name</h3><br>
	<input type="text" name="collab[1][last_name]"><br>
	<h3>Collaborator 1 Role</h3><br>
	<input type="text" name="collab[1][role]"><br>
	<h3>Collaborator 1 Email</h3><br>
	<input type="text" name="collab[1][email]"><br>

	<h3>Collaborator 2 First Name</h3><br>
	<input type="text" name="collab[2][first_name]"><br>
	<h3>Collaborator 2 Last Name</h3><br>
	<input type="text" name="collab[2][last_name]"><br>
	<h3>Collaborator 2 Role</h3><br>
	<input type="text" name="collab[2][role]"><br>
	<h3>Collaborator 2 Email</h3><br>
	<input type="text" name="collab[2][email]"><br>

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
	

-->