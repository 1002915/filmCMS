<!DOCTYPE html>
<head>
	<title>Film CMS</title>

	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/matt_styles.css">
	<link rel="stylesheet" type="text/css" href="css/tatiana_styles.css">
	<link rel="stylesheet" type="text/css" href="css/alex_styles.css">
	<link rel="stylesheet" type="text/css" href="css/anna_styles.css">

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


	<meta name="viewport" content="width=device-width" />
</head>

<div class="site_container">
	<div class="header_navigation">
		<a href="index.php"><img src="img/logo.jpg" class="logo" alt="logo"></a>
		<div id='search_bar'>
			<input type='text' name='search' placeholder='Search...' id='search'>
		</div>
		<form id="login_button" action="login/login.php">
			<input type="submit" Value="Login">
		</form>
	</div>

