<?php session_start();?>
<!DOCTYPE html>

<head>
	<title>Film CMS</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/matt_styles.css">
	<link rel="stylesheet" type="text/css" href="css/tatiana_styles.css">
	<link rel="stylesheet" type="text/css" href="css/alex_styles.css">
	<link rel="stylesheet" type="text/css" href="css/anna_styles.css">
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		$('#search').keyup(function(){
			console.log('Keypress!');
			var search = $('#search').val();
			$.ajax({
				type:"POST",
				url:"get_users.php",
				data:{search:search},
				success:function(res) {
					console.log(res);
					$('#searchList').html(res);
				}
			});
		});
	});
	</script>
</head>

<div class="site_container">
	<div class="header_navigation">
		<a href="index.php">
			<img src="img/logo.png" class="logo" alt="logo">
		</a>
		<?php if (!isset($_SESSION['email'])) { ?>
		<form id="login_button" action="login.php">
			<input type="submit" Value="Login">
		</form>
		<?php } else echo''; ?>
		<?php if (isset($_SESSION['email'])) { ?>
		<form id="login_button" action="logout.php">
			<input type="submit" Value="logout">
		</form>
		<?php } else echo''; ?>
		<div id='search_bar'>
			<input type='text' name='search' placeholder='Search...' id='search'>
		</div>
	</div>
<div class="site_content">
