<div class="loginbox">
<form name="loginForm" method="post" action="checklogin.php">
  <input type='hidden' name='submitted' id='submitted' value='1'/>
  <input type='text' name='email' id='email' placeholder="email" maxlength="50" /><br/>
  <input type='password' name='password_hash' id='password_hash' maxlength="50" placeholder="password"/><br/>
  <input type='submit' name='Submit' value='Submit' />
  <a href='resetpassword.php'>Forgot Password?</a>
  <a href='register.php'>register</a>
</form>
</div>