<?php
ini_set("include_path", '/home/fjskinne/php:' . ini_get("include_path") );
include "config_vars.php";
include "getsessionvars.php";
require_once "Mail.php";
require_once "Mail/mime.php";    
 
$params=array ('emailhost' => $emailhost,'email_auth' => true,'username' => $emailsender,'email_pwd' => $email_pwd);
//echo "<BR>params=" . print_r($params) . "<BR>";

 
 
$to=$_SESSION["email"];
$from="info@" . $siteaddress;
//echo $from . "=from<BR>";
$headers = array('From'=>$from,'To'=>$to, 'Subject'=>"Verify your RMXH Email");

//$message="<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">
//<title>....</title></head><body>";
$message ="Hello " . $firstname . ",<BR>Please verify your email with the following link:<BR><A href = \"" . $siteaddress . "/php/verifyemail.php?uid= " . $_SESSION["user_id"] . "\">Click to verify email</A><br>Thank you,<BR>The Remix Hits Team';
";
$textmessage ="Hello " . $firstname . ",\nPlease verify your email by copying and pastind the following linkin your browser. \n " . $siteaddress . "/php/verifyemail.php?uid=" . $_SESSION["user_id"] . "\nThank you,\nThe Remix Hits Team";
echo "MSGb4=" . $message . "<BR>";

$mime = new Mail_mime();
$mime->setHTMLBody($message);
$mime->setTXTBody($textmessage);
$message = $mime->get();
$headers = $mime->headers($headers);
//echo "Header=" . print_r($headers) . "<BR>";
echo "MSG=" . $message . "<BR>";

$smtp = Mail::factory('smtp', array ('emailhost' => $emailhost,'email_auth' => true,'username' => $emailsender,'email_pwd' => $email_pwd));
$mail_ok=$smtp->send($to ,$headers,  $message);
if (PEAR::isError($mail_ok)) {
	echo("<p>" . $mail_ok->getMessage() . "</p>");
}
else {
	echo("<p>Message successfully sent!</p>");
}
?>