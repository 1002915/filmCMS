<?php
	include('header.php');
	include('uploader.php');

	$user_id = $_SESSION['id'];
?>

<div class="edit"> 
	<h2>Link Your Video</h2>
</div>

<div class="security_box">
    <form name="upload" id="upload" action="newfilm.php" class="dropzone">
    </form>
</div>

<div class="security_box"> 

	<form method="POST" action="formsubmit.php" id="new_project">
		<input type="hidden" name="function" value="new_project">

		<input type="text" id='new_video_link' name="video_link" data-validation="youtube" data-validation="required" placeholder="Video link to Youtube OR Vimeo"><br>
		
		<input type="hidden" id="runtime" name="runtime">

		<div class='display_video'>
			<iframe id="player1" class="preview-video" width="100%" height="540" frameborder="0" webkitallowfullscreen="1" mozallowfullscreen="1" allowfullscreen="1"></iframe>
		</div>

		<h3>Title:</h3>
		<input type="text" name="title" data-validation="required" data-validation="length" data-validation-length="max250"><br>

		<h3>Synopsis</h3>
		<input type="text" name="synopsis" data-validation="required" data-validation="length" data-validation-length="max250"><br>

		<input type="hidden" name="cover_image" id="cover_image" value="cover_image">
		<div class="display_cover_image">
			<img>
		</div>

		<h3>Collaborators</h3>
		<table id="new_collaborator">
			<tr>
				<td>First Name</td>
				<td>Last Name</td>
				<td>Role</td>
				<td>Email</td>
			</tr>
			<tr>
				<td>
					<input type="text" class="first_name" data-validation="required" name="collab[1][first_name]">
				</td>
				<td>
					<input type="text" class="last_name" data-validation="required" name="collab[1][last_name]">
				</td>
				<td>
					<input type="text" class="role" data-validation="required" name="collab[1][role]">
				</td>
				<td>
					<input type="text" class="email" data-validation="required" name="collab[1][email]">
				</td>
			</tr>
		</table>

		<select id="published" name="published">
			<option value="0">Save Draft</option>
			<option value="1">Publish</option>
		</select>

		<!-- hidden fields-->
		<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>"><br>
		<input type="hidden" name="active" value="1"><br>

		<input type="submit">
	</form>
</div>
	

	<script src="https://apis.google.com/js/client.js?onload=OnLoadCallback"></script>
	<script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
	<script>
		$.validate();

		
		// dropzone function
		var errors = false;
		var myDropzone = new Dropzone("#upload", {
			error: function(file, errorMessage) {
			    errors = true;
			},
			success: function(file, response ) {
			    console.log(file);
			    if(errors) {
			        console.log("There were errors!");
			   	} else {
			        console.log("We're done!");
			        var userid = $('input#user_id').val();
					var filepathstring = 'uploads/';
					var file_name = file['name'];
					var filepath = filepathstring + userid + '/'+ file_name;
					console.log(filepath);
					$('input[name=cover_image]').val(file_name);

					$('.display_cover_image > img').attr("src", 'uploads/'+<?php echo $user_id; ?>+'/'+file_name);
			    }
			}
		});

		




		// converting video time in seconds to hh:mm:ss
		function runtimeformat(seconds) {
			seconds = Math.round(seconds)
			//get time in hours and round down
			var hours = Math.floor(seconds / 3600);
			var minutes = Math.floor((seconds - (hours * 3600)) / 60);
			var seconds = seconds - ((hours * 3600) + (minutes * 60));
			var time = hours + ': '+ minutes + ':' + seconds;
			return time;
		}

		function appendResults(text) {
			var runtime = String(text);
			$('input#runtime').val(runtime);
			console.log(runtime);
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





		// remove collaborators
		function deleteRow(btn) {
			var rowcount = $('#edit_collaborator tr').length;
			var rowcurrent = rowcount -1;
			if(rowcurrent > 1){
				var row = btn.parentNode.parentNode;
		  		row.parentNode.removeChild(row);
			}
		}


	


		// do all the things
		$(document).ready(function(){

			// Increase collaborators as user inputs info
			$(document).on('blur',"#new_collaborator > tbody > tr:last > td > input.first_name", function(){
				if($("#new_collaborator > tbody > tr:last > td > input.first_name").val() != ''){

					// clone last row of table and empty its values
					$('#new_collaborator > tbody > tr:last').clone(true).insertAfter('#new_collaborator > tbody > tr:last');
					$('#new_collaborator > tbody > tr:last > td > input.first_name').val('');
					$('#new_collaborator > tbody > tr:last > td > input.last_name').val('');
					$('#new_collaborator > tbody > tr:last > td > input.role').val('');
					$('#new_collaborator > tbody > tr:last > td > input.email').val('');

					// get number of rows in table
					var rowcount = $('#edit_collaborator tr').length;
					var rowcurrent = rowcount -1;

					// name each field in [collab][current row number]['xxxxx'] format
					$('#new_collaborator > tbody > tr:last > td > input.first_name').attr('name', 'collab[' + rowcurrent + '][first_name]');
					$('#new_collaborator > tbody > tr:last > td > input.last_name').attr('name', 'collab[' + rowcurrent + '][last_name]');
					$('#new_collaborator > tbody > tr:last > td > input.role').attr('name', 'collab[' + rowcurrent + '][role]');
					$('#new_collaborator > tbody > tr:last > td > input.email').attr('name', 'collab[' + rowcurrent + '][email]');
					$('#new_collaborator > tbody > tr:last > td > button.remove').attr('name', 'collab[' + rowcurrent + '][remove]');
				}

			});

		});



	</script>

	<?php include('footer.php') ?>

	