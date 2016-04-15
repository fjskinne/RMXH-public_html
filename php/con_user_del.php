<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH add or edit product";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />
<title>RMXH Confirm Song Delete</title>
</head>
<body>
<div class="container">
<?php include "header.php"; 
?>
<div class="content">
<?php
include "getsessionvars.php";

if (isset($_GET['pid']) && is_numeric($_GET['pid']))
 {
 // get id value
echo "<H1>CONFIRM USER DELETION<BR>";
echo "This function is inactive at this time<BR>";
	echo "<form action=\"../php/con_user_del.php?pid= confirmed=1\" id=\"newproduct\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
//	echo "ID=<input type=\"text\" name=\"song_id\" value= \"" . $song_id . "\"><br>";
//	echo "Song Title: <input type=\"text\" name=\"Songtitle\" value= \"" . $Title . "\"><br>";
	echo "<input type=\"submit\" value=\"Confirm Deletion?\"> ";
	echo "</form>";
 }
 else{
	 $user_id=0;
 }

?>
<a href="admin_list_users.php">Cancel</a>

</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>