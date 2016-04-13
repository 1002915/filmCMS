<?php
	require "overlord.php";
?>



<?php
	include('header.php');
?>

	<script>
			$(document).ready(function(){ 
			<?php 
			if (isset($_POST['user_id'])) {
				$userid = $_POST['user_id']; 
				?>
				return_project();
			<?php } ?>
		});
	</script>

<div id="displayvideo">
	
	  <iframe id="video" width="100%" height="450" frameborder="0" allowfullscreen></iframe>
	

<section id="details">
	<div id="film_title" class="film_title">The Bunny Attack </div>
	<section id="details2">
		<div class="student_name">Robertson Ave</div>
		<div class="campus">Brisbane Campus</div>
	</section>
</section>
<section id="rating"> 
<!-- insert stars -->
</section>
<section id="synopsis">
	<p>In a futuristic world where bunnies have multiplied like a plague and evolved like pokemons are trying to rule and destroy every human and easter leftovers.  </p>
</section>
<section id="contributors">
	<div class="contributor1">Blue Glue</div>
</section>
</div>

<script src="https://apis.google.com/js/client.js?onload=OnLoadCallback"></script>
<script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>

<script>

	function return_project() {
		var target = <?PHP echo $_GET['id'];?>;
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
				//$('#displayvideo').html('');
 				$.each(res, function(index,value) {
 					$('#film_title').html(value.title);
 					$('#synopsis').html('<p>'+value.synopsis+'</p>');
 					var videolink = value.video_link;

		    var str = "youtube";

		    // if video was on youtube
			if(videolink.indexOf(str) > -1){
				var videolinkiframe = videolink.replace("watch?v=", "v/");

				//get youtube id
			   	var videoid = videolink.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i)[1];
				


			} else {
				// if video was on vimeo
				var videolinkiframe = videolink.replace("//", "//player.");
		    	var videolinkiframe = videolinkiframe.replace(".com", ".com/video");
		    	var videolinkiframe = videolinkiframe.concat("?api=1&player_id=player1");
		    }


		    $("#video").attr("src", videolinkiframe);
 					console.log(value);
 					//$('#displayvideo').html('');
					//$('#displayvideo').append( "<p>"+value['title']+"</p><p>"+value['synopsis']+"</p> " );
					//
					// WHEN THE CONENT IS NOT IN THE DATABASE
    				if(value['id'] == null){
						$('#displayvideo').html('');
 						$('#displayvideo').append("<p>Sorry there are no results</p>");
 					}	 
				});
			}
		});
	}
	return_project()
</script>