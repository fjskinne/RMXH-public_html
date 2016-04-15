<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Login Page";
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
    <p>Welcome to Remix DB Demo 5</p>
    <form action="../../php/getuserid.php" method="POST" target="_self" accept-charset="UTF-8"
    enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
    Email: <input type="text" name="email"><br>
    Password: <input type="Password" name="passwd"><br>
    <input type="submit" value="Submit">
    </form>
  </div> <!-- end content -->
<BR>

</div>  <!-- end .container <?php include "footer.php";?>-->
</body>
</html>