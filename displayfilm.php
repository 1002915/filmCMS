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
	
	  <iframe id="video" width="100%" height="450" src="" frameborder="0" allowfullscreen></iframe>
	

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

			   	// start youtube api
				gapi.client.setApiKey('AIzaSyAD94F0GwBoXnncL0ck2bZdSeZf6RDW_3s');
				gapi.client.load('youtube', 'v3').then(makeRequest);

				//convert youtube time to seconds
				function convertosecs(duration){
					var a = duration.match(/\d+/g);
				    if (duration.indexOf('M') >= 0 && duration.indexOf('H') == -1 && duration.indexOf('S') == -1) {
				        a = [0, a[0], 0];
				    }
				    if (duration.indexOf('H') >= 0 && duration.indexOf('M') == -1) {
				        a = [a[0], 0, a[1]];
				    }
				    if (duration.indexOf('H') >= 0 && duration.indexOf('M') == -1 && duration.indexOf('S') == -1) {
				        a = [a[0], 0, 0];
				    }
				    duration = 0;
				    if (a.length == 3) {
				        duration = duration + parseInt(a[0]) * 3600;
				        duration = duration + parseInt(a[1]) * 60;
				        duration = duration + parseInt(a[2]);
				    }
				    if (a.length == 2) {
				        duration = duration + parseInt(a[0]) * 60;
				        duration = duration + parseInt(a[1]);
				    }
				    if (a.length == 1) {
				        duration = duration + parseInt(a[0]);
				    }
				    return duration
				}
				
				// actually make api request
				function makeRequest() {
		            var request = gapi.client.youtube.videos.list({
						part: "contentDetails",
						id: videoid
					});
		            console.log('request made');
					request.then(function(response){
						var duration = 	response.result.items[0].contentDetails.duration;
						duration = convertosecs(duration);
						duration = runtimeformat(duration);
						appendResults(duration);
			        });
		        }

			} else {
				// if video was on vimeo
				var videolinkiframe = videolink.replace("//", "//player.");
		    	var videolinkiframe = videolinkiframe.replace(".com", ".com/video");
		    	var videolinkiframe = videolinkiframe.concat("?api=1&player_id=player1");

		    	//add vimeo api
				var iframe = $('#player1')[0];
    			var player = $f(iframe);

				// When the player is ready, add listeners for pause, finish, and playProgress
			//	player.addEvent('ready', function() {
			//		getDuration();
			//	});

				function getDuration() {
				    player.api('getDuration', function(duration) {
				    	duration = runtimeformat(duration);
				        appendResults(duration);
				    });
				}
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