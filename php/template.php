<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Template Page";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

<title> RMXH remixhits() PHP</title>

</head>
<body>
<div class="container">
<?php 
include "header.php"; 
echo "<div class=\"content\">";
include "getsessionvars.php";

// put stuff here


echo "</div>";//    <!-- end .content -->
echo "<div class=\"footer\">";
include "footer.php";
echo "</div></div>";     // end .footer -, end .container -->

?>
</body>
</html>
