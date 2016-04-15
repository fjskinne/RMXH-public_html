<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Upload Product Photo";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

<title>RMXH Upload Product Photo</title>
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

$basename=basename($_FILES["fileToUpload"]["name"]);
//echo "UPD=" . $prod_pic_dir . "<BR>";
//echo "Basename=" . $basename . "<BR>";
$target_file = $prod_pic_dir . "/" .  $basename;
//echo "T file=" . $target_file . "<BR>";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
//        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
 // Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<BR>";
    } 
	else {
        echo "Sorry, there was an error uploading your file.<BR>";
    }
}
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