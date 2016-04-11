<?php
	include('header.php');
?>
	<body>




		<div id='searchBar'>
			Search Bar
			<!-- SEARCH BOX -->
			<input type='text' name='target' placeholder='Search...' id='search' value="<?php if(isset($_POST['search'])) { echo $_POST['search']; } ?>">

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
			<div id='searchList'></div>
		</div>
		<script>
			function search() {
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
							// LOOP THROUGH THE DATA IN THE DATABASE IF SOMEONE SEARCHES SOMETHING
							$('#searchList').html('');
 							$.each(res, function(index,value) {
 								console.log(value);
 								$('#searchList').html('');
								$('#searchList').append( "<img src='"+value['cover_image']+"'class='coverImage' alt='cover_image'> <p>"+value['title']+"</p><p>"+value['synopsis']+"</p> " );
								// WHEN THE CONENT IS NOT IN THE DATABASE
    							if(value['id'] == null){
									$('#searchList').html('');
 									$('#searchList').append("<p>Sorry there are no results</p>");
 								}	 
							});
						}
					});
			}

			$(document).ready(function(){

					<?php if (isset($_POST['search'])) { ?>
						search();
					<?php }?>

					$(document).on('change', '#search, #campus_selection', function() {
						search();
					});
				
			});
		</script>
		<!-- FOOTER -->
		<?php
			include('footer.php');
		?>
	</body>
</html>
