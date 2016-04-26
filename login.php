<?php
if (!isset($_SESSION['first_name'])) {

 include('header.php');


?>
	
<div class="login_error">
	
	<?php if (isset($_SESSION['errors'])) {
	 	$error = $_SESSION['errors'];
	
		print_r($error[0]);
	
		} else echo '';

	?>

</div>
<div class="error_box">  </div>
<div class="flexbox_center">

            <div class="container_register" >
                <header class="popupHeader">
                    <span class="header_title">Login</span><BR>
<!-- Username & Password Login form -->
                    
                        <div class="user_login_main">
                            <form method="post" action="checklogin.php">
                           
                                <input type="text" name='email' placeholder="email" maxlength="50"/><BR>
                              
                                <input type='password'  name='password_hash' maxlength="50" placeholder="password"/><BR>
                                    <div class="action_btns float">
                                        <a href="register.php" class="btn back_btn2"><i class="fa fa-angle-double-left"></i> sign up</a>
                                        <input class="parallelogram" type='submit' name='Submit' value='login' />
                                    </div>
                            </form>
                            <a href="resetpassword.php" class="forgot_password">Forgot password?</a>
                        </div>
          
    </div>
</div>

<script src="js/jquery-2.2.2.min.js"></script>
<script src="js/form-validator/jquery.form-validator.js"></script>
<script>
  $.validate({
    modules : 'html5'
  });
</script>

<?php include('footer.php');

} else header('Location: index.php');
 ?>

