<?php
// MAKES SURE THAT A PERSON IS LOGED IN OR NOT
	session_start();
	$user_type = 0;

	include('header.php');
	if (isset($_SESSION['id'])){
		$user_id = $_SESSION['id'];
		$user_type = $_SESSION['user_type'];
	}
	
?>

<div id="displayvideo">
	
	<iframe id="video" width="100%" height="450" frameborder="0" allowfullscreen></iframe>

	<section id="details">
		
		<section id="details2">
			<div id="film_title" class="film_title"></div>
			<div id="campus" class="campus"></div>
		</section>
		<section id="rating"> 
			<input type="radio" name="rating" class="star" id="star5" value="5">
			<input type="radio" name="rating" class="star" id="star4" value="4">
			<input type="radio" name="rating" class="star" id="star3" value="3">
			<input type="radio" name="rating" class="star" id="star2" value="2">
			<input type="radio" name="rating" class="star" id="star1" value="1">
		</section>
	</section>

	<section id="synopsis">
	</section>
	<section id="contributors">
		<div class="contributors_title">Contributors</div>
		<table id="display_collaborators">
			<thead>
				<tr>
					<td>Role</td>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Email</td>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</section>

	<?php
		if($user_type == 1) {
	?>	
		<div class="hide_film">
			<label id="hide" for="edit_active">Hide film</label>
			<div class="slideThree">	
				<input type="checkbox" value="0" id="slideThree" name="check" />
				<label for="slideThree"></label>
			</div>
		</div>
	<?php
		}
	?>
	
</div>
<!-- ACADEMIC FORM -->
<?php
// MAKES SURE THAT A PERSON IS LOGED IN OR NOT
	if (!isset($_SESSION['id'])) {
		echo('');

	} else { ?>
		<div id='aca_form_button'>
			Please leave some academic feedback
		</div>

		<div id='aca_form'>
			<h1> Academic Feedback Form</h1><br><br>
			<p>What was the filmmakers objective when making this documentary?</p>
			<input type='text' name='feedback_1' id='feedback_1' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>How would you describe the quality of the cinematography?</p>
			<input type='text' name='feedback_2' id='feedback_2' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>How would you describe the quality of the audio?</p>
			<input type='text' name='feedback_3' id='feedback_3' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>How did the editing/structure of this documentary help establish character and plot?</p>
			<input type='text' name='feedback_4' id='feedback_4' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>What were the most & least engaging elements of this documentary and why?</p>
			<input type='text' name='feedback_5' id='feedback_5' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<input type='button' value='submit' id='submit'>
		</div>
<?php } 

include('footer.php');

?>

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
 					$('#campus').html(value.campus);

 					// check star with rating
 					var rating = Math.round(value.average_rating);
 					$("#star"+rating).prop('checked', true);
 					

 					// adjust hide project switch if film is inactive
 					if(value.active == 0){
 						$("input[type='checkbox']" ).prop( "checked", "true");
 						console.log($( "input[type='checkbox']" ).prop('checked'));
 					}

 					// add rows to table with collab values input
	 				var table 	= $('#display_collaborators > tbody');
					var props 	= ["role", "first_name", "last_name", "email"];
					var fred 	= 1;

					$.each(value['collab'], function(i, val) {
						var tr = $('<tr>');
						$.each(props, function(i, prop) {
						   	$('<td>').html(val[prop]).appendTo(tr);
						});
						fred++;
						table.append(tr);
					});



					var videolink = value.video_link;

				    var str = "youtube";

				    // if video was on youtube
					if(videolink.indexOf(str) > -1){
						var videolinkiframe = videolink.replace("watch?v=", "/embed");

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
	return_project();
	
	//});

	// ACADEMIC FORM
	function scrollWin() {
		$('body').animate({
			scrollTop: $('#aca_form').offset().top
		},1000);
    }


	$('#aca_form').hide();
	$('#aca_form_button').on ('click touch', function() {
		$('#aca_form').show();
		scrollWin();
	});

	//SENDING THE FORM INFORMATION TO THE OVERLORD FILE
	function academic_form() {
		console.log('academic form in process!');
			var feedback_1 = $('#feedback_1').val();
			var feedback_2 = $('#feedback_2').val();
			var feedback_3 = $('#feedback_3').val();
			var feedback_4 = $('#feedback_4').val();
			var feedback_5 = $('#feedback_5').val();
			var film_id = <?php echo $_GET['id']?>;
			var user_id = 
			<?php 
				if(isset($_SESSION['id'])) {
					echo $user_id;
				} else {
					echo '';
				}
			?>
				
			console.log(feedback_1);
			console.log(feedback_2);
			console.log(feedback_3);
			console.log(feedback_4);
			console.log(feedback_5);
			$.ajax({
				type:"POST",
				url:"overlord.php",
				data:{
					function:'add_academic_feedback',
					target:film_id,// this is a combination of (what is variable links to the overlord):(what varible you are trying to trigger the function named in the current file {above variable})
					user_id:user_id,
					feedback_1:feedback_1,
					feedback_2:feedback_2,
					feedback_3:feedback_3,
					feedback_4:feedback_4,
					feedback_5:feedback_5
				},
				//dataType:'json',
				success:function(res) {
					// LOOP THROUGH THE DATA IN THE DATABASE IF SOMEONE SEARCHES SOMETHING
					$('#aca_form').html('');
					$('#aca_form').append('<p>Thank you for your feedback.</p>');
				}
			});
	}

	function hide_project() {
		var film_id = <?php echo $_GET['id']?>;
		if($("input[type='checkbox']" ).prop("checked")){
			var active = 1;
		} else {
			active = 0;
		}
		console.log(active);
		$.ajax({
			type: "POST",
			url: "overlord.php",
			data: {
				function: 'hide_project',
				target: film_id,
				active: active
			},
			dataType : 'json',
			success: function(res) {
				console.log('yay!!! success');
			}
	 	});

	}


	$(document).ready(function(){ 
		//$('#aca_form').validate();
		$("#aca_form #submit").on('click touch', function() {
			academic_form();
		});

		$('.slideThree label').on('click touch', function() {
			hide_project();
		});

		$('input.star').on('click touch', function(){

			var rating = $(this).val();
			console.log(rating);
			//var rating = $(this).val();
			var target = <?php echo $_GET['id']?>;
			var ip = 'hjhjhj';

			$.ajax({
				type: "POST",
				url: "overlord.php",
				data: {
					function: 'add_rating',
					target: target,
					rating: rating,
					ip: ip
				},
				dataType : 'json',
				success: function(res) {
					console.log('yay!!! success');
				},
				error: function(res){
					console.log(res);
				}
			 });
			
		});

	});


</script>

