<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH getuserid()";
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
function hash_equals($str1, $str2) {
    if(strlen($str1) != strlen($str2)) {
      return false;
    } else {
      $res = $str1 ^ $str2;
      $ret = 0;
      for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
      return !$ret;
    }
}
include "header.php"; 
echo "<div class=\"content\">";

include "config_vars.php";
include "getsessionvars.php";
include "sql_connect.php"; // makes $conn
$email=$_POST[email];
$passwd=$_POST[passwd];
try {
   $qs = "SELECT * FROM creators WHERE  email='".$email ."'" ;
//      echo $qs . "<br>";
  $result=$conn->query($qs);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$userdata=$result->fetch();
	//$salt=$userdata[salt];
//   echo "Query error=" . print_r($result->errorinfo()) . "<BR>";
//   echo "Query successful Name=" . $userdata["email"] . "<BR>";
}
catch(PDOException $e){
    echo "Query failed: " . $e->getMessage() . "<BR>";
}
//if($result)echo "Result OK<BR>";
//if($userdata)echo "Fetch OK<BR>";
$stored_password = $userdata[pword];
$conn->connection=null;
//echo "SP=" . $stored_password . "<BR>";
/// use if php 5.5 available syntax?
//$hpasswd=password_hash($passwd,PASSWORD_DEFAULT);
//if (password_verify($hashed_password, $stored_password])) {
if (hash_equals($stored_password, crypt($passwd, $stored_password))) {
	// logged in, put current user values in session variables
	$_SESSION["user_id"] = $userdata[ID];	
	$_SESSION["firstname"] = $userdata[firstname];
	$_SESSION["lastname"] = $userdata[lastname];
	$_SESSION["address1"] = $userdata[address1];
	$_SESSION["address2"] = $userdata[address2];
	$_SESSION["City"] = $userdata[City];
	$_SESSION["State"] = $userdata[State];
	$_SESSION["Zip"] = $userdata[Zip];
	$_SESSION["EmailVerified"] = $userdata[EmailVerified];
	$_SESSION["email"] = $userdata[email];
	$_SESSION["UP_Name"] = $userdata[UP_Name];
	$_SESSION["User_level"] = $userdata[userlevel];

  	echo "<BR><BR>Welcome User#" . $_SESSION["user_id"] . " Name:" .$_SESSION["firstname"] . " " . $_SESSION["lastname"] . " User level=" . $_SESSION["User_level"] . "<BR>";
	echo "<BR>";

	echo "<a href=\"../index.php\">Click to continue</a>";
}
else {
	$_SESSION["user_id"] = 0;
  	echo "<BR>Bad Password for: $email $passwd" ;
	echo "<form action=\"/index.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
	echo "<input type=\"submit\" value=\"Try Again\" >
	</form>";
}
?>
</div><!--end content -->
      <?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>
