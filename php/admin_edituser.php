<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Admin Edit User";
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
if (isset($_GET['pid']) && is_numeric($_GET['pid']))
 {
 // get id value
// echo"PID=" . $_GET['pid'] . " <BR>";
 $eu_id = $_GET['pid'];
//echo"EU_ID=" . $eu_id . " <BR>";
 }
 else{
	 $eu_id=0;
}
if($eu_id==0){
echo "bad call to admin_edit user. USER_ID=0<br>";
	 	echo "<a href=\"../../php/admin_list_users.php\"> Continue </a>";
}
else { 
if ($_POST["action"] =="update" ){ //  If called from this form, update data first
	include "sql_connect.php"; // makes $conn
	if( $conn){ 
		try {
			$qs = "UPDATE creators  SET Company=?, firstname=?,lastname=?,address1 =?,address2=?, City=?,State=?,Zip=?,EV=?, email=?, resetpassword=?, userlevel=? WHERE  ID=?";
			 $q=$conn->prepare($qs);
			 $q->execute(array($_POST["Company"],$_POST["FirstName"], $_POST["LastName"], $_POST["Address1"],$_POST["Address2"], $_POST["City"],$_POST["State"],$_POST["Zip"],$_POST["EV"],$_POST["email"],$_POST["RP"], $_POST["UL"],$_POST["ID"]));
			  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //    echo "Query successful<BR>";
		}
		catch(PDOException $e){
			echo "Update failed: " . $e->getMessage() . "<BR>";
		}
		$conn->connection=null;
	}
}
// Now get data for form
  include "sql_connect.php"; // makes $conn
  try{
	 $qs = "SELECT * FROM creators WHERE  ID='". $eu_id ."'" ;
//      echo $qs . "<br>";
	$result=$conn->query($qs);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $rh_data=$result->fetch();
//   echo "Query successful Name=" . $rh_data->rowCount .$rh_data[firstname] . "<BR>";
  }
  catch(PDOException $e){
	  echo "Query failed: " . $e->getMessage() . "<BR>";
  }
//  echo"found RH <BR>";
	$Company= $rh_data[Company];
	$FirstName=$rh_data[firstname] ;
	$LastName=$rh_data[lastname] ;
	$Address1= $rh_data[address1];
	$Address2= $rh_data[address2];
	$City= $rh_data[City];
	$State=$rh_data[State];
	$Zip=$rh_data[Zip];
	$email= $rh_data[email];
	$EV= $rh_data[EV];
	$RP= $rh_data[resetpassword];
	$UL= $rh_data[userlevel];
 
  $conn->connection=null;

}// end else
echo"User ID=" . $eu_id . " <BR>";
echo "<form action=\"../../php/admin_edituser.php?pid=" . $eu_id . "\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
echo " <input type=\"hidden\" name=\"ID\" value=" . $eu_id . "><br>";
echo "Company: <input type=\"text\" name=\"Company\" value=\"" . $Company ."\"><br>";
echo "First Name: <input type=\"text\" name=\"FirstName\" value=\"" . $FirstName ."\">  ";
echo "Last Name: <input type=\"text\" name=\"LastName\" value=\"" . $LastName . "\"><br>";
echo "Address 1: <input type=\"text\" name=\"Address1\" value=\"" . $Address1 . "\"><br>";
echo "Address 2: <input type=\"text\" name=\"Address2\" value=\"" .  $Address2  ."\"><br>";
echo "City: <input type=\"text\" name=\"City\" value=\"" . $City . "\"><br>";
echo "State: <input type=\"text\" name=\"State\" value=" . $State . "><br>";
echo "ZipCode: <input type=\"text\" name=\"Zip\" value=" . $Zip . "><br>";
echo "Email: <input type=\"email\" name=\"email\" value=" . $email . "><br>";
echo "Email Verified: <input type=\"text\" name=\"EV\" value=" . $EV . "><br>";
echo "Reset Password: <input type=\"text\" name=\"RP\" value=" . $RP . "><br>";
echo "User Level: <input type=\"text\" name=\"UL\" value=" . $UL . "><br>";
echo "<button type=\"submit\" name=\"action\" value=\"update\">Update  </button>";
echo "</form>";
echo "<a href=\"../../php/admin_list_users.php\">Cancel </a>";
 ?>

</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>