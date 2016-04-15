<?php
session_start();
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
$email=$_POST[email];
echo "Checking if " . $email . " user exists?<br>";

include "sql_connect.php"; // makes $conn
try {
   $qs = "SELECT * FROM creators WHERE  email='".$email ."'" ;
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
$stored_password = $userdata[pword];
if($result->rowcount()>0){
	echo "User " . $userdata[ID] . $userdata[email] . "Exists!<BR>";
	$dataerr=1;
}
else{
//  echo "Passwords :" . $_POST[pword] . "  " . $_POST[V_pword] . " <br>";

	if ($_POST[pword]!= $_POST[V_pword]){ //Check password'
		$dataerr=1;
	  echo "<h1>Passwords don't match" . $_POST[pword] . "  " . $_POST[V_pword] . " </h1><br>";
	}
	else if ($_POST[email]!= $_POST[V_email]){ // Check Email
		$dataerr=2;
	  echo "<h1>Emails don't match</h1><br>";
	}
	else{
		include "sql_connect.php"; // makes $conn
		try{
//	  echo "Connected successfully<BR>";
			$salt = "000";
		// mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
			$hpasswd = crypt($_POST[pword], $salt);
		//$hpasswd =password_hash($_POST[pword], PASSWORD_DEFAULT);
			$emailverfied=0;
			$sql = "INSERT INTO creators  (firstname,lastname,address1,address2,City,State,Zip,EV,email,pword,salt) VALUES(:FirstName,:LastName,:Address1, :Address2, :City,:State,:Zip,:EV,:email,:hpasswd,:salt)";

//echo $sql . "<BR>";  
			$q=$conn->prepare($sql);
			if (!$q) {
				echo "\nPDO::errorInfo():\n";
				print_r($conn->errorInfo());
			}
	  // use exec() because no results are returned
			$q->execute(array(':FirstName'=>$_POST[FirstName],':LastName' =>$_POST[LastName],':Address1'=>$_POST[Address1], ':Address2'=>$_POST[Address2], ':City'=>$_POST[City],':State'=>$_POST[State],':Zip'=>$_POST[Zip],':EV'=>$emailverfied,':email'=>$_POST[email],':hpasswd'=>$hpasswd,':salt'=>$salt  ));
			$arr = $q->errorInfo();
			if($arr[0]>0){
				echo "\nPDOStatement::errorInfo():\n";
				print_r($arr);
			}
			else{
	//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo "New User created successfully";
				$_SESSION["firstname"]=$_POST[FirstName];
				$_SESSION["lastName"]=$_POST[LastName];
				$_SESSION["address1"]=$_POST[Address1];
				$_SESSION["address2"]=$_POST[Address2];
				$_SESSION["City"]=$_POST[City];
				$_SESSION["State"]=$_POST[State];
				$_SESSION["Zip"]=$_POST[Zip];
				$_SESSION["EmailVerified"]=$_POST[EV];
				$_SESSION["email"]=$_POST[email];
echo $_SESSION["email"] . " S email<br>";
			}
		}// end try
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		try {
	    $qs = "SELECT * FROM creators WHERE  email='".$_SESSION["email"] ."'" ;
//		$qs = "SELECT * FROM creators WHERE  email='".$email ."'" ;
echo $qs . "  find ID<br>";
			$result=$conn->query($qs);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$userdata=$result->fetch();
echo "Query successful email=" . $userdata["email"] . "<BR>";
			$_SESSION["user_id"]=$userdata[ID];// get user_id
echo $_SESSION["user_id"] . "=UID<br>";
			include "sendVemail.php"; // makes $conn
		}
		catch(PDOException $e){
		    echo "Get new User ID Query failed: " . $e->getMessage() . "<BR>";
		}
	}
}
$conn->connection=null;  
if ($dataerr>0){
echo"Try Again <BR>";
  echo "<form action=\"../php/newuser.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"hidden\" name=\"FirstName\" value=" . $_POST["FirstName"] . ">";
  echo "<input type=\"hidden\" name=\"LastName\" value=" . $_POST["LastName"] . ">";
  echo "<input type=\"hidden\" name=\"Address1\" value=" . $_POST["Address1"] . ">";
  echo "<input type=\"hidden\" name=\"Address2\" value=" . $_POST["Address2"] . ">";
  echo "<input type=\"hidden\" name=\"City\" value=" . $_POST["City"] . ">";
  echo "<input type=\"hidden\" name=\"State\" value=" . $_POST["State"] . ">";
  echo "<input type=\"hidden\" name=\"Zip\" value=" . $_POST["Zip"] . ">";
  echo "<input type=\"hidden\" name=\"email\" value=" . $_POST["email"] . ">";
  echo "<input type=\"hidden\" name=\"EV\" >";
  echo "<input type=\"hidden\" name=\"pword\" value=" . $_POST["pword"] . ">";
  echo "<input type=\"hidden\" name=\"V_pword\" value=\"\">";
  echo "<input type=\"hidden\" name=\"refill\" value=\"1 \" >";
  echo "<input type=\"submit\" name=\"Retry\" value=\"Retry it\">";
  echo "</form>";
}
else{ // add user successful, go to remixhits
//echo "passwd=" . $_POST[pword] . "  email=" . $_POST[email] . "/><br>";
	echo "A verification email has been sent to " .  $_SESSION["email"] . "<br>Please respond to enjoy your RMXH accout. <BR>";
  echo "<form action=\"../php/rmxhmain.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"hidden\" name=\"ID\" value=" . $_SESSION["user_id"] . "><br>";
  echo "<input type=\"submit\" name=\"continue\" value=\"Click to continue\" >";
  echo "</form>";
}
?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>