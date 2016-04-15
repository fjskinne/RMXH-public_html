<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Change RMXHTZ Password</title>
</head>
<!-- post ID and user [email] to this page -->
<body>
<?php
if ($_POST["action"] =="changepasswd" ){
  echo "<h2> Changing Password for </h2> " . $_POST[email];
  echo "<form action=\"../RMXH/updatepassword.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "ID: <input type=\"hidden\" name=\"ID\" value=" . $_POST["ID"] . "><br>";
  echo "Password: <input type=\"text\" name=\"pword\" value=\"\" ><br> ";
  echo "Verify Password: <input type=\"text\" name=\"V_pword\"> <br>";
echo "<button type=\"submit\" name=\"action\" value=\"change\">Change Password</button>";
echo "<button type=\"submit\" name=\"action\" value=\"cancel\">Cancel</button>";
  echo "</form>";
}
else {
}?>
</body>
</html>