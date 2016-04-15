<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Delete Song";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />

<title> RMXH delete song() PHP</title>
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

$sql = "DELETE FROM songs  WHERE ID = :song_id ";
echo "DELETE FROM songs<BR>";  
try{
	$q=$conn->prepare($sql);
	if (!$q) {
	  echo "\n Prepare DELETE Error PDO::errorInfo():\n";
	  print_r($conn->errorInfo());
	}
	else{
//	  echo "Prepare Update OK<BR>";  
  }
  $q->execute(array(':song_id'=>$_POST[song_id]));
	  $arr = $q->errorInfo();
	  if($arr[0]>0){
		  echo "\nExecute DELETE Error PDOStatement::errorInfo():\n";
		  print_r($arr);
	  }
	  else{
//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Product DELETED successfully";
	  }
  }// end try
catch(PDOException $e){
	  echo "DELETE Failed: " . $e->getMessage();
  }

$sql = "DELETE FROM song_to_stem  WHERE Song_ID = :song_id ";
echo "DELETE FROM song_to_stem<BR>";  
try{
	$q=$conn->prepare($sql);
	if (!$q) {
	  echo "\n Prepare S2S DELETE Error PDO::errorInfo():\n";
	  print_r($conn->errorInfo());
	}
	else{
//	  echo "Prepare Update OK<BR>";  
  }
  $q->execute(array(':song_id'=>$_POST[song_id]));
	  $arr = $q->errorInfo();
	  if($arr[0]>0){
		  echo "\nExecute S2S DELETE Error PDOStatement::errorInfo():\n";
		  print_r($arr);
	  }
	  else{
//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Song DELETED successfully";
	  }
  }// end try
catch(PDOException $e){
	  echo "DELETE Failed: " . $e->getMessage();
  }


$conn->connection=null;  

  echo "<form action=\"../php/managesongs.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "<input type=\"submit\" name=\"continue\" value=\"Click to continue\" >";
  echo "</form>";

?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>