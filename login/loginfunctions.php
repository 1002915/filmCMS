<?php
require_once("class.phpmailer.php");
require_once("PHPMailerAutoload.php");

 function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';

        $urldir ='';
        $pos = strrpos($_SERVER['REQUEST_URI'],'/');
        if(false !==$pos)
        {
            $urldir = substr($_SERVER['REQUEST_URI'],0,$pos);
        }

        $scriptFolder .= $_SERVER['HTTP_HOST'].$urldir;

        return $scriptFolder;
    }
    
    function SendUserConfirmationEmail(&$formvars)
{
    $verify_hash = md5(uniqid(rand(), true));
    $confirm_url = GetAbsoluteURLFolder().'/confirmreg.php?code='.$verify_hash;

    $body = "Hello ".$formvars['name']."\r\n\r\n".
    "Thanks for your registration with "."FilmCMS"."\r\n".
    "Please click the link below to confirm your registration.\r\n".
    "$confirm_url\r\n".
    "\r\n".
    "Regards,\r\n".
    "Webmaster\r\n".

    $mail = new PHPMailer(); // Start the phpmailer function
    $mail->CharSet = 'utf-8';
    $mail->IsSMTP();
    $mail->Host       = "smtp.google.com"; // SMTP server
   // $mail->SMTPDebug  = 2;  // DISABLE THIS WHEN GOING LIVE!!!                                                          
    $mail->SMTPAuth   = true;      
    $mail->SMTPSecure = "tls";    
    $mail->Host       = "smtp.gmail.com"; 
    $mail->Port       = 587;     
    $mail->Username   = "1002915@student.sae.edu.au"; 
    $mail->Password   = "huyp35c5"; 
    $mail->SetFrom = $this->GetFromAddress();
    $mail->AddReplyTo("1002915@student.sae.edu.au","Matthew Neal");
    $mail->Subject = "Your registration with ".$this->sitename;
    $mail->MsgHTML($body);
    $mail->AddAddress($formvars['email'],$formvars['name']);
    
    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      echo "Message sent!";
    }
}

?>