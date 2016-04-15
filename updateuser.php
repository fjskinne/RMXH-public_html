<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Update User Info";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php	echo "<title>" . $_REQUEST['pageTitle'] . "</title>"; ?>
</head>
<body>
<?php 
if ($_POST["action"] =="update" ){
  $servername = "rmxhsql.db.8987649.hostedresource.com";
  $username = "rmxhsql";
  $password = "Rmxh2015!";
  $dbname = "rmxhsql";
  try {
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  // set the PDO error mode to exception
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //    echo "Connected successfully";
  }
  catch(PDOException $e){
	  echo "Connection failed: " . $e->getMessage();
  }
  $id=$_POST['ID'];
  $passwd=$_POST['passwd'];
  //$who = "Now Looking for " . $email . " PW= " . $passwd . "<br>"; 
  //echo $who;
  //  $data = "SELECT * FROM `creators` WHERE `email` = ' " . $name . "'";
  try {
//	  echo  "name:" . $_POST["FirstName"] . $_POST["LastName"]. "<BR>A1=" . $_POST["Address1"] . "<BR>A2=" . $_POST["Address2"] . "<BR>" . $_POST["City"] . $_POST["State"].$_POST["Zip"]. "<BR>email:" . $_POST["email"] . "<BR>ID:" . $_POST["ID"] . " Pword:" . $_POST["pword"];
	  
	 $qs = "UPDATE creators  SET firstname=?,lastname=?,address1 =?,address2=?, City=?,State=?,Zip=?,email=? WHERE  ID=?";
//	 echo $qs . "<BR>";
	 $q=$conn->prepare($qs);
	 $q->execute(array($_POST["FirstName"], $_POST["LastName"], $_POST["Address1"],$_POST["Address2"], $_POST["City"],$_POST["State"],$_POST["Zip"],$_POST["email"],$_POST["ID"]));
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //    echo "Query successful<BR>";
  }
  catch(PDOException $e){
	  echo "Update failed: " . $e->getMessage() . "<BR>";
  }
  $conn->connection=null;
	echo"Update successful";
}
if ($_POST["action"] =="changepasswd" ){
	echo "change Password";
  echo "<form action=\"../RMXH/changepassword.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "</form>";
}
else {
	echo "Update Cancelled";
}
 ?>
<form action="../RMXH/rmxhmain.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="ID" value="<?php echo $_POST["ID"]; ?>"/><br>
<input type="submit" name="continue" value="Click to continue">
</form>
</body>
</html>