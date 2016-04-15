<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Use Existing Product Photo";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

<title>RMXH Use Existing Product Photo</title>
</head>
<body>
<div class="container">
<?php
include "header.php";
?>
<div class="content">
<?php
include "config_vars.php";
include "getsessionvars.php";
if (isset($_GET['pid']) && is_numeric($_GET['pid']))
 {
 // get id value
 $prod_id = $_GET['pid'];
 }
 else{
	 $prod_id=0;
 }
if (isset($_GET['picpos']) && is_numeric($_GET['picpos']))
 {
 // get id value
 $picpos = $_GET['picpos'];
 }
 else{
	 $picpos=0;
 }
echo "PID=" . $prod_id . " picpos=" . $picpos . "<BR>";
echo "Ppd=" . $prod_pic_dir . "<BR>";
$files = scandir($prod_pic_dir);
//$files = array_diff(scandir($prod_pic_dir), array('..', '.'));
$i=2;
$go=1;
echo "<table class=\"existphoto\">";
//echo "<table class=\"existphoto\"><th width=\"22%\"</th><th width=\"22%\"</th><th width=\"22%\"</th><th width=\"22%\"</th>";
while($go){
	echo "<tr>";
	for($x=0;$x<4;$x++){
		if($files[$i]){
			echo "<td><a href=\"setphoto.php?pid=" . $prod_id . "&picpos=" . $picpos ."&pname=" . $files[$i] . "\">";
			echo "<img src=\"" . $prod_pic_dir . "/" .$files[$i]. "\" >";
			echo $files[$i++] . "</a></td>";// end product box
		}
		else {
			$x=5;
			$go=0;
		}	
	}
	echo "</tr>";
}
echo "</table>";
$uploadOk = 1;
/*
include "sql_connect.php"; // makes $conn
try{
	$qs = $conn->prepare("SELECT * From prod_photos WHERE prod_id=? AND position=?");
	 	echo "prod ID=" . $prod_id . "basname=" . $basename . "<BR>";
//echo "Prepare OK<BR>";
	 	$qs->execute(array($prod_id,$picpos));
//echo "Execute OK<BR>";
	if($qs->rowCount()>0){ //exists, update it
//echo "Record exists<BR>";
		$qs = "UPDATE prod_photos  SET Name=? WHERE  prod_id=? AND position=?";
	 	echo "prod ID=" . $prod_id . "basname=" . $basename . "<BR>";
	 	$q=$conn->prepare($qs);
	 	$q->execute(array($basename,$prod_id,$picpos));
	  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result = $q->setFetchMode(PDO::FETCH_ASSOC);
	}
	else{ // no record so create it
//echo "No Photos<BR>";
		$qs = "INSERT INTO prod_photos  ( Name, prod_id, position) VALUES(:Name, :prod_id, :position)";
	 	echo "prod ID=" . $prod_id . "basname=" . $basename . "<BR>";
	 	$q=$conn->prepare($qs);
	 	$q->execute(array(':Name'=>$basename,':prod_id'=>$prod_id  ,':position'=>$picpos));
	  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result = $q->setFetchMode(PDO::FETCH_ASSOC);
  }
}// end try
catch(PDOException $e){
	  echo "Update failed: " . $e->getMessage() . "<BR>";
    $uploadOk = 0;
}
$conn->connection=null;
 *
 */
if($uploadOk ){
	echo"Update successful";}
else {	echo"Update FAILED";}
	echo "<form action=\"../php/newproduct.php?pid=" . $prod_id . "\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\" enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"hidden\" name=\"ID\" value=" . $_SESSION["user_id"] . "><br>";
  echo "<input type=\"submit\" name=\"continue\" value=\"Click to continue\" >";
  echo "</form>";

?>

</div><!-- end .content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>