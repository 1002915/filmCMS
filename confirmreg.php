<?php
session_start();

include('connection.php');

$getemailconfirm = $_GET['code'];

$idconfirm = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = '$idconfirm'";

$result = mysqli_query($mysqli, $sql);

$row = mysqli_fetch_row($result);

$databasekey = $row[8];


if ($databasekey == $getemailconfirm) {

	$verifiedupdate = "UPDATE users SET verified='1' WHERE id = '$idconfirm'";

if ($mysqli->query($verifiedupdate) === TRUE) {
	include('header.php');?>
	<div class='confirm_container'>
		<?php echo "<p>Thank you for registering. Click <span id=link>HERE</span> to login.</p>";?>
	</div>

	<?php include('footer.php');
}

} else {

	echo 'sorry, this link has expired. Please click <a href="index.php">here</a>';
}

?>

<script>
	$('#link').on('click touch', function() {
  		$('#modal_trigger').click();
	});
		

</script>