<?php
	include('header.php');
?>

	<body id='search_body'>

		<div id='searchBar'>
			<p class='center_text'>Search Bar</p>
			<!-- SEARCH BOX -->
			<div class='middle_postition'>
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
			</div>
			<div class='clear_float'></div>
			<!-- SEARCH RESULTS CONTAINER -->
			<div id='searchList'></div>
			<div class='clear_float'></div>
		</div>
		<script>
		//EDITING THE HEADER SEARCH BAR
		$(document).ready(function(){ 
			if ($('body').attr('id') == 'search_body') {
				$('#search_bar').hide();
			}
		});
		// SEARCH ENGINE FUNCTION
			function search() {
				console.log('Keypress!');
					var search = $('#search').val();
					var campus_selection = $('#campus_selection').val();
					console.log(campus_selection);
					if (search != '') {
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
	 							var count = 0;
	 							$.each(res, function(index,value) {
	 								if(value['id'] != null){
		 								console.log(value);
										$('#searchList').append( "<div class='search_product'><a href='displayfilm.php?id="+value['id']+"'><div class='film_cover_image' style='background-image:url("+value['cover_image']+");'></div></a><a href='displayfilm.php?id="+value['id']+"'><p class='film_title_search text_width'>"+value['title']+"</p></a><p class='max_length text_width'>"+value['synopsis']+"</p></div>" );
										// WHEN THE CONENT IS NOT IN THE DATABASE
	    							
										count++;		
	 								}
								});
	 							if (count < 1){
	 								$('#searchList').html('');
	 								$('#searchList').append("<p>Sorry there are no results</p>");
	 							}
								
							}
						});
					} else {
						$('#searchList').html('');
					}
			}

			$(document).ready(function(){ 

					<?php if (isset($_POST['search'])) { ?>
						search();
					<?php }?>

					$(document).on('change keyup', '#search, #campus_selection', function() {
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
