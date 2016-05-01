</div>
</div>
</div>
<footer>
        <div class="footer">
		<div class="footer_col_one"> 
			  contact@email.com<!-- <a href="index.php">HOME</a> 	-->
		</div>
	       <div class="footer_col_two">
		     <!--  <a href="login.php"> LOGIN</a> -->
	       </div>
	       <div class="footer_col_three">
                  <!--     <a href="register.php"> REGISTER</a> -->
	       </div>
	       <div class="footer_col_four text_align_fix">
                  LocoDoco 2015 <!--      <a href="search.php"> SEARCH</a> -->
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
		//open login by clicking the header button
	    $("#modal_trigger").click(function() {
                $(".social_login").hide();
                $(".user_login").show();
                $(".user_register").hide();
                $(".reset_email").hide();

                return false;
        });
                // Going back to Social Forms
        $(".back_btn2").click(function() {
                $(".user_login").hide();
                $(".user_register").show();
                $(".social_login").hide();
                $(".reset_email").hide();
                $(".header_title").text('Login');
                return false;
        });

                        // Going back to Social Forms
        $(".loginform").click(function() {
                $(".user_login").show();
                $(".user_register").hide();
                $(".reset_email").hide();
                $(".header_title").text('Login');
                return false;
        });

          // Forgot Password show
        $(".forgot_password").click(function() {
                $(".user_login").hide();
                $(".user_register").hide();
                $(".reset_email").show();
                $(".header_title").text('Login');
                return false;
        });
});
</script>
<script>
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
          },
          
          success: function(data){
            
            if(data) {
              
              $("body").load("index.php").hide().fadeIn(1500).delay(6000);
            }
            
            else {

              $("#login_var").val('Login')
              $("#error").html("<span style='color:#cc0000; font-size:0.9em;'>Error: Invalid username or password.</span> ");
            }
          }
        });
      }
return false;
    });

});
</script>

<script>
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
            
            if(data) {
              
                $("#success").html("<span style='color:#cc0000; font-size:0.9em;'>Success! please check your email for a reset link.</span> ");
                $("#reset_password").val('reset');
            }
            
            else {

              $("#reset_email").val('Reset');
              $("#error").html("<span style='color:#cc0000; font-size:0.9em;'>Sorry, that email isn't valid.</span> ");
            }
          }
        });
      }
return false;
    });

});
</script>