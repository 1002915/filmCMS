<?php include('header.php');?>
	
<div class="login_error">
	
	<?php if (isset($_SESSION['errors'])) {
	 	$error = $_SESSION['errors'];
	
		print_r($error[0]);
	
		} else echo '';

	?>

</div>

<div class="login_box">Please enter your SAE email <BR> <BR> Please enter your password
	<form name="loginForm" id="login" method="post" action="checklogin.php">
  		<input type="text" data-validation="email" name='email' id='email' placeholder="email" maxlength="50" /><br/>
  		<input type='password' data-validation="alphanumeric" name='password_hash' id='password_hash' maxlength="50" placeholder="password"/><br/>
  		<input type='submit' name='Submit' value='Submit' /><BR>
  		
  		<a href='resetpassword.php'>Forgot Password?</a><BR><BR>
  		<a href='register.php'>register</a>
	</form>
</div>

<script src="../js/jquery-2.2.2.min.js"></script>
<script src="../js/form-validator/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    modules : 'html5'
  });
</script>

<?php include('footer.php'); ?>

