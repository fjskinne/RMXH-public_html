<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Product List";
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
//echo "try conn UID=" . $user_id . "<BR>";
include "sql_connect.php"; // makes $conn
try{
    $stmt = $conn->prepare("SELECT prod_name,prod_id FROM products ");
	if(!$stmt->execute()){
		echo "Execute Error";
	}

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//Set up table to display search results
echo "<h2>Remix Hits Product List</h2><BR>";

echo "<form action=\"newproduct.php\" method=\"POST\" name=\"table\">";
echo "<table border=1 align=\"center\">";
echo "<tr>";
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Product Name</th></tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
echo "<tr>\n";
//  foreach($row as $value) {
      echo "<td>" . $row["prod_id"] . "  " .  $row["prod_name"] . "</td>";
//   }
//	echo "<td><input name=\"prod_id'\" type=\"submit\" value=\" " . $row['prod_id']. "\"></td>";
	echo '<td><a href="newproduct.php?pid=' . $row['prod_id'] . '">Edit</a></td>';
	echo '<td><a href="con_del_prod.php?pid=' . $row['prod_id'] . '">Delete</a></td>';
	echo "</tr>\n";
}
echo "</table>";
echo "</form>";
//  echo "Connected successfully";
}
catch(PDOException $e){
    echo "Querry failed: " . $e->getMessage();
}

$conn->connection=null;

 ?>
<BR>
<a href="newproduct.php?pid=0">New Product</a>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>
