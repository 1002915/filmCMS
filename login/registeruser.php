<?php
session_start();
include('connection.php');


  
    $submitted = e($_POST['submitted']);

    $first_name = e($_POST['first_name']);

    $last_name = e($_POST['last_name']);

    $email = e($_POST['email']);

    $password = e($_POST['password']);

    $campus_id = e($_POST['campus_id']);

    $last_row = mysqli_insert_id($mysqli);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $verify_hash = md5(uniqid(rand(), true));

        function Sanitize($str,$remove_nl=true)
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
        $formvars['password'] = Sanitize($_POST['password']);
    


		function e($text) {
        
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

	
$sql = "INSERT INTO users (campus_id, first_name, Last_name, email, password_hash, verify_hash) 
        VALUES ('$campus_id', '$first_name', '$last_name', '$email', '$hashed_password', '$verify_hash')";


if (mysqli_query($mysqli, $sql)) {

           $confirm_url = 'localhost/filmCMS/confirmreg.php?code='.$verify_hash;

    require_once('PHPMailerAutoload.php');



    $body = "Hello ".$formvars['first_name']."!<BR>\r\n\r\n".
    "Thanks for your registration with "."FilmCMS"."\r\n<BR>".
    "Please click the link below to confirm your registration.\r\n".
    "<a href='$confirm_url'>Click here to confirm your registration</a>\r\n".
    "\r\n".
    "Regards,\r\n".
    "Webmaster\r\n";

    $sendmail = new PHPMailer(); // Start the phpmailer function
    $sendmail->CharSet = 'utf-8';
    $sendmail->IsSMTP();
    $sendmail->Host       = "smtp.google.com"; // SMTP server
   // $mail->SMTPDebug  = 2;  // DISABLE THIS WHEN GOING LIVE!!!                                                          
    $sendmail->SMTPAuth   = true;      
    $sendmail->SMTPSecure = "tls";    
    $sendmail->Host       = "smtp.gmail.com"; 
    $sendmail->Port       = 587;     
    $sendmail->Username   = "1002915@student.sae.edu.au"; 
    $sendmail->Password   = "huyp35c5"; 
    $sendmail->AddReplyTo("1002915@student.sae.edu.au","Matthew Neal");
    $sendmail->Subject = "Your registration with FILMCMS";
    $sendmail->MsgHTML($body);
    $sendmail->AddAddress($formvars['email'],$formvars['first_name']);
    $sendmail->Send();

    echo 'Thanks for registering. Please check your student email for the confirmation link to finalise the registration process.';
    
} else {
    
    echo "Error updating record: " . mysqli_error($mysqli);
}


mysqli_close($mysqli);

?>


