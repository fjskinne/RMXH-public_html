<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH New Song:";
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
<p class="content">
<?php
include "config_vars.php";
include "getsessionvars.php";
include "sql_connect.php"; // makes $conn
try{
	$sql = "INSERT INTO songs (Creator,Title) VALUES('"  . $user_id . "','" . $_POST[Title]. "')";
//echo $sql . "<BR>";  
//	  $q=$conn->prepare($sql);
//	  if (!$q) {
//		  echo "<BR>Prepare: PDO::errorInfo():\n";
//		  print_r($conn->errorInfo());
//	  }
	  // use exec() because no results are returned
//	  $q->execute(array(':Creator'=>$user_id,':Title' =>$_POST[Title]));
		if(	  $conn->query($sql)===TRUE){
			echo "song added OK<BR>";
		}
//	  $arr = $q->errorInfo();
//	  if($arr[0]>0){
//		  echo "\nPDOStatement::errorInfo():\n";
//		  print_r($arr);
//	  }
//	  else{
//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "New Added successfully" .$_POST[Title] ;
//	  }
}// end try
catch(PDOException $e)
{
	  echo "Connection failed: " . $e->getMessage();
}
$conn->connection=null;  
  echo "<form action=\"../php/newsong.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"submit\" name=\"Add Another Song\" value=\"Add\" >";
  echo "</form>";
  
  echo "<form action=\"../php/rmxhmain.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "   <input type=\"submit\" name=\"Done Adding Songs\" value=\"Done\" >";
  echo "</form>";
?>
</p>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>