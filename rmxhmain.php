<html>
<head>
<title> RMXH Test</title></head>
<body>
<?php
echo "<div class=\"container\">";
include "header.php"; 
echo "<div class=\"content\">";
include "config_vars.php";
include "getsessionvars.php";
/*global $currentuser,$userdata;
$servername = "rmxhsql.db.8987649.hostedresource.com";
$username = "rmxhsql";
$password = "Rmxh2015!";
$dbname = "rmxhsql";
  */
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
//$who = "Now Looking for " . $email . " PW= " . $passwd . "<br>"; 
//echo $who;
try {
   $qs = "SELECT * FROM creators WHERE  ID='".$_POST['ID'] ."'" ;
//   echo $qs . "<br>";
   $result=$conn->query($qs);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$userdata=$result->fetch();
	$currentuser=$userdata[ID];
//    echo "Query successful<BR>";
}
catch(PDOException $e){
    echo "Query failed: " . $e->getMessage() . "<BR>";
}
$conn->connection=null;
//echo "user ID=" . $currentuser . "<BR>";

  	echo "Welcome $userdata[Firstname] ";
	echo "<h1>This system is for testing purposes ONLY!</h1>";
 ?>
<form action="../RMXH/edituser.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="ID" value="<?php echo $userdata[ID]; ?>"/>
Name:<input  type="text" name="FirstName" value="<?php echo $userdata[firstname]; ?>"/>
&nbsp<input type="text" name="LastName" value="<?php echo $userdata[lastname]; ?>"/><BR>
<input type="hidden" name="Address1" value="<?php echo $userdata[address1]; ?>"/>
<input type="hidden" name="Address2" value="<?php echo $userdata[address2]; ?>"/>
<input type="hidden" name="City" value="<?php echo $userdata[City]; ?>"/>
<input type="hidden" name="State" value="<?php echo $userdata[State]; ?>"/>
<input type="hidden" name="Zip" value="<?php echo $userdata[Zip]; ?>"/>
<input type="hidden" name="email" value="<?php echo $userdata[email]; ?>"/>
<input type="hidden" name="pword" value="<?php echo $userdata[pword]; ?>"/>
<input type="submit" value="Edit user info">
</form>
<br>

<form action="../RMXH/listsongs.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="ID" value="<?php echo $userdata[ID]; ?>"/>
<input type="submit" value="List Songs">
</form>

<form action="../RMXH/addsong.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="ID" value="<?php echo $userdata[ID]; ?>"/>
<input type="submit" value="Add Song">
</form>
</div> <BR> <!-- end .content <?php include "footer.php";?> -->

</div>  <!-- end .container -->
</body>
</html>
