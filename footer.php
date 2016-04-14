</div>
</div>
<footer>
	<div class="footer">
		<div class="footer_col_one"> 
			<a href="index.php">HOME</a> <BR><BR>
			<a href="login.php"> LOGIN</a> <BR><BR>
			<a href="register.php"> REGISTER</a> <BR><BR>
			<a href="search.php"> SEARCH</a> 
		</div>

	<div class="footer_col_two">
		 F <BR><BR> LINES TWO <BR><BR> LINES THREE <BR><BR> LINES FOURS
	</div>

	<div class="footer_col_three"> F <BR><BR> LINES TWO <BR><BR> LINES THREE <BR><BR> LINES FOURS
	</div>

	<div class="footer_col_four"> ALEX MURPHY <BR><BR> ANNA ESTRELA <BR><BR> MATTHEW NEAL <BR><BR> TATIANA ROGA
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
//popup dialog end//
</script>