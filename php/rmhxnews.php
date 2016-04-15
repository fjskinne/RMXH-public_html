<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH News Page";
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
<?php include "header.php"; ?>
<div class="content">
<p class="content">
<?php
  include "getsessionvars.php";
  echo "Here is the latest News Flash from Remix Hits<BR>";
  echo "<a href=\"../index.php\">Home</a><BR />";
?>
</p>
</div>    <!-- end .content -->
<div class="footer">
<?php include "footer.php";?>
</div>    <!-- end .footer -->
</div>  <!-- end .container -->
</body>
</html>
