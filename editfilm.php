<?php 
	require "overlord.php";
	include('header.php'); 

	$user_id = $_SESSION['id'];
	$user_type = $_SESSION['user_type'];
	$activebutton = false;

	//$filmid = $_GET['id'];
	$film_id = 1;

    json_encode($film_id);
?>

	<script src="js/form-validator/jquery.form-validator.js"></script>
	<link rel="stylesheet" type="text/css" href="css/dropzone.css">

<h2>Link Your Video</h2>
<p>Please copy and paste the link from youtube or vimeo</p>

<form method="POST" action="displayfilm.php">
	<input type="hidden" name="function" value="update_project">

	<input type="text" id='edit_video_link' name="video_link" data-validation="youtube" data-validation="required"><br>

	<input type="text" id="edit_runtime" name="runtime">

	<div class='display_video'>
		<iframe id="player1" class="preview-video" width="960" height="540" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	</div>

	<h3>Title:</h3><br>
	<input type="text" id="edit_title" name="title" data-validation="required" data-validation="length" data-validation-length="max250"><br>

	<h3>Synopsis</h3><br>
	<input type="text" id="edit_synopsis" name="synopsis" data-validation="required" data-validation="length" data-validation-length="max250"><br>

	<h3>Collaborators</h3>
	<table id="new_collaborator">
		<tr>
			<td>First Name</td>
			<td>Last Name</td>
			<td>Role</td>
			<td>Email</td>
			<td></td>
		</tr>
	</table>

	<h3>Cover Image</h3><br>
	<!--<div class="dropzone" id="cover_image" name="cover_image"></div>-->
	<input type="text" id="edit_cover_image" name="cover_image">

	<select id="edit_published" name="published">
		<option value="0">Save Draft</option>
		<option value="1">Publish</option>
	</select>

	<?php
	if($user_type == 1) {
		?>

		<input type="checkbox" name="active" class="active-checkbox" id="edit_active" checked>
	    <label class="active-label" for="edit_active">
	        <span class="active-inner"></span>
	        <span class="active-switch"></span>
	    </label>

		<?php
	}
	?>

	<!-- hidden fields-->
	<input type="hidden" id="edit_user_id" name="user_id" value="<?php echo $user_id;?>"><br>

	<input type="submit">

</form>
	
	<script src="https://apis.google.com/js/client.js?onload=OnLoadCallback"></script>
	<script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
	<script src="js/dropzone.js"></script>

	<script>

		$.validate();

		// relevant film id
		var target = <?php echo json_encode($film_id)?>;

		// return single project
		function return_project() {	
			$.ajax({
				type:"POST",
				url:"overlord.php",
				data:{
					function:'return_project',
					target: target
				},
				dataType:'json',
				success:function(res) {

					// loop through response
	 				$.each(res, function(i, val) {

	 					// input the values from the overlord into the appropraite input fields
	 					$('input#edit_video_link').val(val['video_link']);
	 					$('input#edit_title').val(val['title']);
	 					$('input#edit_synopsis').val(val['synopsis']);	 
	 					$('input#edit_cover_image').val(val['cover_image']);
	 					$('input#edit_published').val(val['published']);
	 					$('input#edit_user_id').val(val['user_id']);	 
	 					$('input#edit_active').val(val['active']);

	 					// get array length
	 					var collablength = (Object.keys(val['collab']).length);

						// add rows to table with collab values input
	 					var table = $('#new_collaborator > tbody'),
						    props = ["first_name", "last_name", "role", "email"];
						    var fred = 1;

						$.each(val['collab'], function(i, val) {
						  	var tr = $('<tr>');
						  	var input = $('#new_collaborator > tbody > tr:last > td > input');

						  	$.each(props, function(i, prop) {
						   		$('<td>').html('<input type="text" class="' + prop + '" value=" ' + val[prop] + ' " name="collab[' + fred + '][' + prop + ']">').appendTo(tr);

						  	});

						  	$('<td>').html('<input type="button" id="remove" value="remove" name="collab[' + fred + '][remove]" onclick="deleteRow(this)">').appendTo(tr);

						  	fred++;

						  	table.append(tr);
						});
							
					});
				}, 
				error: function(res) {
					console.log("ERROR: no id received");
				}
			});
		}


		// converting time in seconds to hh:mm:ss
		function runtimeformat(seconds) {
			seconds = Math.round(seconds)
			//get time in hours and round down
			var hours = Math.floor(seconds / 3600);
			var minutes = Math.floor((seconds - (hours * 3600)) / 60);
			var seconds = seconds - ((hours * 3600) + (minutes * 60));
			var time = hours + ': '+ minutes + ':' + seconds;
			return time;
		}

		// append runtime to input field
		function appendResults(text) {
			$('input#runtime').val($('input#runtime').val() + text);
			console.log($('input#runtime').val());
		}
		
		// load video after user inputs link
		$("#new_video_link").on('input', function () {
		    var videolink = $('#new_video_link').val();

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
						// trigger insert duration function
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
				player.addEvent('ready', function() {
					getDuration();
				});

				function getDuration() {
				    player.api('getDuration', function(duration) {
				    	duration = runtimeformat(duration);
				        appendResults(duration);
				    });
				}
		    }

		    $(".preview-video").attr("src", videolinkiframe);

		});	

		// Increase collaborators as user inputs info
		$("#new_collaborator > tbody > tr:last > td > .firstname").on('blur', function(){
			if($("#new_collaborator > tbody > tr:last > td > .firstname").val() != ''){

				// clone last row of table and empty its values
				$('#new_collaborator > tbody > tr:last').clone(true).insertAfter('#new_collaborator > tbody > tr:last');
				var input = $('#new_collaborator > tbody > tr:last > td > input');
				$('#new_collaborator > tbody > tr:last > td > input.firstname').val('');
				$('#new_collaborator > tbody > tr:last > td > input.lastname').val('');
				$('#new_collaborator > tbody > tr:last > td > input.role').val('');
				$('#new_collaborator > tbody > tr:last > td > input.email').val('');

				// get number of rows in table
				var rowcount = $('#new_collaborator tr').length;
				var rowcurrent = rowcount -1;

				// name each field in [collab][current row number]['xxxxx'] format
				$('#new_collaborator > tbody > tr:last > td > input.firstname').attr('name', 'collab[' + rowcurrent + '][firstname]');
				$('#new_collaborator > tbody > tr:last > td > input.lastname').attr('name', 'collab[' + rowcurrent + '][lastname]');
				$('#new_collaborator > tbody > tr:last > td > input.role').attr('name', 'collab[' + rowcurrent + '][role]');
				$('#new_collaborator > tbody > tr:last > td > input.email').attr('name', 'collab[' + rowcurrent + '][email]');
				$('#new_collaborator > tbody > tr:last > td > button.remove').attr('name', 'collab[' + rowcurrent + '][remove]');
			}

		});
	
		// remove collaborators
		function deleteRow(btn) {
		  	var row = btn.parentNode.parentNode;
		  	row.parentNode.removeChild(row);
		}

		// do all the things
		$(document).ready(function(){ 
			return_project();
		});

	</script>

	