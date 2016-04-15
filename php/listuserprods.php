<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Your Products";
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
echo "<div class=\"content\">";

include "config_vars.php";
include "getsessionvars.php";

include "sql_connect.php"; // makes $conn
try{
    $stmt = $conn->prepare("SELECT products.prod_name, userpurchases.user_id, userpurchases.ser_num, userpurchases.p_date, userpurchases.upid FROM products ,userpurchases WHERE products.prod_id = userpurchases.prod_id AND userpurchases.user_id='".$user_id ."'");
//    $stmt = $conn->prepare("SELECT Title FROM songs WHERE Creator='".$user_id ."'");
	if(!$stmt->execute()){
		echo "Execute Error";
	}

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
echo "<h2>Purchase List for:" . $user_id . " - " . $firstname . " " . $lastname . "<BR></h2>";
echo "<table style='border: solid 1px black;font-size:small '>";
echo "<tr><th width=\"120px\"> Product </th><th  width=\"230px\">Purchase Date</th><th  width=\"80px\">  Serial #</th></tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr><td>". $row["prod_name"] . "</td>";
      echo "<td>". $row["p_date"] . "</td>";
      echo "<td>". $row["ser_num"] . "</td>";
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
