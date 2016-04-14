<?php session_start();?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="Film CMS" content="A place where SAE film students can showcase their Loco-Doco's">
	<title>Film CMS</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/matt_styles.css">
	<link rel="stylesheet" type="text/css" href="css/tatiana_styles.css">
	<link rel="stylesheet" type="text/css" href="css/alex_styles.css">
	<link rel="stylesheet" type="text/css" href="css/ana_styles.css">
	<link rel="stylesheet" type="text/css" href="css/dropzone.css">
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/form-validator/jquery.form-validator.js"></script>
	<script src="js/dropzone.js"></script>
</head>

<body>

<div class="site_container">
	<div class="header_navigation">
		<a href="index.php"><img src="img/logo.png" class="logo" alt="logo"></a>

<?php 

if (!isset($_SESSION['email'])) { 

?>

		<div class="login_header">
			<form name="login_form_front" id="login" method="post" action="checklogin.php">
  				<input type="text" name='email' placeholder="email" maxlength="50" />
  				<input type='password'  name='password_hash' maxlength="50" placeholder="password"/>
  				<input class="parallelogram" type='submit' name='Submit' value='login' />
  			</form>
  		</div>
  		<a href="register.php" class="register">Register</a>

<?php } else echo'';

if (isset($_SESSION['email'])) { 

?>
		<a href="profile.php" class="profile">Profile</a>
		<a href="newfilm.php" class="contribute">Contribute</a>
		<a href="logout.php" class="logout">Logout</a>

<?php

} else echo''; 

?>

		<div id='search_bar'>
			<form action="search.php" method="post">
				<input type='hidden' name='function' value='search_project'>
				<input type='text' name='search' placeholder='Search...' class='search'>
				<input type="submit" name="Search" value="Search">
			</form>

		</div>
	</div>
	
<div class="site_content">
