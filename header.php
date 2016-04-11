<?php session_start();?>
<!DOCTYPE html>
<head>
	<title>Film CMS</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/matt_styles.css">
	<link rel="stylesheet" type="text/css" href="css/tatiana_styles.css">
	<link rel="stylesheet" type="text/css" href="css/alex_styles.css">
	<link rel="stylesheet" type="text/css" href="css/anna_styles.css">
	
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<div class="site_container">
	<div class="header_navigation">
		<a href="index.php"><img src="img/logo.png" class="logo" alt="logo"></a>
		<?php if (!isset($_SESSION['email'])) { ?>
		<div class="login_header">
			<form name="login_form_front" id="login" method="post" action="checklogin.php">
  				<input type="text" name='email' placeholder="email" maxlength="50" />
  				<input type='password'  name='password_hash' maxlength="50" placeholder="password"/>
  				<input class="parallelogram" type='submit' name='Submit' value='login' />
  			</form>
  		</div>
  		  			<form id="register" action="register.php">
				<input type="submit" Value="register">
			</form>
  		
		<?php } else echo''; ?>
		<?php if (isset($_SESSION['email'])) { ?>

		<form class="login_button profile" action="profile.php">
			<input type="submit" Value="my profile">
		</form>

		<form class="login_button contribute" action="newfilm.php">
			<input type="submit" Value="contribute">
		</form>

		<form class="login_button logout" action="logout.php">
			<input type="submit" Value="logout">
		</form>

		<?php } else echo''; ?>

		<div id='search_bar'>
			<form action="search.php" method="post">
				<input type='text' name='search' placeholder='Search...' class='search'>
				<input type="submit" name="Search" value="Search">
			</form>

		</div>
	</div>
<div class="site_content">
