<?php include('header.php'); ?>

	<div id="content">
		<div class="banner">
			<img src="" alt/>
			<div class="blurb"> 
				<h3>ABOUT THE PROJECT </h3>
				<br></br>
				<p>  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet fermentum lectus, 
					eget blandit justo. Duis libero est, tempor et felis at, scelerisque ultricies odio. 

Cposuere. Curabitur elementum est vitae leo vehicula, id rutrum leo luctus. Aenean sit amet odio et nisi pharetra efficitur 
nec vel nulla. Donec dolor neque, semper sodales metus ac, feugiat efficitur mi. 
Etiam in dui nulla. Nullam ac nunc mauris.putate in luctus vel, congue id augue.</p>
				<p>Nam dolor mauris, pellentesque vitae tellus id, tincidunt venenatis sapien. 
					Morbi vitae pretium mauris, vitae cursus est. Mauris sagittis felis est, vitae posuere neque 
					maximus eget. Sed pharetra felis fringilla rhoncus suscipit. Vivamus varius, tellus nec mattis 
					rutrum, elit libero sollicitudin nibh, in lobortis nisl magna vitae leo. Morbi interdum metus 
					ac mi laoreet lacinia. Morbi bibendum mauris sapien, eu posuere risus ornare vel.</p>

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
 										$("#film_content").append('<div class="content_left" id="content_left_'+counter+'" ></div>');
 										$('#content_left_'+counter).append('<div class="film_large"><img src="'+value.cover_image+'"><div class="film_title_large">'+value.title+'</div></div>');
 										inner++;
 									} else if (inner == 2) {
 										$('#content_left_'+counter).append('<div class="film_small"><img src="'+value.cover_image+'"><div class="film_title_small">'+value.title+'</div></div>');
 										inner++
 									} else {
 										$('#content_left_'+counter).append('<div class="film_small"><img src="'+value.cover_image+'"><div class="film_title_small">'+value.title+'</div></div>');
 										group = 'content_right'
 										inner = 1 
 									};

 								} else if (group == "content_right") {
 									if (inner == 1) {
 										$("#film_content").append('<div class="content_right" id="content_right_'+counter+'" ></div>');
 										$('#content_right_'+counter).append('<div class="film_small"><img src="'+value.cover_image+'"><div class="film_title_small">'+value.title+'</div></div>');
 										inner++;

 									} else if (inner == 2) {
 										$('#content_right_'+counter).append('<div class="film_small"><img src="'+value.cover_image+'"><div class="film_title_small">'+value.title+'</div></div>');
 										inner++;

 									} else {
 										$('#content_right_'+counter).append('<div class="film_large"><img src="'+value.cover_image+'"><div class="film_title_large">'+value.title+'</div></div>');
 										group = 'content_bottom'
 										inner = 1 
 									};

 								} else {
 									if (inner == 1) {
 										$("#film_content").append('<div class="content_bottom" id="content_bottom_'+counter+'" ></div>');
 										$('#content_bottom_'+counter).append('<div class="film_medium"><img src="'+value.cover_image+'"><div class="film_title_medium">'+value.title+'</div></div>');
 										inner++;
 									} else if (inner == 2) {
 										$('#content_bottom_'+counter).append('<div class="film_medium"><img src="'+value.cover_image+'"><div class="film_title_medium">'+value.title+'</div></div>');
 										inner++;

 									} else {
 										$('#content_bottom_'+counter).append('<div class="film_medium"><img src="'+value.cover_image+'"><div class="film_title_medium">'+value.title+'</div></div>');
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

