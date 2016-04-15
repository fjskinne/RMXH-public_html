<?php
ini_set("include_path", '/home/fjskinne/php:' . ini_get("include_path") );
include "config_vars.php";
include "getsessionvars.php";
include ('Mail.php');

$params=array ('emailhost' => $emailhost,'email_auth' => true,'username' => $emailsender,'email_pwd' => $email_pwd);
//echo "<BR>params=" . print_r($params) . "<BR>";


$smtp = Mail::factory('smtp', array ('emailhost' => $emailhost,'email_auth' => true,'username' => $emailsender,'email_pwd' => $email_pwd));
 
$to=$_SESSION["email"];
$from="info@" . $siteaddress;
//echo $from . "=from<BR>";
$headers = array('From'=>$from,'To'=>$to, 'Subject'=>"Verify your RMXH Email");//. . 
$message="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">";

$message .="Hello " . $firstname . ",<BR>Please verify your email with the following link:<BR><a href=\"" . $siteaddress . "/php/verifyemail.php?uid=" . $_SESSION["user_id"] . "\">Click to verify email</a><br>Thank you,<BR>The Remix Hits Team";

//echo "Header=" . print_r($headers) . "<BR>";
//echo "MSG=" . $message . "<BR>";
	$mail_ok=$smtp->send($to ,$headers,  $message);
if (PEAR::isError($mail_ok)) {
	echo("<p>" . $mail_ok->getMessage() . "</p>");
}
else {
	echo("<p>Message successfully sent!</p>");
}
?>