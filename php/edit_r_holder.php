<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Edit Right Holder";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />
<title>Edit RMXH User</title>
</head>
<body>
<div class="container">
<?php include "header.php"; 
?>
<div class="content">
<?php 
include "config_vars.php";
include "getsessionvars.php";
if (isset($_GET['pid']) && is_numeric($_GET['pid']))
 {
 // get id value
 $rh_id = $_GET['pid'];
 }
 else{
	 $rh_id=0;
 }
 if($rh_id==0){
	$Company= "Company Name";
	$FirstName="First Name" ;
	$LastName="Last Name" ;
	$Address1= "Address 1";
	$Address2= "Address 2";
	$City= "City";
	$Zip= "Zip Code";
	$email= "email";
	$EV= "XX";
}
else{ // look for existing product
  include "sql_connect.php"; // makes $conn
  try{
	 $qs = "SELECT * FROM creators WHERE  ID='".$rh_id ."'" ;
//       echo $qs . "<br>";
	$result=$conn->query($qs);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $rh_data=$result->fetch();
//   echo "Query successful Name=" . $rh_data->rowCount .$rh_data[prod_name] . "<BR>";
  }
  catch(PDOException $e){
	  echo "Query failed: " . $e->getMessage() . "<BR>";
  }
//  echo"found RH <BR>";
	$Company= $rh_data[Company];
	$FirstName=$rh_data[FirstName] ;
	$LastName=$rh_data[LastName] ;
	$Address1= $rh_data[Address1];
	$Address2= $rh_data[Address2];
	$City= $rh_data[City];
	$State=$rh_data[State];
	$Zip=$rh_data[Zip];
	$email= $rh_data[email];
	$EV= $rh_data[EV];
 
  $conn->connection=null;

}// end else
echo "<form action=\"../../php/update_rh.php?rh_id=" . $rh_id . "\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
echo " <input type=\"hidden\" name=\"ID\" value=" . $rh_id . "><br>";
echo "Company: <input type=\"text\" name=\"Company\" value=\"" . $Company ."\"><br>";
echo "First Name: <input type=\"text\" name=\"FirstName\" value=\"" . $FirstName ."\"><br>";
echo "Last Name: <input type=\"text\" name=\"LastName\" value=\"" . $LastName . "\"><br>";
echo "Address 1: <input type=\"text\" name=\"Address1\" value=\"" . $Address1 . "\"><br>";
echo "Address 1: <input type=\"text\" name=\"Address2\" value=\"" .  $Address2  ."\"><br>";
echo "City: <input type=\"text\" name=\"City\" value=\"" . $City . "\"><br>";
echo "State: <input type=\"text\" name=\"State\" value=" . $State . "><br>";
echo "ZipCode: <input type=\"text\" name=\"Zip\" value=" . $Zip . "><br>";
echo "Email: <input type=\"email\" name=\"email\" value=" . $Zip . "><br>";
//<!-- Verify Password: <input type="text" name="V_pword"><br>
//echo "<input type=\"submit\" value=\"Update User\" />"; -->
echo "<button type=\"submit\" name=\"action\" value=\"update\">Update  </button>";
echo "</form>";
echo "<a href=\"../../php/list_rh.php\">Cancel </a>";
 ?>

</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>