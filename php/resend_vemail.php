<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Resend Verification Email";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

<?php	echo "<title>" . $_REQUEST['pageTitle'] . "</title>"; ?>
</head>
<body>
<div class="container">
<?php include "header.php"; 
?>
<div class="content">
<?php
include "config_vars.php";
include "getsessionvars.php";
include "sendVemail.php";
echo "A verification email has been sent to " .  $_SESSION["email"] . "<br>Please respond to enjoy your RMXH accout. <BR>";
echo "<a href=\"../php/edituser.php\"> Continue </a >";
?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>