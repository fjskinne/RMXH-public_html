<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
$servername = "rmxhsql.db.8987649.hostedresource.com";
$username = "rmxhsql";
$password = "Rmxh2015!";
$dbname = "rmxhsql";
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
  try {
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  // set the PDO error mode to exception
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//	  echo "Connected successfully<BR>";
		$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
		$hpasswd = crypt($pass, '$6$'.$salt);
		$emailverfied=0;
	  $sql = "INSERT INTO creators  (firstname,lastname,address1,address2,City,State,Zip,EmailVerified,email,pword,salt) VALUES(:FirstName,:LastName,:Address1, :Address2, :City,:State,:Zip,:EmailVerified,:email,:hpasswd,:salt)";

//echo $sql . "<BR>";  
	  $q=$conn->prepare($sql);
	  if (!$q) {
		  echo "\nPDO::errorInfo():\n";
		  print_r($conn->errorInfo());
	  }
	  // use exec() because no results are returned
	  $q->execute(array(':FirstName'=>$_POST[FirstName],':LastName' =>$_POST[LastName],':Address1'=>$_POST[Address1], ':Address2'=>$_POST[Address2], ':City'=>$_POST[City],':State'=>$_POST[State],':Zip'=>$_POST[Zip],':EmailVerified'=>$emailverfied,':email'=>$_POST[email],':hpasswd'=>$hpasswd,':salt'=>$salt  ));
	  $arr = $q->errorInfo();
	  if($arr[0]>0){
		  echo "\nPDOStatement::errorInfo():\n";
		  print_r($arr);
	  }
	  else{
//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "New User created successfully";
	  }
  }// end try
  catch(PDOException $e)
	  {
	  echo "Connection failed: " . $e->getMessage();
  }

$email=$_POST[email];
try {
   $qs = "SELECT * FROM creators WHERE  email='".$email ."'" ;
//   echo $qs . "<br>";
   $result=$conn->query($qs);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$userdata=$result->fetch();
	$currentuser=$userdata[ID];
}
catch(PDOException $e){
    echo "Query failed: " . $e->getMessage() . "<BR>";
}
$conn->connection=null;  
}
if ($dataerr>0){
echo"Try Again <BR>";
  echo "<form action=\"../RMXH/newuser.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"hidden\" name=\"FirstName\" value=" . $_POST["FirstName"] . ">";
  echo "<input type=\"hidden\" name=\"LastName\" value=" . $_POST["LastName"] . ">";
  echo "<input type=\"hidden\" name=\"Address1\" value=" . $_POST["Address1"] . ">";
  echo "<input type=\"hidden\" name=\"Address2\" value=" . $_POST["Address2"] . ">";
  echo "<input type=\"hidden\" name=\"City\" value=" . $_POST["City"] . ">";
  echo "<input type=\"hidden\" name=\"State\" value=" . $_POST["State"] . ">";
  echo "<input type=\"hidden\" name=\"Zip\" value=" . $_POST["Zip"] . ">";
  echo "<input type=\"hidden\" name=\"email\" value=" . $_POST["email"] . ">";
  echo "<input type=\"hidden\" name=\"V_email\" >";
  echo "<input type=\"hidden\" name=\"pword\" value=" . $_POST["pword"] . ">";
  echo "<input type=\"hidden\" name=\"V_pword\" value=\"\">";
  echo "<input type=\"hidden\" name=\"refill\" value=\"1 \" >";
  echo "<input type=\"submit\" name=\"Retry\" value=\"Retry it\">";
  echo "</form>";
}
else{ // add user successful, go to rmxhmain
	echo "<a href=\"../../php/rmxhmain.php\">Click to continue</a>";
}
?>
</body>
</html>