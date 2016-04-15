<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Admin Update User";
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
<?php include "header.php"; ?>
<div class="content">

<?php 
include "config_vars.php";
include "getsessionvars.php";
if ($_POST["action"] =="update" ){
	include "sql_connect.php"; // makes $conn
	if( $conn){ 
		try {
			$qs = "UPDATE creators  SET Company=?, firstname=?,lastname=?,address1 =?,address2=?, City=?,State=?,Zip=?,EV=?, email=?, resetpassword=?, userlevel=? WHERE  ID=?";
echo $_POST["ID"] . "<BR>";
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
	else {
		echo "<BR>Update Cancelled";
	}
echo $_POST["ID"] . "X<BR>";
	echo "<a href=\"../../php/admin_edituser.php?pid=" . $_POST["ID"] . "\"> Continue </a>";
}
?>

</div>  <!-- end .container -->

</body>
</html>