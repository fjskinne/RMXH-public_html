<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

<title> RMXH adduser() PHP</title>
</head>
<body>
<div class="container">
<?php
include "header.php";
?>
<div class="content">
<?php
include "getsessionvars.php";

$basename=basename($_FILES["fileToUpload"]["name"]);
echo "UPD=" . $user_photodir . "<BR>";
echo "Basename=" . $basename . "<BR>";
$target_file = $user_photodir . "/" .  $basename;
echo "T file=" . $target_file . "<BR>";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
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
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } 
	else {
        echo "Sorry, there was an error uploading your file.";
    }
}
include "sql_connect.php"; // makes $conn
  if( $conn) try {
	 $qs = "UPDATE creators  SET UP_Name=? WHERE  ID=?";
	 echo "UID=" . $user_id . "basname=" . $basename . "<BR>";
	 $q=$conn->prepare($qs);
	 $q->execute(array($basename,$user_id));
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$_SESSION["UP_Name"] =  $basename;
  }
  catch(PDOException $e){
	  echo "Update failed: " . $e->getMessage() . "<BR>";
  }
  $conn->connection=null;
	echo"Update successful";
	echo "<form action=\"../php/rmxhmain.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\" enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"hidden\" name=\"ID\" value=" . $_SESSION["user_id"] . "><br>";
  echo "<input type=\"submit\" name=\"continue\" value=\"Click to continue\" >";
  echo "</form>";

?>

</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>