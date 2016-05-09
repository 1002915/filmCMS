<?php 
	require 'overlord.php';
	session_start();

	if (!isset($_SESSION['id'])) {
	   header('Location: index.php');
	} else {
		include('header.php');
	}

	include('uploader.php');

	$user_id = $_SESSION['id'];
	$film_id = $_GET['filmid'];
?>

<div class="filmdisplay_box"> 
	<h2>Edit Your Video</h2>
</div>

<div class="filmdisplay_box"> 

	<form method="POST" id="edit_project">
		<input type="hidden" name="function" value="update_project">
		<input type="hidden" name="target" value="<?php echo $film_id; ?>">

		<label for="edit_title">Title</label>
		<input type="text" id="edit_title" name="title" data-validation="required" data-validation="length" data-validation-length="max250">

		<label for="edit_video_link">Video</label>
		<input type="text" id='edit_video_link' name="video_link" data-validation="youtube" data-validation="required">

		<input type="hidden" id="edit_runtime" name="runtime">

		<div class='display_video'>
			<iframe id="player1" class="preview-video" width="100%" height="540" frameborder="0" webkitallowfullscreen="1" mozallowfullscreen="1" allowfullscreen="1"></iframe>
		</div>

		<label for="edit_synopsis">Synopsis</label>
		<input type="text" id="edit_synopsis" name="synopsis" data-validation="required" data-validation="length" data-validation-length="max250">

		<label id="label_cover" for="cover_image">Cover Image</label>
		<div class="cover_image">
			<div id="upload" class="dropzone display_cover_image">
				 <div class="dz-default"></div>
			</div>

			<input type="hidden" name="cover_image" id="cover_image" value="">
			<div class="display_cover_image actual_display">
				<img>
			</div>
		</div>

		<label class="collab_label">Contributors</label>
		<table id="edit_collaborator">
			<thead>
				<tr>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Role</td>
					<td>Email</td>
				</tr>
			</thead>
			<tr></tr>
		</table>

		<select id="edit_published" name="published">
			<option value="0">Save Draft</option>
			<option value="1">Publish</option>
		</select>

		<!-- hidden fields-->
		<input type="hidden" id="edit_user_id" name="user_id" value="<?php echo $user_id;?>">
		<input type="hidden" id="edit_active" name="active" value="1">
		<input type="submit">

		<input type="button" id="hide_project" class="hide_project" value="Delete Film">

	</form>
