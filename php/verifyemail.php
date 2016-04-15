<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Verify Email";
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
echo "<div class=\"content\">";
include "config_vars.php";
include "getsessionvars.php";
if (isset($_GET['uid']) && is_numeric($_GET['uid'])){
 // get id value
	$user_id = $_GET['uid'];
echo "Now Looking for " . $user_id . "<br>";
	include "sql_connect.php"; // makes $conn
	try {
		$qs = "SELECT * FROM creators WHERE  ID='".$user_id ."'" ;
		echo $qs . "<br>";
		$result=$conn->query($qs);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$userdata=$result->fetch();
	}
	catch(PDOException $e){
	    echo "Query failed: " . $e->getMessage() . "<BR>";
	}
	echo"got user data<BR>";
	if($userdata[userlevel]==0){
		$ul=1;
	}
	else {
		$ul=1;
	}
	try{ 
		$qs = "UPDATE creators  SET EV=?,userlevel=? WHERE  ID=?";
//	 echo $qs . "<BR>";
		$q=$conn->prepare($qs);
		$q->execute(array(1, $ul,$user_id));
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //    echo "Query successful<BR>";
	}
	catch(PDOException $e){
		echo "Update failed: " . $e->getMessage() . "<BR>";
	}
	echo"Email Verified<BR>";
}
else{
	 $user_id=0;
}
?>


<a href="../index.php">Click to login</a> 
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>