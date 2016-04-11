<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>FilmCMS</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link rel='stylesheet' type='text/css' href='css/alex_styles.css'>
	</head>
	<body>

		<script>
			$(document).ready(function(){
				$('#search').keyup(function(){
					console.log('Keypress!');
					var search = $('#search').val();
					var campus_selection = $('#campus_selection').val();
					$.ajax({
						type:"POST",
						url:"overlord.php",
						data:{
							function:'search_project',
							target:search,
							campus:campus_selection
						},
						dataType:'json',
						success:function(res) {
							// loop through data
							$('#searchList').html('');
 							$.each(res, function(index,value) {
 								console.log(value);
 								$('#searchList').html('');
								$('#searchList').append( "<img src='"+value['cover_image']+"'class='coverImage' alt='cover_image'> <p>"+value['title']+"</p><p>"+value['synopsis']+"</p> " );
								// WHEN THE CONENT IS NOT IN THE DATA
    							if(value['id'] == null){
									$('#searchList').html('');
 									$('#searchList').append("<p>there are no results</p>");
 								}	 
							});
								
							//$('#searchList').html(res);
						},
						error:function(req,text,error) {
							console.log('Oops!');
							console.log(req);
							console.log(text);
							console.log(error);
						}
					});
				});
			});
		</script>


		<div id='searchBar'>
			Test Search Bar
			<!-- SEARCH BOX -->
			<input type='text' name='target' placeholder='Search...' id='search'>

			<!-- FILTER BY CAMPUS -->
			<select name="campus" id='campus_selection'>
			    <option value="all" selected>All Campuses</option>
			    <option value="1">Brisbane</option>
			    <option value="2">Byron Bay</option>
			    <option value="3">Sydeny</option>
			    <option value="4">Adelaide</option>
			    <option value="5">Melbourne</option>
			    <option value="6">Perth</option>
			    <option value="7">Online</option>
			</select>
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
