<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Password Update Status";
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
<?php 
include "header.php"; 
echo "<div class=\"content\">";
//echo $_POST[action] . " Passwords :" . $_POST[pword] . "  " . $_POST[V_pword] . " <br>";
if( $_POST[action]== "change"){
  if ($_POST[pword]!= $_POST[V_pword]){ //Check password'
	  $dataerr=1;
	echo "<h1>Passwords don't match" . $_POST[pword] . "  " . $_POST[V_pword] . " </h1><br>";
  }
  else{
include "sql_connect.php"; // makes $conn
	try {
	  $salt = "000";
// use if php5.5 available	  $hpasswd=password_hash($_POST[pword],PASSWORD_DEFAULT);
$hpasswd=crypt($_POST[pword],$salt);
	   $qs = "UPDATE creators  SET pword=?,salt=? WHERE  ID=?";
//echo "UPDATE creators  <BR> pword=" . $hpasswd . "<br>salt=" . $salt ." <br>ID=" . $_POST[ID] ;
	   $q=$conn->prepare($qs);
	   $q->execute(array($hpasswd, $salt,$_POST[ID]));
		if (!$q) {
			echo "\nPDO::errorInfo():\n";
			print_r($conn->errorInfo());
		}
		// use exec() because no results are returned
		$arr = $q->errorInfo();
		if($arr[0]>0){
			echo "\nPDOStatement::errorInfo():\n";
			print_r($arr);
		}
		else{
  //	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  echo "Password changed successfully";
		}
	}// end try
	catch(PDOException $e)
		{
		echo "Connection failed: " . $e->getMessage();
	}
	$conn = null;
  }
  if ($dataerr>0){
	echo"Try Again <BR>";
	echo "<form action=\"../php/changepassword.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
	echo "ID: <input type=\"hidden\" name=\"ID\" value=" . $_POST["ID"] . "><br>";
	echo "<button type=\"submit\" name=\"action\" value=\"Retry\">Retry</button>";
	echo "<button type=\"submit\" name=\"action\" value=\"Cancel\">Cancel</button>";
	echo "</form>";
  }
  else{ // Update passwoed successful, goback to remixhits
  //echo "passwd=" . $_POST[pword] . "  email=" . $_POST[email] . "/><br>";
	echo "<h2> Password Change Successful! </h2><BR>";
	echo "<form action=\"../php/rmxhmain.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
	echo "<input type=\"hidden\" name=\"ID\" value=" . $_POST["ID"] . "><br>";
	echo "<input type=\"submit\" name=\"continue\" value=\"Click to continue\" >";
	echo "</form>";
  }
}
else{
	echo "<h2> Password Change Cancelled </h2><BR>";
	echo "<form action=\"../php/rmxhmain.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
	echo "<input type=\"hidden\" name=\"ID\" value=" . $_POST["ID"] . "><br>";
	echo "<input type=\"submit\" name=\"continue\" value=\"Click to continue\" >";
	echo "</form>";
}
?>
</>
</div>    <!-- end .content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>