<?php
// MAKES SURE THAT A PERSON IS LOGED IN OR NOT
	if (!isset($_SESSION['id'])) {
   		header('Location: index.php');
	} else {
		include('header.php');
	}
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
		
		<section id="details2">
			<div id="film_title" class="film_title">The Bunny Attack </div>
			<div class="student_name">Robertson Ave</div>
			<div class="campus">Brisbane Campus</div>
		</section>
		<section id="rating"> 
			<div class="star" id="star1"></div>
			<div class="star" id="star2"></div>
			<div class="star" id="star3"></div>
			<div class="star" id="star4"></div>
			<div class="star" id="star5"></div>
		</section>
	</section>

	<section id="synopsis">
		<p>In a futuristic world where bunnies have multiplied like a plague and evolved like pokemons are trying to rule and destroy every human and easter leftovers.  </p>
	</section>
	<section id="contributors">
		<div class="contributors_title">Contributors</div>
		<div class="contributor1">Blue Glue</div>
	</section>
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
			<input type='text' name='feedback_1' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>How would you describe the quality of the cinematography?</p>
			<input type='text' name='feedback_2' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>How would you describe the quality of the audio?</p>
			<input type='text' name='feedback_3' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>How did the editing/structure of this documentary help establish character and plot?</p>
			<input type='text' name='feedback_4' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<p>What were the most & least engaging elements of this documentary and why?</p>
			<input type='text' name='feedback_5' placeholder='Please place your answer here...' class='aca_form_input'>
			<br>
			<input type='submit' value='submit' id='submit'>
		</div>
<?php } ?>

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
 					//$('#contributors').html(value.title);
 					$('#synopsis').html('<p>'+value.synopsis+'</p>');

 					for(var i=1;i < value.rating;i++) {
 						$("#star"+i).addClass("star_full");
 					} 

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

	// ACADEMIC FORM
	$('#aca_form').hide();
	$('#aca_form_button').on ('click touch', function() {
		$('#aca_form').show();
		$('#aca_form').scrollView();
	});

	//SENDING THE FORM INFORMATION TO THE OVERLORD FILE
	function academic_form() {
		console.log('academic form in process!');
			var feedback_1 = $('#feedback_1').val();
			var feedback_2 = $('#feedback_2').val();
			var feedback_3 = $('#feedback_3').val();
			console.log(feedback_1);
			console.log(feedback_2);
			console.log(feedback_3);
			$.ajax({
				type:"POST",
				url:"overlord.php",
				data:{
					function:'add_academic_feedback',
					target:search,// this is a combination of (what is variable links to the overlord):(what varible you are trying to trigger the function named in the current file {above variable})
					feedback_1:feedback_1,
					feedback_2:feedback_2,
					feedback_3:feedback_3
				},
				dataType:'json',
				success:function(res) {
					// LOOP THROUGH THE DATA IN THE DATABASE IF SOMEONE SEARCHES SOMETHING
					$('#aca_form').html('');
					$('#aca_form').append('<p>thank you for your feedback.</p>');
				}
			}
	}

			$(document).ready(function(){ 

				$("#submit").on('click touch', function() {
					academic_form();
				});
				
			});
</script>

