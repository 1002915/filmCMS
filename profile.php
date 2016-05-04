<?php session_start();

if (!isset($_SESSION['id'])) {

    header('Location: index.php');

} else {

include('header.php');

$user_id = $_SESSION['id'];

//json_encode($user_id);

$film_id = 'testID';

$campus_id = $_SESSION['campus_id'];

$user_type = $_SESSION['user_type'];

$selected = 'selected="selected"';

?>

<div class="profile_left">
<div class="security_box">
    <form method="post" action="newfilm.php">
    <input type="submit" class="long_button" value="Upload new film">
</form>
</div>
    <div class="security_box">My details</div>
    <div class="security_box">
        <form name="registerForm" method="post" class="toggle-disabled" action="updateuser.php">
            <input name='first_name' type='text' data-validation="length required" data-validation-length="min2" data-validation-error-msg="Please enter your first name" value="<?php echo $_SESSION['first_name']; ?>"placeholder="first Name" maxlength="50" /><br/>
            <input name='last_name' value="<?php echo $_SESSION['last_name']; ?>" type='text' data-validation="length required" data-validation-length="min2" placeholder="Last Name" data-validation-error-msg="Please enter your last name" maxlength="50" /><br/>
            <input name="email" type="text" value="<?php echo $_SESSION['email']; ?>" data-validation="email" placeholder="email address" data-validation-error-msg="Please enter your SAE email address" maxlength="50" /><br/>
            <select class="styled_select" name="campus_id" id='campus_selection_teacher' data-validation="required">
                <option value="">Select Campus</option>
                <option value="1" <?php if($_SESSION['campus_id'] == 1) {echo $selected;} ?>name="1">Brisbane</option>
                <option value="2" <?php if($_SESSION['campus_id'] == 2) {echo $selected;} ?>name="2">Byron Bay</option>
                <option value="3" <?php if($_SESSION['campus_id'] == 3) {echo $selected;} ?>name="3">Sydney</option>
                <option value="4" <?php if($_SESSION['campus_id'] == 4) {echo $selected;} ?>name="4">Adelaide</option>
                <option value="5" <?php if($_SESSION['campus_id'] == 5) {echo $selected;} ?>name="5">Melbourne</option>
                <option value="6" <?php if($_SESSION['campus_id'] == 6) {echo $selected;} ?>name="6">Perth</option>
                <option value="7" <?php if($_SESSION['campus_id'] == 7) {echo $selected;} ?>name="7">Online</option>
            </select><BR><BR>
            <input id="SubmitButton" onclick="this.disabled=true;this.value='updating...'; this.form.submit();"type='submit' name='Submit' value='Submit' />
        </form><BR>
    </div>
</div>
<div class="profile_right">
<?php if($user_type == 1) { ?>
<div class="security_box">
    <form method="POST" action="overlord.php">
    <input type="hidden" name="function" value="return_academic_feedback">
    <input type="hidden" name="target" value="<?php echo $_SESSION['campus_id']; ?>">
    <input type="submit" class="long_button" value="Get academic Feedback">
</form>
</div>
<?php }; ?>

<div class="placeholder">
</div>

<div id='student_films'></div>

 <script>
$(document).ready(function(){
    

    console.log('ssd');
    var target = <?php echo $user_id; ?>;
                    
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
        
        $('.placeholder').append( "<div class='profile_edit_box'><div class='edit_title'>"+value['title']+"</div><a href='editfilm.php?filmid="+value['id']+"'>"+"<div class='edit_film_button'></div><div class=''>"+value['collaborators.first_name']+"</div>");

                            });
                        },
                        error:function(req,text,error) {
                            console.log('Oops!');
                            console.log(req);
                            console.log(text);
                            console.log(error);
                        }
                    });

 console.log('student films per capmus');
            var campus_selection = $('#campus_selection_teacher').val();
            var search = '';
            console.log(campus_selection);
            //if (capmus_selection != '') {
                $.ajax({
                    type:"POST",
                    url:"overlord.php",
                    data:{
                        function:'search_project',
                        target:search,
                        campus:campus_selection
                    },
                    dataType:'json',
                    success:function(res) {
                        console.log(res);
                        // LOOP THROUGH THE DATA IN THE DATABASE IF SOMEONE SEARCHES SOMETHING
                        $('#student_films').html('');
                        var count = 0;
                        $.each(res, function(index,value) {
                            if(value['id'] != null){
                                console.log(value);
                                var rating = parseInt(value['average_rating']);
                               var decimal = rating.toFixed(1);
                                $('#student_films').append("<div class='search_product_teacher'><a href='displayfilm.php?id="+value['id']+"'><p class='film_title_search text_width'>"+value['title']+"</p></a><div class''><p>Current Rating:</p>"+decimal+"</div>");
                                // WHEN THE CONENT IS NOT IN THE DATABASE
                            
                                count++;        
                            }
                        });
                        $('#student_films').append( "<div class='clear_float'></div>");
                        if (count < 1){
                            $('#student_films').html('');
                            $('#student_films').append("<p class='empty_search'>Sorry there are no results</p>");
                        }
                        
                    }
                });
            /*} else {
                $('#student_films').html('');
            }*/

    });
        

        $.validate();
  $.validate({
    modules : 'security'
  });

  // MAKEING LECTURES SEE STUDENT PER CAMPUS 

</script>
</div>
<?php include('footer.php'); };?>