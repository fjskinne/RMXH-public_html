<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Admin Main Page";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

<title> RMXH admin() PHP</title>

</head>
<body>
<div class="container">
<?php include "adminheader.php"; 
//	  include "topnavbar.php"; 
?>
<div class="content">
Welcome to the Administration Area
<?php
    include "config_vars.php";
	include "getsessionvars.php";

//  echo "<h1>This system is for testing purposes ONLY!</h1>";
//  echo "Name:" . $firstname . " " . $lastname . "<BR>";
//  echo "<a href=\"../../php/edituser.php\">Edit Your Info</a><BR />";
//  echo "<br>";
//  echo "<a href=\"../../php/listsongs.php\">List Your Songs</a><BR />";
//  echo "<a href=\"../../php/newsong.php\">Upload New Song</a><BR />";
?>
</div>    <!-- end .content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>
