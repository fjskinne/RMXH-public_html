<html>
<head>
<title> RMXH Test</title></head>
<body>
<?php
global $currentuser,$userdata;
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
$email=$_POST[email];
$passwd=$_POST[passwd];
//$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
//$passh = crypt($pass, '$6$'.$salt);
//$hpasswd=password_hash($passwd,PASSWORD_DEFAULT);
//$who = "getuserid.php Now Looking for user=" . $email . " PW= " . $passwd . "<br>"; 
//echo $who;
try {
   $qs = "SELECT * FROM creators WHERE  email='".$email ."'" ;
//   echo $qs . "<br>";
   $result=$conn->query($qs);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$userdata=$result->fetch();
	$currentuser=$userdata[ID];
	$salt=$userdata[salt];
    echo "Query successful<BR>";
}
catch(PDOException $e){
    echo "Query failed: " . $e->getMessage() . "<BR>";
}
//$passwd=password_hash($_POST['passwd'],PASSWORD_DEFAULT); // use if php 5.5 available syntax?

$hpasswd = crypt($passwd, '$6$'.$salt);
$conn->connection=null;
echo "user ID=" . $currentuser . "<BR>";
echo "hp=" . $hpasswd . "\nUP=" . $userdata[pword];
	if ($hpasswd != $userdata[pword]){
  	echo "<BR>You are not welcome here $email $passwd" ;
	echo "<form action=\"../RMXH/login.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
	echo "<input type=\"submit\" value=\"Try Again\" >
	</form>";
}
else {
  	echo "Welcome $userdata[email] ";
	echo "<h1>This system is for testing purposes ONLY!</h1>";
}

echo "<form action=\"../RMXH/rmxhmain.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate>";
echo "<input type=\"hidden\" name=\"ID\" value=" . $userdata[ID] . "/>";
echo "<input type=\"submit\" value=click to continue >";
echo "</form>";
 ?>
</body>
</html>
