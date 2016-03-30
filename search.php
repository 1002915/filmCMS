<!-- THIS IS WHAT YOU PUT ON THE INDEX PAGE -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>FilmCMS</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link rel='stylesheet' type='text/css' href='css/searchCSS.css'>
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
	<body>
		<div id='searchBar'>
			Test Search Bar
			<!-- SEARCH BOX -->
			<input type='text' name='search' placeholder='Search...' id='search'>
			<!-- SEARCH RESULTS CONTAINER -->
			<div id='searchList'>
				<?php include 'get_users.php';?>
			</div>
		</div>
		<!-- THIS IS THE INFORMATION THAT BELONGS ON THIS PAGE  IS IN TEH GET_UESRS PHP FILE-->


	</body>
</html>
