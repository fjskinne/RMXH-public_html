<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Change email";
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
if (isset($_POST['updateemail']))//if posted, update
{
	$chkemail=$_POST[email];
echo "Checking if " . $chkemail . " user exists?<br>";

	include "sql_connect.php"; // makes $conn
	try {
	   $qs = "SELECT * FROM creators WHERE  email='".$chkemail ."'" ;
//      echo $qs . "<br>";
		$result=$conn->query($qs);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$userdata=$result->fetch();
//echo "Query successful Name=" . $userdata["email"] . "<BR>";
	}
	catch(PDOException $e){
	    echo "Check for Existing user Query failed: " . $e->getMessage() . "<BR>";
	}
//if($result)echo "Result OK<BR>";
//if($userdata)echo "Fetch OK<BR>";
	if($result->rowcount()>0){
		echo "User " . $userdata[ID] . $userdata[email] . "Exists!<BR>";
		$dataerr=1;
	}
	else{
		if ($_POST[email]!= $_POST[V_email]){ // Check Email
		$dataerr=2;
		echo "<h1>Emails don't match! "  . $_POST[email] . " and   " . $_POST[V_email] . "</h1><br>";
		}
		else{
			include "sql_connect.php"; // makes $conn
			try{
//	  echo "Connected successfully<BR>";
				$emailverfied=0;
				$qs = "UPDATE creators  SET email=?,EV=? WHERE  ID=?";
//	 echo $qs . "<BR>";
				$q=$conn->prepare($qs);
				$q->execute(array($_POST["email"],$emailverified,$user_id));
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //    echo "Query successful<BR>";
				$_SESSION["email"] = $_POST["email"];
				if (!$q) {
					echo "\nPDO::errorInfo():\n";
					print_r($conn->errorInfo());
				}
			}// end try
			catch(PDOException $e)
			{
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}// end email is new
	$conn->connection=null;
 
	if ($dataerr>0){
		echo"Try Again <BR>";
		echo "<form action=\"../../php/change_email.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
		enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
//echo "Email: " . $email . "<br>";
		echo "<input type=\"text\" size=\"35\" name=\"email\" value=" . $_POST["email"] . ">";
		echo "<input type=\"text\" size=\"35\" name=\"V_email\" value=\"\">";
		echo "<button type=\"submit\" name=\"updateemail\" value=\"chgemail\">Change  </button>";
		echo "</form>";
		echo "<a href=\"../php/edituser.php\"> Cancel </a >";
	}
	else{ //Email update sucessful
		include "sendVemail.php";
		echo "A verification email has been sent to " .  $_SESSION["email"] . "<br>Please respond to enjoy your RMXH accout. <BR>";
		echo "<a href=\"../php/edituser.php\"> Continue </a >";
	} 	
}
else{ // first time in file, get email and v_email
		echo"Enter and veirfy new Email <BR>";
		echo "FIRST<form action=\"../../php/change_email.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
		enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
//echo "Email: " . $email . "<br>";
		echo "<input type=\"text\" size=\"35\" name=\"email\" value=\"\" >";
		echo "<input type=\"text\" size=\"35\" name=\"V_email\" value=\"\">";
		echo "<button type=\"submit\" name=\"updateemail\" value=\"chgemail\">Change  </button>";
		echo "</form>";
		echo "<a href=\"../php/edituser.php\"> Cancel </a >";
}
?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>