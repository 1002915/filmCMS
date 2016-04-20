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
	       <div class="footer_col_four">
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

                return false;
        });
                // Going back to Social Forms
        $(".back_btn2").click(function() {
                $(".user_login").hide();
                $(".user_register").show();
                $(".social_login").hide();
                $(".header_title").text('Login');
                return false;
        });

                        // Going back to Social Forms
        $(".loginform").click(function() {
                $(".user_login").show();
                $(".user_register").hide();
                $(".header_title").text('Login');
                return false;
        });
});
</script>
<div class="popper"><img src="img/logo.png" class="logo_loading" alt="logo"><!-- Place at bottom of page --></div>

<script>
$body = $("#searchList");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
</script>