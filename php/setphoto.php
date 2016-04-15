<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Set Product Photo";
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
//echo "PID=" . $prod_id . " picpos=" . $picpos . "<BR>";

$basename=basename($_GET["pname"]);
//echo "UPD=" . $prod_pic_dir . "<BR>";
//echo "Basename=" . $basename . "<BR>";
//$target_file = $prod_pic_dir . "/" .  $basename;
//echo "T file=" . $target_file . "<BR>";
$uploadOk = 1;
include "sql_connect.php"; // makes $conn
try{
	$qs = $conn->prepare("SELECT * From prod_photos WHERE prod_id=? AND position=?");
//echo "prod ID=" . $prod_id . "basname=" . $basename . "<BR>";
//echo "Prepare OK<BR>";
	 	$qs->execute(array($prod_id,$picpos));
//echo "Execute OK<BR>";
	if($qs->rowCount()>0){ //exists, update it
//echo "Update Photo<BR> prod ID=" . $prod_id . "Position=" . $picpos . "<BR>";
		$qs = "UPDATE prod_photos  SET Name=? WHERE  prod_id=? AND position=?";
	 	$q=$conn->prepare($qs);
	 	$q->execute(array($basename,$prod_id,$picpos));
	  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result = $q->setFetchMode(PDO::FETCH_ASSOC);
	}
	else{ // no record so create it
//echo "Add Photo prod ID=" . $prod_id . "Position=" . $picpos . "<BR>";
		$qs = "INSERT INTO prod_photos  ( Name, prod_id, position) VALUES(:Name, :prod_id, :position)";
//echo "prod ID=" . $prod_id . "basname=" . $basename . "<BR>";
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
if($uploadOk ){
	echo "Added Photo " . $basename . " to  prod ID=" . $prod_id . " in Position=" . $picpos . "<BR>";
	echo"Update successful";
}
else {	echo"Update FAILED";}
echo '<br><a href="newproduct.php?pid=' . $prod_id . '">Continue</a>';

?>

</div><!-- end .content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>