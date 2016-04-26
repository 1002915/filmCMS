<?php $lecturer_email = array('sae.edu');

$matches = array();
preg_match("/^(.+)@([^\(\);:,<>]+\.[a-zA-Z]{2,4})/", $email, &$matches); //validates the email and gathers information about it simultaneously
//should return ['user@mail.com', 'user', 'mail.com']
$domain = $matches[3];

if(in_array($domain, $lecturer_email))
{
    $user_type = 1;
}
else
{
    //oh no! an imposter!
}

?>