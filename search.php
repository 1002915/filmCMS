<!-- THIS IS WHAT YOU PUT ON THE INDEX PAGE -->
<?php
	include('overlord.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>FilmCMS</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link rel='stylesheet' type='text/css' href='css/searchCSS.css'>
	</head>
	<body>

		<script>
			$(document).ready(function(){
				$('#search').keyup(function(){
					console.log('Keypress!');
					var search = $('#search').val();
					console.log({$data});
					$.ajax({
						type:"POST",
						url:"overlord.php",
						data:{
							function:'search_project'
						},
						success:function(res) {
							console.log(res);
							// loop through data
 							for ( data in {$data}) {
								$('#searchList').append( "<img src='data['.'cover_image'.']'class='coverImage' alt='cover_image'> <p>test</p>" );
							}
								
							//$('#searchList').html(res);
						}
					});
				});
			});
		</script>


		<div id='searchBar'>
			Test Search Bar
			<!-- SEARCH BOX -->
			<input type='text' name='target' placeholder='Search...' id='search'>

			<!-- SEARCH RESULTS CONTAINER -->
			<div id='searchList'>
				<?php
				//foreach (){?>
					<!--<img src="<?php echo $data['cover_image']; ?>" alt='coverImg' class='coverImage'><br>
					<span><?php echo $data['title']; ?></span><br>
					<span class='runTime'><?php echo $data['runtime']; ?></span><br>
					<span><?php echo $data['synopsis']; ?></span><br>-->

			<?php //}?>
			</div>
		</div>
		<!-- THIS IS THE INFORMATION THAT BELONGS ON THIS PAGE  IS IN TEH GET_UESRS PHP FILE-->


	</body>
</html>
