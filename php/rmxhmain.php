<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Main Page";
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
<BR />
<?php
  include "getsessionvars.php";
//  include "show_s_vars.php";
/*
echo "Session Variables are :";
echo "<BR>username:" . $username;
echo "<BR>servername" . $servername;
echo "<BR>password:" . $password;
echo "<BR>dbname:" . $dbname;
echo "<BR>user_id:" . $user_id;	
echo "<BR>firstname:" . $firstname;
echo "<BR>lastname:" . $lastname;
echo "<BR>Address1:" . $Address1;
echo "<BR>Address2:" . $Address2;
echo "<BR>City:" . $City;
echo "<BR>State:" . $State;
echo "<BR>Zip:" . $Zip;
echo "<BR>EmailVerified=" . $emailverfied;
echo "<BR>email=" . $email;
*/
  echo "<h1>This system is for testing purposes ONLY!</h1>";
  echo "Name:" . $firstname . " " . $lastname . "<BR>";
  echo "<a href=\"../../php/edituser.php\">Edit Your Info</a><BR />";
//  echo "<br>";
  echo "<a href=\"../../php/listuserprods.php\">List Your Purchases</a><BR />";
  echo "<a href=\"../../php/listsongs.php\">List Your Songs</a><BR />";
  echo "<a href=\"../../php/newsong.php\">Upload New Song</a><BR />";
?>
</div>    <!-- end .content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>
