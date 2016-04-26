<?php include('header.php');?>

<div class="error_box">  </div>
<div class="flexbox_center">

            <div class="container_register" >
                <header class="popupHeader">
                    <span class="header_title">REGISTER</span><BR><BR>
<!-- BEGIN REGISTER FORM -->
                       <div class="user_register_main">
                            <form name="registerForm" method="post" class="toggle-disabled" action="registeruser.php">
                                <input name='first_name' type='text' data-validation="length required" data-validation-length="min2" data-validation-error-msg="Please enter your first name" placeholder="first Name" maxlength="50" /><br/>
                                <input name='last_name' type='text' data-validation="length required" data-validation-length="min2" placeholder="Last Name" data-validation-error-msg="Please enter your last name" maxlength="50" /><br/>
                                <input name="email" type="text" data-validation="email" placeholder="email address" data-validation-error-msg="Please enter your SAE email address" maxlength="50" /><br/>
                                <input name="pass_confirmation" type="password" data-validation="length" data-validation-length="min8"  data-validation-error-msg="Please enter a password using at least eight alphanumeric characters long"placeholder="password" maxlength="50" /><br/>
                                    <select name="campus_id"class="styled_select" data-validation="required">
                                        <option value="">Select Campus</option>
                                        <option value="1" name="1">Brisbane</option>
                                        <option value="2" name="2">Byron Bay</option>
                                        <option value="3" name="3">Sydney</option>
                                        <option value="4" name="4">Adelaide</option>
                                        <option value="5" name="5">Melbourne</option>
                                        <option value="6" name="6">Perth</option>
                                        <option value="7" name="7">Online</option>
                                    </select><BR><BR>
                                    <div class="float">
                                        <a href="#" class="btn loginform"><i class="fa fa-angle-double-left"></i> Back</a>
                                        <input id="SubmitButton" class="popup_button big" type='submit' name='Submit' value='Register' />
                                    </div>
                            </form><BR>
                        </div>
                    </section>
          
    </div>
</div>

<script src="js/jquery-2.2.2.min.js"></script>
<script src="js/form-validator/jquery.form-validator.js"></script>

<script>
$.validate();
  $.validate({
    modules : 'security'
  });

 
</script>
</div>
<?php include('footer.php'); ?>
