<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Product List X";
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
<?php 
include "header.php"; 
echo "<div class=\"content\">";

include "config_vars.php";
include "getsessionvars.php";
//echo "try conn UID=" . $user_id . "<BR>";
include "sql_connect.php"; // makes $conn
try{
    $stmt = $conn->prepare("SELECT products.prod_id,products.prod_name,products.price,products.Title_text, prod_photos.Name FROM products, prod_photos WHERE  prod_photos.position=0 AND products.prod_id = prod_photos.prod_id ");
	if(!$stmt->execute()){
		echo "Execute Error";
	}
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	echo "<h2>Remix Hits Products</h2>";
//Set up table to display search results<br>
echo "Displaying " . $stmt->rowcount() . " Products" ;
echo "<table class=\"prodtable\">";
	$go=1;
	while($go){
		echo "<tr>";
		for($i=0;$i<3;$i++) {
			if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//				"";
				echo "<td><a href=\"showproduct.php?pid=" . $row["prod_id"] . "\">";
				echo " <div class=\"productbox\"><h1>" . $row["prod_name"] . "</h1> ";
				echo "</h1><img class=\"productboximg\" src=\"". $prod_pic_dir ."/" . $row["Name"] . "\" ><p>" . $row["Title_text"] . "</p>";
				echo "Price:" . $row["price"] ;
		echo "</div></a></td>";// end product box
			}
			else {
				$go=0;
//				echo "BROKE";
				break;
			}
		}//Fend
		echo "</tr>";// end product row
//				echo "next row";
//		echo "<br>";
	}//Wend
	echo "</table>";// end product row
	//echo "Connected successfully";
	}
catch(PDOException $e){
    echo "Querry failed: " . $e->getMessage();
}
$conn->connection=null;

echo "<br></div>"; //<!-- end content -->
include "footer.php";
?>
</div>  <!-- end .container -->
</body>
</html>
