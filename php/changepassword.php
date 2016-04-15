<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Change Password";
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
echo "<div class=\"content\">";
include "/php/getsessionvars.php";
$changepw=0;
$user_id=$_SESSION["user_id"];
if(isset($_GET["a"])){
	$user_id=$_GET["a"];
	$changepw=1;
}
echo "uid=" . $user_id . "<BR>";
echo "cpw=" . $changepw . "<BR>";
if ($_POST["action"] =="changepasswd" or $changepw){
  echo "<h2> Changing Password for </h2> " . $_POST[email];
  echo "<form action=\"../php/updatepassword.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"hidden\" name=\"ID\" value=" . $user_id . "><br>";
  echo "Password: <input type=\"text\" name=\"pword\" value=\"\" ><br> ";
  echo "Verify Password: <input type=\"text\" name=\"V_pword\"> <br>";
echo "<button type=\"submit\" name=\"action\" value=\"change\">Change Password</button>";
echo "<button type=\"submit\" name=\"action\" value=\"cancel\">Cancel</button>";
  echo "</form>";
}
else {
		echo "<a href=\"../../php/edituser.php\">Cancelled</a>";
}
?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>