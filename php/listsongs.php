<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH List Songs";
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
try{
    $stmt = $conn->prepare("SELECT Title FROM songs WHERE Creator='".$user_id ."'");
	if(!$stmt->execute()){
		echo "Execute Error";
	}

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
echo "<h2>Song List for:" . $user_id . " - " . $firstname . " " . $lastname . "<BR></h2>";
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Title</th></tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  foreach($row as $value) {
      echo "<td>{$value}</td>";
   }
   echo "</tr>";
}
echo "</table>";
//  echo "Connected successfully";
}
catch(PDOException $e){
    echo "Query failed: " . $e->getMessage();
}

$conn->connection=null;
echo "<a href=\"../../php/rmxhmain.php\">Return to User Page </a>";
?>
<BR>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>
