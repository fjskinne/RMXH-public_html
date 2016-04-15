<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add RMXH User</title>
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="container">
<?php include "header.php"; 
?>
<div class="content">
<?php
//include "getsessionvars.php";
if ($_POST["refill"]==1){
	echo "retry refill data=" . $_POST["refill"]  . "<BR>";
  echo "<form action=\"../php/adduser.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "First Name: <input type=\"text\" name=\"FirstName\" value=" . $_POST["FirstName"] . "><br>";
  echo "Last Name: <input type=\"text\" name=\"LastName\" value=" . $_POST["LastName"] . "><br>";
  echo "Address 1: <input type=\"text\" name=\"Address1\" value=" . $_POST["Address1"] . "><br>";
  echo "Address 1: <input type=\"text\" name=\"Address2\" value=" . $_POST["Address2"] . "><br>";
  echo "City: <input type=\"text\" name=\"City\" value=" . $_POST["City"] . "><br>";
  echo "State: <input type=\"text\" name=\"State\" value=" . $_POST["State"] . "><br>";
  echo "ZipCode: <input type=\"text\" name=\"Zip\" value=" . $_POST["Zip"] . "><br>";
  echo "Email: <input type=\"text\" name=\"email\" value=" . $_POST["email"] . "><br>";
  echo "Verify Email: <input type=\"text\" name=\"V_email\" ><br>";
  echo "Password: <input type=\"text\" name=\"pword\" value=" . $_POST["pword"] . "><br>";
  echo "Verify Password: <input type=\"text\" name=\"V_pword\" value=\"\"><br>";
  echo "<input type=\"submit\" value=\"ReSubmit\"> ";
  echo "<input type=\"submit\" value=\"Cancel\" >";
  echo "</form>";
}
else{
echo "New refill data=" . $_POST["refill"]  . "<BR>";
  echo "<form action=\"../php/adduser.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "First Name: <input type=\"text\" name=\"FirstName\" ><br>";
  echo "Last Name: <input type=\"text\" name=\"LastName\" ><br>";
  echo "Address 1: <input type=\"text\" name=\"Address1\" ><br>";
  echo "Address 1: <input type=\"text\" name=\"Address2\" ><br>";
  echo "City: <input type=\"text\" name=\"City\" ><br>";
  echo "State: <input type=\"text\" name=\"State\" ><br>";
  echo "ZipCode: <input type=\"text\" name=\"Zip\" ><br>";
  echo "Email: <input type=\"text\" name=\"email\" ><br>";
  echo "Verify Email: <input type=\"text\" name=\"V_email\" ><br>";
  echo "Password: <input type=\"text\" name=\"pword\" ><br>";
  echo "Verify Password: <input type=\"text\" name=\"V_pword\" ><br>";
  echo "<input type=\"submit\" value=\"Submit\" >";
  echo "<input type=\"submit\" value=\"Cancel\" >";
  echo "</form>";
}
?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>