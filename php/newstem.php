<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH New Stem for Product";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Song</title>
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />
<?php	echo "<title>" . $_REQUEST['pageTitle'] . "</title>"; ?>
</head>
<body>
<?php include "header.php"; 

echo "<div class=\"content\">";

include "getsessionvars.php";

if (isset($_GET['pid']) && is_numeric($_GET['pid']))
 {
 // get id value
  $prod_id = $_GET['pid'];
if($_POST[stemname]){ // Then add it
  $name=$_POST['stemname'];
	echo "STEM Name=" . $name . "<br>";
} 
echo "Add STEM for:" . $firstname . " " . $lastname . "<BR>";
echo "<form action=\"newstem.php?pid=" . $prod_id . "\" method=\"post\" enctype=\"multipart/form-data\">";
  echo "STEM Name<input type=\"text\" name=\"stemname\" ><br>";
  echo "Royalty %<input type=\"number\" name=\"royalty\" ><br>";
  echo "<input type=\"submit\" value=\"Add\" name=\"Add\">";
  echo "</form>";
	echo "<a href=\"newproduct.php?pid=" . $prod_id . "\">Continue</a>";
 }
?>

</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>