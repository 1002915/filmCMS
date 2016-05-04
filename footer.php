</div>
</div>
</div>
<footer>
        <div class="footer">
		<div class="footer_col_one"> 
			  filmcms@gmail.com<!-- <a href="index.php">HOME</a> 	-->
		</div>
	       <div class="footer_col_two">
		     <!--  <a href="login.php"> LOGIN</a> -->
	       </div>
	       <div class="footer_col_three">
                  <!--     <a href="register.php"> REGISTER</a> -->
	       </div>
	       <div class="footer_col_four text_align_fix">
                  Doco Loco 2015 <!--      <a href="search.php"> SEARCH</a> -->
	       </div>
        </div>
</footer>
</body>
<script>
//script to start validator
$.validate();
//popup dialog box start //	
$("#modal_trigger").leanModal({
        top: 80,
        overlay: 0.6,
        closeButton: ".modal_close"
});

$(function() {
		//SHOW USER LOGIN FORM
	    $("#modal_trigger").click(function() {
                $(".social_login").hide();
                $(".user_login").show();
                $(".user_register").hide();
                $(".reset_email").hide();

                return false;
        });
          // SHOW USER REGISTER FORM
        $(".back_btn2").click(function() {
                $(".user_login").hide();
                $(".user_register").show();
                $(".social_login").hide();
                $(".reset_email").hide();
                $(".header_title").text('Login');
                return false;
        });

          // SHOW USER LOGIN FORM 
        $(".loginform").click(function() {
                $(".user_login").show();
                $(".user_register").hide();
                $(".reset_email").hide();
                $(".header_title").text('Login');
                return false;
        });

          // SHOW RESET PASSWORD FORM
        $(".forgot_password").click(function() {
                $(".user_login").hide();
                $(".user_register").hide();
                $(".reset_email").show();
                $(".header_title").text('Login');
                return false;
        });
});
// CHECK LOGIN AJAX FUNCTION
$(document).ready(function() {
    
  $('#login_var').click(function() {

    var username=$("#email_var").val();
    var password=$("#password_var").val();
    var dataString = 'email='+username+'&password_hash='+password;
    
      if($.trim(username).length>0 && $.trim(password).length>0) {
        $.ajax({
          type: "POST",
          url: "checklogin.php",
          data: dataString,
          cache: false,
  
          beforeSend: function(){ 
            $("#login_var").val('Connecting...');
            $("#login_var").attr('disabled', true);
          },
          
          success: function(data){
            if(data) {
              $("body").load("index.php").hide().fadeIn(1500).delay(6000);
            } 
            else {

              $("#login_var").val('Login')
              $("#error").html("<span style='color:#cc0000; font-size:0.9em;'>Error: Invalid username or password.</span> ");
              $("#login_var").attr('disabled', false);
            }
          }
        });
      }
return false;
    });

});

// PASSWORD RESET JQUERY AJAX FUNTION //
$(document).ready(function() {
    
  $('#reset_password').click(function() {
     
      var email=$("#email_reset").val();
      var dataString = 'email='+email;
      
      if($.trim(email).length>0) {
        $.ajax({
          type: "POST",
          url: "reset.php",
          data: dataString,
          cache: false,
  
          beforeSend: function(){ 
            $("#reset_password").val('resetting...');
            $("#reset_password").attr('disabled', true);
          },
        
          success: function(data){
                $("#success").html("<span style='color:#009900; font-size:0.9em;'>Please check your email for your reset link.</span> ");
                $("#reset_password").val('reset');
          },

          error: function (data){
              $("#reset_password").val('reset');
              $("#reset_password").attr('disabled', false);
              $("#success").html("<span style='color:#cc0000; font-size:0.9em;'>Sorry, that email isn't valid.</span> ");
          }
          
        });
      }
return false;
  });

});

// REGISTER USER JQUERY AJAX FUNTION //
$(document).ready(function() {
    
  $('#register_user').submit(function(e) {
 e.preventDefault();
      var firstname=$("#reg_first_name").val();
      var lastname=$("#reg_last_name").val();
      var email=$("#reg_email").val();
      var password=$("#reg_password").val();
      var campus=$("#campus_id").val();

      var dataString = 'first_name='+firstname+'&last_name='+lastname+'&email='+email+'&pass_confirmation='+password+'&campus_id='+campus;
      
      if($.trim(email).length>0) {
        $.ajax({
          type: "POST",
          url: "registeruser.php",
          data: dataString,
          cache: false,
  
          beforeSend: function(){ 
            $("#SubmitButton").val('registering...');
            $("#SubmitButton").attr('disabled', true);
          },
        
          success: function(data){
                $("#success2").html(data);
                $("#SubmitButton").val('submit');
                $("#SubmitButton").attr('disabled', false);
          },

          error: function (data){
              alert(data);
              $("#reset_password").val('reset');
              $("#reset_password").attr('disabled', false);
              $("#success2").html("<span style='color:#cc0000; font-size:0.9em;'>Success! Please check your email for your confirmation code.</span> ");
          }
        
        });
      }
return false;
  });

});

</script>