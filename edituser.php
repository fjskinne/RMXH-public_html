<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit RMXH User</title>
<h1> Editting RMXH User</h1>
</head>
<body>
<?php echo "ud=" . $_POST["ID"] . " name=" . $_POST["FirstName"] . "<BR />"; ?>
<form action="../RMXH/updateuser.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
ID: <input type="text" name="ID" value="<?php echo $_POST["ID"]; ?>"/><br>
First Name: <input type="text" name="FirstName" value="<?php echo $_POST["FirstName"]; ?>"/><br>
Last Name: <input type="text" name="LastName" value="<?php echo $_POST["LastName"]; ?>"/><br>
Address 1: <input type="text" name="Address1" value="<?php echo $_POST["Address1"]; ?>"/><br>
Address 1: <input type="text" name="Address2" value="<?php echo $_POST["Address2"]; ?>"/><br>
City: <input type="text" name="City" value="<?php echo $_POST["City"]; ?>"/><br>
State: <input type="text" name="State" value="<?php echo $_POST["State"]; ?>"/><br>
ZipCode: <input type="text" name="Zip" value="<?php echo $_POST["Zip"]; ?>"/><br>
Email: <input type="text" size=\"35\" name="email" value="<?php echo $_POST["email"]; ?>"/><br>
<!-- Verify Password: <input type="text" name="V_pword"><br>
<input type="submit" value="Update User" /> -->
<button type="submit" name="action" value="update">Update  </button>
<button type="submit" name="action" value="cancel">Cancel</button>
</form>
<form action="../RMXH/changepassword.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="ID" value="<?php echo $_POST["ID"]; ?>"/>
<input type="hidden" size=\"35\" name="email" value="<?php echo $_POST["email"]; ?>"/>
<button type="submit" name="action" value="changepasswd">Change Password</button>
</form>

</body>
</html>