<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Specials Page";
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
<?php include "header.php"; 
?>
<div class="content">
<?php
  include "getsessionvars.php";
  echo "Sorry, we don't have any specials right now.<BR>But check back often because you never know what kind of crazy deal might be here. <br>";
?>
</div>    <!-- end .content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>
