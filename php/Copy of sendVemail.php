<?php
ini_set("include_path", '/home/fjskinne/php:' . ini_get("include_path") );
include "config_vars.php";
include "getsessionvars.php";
include ('Mail.php');
echo "IP=" . include_path;
$mail = Mail::factory("mail");

$headers = array("From"=>"info@rmxhtz.us", "Subject"=>"Verify your RMXH Email");//. $siteaddress . 
	$message="Please verify your email with the following link:<a href=\"" . $siteaddress . "/php/verifyemail.php?uid=" . $_SESSION["user_id"] . "\">Click to verify email</a><br>Thank you,<BR>The Remix Hits Team";
	echo "Header=" . print_r($headers) . "<BR>";
	echo "MSG=" . $message . "<BR>";
	$mail_ok=$mail->send($S_SESSION["email"] ,$headers,  $message);
	if($mail_ok)echo "Mail OK<br>";
	else echo "Mail Fucked<br>";
?>