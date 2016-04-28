<!-- SITE CONTAINER AND LOGO -->

	<div class="header_navigation">
		<a href="index.php"><img src="img/logo2.0_locodoco_final-05.png" class="logo" alt="logo"></a>

<!--SEARCH BAR IN HEADER -->
		<div class="search_holder">
			<form action="search.php" method="post">
				<input type='hidden' name='function' value='search_project'>
				<input type='text' name='search' placeholder='Search...' class='search'>
				<input id="search_button" type="submit" name="Search" value="">
			</form>
		</div>
<!-- LOGGED IN CONTENT DISPLAY -->
<?php if (isset($_SESSION['email'])) { ?>
<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn"><?php echo $_SESSION['first_name']; ?></button>
  <div id="myDropdown" class="dropdown-content">
    <a href="profile.php" class="btn">Profile</a>
    <a href="logout.php" class="btn">logout</a>
  </div>
</div>


<?php } else echo''; ?>
<!-- BEGIN LOGIN FORM  - VISIBLE IN HEADER -->
<?php if (!isset($_SESSION['email'])) { ?>
	<div class="container">
        <a id="modal_trigger" href="#modal" class="btn">Login</a>
        	<div id="modal" class="popupContainer" style="display:none;">
           		<header class="popupHeader">
           		    <span class="header_title">Login</span>
           		    <span class="modal_close"><i class="fa fa-times"></i></span>
           		</header>
<!-- Username & Password Login form -->
                	<section class="popupBody">      
                        <div class="user_login">
                            <form method="post" action="checklogin.php">
                                <label>SAE email Address</label>
                                <input type="text" name='email' placeholder="email" maxlength="50"/><BR>
                                <label>Password</label>
                                <input type='password'  name='password_hash' maxlength="50" placeholder="password"/><BR>
                                    <div class="action_btns float">
                                        <a href="#" class="btn back_btn2"><i class="fa fa-angle-double-left"></i> sign up</a>
                                        <input class="parallelogram" onclick="this.disabled=true;this.value='logging in...'; this.form.submit();" type='submit' name='Submit' value='login' />
                                    </div>
                            </form>
                            <a href="resetpassword.php" class="forgot_password">Forgot password?</a>
                        </div>

<!-- BEGIN REGISTER FORM -->
	                   <div class="user_register">
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
                                        <input id="SubmitButton" onclick="this.disabled=true;this.value='please wait...'; this.form.submit();" class="popup_button big" type='submit' name='Submit' value='Register' />
                                    </div>
                            </form><BR>
                        </div>
                    </section>
            </div>   
    </div>
<?php }; ?>
    </div>
	
<div class="site_container">
<div class="site_content">
    <script>
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}</script>

<script>
$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
</script>



<div class="popper"><img src="img/logo.png" class="logo_loading" alt="logo"><!-- Place at bottom of page --></div>
	