<?php
include('header.php');
include('connection.php');
  
$first_name = e($_POST['first_name']);

$last_name = e($_POST['last_name']);

$email = e($_POST['email']);

$password = e($_POST['pass_confirmation']);

$campus_id = e($_POST['campus_id']);

$lecturer_email = array('sae.edu');

$matches = array();

preg_match("/^(.+)@([^\(\);:,<>]+\.[a-zA-Z]{2,4})/", $email, &$matches);

$domain = $matches[3];

if(in_array($domain, $lecturer_email))
{
    $user_type = 1;

} else {

    $user_type = 0;
}

$last_row = mysqli_insert_id($mysqli);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$verify_hash = md5(uniqid(rand(), true));

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))

    exit("Invalid email address");

$select = mysqli_query($mysqli, "SELECT `email` FROM `users` WHERE `email` = '".$_POST['email']."'") or exit(mysql_error());

if(mysqli_num_rows($select))

    exit("This email is already being used. click <a href='resetpassword.php'> Here </a> to reset your password, or click <a href='login.php'> here </a> to go back.");


function Sanitize($str, $remove_nl = true)

    {
        $str = StripSlashes($str);

        if($remove_nl)

        {

            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );

        $str = preg_replace($injections,'',$str);

        }

        return $str;
    }   

$formvars['first_name'] = Sanitize($_POST['first_name']);

$formvars['last_name'] = Sanitize($_POST['last_name']);

$formvars['email'] = Sanitize($_POST['email']);

$formvars['password'] = Sanitize($_POST['pass_confirmation']);


function e($text) {
        
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
   
}


$sql = "INSERT INTO users (campus_id, first_name, Last_name, email, password_hash, verify_hash, user_type) 

        VALUES ('$campus_id', '$first_name', '$last_name', '$email', '$hashed_password', '$verify_hash', '$user_type')";

if (mysqli_query($mysqli, $sql)) {

    $confirm_url = 'localhost/filmCMS/confirmreg.php?code='.$verify_hash;

    $confirm_id = $mysqli->insert_id;




    

require_once('PHPMailerAutoload.php');

$body = "Hello ".$formvars['first_name']."!<BR>\r\n\r\n".

    "Thanks for your registration with "."FilmCMS"."\r\n<BR>".

    "Please click the link below to confirm your registration.\r\n".

    "<a href='$confirm_url&id=$confirm_id'>Click here to confirm your registration</a>\r\n".

    "\r\n".

    "Regards,\r\n".

    "Webmaster\r\n";

$sendmail = new PHPMailer(); // Start the phpmailer function

$sendmail->CharSet = 'utf-8';

$sendmail->IsSMTP();

$sendmail->Host = "smtp.google.com";

$sendmail->SMTPAuth = true;     

$sendmail->SMTPSecure = "tls";  

$sendmail->Host = "smtp.gmail.com";

$sendmail->Port = 587;    

$sendmail->Username = "filmcms@gmail.com"; 

$sendmail->Password = "filmcmspassword"; 

$sendmail->AddReplyTo("1002915@student.sae.edu.au","Matthew Neal");

$sendmail->Subject = "Your registration with FILMCMS";

$sendmail->MsgHTML($body);

$sendmail->AddAddress($formvars['email'],$formvars['first_name']);

$sendmail->Send();
?>
<div class="error_box">  </div>  
<div class="security_box reset_email">
<?php
echo 'Thanks for registering. Please check your email for the confirmation link to finalise the registration process.';
?>
</div>
<?php
} else {
    
    echo "Error updating record: " . mysqli_error($mysqli);
}

mysqli_close($mysqli);

include('footer.php'); 

?>



