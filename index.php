<?php include('header.php'); ?>

	<div id="content">
		<div class="banner">
		<video class="bannervideo" src="http://stack.soldevi.net/img/sae.mp4" autoplay loop> </video>
			
			<div class="blurb"> 
				<h3>ABOUT THE PROJECT </h3>
				<br></br>
				<div class="paragraph_about"> Welcome to doco-loco a place to share our student films with you, our community. Here you can watch short documentaries and films produced by SAE students, both local and abroad. Come and meet some of the characters that inspire us into action, the causes that need to be shown, and the issues that can't be ignored. 
This is also a shared space, and we need your feedback so, please rate and review our work.</div>


			</div>

		</div>

		<div id="film_content">
		</div>
<script>
$(document).ready(function(){

					console.log('Keypress!');
					
					$.ajax({
						type:"POST",
						url:"overlord.php",
						data:{
							function:'return_all_projects'
						},
						dataType:'json',
						success:function(res) {
							// loop through all film

							var counter = 1;

							var group = "content_left";
							var inner = 1;


 							$.each(res, function(index,value) {
 								console.log(counter);
 								if (group == "content_left") {
 									if (inner == 1) {
 										$("#film_content").append('<div class="content_left" id="content_left_'+counter+'"></div>');
 										$('#content_left_'+counter).append('<div class="film_large"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_large">'+value.title+'</div></a></div>');
 										inner++;
 									} else if (inner == 2) {
 										$('#content_left_'+counter).append('<div class="film_small"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_small">'+value.title+'</div></a></div>');
 										inner++
 									} else {
 										$('#content_left_'+counter).append('<div class="film_small"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_small">'+value.title+'</div></a></div>');
 										group = 'content_right'
 										inner = 1 
 									};

 								} else if (group == "content_right") {
 									if (inner == 1) {
 										$("#film_content").append('<div class="content_right" id="content_right_'+counter+'" ></div>');
 										$('#content_right_'+counter).append('<div class="film_small"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_small">'+value.title+'</div></a></div>');
 										inner++;

 									} else if (inner == 2) {
 										$('#content_right_'+counter).append('<div class="film_small"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_small">'+value.title+'</div></a></div>');
 										inner++;

 									} else {
 										$('#content_right_'+counter).append('<div class="film_large"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_large">'+value.title+'</div></a></div>');
 										group = 'content_bottom'
 										inner = 1 
 									};

 								} else {
 									if (inner == 1) {
 										$("#film_content").append('<div class="content_bottom" id="content_bottom_'+counter+'" ></div>');
 										$('#content_bottom_'+counter).append('<div class="film_medium"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_medium">'+value.title+'</div></a></div>');
 										inner++;
 									} else if (inner == 2) {
 										$('#content_bottom_'+counter).append('<div class="film_medium"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_medium">'+value.title+'</div></a></div>');
 										inner++;

 									} else {
 										$('#content_bottom_'+counter).append('<div class="film_medium"><a href="displayfilm.php?id='+value.id+'"><div class="film_thumbnail" style="background-image:url('+"'uploads/"+value.user_id+'/'+value.cover_image+"'"+')">'+'</div><div class="film_title_medium">'+value.title+'</div></a></div>');
 										group = 'content_left';
 										inner = 1;
 										counter++;
 									};

 								};



 								console.log(value);
 								//counter++;

 						//$("#film_content").append('<div class="film_small"><img src="'+value.cover_image+'"><div class="film_title_small">'+value.title+'</div></div>')
    					//$("#film_content").append('<div class="film_medium"><img src="'+value.cover_image+'"><div class="film_title_medium">'+value.title+'</div></div>')
						//$("#film_content").append('<div class="film_large"><img src="'+value.cover_image+'"><div class="film_title_large">'+value.title+'</div></div>')
							//counter = counter + 1 
							
							//counter = counter - 1
							//counter--

    							if(value['id'] == null){
									$('#film_content').html('');
 									$('#film_content').append("<p>Sorry there are no results</p>");
 								}	 
							});
								
							//$('#searchList').html(res);
						},
						error:function(req,text,error) {
							console.log('Oops!');
							console.log(req);
							console.log(text);
							console.log(error);
						}
					});
				});
		

	</script>
	

<?php include('footer.php'); ?>

