<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Confirm Product Deletion";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php	echo "<title>" . $_REQUEST['pageTitle'] . "</title>"; ?>
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

</head>
<body>
<?php include "header.php"; 
?>
<div class="content">
<p class="content">
<?php
include "getsessionvars.php";
echo "Add song for:" . $firstname . " " . $lastname . "<BR>";
echo "<form action=\"uploadusersong.php\" method=\"post\" enctype=\"multipart/form-data\">";
  echo "Title: <input type=\"text\" name=\"Title\" ><br>";
  echo "Select song to upload:";
  echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" >";
  echo "<input type=\"submit\" value=\"Upload Song\" name=\"submit\">";
  echo "</form>";
	echo "<a href=\"../../php/rmxhmain.php\">Cancel </a>";
?>
</p>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>