<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Rights List";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />
<title> RMXH listrights() PHP</title>
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
    $stmt = $conn->prepare("SELECT Company,ID, FirstName,LastName FROM creators ");
	if(!$stmt->execute()){
		echo "Execute Error";
	}

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//Set up table to display search results
echo "<h2>Remix Hits Rights Holder List</h2><BR>";

echo "<form action=\"edit_r_holder.php\" method=\"POST\" name=\"table\">";
echo "<table border=1 align=\"center\">";
echo "<tr>";
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Right Holder</th></tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
echo "<tr>\n";
//  foreach($row as $value) {
      echo "<td>" . $row["ID"] . "  " .  $row["Company"] .  $row["FirstName"] .  $row["LastName"] . "</td>";
//   }
//	echo "<td><input name=\"prod_id'\" type=\"submit\" value=\" " . $row['prod_id']. "\"></td>";
	echo '<td><a href="edit_r_holder.php?pid=' . $row['ID'] . '">Edit</a></td>';
	echo '<td><a href="con_rh_del.php?pid=' . $row['ID'] . '">Delete</a></td>';
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
<a href="edit_r_holder.php?pid=0">New</a>

</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>
