<?php session_start();

if (!isset($_SESSION['id'])) {

    header('Location: index.php');

} else {

include('header.php');


$user_id = $_SESSION['id'];

json_encode($user_id);

$film_id = 'testID';


?>

<div class="error_box"></div> 
    <div class="security_box">My details</div>
    <div class="security_box">

        <form name="registerForm" method="post" class="toggle-disabled" action="updateuser.php">
            <input name='first_name' type='text' data-validation="length required" data-validation-length="min2" data-validation-error-msg="Please enter your first name" value="<?php echo $_SESSION['first_name']; ?>"placeholder="first Name" maxlength="50" /><br/>
            <input name='last_name' value="<?php echo $_SESSION['last_name']; ?>" type='text' data-validation="length required" data-validation-length="min2" placeholder="Last Name" data-validation-error-msg="Please enter your last name" maxlength="50" /><br/>
            <input name="email" type="text" value="<?php echo $_SESSION['email']; ?>" data-validation="email" placeholder="email address" data-validation-error-msg="Please enter your SAE email address" maxlength="50" /><br/>
            
            <select class="styled_select" name="campus_id" data-validation="required">
                <option value="">Select Campus</option>
                <option value="1" name="1">Brisbane</option>
                <option value="2" name="2">Byron Bay</option>
                <option value="3" name="3">Sydney</option>
                <option value="4" name="4">Adelaide</option>
                <option value="5" name="5">Melbourne</option>
                <option value="6" name="6">Perth</option>
                <option value="7" name="7">Online</option>
            </select><BR><BR>
            
            <input id="SubmitButton" type='submit' name='Submit' value='Submit' />

</form><BR>
</div>
<div class="project_profile">
   
</div>
 <script>
$(document).ready(function(){
                    var target = <?php echo json_encode($user_id)?>;
                    $.ajax({
                        type:"POST",
                        url:"overlord.php",
                        data:{
                            function:'return_user_project',
                            target: target
                        },
                        dataType:'json',
                        success:function(res) {
                            // loop through all film
                            $.each(res, function(index,value) {
                                console.log(value);
                                $('.project_profile').append( "<img src='uploads/<?php echo $_SESSION['id'] ?>/"+value['cover_image']+"'class='cover_image_profile' alt='cover_image'> <BR><p>"+value['title']+"</p>"+"<BR>"+"<form action='editfilm.php' method='GET'>" + "<input type='hidden' name='filmid' value='"+value['id']+"'> <input type='submit' value='edit'> </form>" );

                            });
                        },
                        error:function(req,text,error) {
                            console.log('Oops!');
                            console.log(req);
                            console.log(text);
                            console.log(error);
                        }
                    });
                });
        

        $.validate();
  $.validate({
    modules : 'security'
  });


    </script>




<?php include('footer.php'); };?>