</div>
	

	<script src="https://apis.google.com/js/client.js?onload=OnLoadCallback"></script>
	<script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
	<script src="js/dropzone.js"></script>

	<script>

		var form = $('form#edit_project');
		$.validate({
			form : form,
		});

		// relevant film id
		var target = <?php echo $film_id; ?>;

		// return single project
		function return_project() {	
			$.ajax({
				type:"POST",
				url:"overlord.php",
				data:{
					function:'return_edit_project',
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
	 					$('input#cover_image').val(val['cover_image']);
	 					$('input#edit_published').val(val['published']);
	 					$('input#edit_user_id').val(val['user_id']);	 
	 					$('input#edit_active').val(val['active']);

	 					//display video from video link val
	 					var videolink = $('#edit_video_link').val();
					    var str = "youtube";
					    // if video was on youtube
						if(videolink.indexOf(str) > -1){
							var videolinkiframe = videolink.replace("watch?v=", "v/");
						} else {
							var videolinkiframe = videolink.replace("//", "//player.");
		    				var videolinkiframe = videolinkiframe.replace(".com", ".com/video");
		    				var videolinkiframe = videolinkiframe.concat("?api=1&player_id=player1");
						}
	 					$(".preview-video").attr("src", videolinkiframe);

	 					$('.display_cover_image > img').attr("src", 'uploads/'+val['user_id']+'/'+val['cover_image']);

						// add rows to table with collab values input
	 					var table 	= $('#edit_collaborator > tbody');
						var props 	= ["first_name", "last_name", "role", "email"];
						var fred 	= 1;

						$.each(val['collab'], function(i, val) {
							console.log(val);
						  	var tr = $('<tr>');

						  	$.each(props, function(i, prop) {
						   		$('<td>').html('<input type="text" data-validation="required" class="edit_'+prop+'" value="'+val[prop]+'" name="collab[' + fred + '][' + prop + ']">').appendTo(tr);
						  	});
						  	$('<td class="removerow">').html('<input type="button" id="remove" value="remove" name="collab[' + fred + '][remove]" onclick="deleteRow(this)">').appendTo(tr);
						  	fred++;
						  	table.append(tr);
						});

						var rowcount = $('#edit_collaborator tr').length;
						var rowlast = rowcount -1;
						var tr = $('<tr>');

						for(i = 0; i < 1; i++) {
							console.log(i);
							$.each(props, function(i , prop) {
								$('<td>').html('<input type="text" data-validation="required" class="edit_' + prop + '" name="collab[' + rowlast + '][' + prop + ']">').appendTo(tr);
							});
							$('<td class="removerow">').html('<input type="button" id="remove" value="remove" name="collab[' + rowlast + '][remove]" onclick="deleteRow(this)">').appendTo(tr);	
						}
						table.append(tr);


							
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
			$('input#edit_runtime').val($('input#edit_runtime').val() + text);
			console.log($('input#edit_runtime').val());
		}
		

		// load video after user inputs link
		$("#edit_video_link").on('input', function () {
		
		    var videolink = $('#edit_video_link').val();
		    var str = "youtube";
		    var str2 = "vimeo";

		    // if video was on youtube
			if(videolink.indexOf(str) > -1){
				var videolink1 = videolink.replace("watch?v=", "embed/");
				var values = videolink1.split('&feature');
				var videolinkiframe = values[0];
				console.log(videolinkiframe);

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

			} 

			if(videolink.indexOf(str2) > -1){
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

			else {
		    	var videolinkiframe = videolinkiframe.concat("");
		    }

		    $(".preview-video").attr("src", videolinkiframe);
		    $('#edit_video_link').val(videolinkiframe);
		});	






		// dropzone function
		Dropzone.autoDiscover = false;
	    $("#upload").dropzone({
	    	acceptedFiles: "image/jpeg, image/png",
	    	maxFiles: 1, // Number of files at a time
			maxFilesize: 2, //in MB
	        url: "editfilm.php",
	        addRemoveLinks: true,
	        success: function (file, response) {
	        	if (file.type == "image/jpeg" || file.type == "image/png") {
	            	var file_name = file['name'];
	            	file.previewElement.classList.add("dz-success");
	            	console.log('Successfully uploaded :' + file_name);
	            	file_name = file_name.replace(/\s+/g, '_');

		            $('input#cover_image').val(file_name);
					$('.display_cover_image > img').attr("src", 'uploads/'+<?php echo $user_id; ?>+'/'+file_name);
					console.log($('#cover_image').val());
					
	      		} else {
	       			alert('Sorry, you need to upload an image file! JPG AND PNG FILES ONLY! MAX FILE SIZE: 2MB')
	       		}
	        },
	        error: function (file, response) {
	            file.previewElement.classList.add("dz-error");
	            console.log('error')
	            alert('Sorry, you need to upload an image file! JPG AND PNG FILES ONLY! MAX FILE SIZE: 2MB')
	            this.removeFile(file)
	        }
	    });





		


		// remove collaborators
		function deleteRow(btn) {
			var rowcount = $('#edit_collaborator tr').length;
			var rowcurrent = rowcount -1;
			console.log(rowcurrent);
			if(rowcurrent > 2){
				var row = btn.parentNode.parentNode;
		  		row.parentNode.removeChild(row);
			}
		}



		function hide_project() {
			var active = 0;
			$.ajax({
				type: "POST",
				url: "overlord.php",
				data: {
					function: 'hide_project',
					target: target,
					active: active
				},
				success: function(res) {
					console.log('yay!!! success');
					window.location="index.php";
				}
		 	});
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
			console.log(form.serialize());

			$.ajax({
				type: "POST",
				url: "overlord.php",
				data: form.serialize(),
				//dataType: 'json',
				success:function(res){
					var published = $('select#edit_published').val();
					if(published == 0) {
						var location = "profile.php";
					} else {
						var editid = JSON.parse(res);
						var editid = res.replace(/\"/g, "");
						var location = 'displayfilm.php?id='+editid;

					}
					console.log(location);
					window.location=location;
					//console.log(res);

				},

			});
			
		}




		// do all the things
		$(document).ready(function(){ 
			return_project();

			var form = $('form#edit_project');
			form.on('submit', function(e){
				e.preventDefault();

				$('form').preventDoubleSubmission();

				if(($("#edit_collaborator > tbody > tr:last > td > input.edit_first_name").val() == '') && ($("#edit_collaborator > tbody > tr:last > td > input.edit_last_name").val() == '') && ($("#edit_collaborator > tbody > tr:last > td > input.edit_role").val() == '') && ($("#edit_collaborator > tbody > tr:last > td > input.edit_email").val() == '') ) {
					$('#edit_collaborator > tbody > tr:last', this).remove();
				}

				console.log($("#edit_collaborator > tbody > tr:last > td > input.edit_first_name").val());

				submit_form();
			})

			$('input#hide_project').on('click touch', function(e){
				e.preventDefault();
				hide_project();
			});


			// Increase collaborators as user inputs info
			$(document).on('blur',"#edit_collaborator > tbody > tr:last > td > input.edit_first_name", function(){
				if($("#edit_collaborator > tbody > tr:last > td > input.edit_first_name").val() != ''){

					// clone last row of table and empty its values
					$('#edit_collaborator > tbody > tr:last').clone(true).insertAfter('#edit_collaborator > tbody > tr:last');
					$('#edit_collaborator > tbody > tr:last > td > input.edit_first_name').val('');
					$('#edit_collaborator > tbody > tr:last > td > input.edit_last_name').val('');
					$('#edit_collaborator > tbody > tr:last > td > input.edit_role').val('');
					$('#edit_collaborator > tbody > tr:last > td > input.edit_email').val('');

					// get number of rows in table
					var rowcount = $('#edit_collaborator tr').length;
					var rowcurrent = rowcount -1;

					// name each field in [collab][current row number]['xxxxx'] format
					$('#edit_collaborator > tbody > tr:last > td > input.edit_first_name').attr('name', 'collab[' + rowcurrent + '][first_name]');
					$('#edit_collaborator > tbody > tr:last > td > input.edit_last_name').attr('name', 'collab[' + rowcurrent + '][last_name]');
					$('#edit_collaborator > tbody > tr:last > td > input.edit_role').attr('name', 'collab[' + rowcurrent + '][role]');
					$('#edit_collaborator > tbody > tr:last > td > input.edit_email').attr('name', 'collab[' + rowcurrent + '][email]');
					$('#edit_collaborator > tbody > tr:last > td > input#remove').attr('name', 'collab[' + rowcurrent + '][remove]');
				}
			});

		});

	</script>

	