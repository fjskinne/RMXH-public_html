<?php
// Start the session
session_start();
include "php/set_sessionvars.php";
$_REQUEST['pageTitle'] = "RMXH Demo Login";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RMXH Login Page</title>

</head>

<body>
<p>Welcome to Remix DB Demo 4</p>

<form action="../RMXH/getuserid.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
Email: <input type="text" size=\"35\" name="email"><br>
Password: <input type="Password" name="passwd"><br>

<input type="submit" value="Submit">
</form>
Or if you are new to RMXH
<br>
<form action="../RMXH/newuser.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="refill" value="N" ><br>
<input type="submit" value="New User">
</form>

</body>
</html>