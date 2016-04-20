<?php
// MAKES SURE THAT A PERSON IS LOGED IN OR NOT
	session_start();
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

	<div class="hide_film">
		<label for="edit_active">Hide film</label>
		<?php
			if($user_type == 1) {
			?>	
				<div class="slideThree">	
					<input type="checkbox" value="0" id="slideThree" name="check" />
					<label for="slideThree"></label>
				</div>
			<?php
			}
		?>
	</div>

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
 					//$('#contributors').html(value.title);
 					$('#synopsis').html('<p>'+value.synopsis+'</p>');

 					for(var i=1;i < value.rating;i++) {
 						$("#star"+i).addClass("star_full");
 					} 

 					if(value.active == 0){
 						$("input[type='checkbox']" ).prop( "checked", "true");
 						console.log($( "input[type='checkbox']" ).prop('checked'));
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
			var user_id = <?php echo $user_id?>;
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
		$("#submit").on('click touch', function() {
			academic_form();
		});

		$('.slideThree label').on('click touch', function() {
			hide_project();
		});
	});


</script>

