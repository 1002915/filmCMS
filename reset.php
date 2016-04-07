<?php 
include('header.php');
include('connection.php');

function e($text) {
        
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
   
}
?>
<div class="login_box"> <a href="register.php">REGISTER HERE</a>
    <?php
/* 
SELECT the 'id' of the user where their email address matches their input 
*/

$email = e($_POST['email']);

$verify_hash = md5(uniqid(rand(), true));

$sql = "SELECT * FROM users WHERE email = '$email'";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

        $row_id = $row["id"];



/* 
UPDATE 'verify_hash' in the database. This wey, we can send the hash to the users email 
which will then link to the page where the user can update their password 
*/


$update_hash = "UPDATE users SET verify_hash='$verify_hash' WHERE id='$row_id'";

if ($mysqli->query($update_hash) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $mysqli->error;
}


/* THIS SECTION WILL EMAIL THE RESET CODE. The reset code is simply a randomly generated hash that
will be emailed to the user.
*/
if (isset($_POST['email'])) {

require_once('PHPMailerAutoload.php');

$confirm_url = 'localhost/filmCMS/resetlink.php?code='.$verify_hash;

$confirm_id = $mysqli->insert_id;


$body = "Hello ".$row['first_name']."!<BR>\r\n\r\n".

    "It looks like you've forgotten your password! :( We can reset that for you. :)\r\n<BR><BR>".

    "Please click the link below to reset your password.\r\n".

    "<a href='$confirm_url&id=$row_id'>Click here to reset your password</a>\r\n".

    "\r\n".

    "Regards,\r\n".

    "The Web Team @ SAE\r\n";

$sendmail = new PHPMailer(); // Start the phpmailer function

$sendmail->CharSet = 'utf-8';

$sendmail->IsSMTP();

$sendmail->Host = "smtp.google.com";

$sendmail->MTPDebug = 2;

$sendmail->SMTPAuth = true;     

$sendmail->SMTPSecure = "tls";  

$sendmail->Host = "smtp.gmail.com"; 

$sendmail->Port = 587;    

$sendmail->Username = "1002915@student.sae.edu.au"; 

$sendmail->Password = "huyp35c5"; 

$sendmail->AddReplyTo("1002915@student.sae.edu.au","Matthew Neal");

$sendmail->Subject = "FILM CMS Password Reset";

$sendmail->MsgHTML($body);

$sendmail->AddAddress($email, $row['first_name']);

$sendmail->Send();

if(!$sendmail->Send()) {
echo 'Message could not be sent.';
echo 'Mailer Error: ' . $sendmail->ErrorInfo;
}

echo '<h3>Thanks for being a part of Film CMS.</h3>We have sent your password to your eamil address. <BR>
	Please follow the instructions to reset  your password. May your grades be high and your <BR>
	framerate cinematic!.<BR><BR><a href="login.php">HOME</a>';


} else {
    
    echo "Error updating record: " . mysqli_error($mysqli);
}
    }

} else {

    echo "Sorry, that email address isn't yet registered. Please sign up before resetting your email.";

}

?>
</div>
<?php include('footer.php'); ?>