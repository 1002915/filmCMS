<?php
	session_start();

	if (!isset($_SESSION['id'])) {
	   header('Location: index.php');
	} else {
		include('header.php');
	}
	include('uploader.php');

	$user_id = $_SESSION['id'];
?>

<div class="filmdisplay_box"> 
	<h2>Link Your Video</h2>
</div>

<div class="filmdisplay_box"> 
	<form id="new_project" method="POST" action="">
		<input type="hidden" name="function" value="new_project">

		<label for="title">Title</label>
		<input type="text" name="title" id="title" data-validation="required" data-validation="length" data-validation-length="max250">

		<label for="video_link">Video</label>
		<input type="text" id='new_video_link' name="video_link" id="video_link" data-validation="youtube" data-validation="required" placeholder="Video link to Youtube OR Vimeo">
		
		<input type="hidden" id="runtime" name="runtime">

		<div class='display_video'>
			<iframe id="player1" class="preview-video" width="100%" heigh="0"frameborder="0" webkitallowfullscreen="1" mozallowfullscreen="1" allowfullscreen="1"></iframe>
		</div>

		<label for="synopsis">Synopsis</label>
		<input type="text" name="synopsis" id="synopsis" data-validation="required" data-validation="length" data-validation-length="max250"><br>


		<label id="label_cover" for="cover_image">Cover Image</label>
		<div class="cover_image">
			<div id="upload" class="dropzone display_cover_image">
				 <div class="dz-default"></div>
			</div>

			<input type="hidden" name="cover_image" id="cover_image" value="cover_image">
			<div class="display_cover_image actual_display">
				<img>
			</div>
		</div>

		<label class="collab_label">Contributors</label>
		<table id="new_collaborator">
			<thead>
				<tr>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Role</td>
					<td>Email</td>
				</tr>
			</thead>
			<tr>
				<td>
					<input type="text" class="first_name" id="first_name-1" data-validation="required" name="collab[1][first_name]" placeholder="First Name">
				</td>
				<td>
					<input type="text" class="last_name" id="last_name-1" data-validation="required" name="collab[1][last_name]" placeholder="Last Name">
				</td>
				<td>
					<input type="text" class="role" id="role-1" data-validation="required" name="collab[1][role]" placeholder="Role">
				</td>
				<td>
					<input type="text" class="email" id="email-1" data-validation="required" name="collab[1][email]" placeholder="Email">
				</td>
				<td>
					<input type="button" id="remove" value="remove" name="collab[1][remove]" onclick="deleteRow(this)">
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
		
		var form = $('form#new_project');
		$.validate({
			form : form,
		});





		// dropzone function
		Dropzone.autoDiscover = false;
	    $("#upload").dropzone({
	    	acceptedFiles: "image/jpeg",
	        url: "editfilm.php",
	        maxFiles: 1, // Number of files at a time
			maxFilesize: 1, //in MB
	        addRemoveLinks: true,
	        maxfilesexceeded: function(file) {
				alert('You have uploaded more than 1 Image. Only the first file will be uploaded!');
			},
	        success: function (file, response) {
	            var file_name = file['name'];
	            file.previewElement.classList.add("dz-success");
	            console.log('Successfully uploaded :' + file_name);
	            $('input[name=cover_image]').val(file_name);
	            file_name = file_name.replace(/\s+/g, '_');
				$('.display_cover_image > img').attr("src", 'uploads/'+<?php echo $user_id; ?>+'/'+file_name);
	        },
	        error: function (file, response) {
	            file.previewElement.classList.add("dz-error");
	            console.log('error')
	        },
	        init: function() {
   				this.on("addedfile", function() {
     				if (this.files[1]!=null){
       					this.removeFile(this.files[0]);
     				}
   				});
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
			$('#player1').attr('height', '540');

		    var videolink = $('#new_video_link').val();

		    var str = "youtube";

		    // if video was on youtube
			if(videolink.indexOf(str) > -1){
				var videolinkiframe = videolink.replace("watch?v=", "embed/");

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
			var rowcount = $('#new_collaborator tr').length;
			var rowcurrent = rowcount -1;
			if(rowcurrent > 1){
				var row = btn.parentNode.parentNode;
		  		row.parentNode.removeChild(row);
			}
		}



		jQuery.fn.preventDoubleSubmission = function() {
  		$(this).on('submit',function(e){
		    var form = $(this);

		    if (form.data('submitted') === true) {
		      // Previously submitted - don't submit again
		      e.preventDefault();
		    } else {
		      // Mark it so that the next submit can be ignored
		      form.data('submitted', true);
		    }
		  });

		  // Keep chainability
		  return this;
		};



		function submit_form() {

			/*
			var mega_array = [];
			$('.first_name').each(function() {
				var tempArray = [];
				var rowId = $(this).attr('id').split('-')[1];
				tempArray.first_name = $('#first_name-'+rowId).val();
				tempArray.last_name = $('#last_name-'+rowId).val();
				tempArray.role = $('#role-'+rowId).val();
				tempArray.email = $('#email-'+rowId).val();
				mega_array.push(tempArray);
			});
			*/

			$.ajax({
				type: "POST",
				url: "overlord.php",
				data: form.serialize(),
				success:function(res){
					var published = $('select#published').val();
					if(published == 0) {
						var location = "profile.php";
					} else {
						var location = "displayfilm.php?id="+res;
					}
					window.location=location;
				},
				error:function(res){
					console.log(res);
				}
			});
			
		}



		// do all the things
		$(document).ready(function(){
			var form = $('form#new_project');

			form.on('submit', function(e){
				e.preventDefault();

				$('form').preventDoubleSubmission();

				if(($("#new_collaborator > tbody > tr:last > td > input.first_name").val() == '') && ($("#new_collaborator > tbody > tr:last > td > input.last_name").val() == '') && ($("#new_collaborator > tbody > tr:last > td > input.role").val() == '') && ($("#new_collaborator > tbody > tr:last > td > input.email").val() == '') ) {
					$('tr:last', this).remove();
				}

				submit_form();
			})


			// Increase collaborators as user inputs info
			$(document).on('blur',"#new_collaborator > tbody > tr:last > td > input.first_name", function(){
				console.log('blur');
				if($("#new_collaborator > tbody > tr:last > td > input.first_name").val() != ''){

					// clone last row of table and empty its values
					$('#new_collaborator > tbody > tr:last').clone(true).insertAfter('#new_collaborator > tbody > tr:last');
					$('#new_collaborator > tbody > tr:last > td > input.first_name').val('');
					$('#new_collaborator > tbody > tr:last > td > input.last_name').val('');
					$('#new_collaborator > tbody > tr:last > td > input.role').val('');
					$('#new_collaborator > tbody > tr:last > td > input.email').val('');

					// get number of rows in table
					var rowcount = $('#new_collaborator tr').length;
					var rowcurrent = rowcount -1;
					console.log(rowcurrent);

					// name each field in [collab][current row number]['xxxxx'] format
					$('#new_collaborator > tbody > tr:last > td > input.first_name').attr('name', 'collab[' + rowcurrent + '][first_name]');
					$('#new_collaborator > tbody > tr:last > td > input.last_name').attr('name', 'collab[' + rowcurrent + '][last_name]');
					$('#new_collaborator > tbody > tr:last > td > input.role').attr('name', 'collab[' + rowcurrent + '][role]');
					$('#new_collaborator > tbody > tr:last > td > input.email').attr('name', 'collab[' + rowcurrent + '][email]');
					$('#new_collaborator > tbody > tr:last > td > input#remove').attr('name', 'collab[' + rowcurrent + '][remove]');

					// edit id for each row
					$('#new_collaborator > tbody > tr:last > td > input.first_name').attr('id', 'first_name-' + rowcurrent);
					$('#new_collaborator > tbody > tr:last > td > input.last_name').attr('id', 'last_name-' + rowcurrent);
					$('#new_collaborator > tbody > tr:last > td > input.role').attr('id', 'role-' + rowcurrent);
					$('#new_collaborator > tbody > tr:last > td > input.email').attr('id', 'email-' + rowcurrent);
				}
			});
		});
	</script>

	<?php include('footer.php') ?>

	