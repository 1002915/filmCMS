<?php include('header.php');?>

<div class="error_box"></div> 
    <div class="security_box">My details

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
            <input class="checkbox" type="checkbox" data-validation="required" data-validation-qty="min 1" name="accept" value="accept"> 
            I have selected the correct campus AND entered in the correct details. I also agree to the terms and conditions.<br><BR>
            <input id="SubmitButton" type='submit' name='Submit' value='Submit' />

</form><BR>

<script src="js/jquery-2.2.2.min.js"></script>
<script src="js/form-validator/jquery.form-validator.js"></script>

<script>
$.validate();
  $.validate({
    modules : 'security'
  });

 
</script>


</div>
<img src="<?php echo $_SESSION['user_photo'];?>" class="cover_image_profile">

<div class="security_box">
    <form name="upload" id="upload" action="upload.php" class="dropzone"></form>
</div>

<?php include('footer.php'); ?>