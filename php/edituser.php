<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Edit User";
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
//echo "ud=" . $user_id . " name=" . $address1 . "<BR />";
echo "<form action=\"../../php/updateuser.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
//echo "ID: <input type=\"text\" name=\"ID\" value=" . $user_id . "><br>";
echo "First Name: <input type=\"text\" name=\"FirstName\" value=\"" . $firstname ."\"><br>";
echo "Last Name: <input type=\"text\" name=\"LastName\" value=\"" . $lastname . "\"><br>";
echo "Address 1: <input type=\"text\" name=\"Address1\" value=\"" . $address1 . "\"><br>";
echo "Address 1: <input type=\"text\" name=\"Address2\" value=\"" .  $address2  ."\"><br>";
echo "City: <input type=\"text\" name=\"City\" value=\"" . $City . "\"><br>";
echo "State: <input type=\"text\" name=\"State\" value=" . $State . "><br>";
echo "ZipCode: <input type=\"text\" name=\"Zip\" value=" . $Zip . "><br>";
//<!-- Verify Password: <input type="text" name="V_pword"><br>
//echo "<input type=\"submit\" value=\"Update User\" />"; -->
echo "<button type=\"submit\" name=\"action\" value=\"update\">Update  </button>";
echo "   <button type=\"submit\" name=\"action\" value=\"cancel\">Cancel</button>";
echo "</form>";

echo "<form action=\"../../php/change_email.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
//echo "Email: " . $email . "<br>";
echo "Email: <input type=\"text\" size=\"35\" name=\"email\" value=" . $email . ">";
echo "<button type=\"submit\" name=\"action\" value=\"chgemail\">Change  </button>";
echo "</form>";

 ?>
 
<form action="../../php/resend_vemail.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<button type="submit" name="action" value="">Re-send Verification Email</button>
</form>
<form action="../../php/changepassword.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="ID" value="<?php echo $user_id; ?>"/>
<input type="hidden" size="35" name="email" value="<?php echo $email; ?>"/>
<button type="submit" name="action" value="changepasswd">Change Password</button>
</form>

<form action="uploaduserphoto.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>