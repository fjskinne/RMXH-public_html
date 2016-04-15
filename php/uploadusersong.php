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
//echo "upload song UPD=" . $user_photodir . "<BR>";
echo "Basename=" . $basename . "<BR>";
$target_dir=$usersongdir . "/" . $user_id ;
$target_file =  $target_dir . "/" .  $basename;
echo "T dir=" . $target_dir . "<BR>";
echo "T file=" . $target_file . "<BR>";
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
/*
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
*/
 // Check file size may need to adjust? Change to sessionvar?
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "wav" && $FileType != "mp3" && $FileType != "mp4"
&& $FileType != "wma" ) {
    echo "Sorry, only WAV, MP3, MP4 & WMA files are allowed.";
    $uploadOk = 0;
}
if (! file_exists($target_dir)) {
	if(mkdir($target_dir)){
		echo "The directory " . $target_dir . "was created<BR>";
	}
	else $uploadOk=0;
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
        echo "Sorry, there was an error uploading your file.";
    }
}
include "sql_connect.php"; // makes $conn
  if( $conn) try {
	  $sql = "INSERT INTO songs (Creator,Title,SF_name) VALUES('"  . $user_id . "','" . $_POST[Title]. "','" . $basename. "')";
echo $sql . "<BR>";  
//	  $q=$conn->prepare($sql);
//	  if (!$q) {
//		  echo "<BR>Prepare: PDO::errorInfo():\n";
//		  print_r($conn->errorInfo());
//	  }
	  // use exec() because no results are returned
//	  $q->execute(array(':Creator'=>$user_id,':Title' =>$_POST[Title]));
		if(	  $conn->query($sql)===TRUE){
			echo"Song Upload Successful";
		}
  }
  catch(PDOException $e){
	  echo "Song upload failed: " . $e->getMessage() . "<BR>";
  }
  $conn->connection=null;
	echo "<a href=\"../../php/rmxhmain.php\">Cancel </a>";
?>

</div>
<div class="footer">
<?php include "footer.php";?>
</div>    <!-- end .footer -->
</div>  <!-- end .container -->
</body>
</html>