<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Delete Product";
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
<?php include "header.php"; 
?>
<div class="content">
<?php
include "config_vars.php";
include "getsessionvars.php";
include "sql_connect.php"; // makes $conn


$sql = "DELETE FROM stems  WHERE prod_id = :prod_id ";
try{
	$q=$conn->prepare($sql);
	if (!$q) {
	  echo "\n Prepare DELETE Error PDO::errorInfo():\n";
	  print_r($conn->errorInfo());
	}
	$q->execute(array(':prod_id'=>$_POST[prod_id]));
	$arr = $q->errorInfo();
	if($arr[0]>0){
		  echo "\nExecute DELETE Error PDOStatement::errorInfo():\n";
		  print_r($arr);
	}
	else{
		echo "STEMS DELETED successfully<BR>";
	  }
  }// end try
catch(PDOException $e){
	  echo "DELETE Failed: " . $e->getMessage();
  }
// Now delete Product
	$sql = "DELETE FROM products  WHERE prod_id = :prod_id ";
	try{
	$q=$conn->prepare($sql);
	if (!$q) {
	  echo "\n Prepare DELETE Error PDO::errorInfo():\n";
	  print_r($conn->errorInfo());
	}
	$q->execute(array(':prod_id'=>$_POST[prod_id]));
	$arr = $q->errorInfo();
	if($arr[0]>0){
		echo "\nExecute DELETE Error PDOStatement::errorInfo():\n";
		print_r($arr);
	}
	else{
//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Product DELETED successfully<BR>";
	}
}// end try
catch(PDOException $e){
	  echo "DELETE Failed: " . $e->getMessage();
}
$conn->connection=null;  
echo "<a href=\"../php/listprods.php\"> Continue";
?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>