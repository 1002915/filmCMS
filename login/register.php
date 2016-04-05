<h2>Register</h2>
<div id="email-error-dialog"></div>
<form   id="registerForm"
        name="registerForm" 
        method="post" 
        class="toggle-disabled" 
        action="registeruser.php">
    
    <input  id='first_name' 
            name='first_name' 
            type='text' 
            data-validation="length required"
            data-validation-length="min3"
            data-validation-error-msg="Please enter your first name"
            placeholder="first Name" 
            maxlength="50" /><br/>
    
    <input  id='last_name'
            name='last_name' 
            type='text' 
            data-validation="length required" 
            data-validation-length="min3"
            placeholder="Last Name" 
            data-validation-error-msg="Please enter your last name"
            maxlength="50" /><br/>
    
    <input  id="email"
            name="email"
            type="text" 
            data-validation="email"
            placeholder="email address" 
            maxlength="50" /><br/>

    <input  id="password"
            name="pass_confirmation"
            type="password" 
            data-validation="length" 
            data-validation-length="min8"  
            data-validation-error-msg="Please enter a password using at least eight alphanumeric characters long"           
            placeholder="password" 
            maxlength="50" /><br/>

    <input  id='passwordconfirm'
            name='pass'
            type='password' 
            data-validation="confirmation"
            placeholder="confirm password" 
            maxlength="50" /><br/>

            <select name="campus_id" id="campus_id" data-validation="required">
                <option value="">Select Campus</option>
                <option value="1" name="1">Brisbane</option>
                <option value="2" name="2">Byron Bay</option>
                <option value="3" name="3">Sydney</option>
                <option value="4" name="4">Adelaide</option>
                <option value="5" name="5">Melbourne</option>
                <option value="6" name="6">Perth</option>
                <option value="7" name="7">Online</option>
            </select><BR>

    <input  id="accept"
            type="checkbox" 
            data-validation="required" 
            data-validation-qty="min 1"
            name="accept" 
            value="accept"> I have selected the correct campus AND entered in the correct details. I also agree to the terms and conditions.<br>

    <input id="SubmitButton" type='submit' name='Submit' value='Submit' />

</form><BR>

<script src="../js/jquery-2.2.2.min.js"></script>
<script src="../js/form-validator/jquery.form-validator.js"></script>

<script>

$.validate();
  $.validate({
    modules : 'security'
  });

 
</script>


