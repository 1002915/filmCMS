<?php include('header.php'); ?>

<div class="error_box">Reset your password  </div>  
	<div class="security_box reset_email">
			<form action="reset.php" method="post" >
	    		<input type='hidden' name='submitted' id='submitted' value='1'/>
	    		<input type='text' name='email' id='email' maxlength="50" placeholder="your SAE email" />
	    		<input type='submit' name='Submit' value='Submit' />
			</form>
</div>

<?php include('footer.php'); ?>