<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Manage Songs";
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
    $stmt = $conn->prepare("SELECT * FROM songs ");
	if(!$stmt->execute()){
		echo "Execute Error";
	}

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	echo "<h2>Song List <BR></h2>";
	echo "<form action=\"newproduct.php\" method=\"POST\" name=\"table\">";
	echo "<table style='border: solid 1px black;'>";
	echo "<tr><th> ID#</th>   <th>Title</th></tr>";
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>";
		echo "<td width=\"25px\">" . $row["ID"] . "</td>";
		echo "<td width=\"250px\">"  . $row["Title"] . "</td>";
//		echo '<td width=\"25px\"><a href="songstems.php?song_id=' . $row['ID'] . '&amp;title='.$row['Title'].' ">STEMS</a></td>';
		echo '<td width=\"25px\"><a href="songstems.php?title=' . $row['Title'] . '&amp;song_id='.$row['ID'].' ">STEMS</a></td>';
		echo '<td width=\"30px\"><a href="songrights.php?song_id=' . $row['ID'] . '&amp;title=' . $row['Title'] .'">Rights</a></td>';
		echo '<td width=\"35px\"><a href="con_song_del.php?song_id=' . $row['ID'] .'&amp;title=' . $row['Title'] . '">Delete</a></td>';
		echo "</tr>\n";
	}
	echo "</table>";
	echo "</form>";
}
catch(PDOException $e){
    echo "Query failed: " . $e->getMessage();
}

$conn->connection=null;

 ?>
<BR>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>
