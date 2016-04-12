<?php
	require "overlord.php";
?>

<script>
	function return_project() {
		var target = 2;
		$.ajax({
			type:"POST",
			url:"overlord.php",
			data:{
				function:'return_project',
				target: target
			},
			dataType:'json',
			success:function(res) {
				// LOOP THROUGH THE DATA IN THE DATABASE IF SOMEONE SEARCHES SOMETHING
				$('#displayvideo').html('');
 				$.each(res, function(index,value) {
 					console.log(value);
 					$('#displayvideo').html('');
					$('#displayvideo').append( "<p>"+value['title']+"</p><p>"+value['synopsis']+"</p> " );
					// WHEN THE CONENT IS NOT IN THE DATABASE
    				if(value['id'] == null){
						$('#displayvideo').html('');
 						$('#displayvideo').append("<p>Sorry there are no results</p>");
 					}	 
				});
			}
		});
	}
</script>

<?php
	include('header.php');
?>

	<script>
			$(document).ready(function(){ 
			<?php 
			if (isset($_POST['user_id'])) {
				$userid =  $_POST['user_id']; 
				?>
				return_project();
			<?php } ?>
		});
	</script>


<div id="displayvideo"></div>