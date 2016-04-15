<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Confirm Product Deletion";
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

include "getsessionvars.php";

if (isset($_GET['pid']) && is_numeric($_GET['pid']))
 {
 // get id value
 	$prod_id = $_GET['pid'];
 }
 else{
	 $prod_id=0;
 }
echo "PID=" . $prod_id . "<BR>";
if($prod_id){
	include "sql_connect.php"; // makes $conn
// check for songs using this product
	$sql = "SELECT stems.prod_id, song_to_stem.Song_Id FROM song_to_stem INNER JOIN stems ON song_to_stem.Stem_ID=stems.Stem_ID WHERE stems.prod_id=" . $prod_id ;
	try{
//      echo $qs . "<br>";
		$stmt = $conn->prepare($sql);
		if(!$stmt->execute()){
			echo "Execute Error";
		}
	    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	    $prod_data=$stmt->fetch();
		$has_songs= $stmt->rowcount();
	}
	catch(PDOException $e){
	    echo "Query failed: " . $e->getMessage() . "<BR>";
	}
	if($has_songs>0){ //  Product has songs
		echo "Product has Song " . $prod_data[Song_Id] . " using it and CANNOT be Deleted<BR>";
	}
	else{
		try{
			$qs = "SELECT * FROM products WHERE  prod_id='".$prod_id ."'" ;
			$result=$conn->query($qs);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$prod_data=$result->fetch();
		}
		catch(PDOException $e){
		    echo "Query failed: " . $e->getMessage() . "<BR>";
		}
		$productname= $prod_data[prod_name];
		$price = $prod_data[price];
		$Title_text = $prod_data[Title_text];
		$Desc_main= $prod_data[desc_main];
		$Desc1 = $prod_data[desc_1];
		$Desc2 = $prod_data[desc_2];
		$Desc3 = $prod_data[desc_3];
/*
echo "p name=" . $productname . "<BR>";
echo "$=" . $price  . "<BR>";
echo "tities=" . $Title_text . "<BR>";
echo "DM=" . $Desc_main . "<BR>";
echo "D1=" . $Desc1 . "<BR>";
echo "D2=" . $Desc2 . "<BR>";
echo "D3=" . $Desc3 . "<BR>";
*/
	
		echo "<H1>CONFIRM PRODUCT DELETION</h1><BR>";
		echo "<form action=\"../php/deleteproduct.php\" id=\"newproduct\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\" enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
		echo "<input type=\"hidden\" name=\"prod_id\" value= \"" . $prod_id . "\"><br>";
		echo "Product Name: <input type=\"text\" name=\"productname\" value= \"" . $productname . "\"><br>";
		echo "Price: <input type=\"text\" name=\"price\" value=" . $price . "><br>";
	 
		echo "<textarea name=\"Title_text\" form=\"newproduct\">" . $Title_text . "</textarea>";
		echo "<textarea name=\"Desc_main\" form=\"newproduct\">" . $Desc_main . "</textarea>";
		echo "<textarea name=\"Desc1\" form=\"newproduct\">" . $Desc1 . "</textarea>";
		echo "<textarea name=\"Desc2\" form=\"newproduct\">" . $Desc2 . "</textarea>";
		echo "<textarea name=\"Desc3\" form=\"newproduct\">" . $Desc3 . "</textarea>";
	
		echo "<input type=\"submit\" value=\"Submit\"> ";
		echo "</form>";
}
	$conn->connection=null;
}
?>
<a href="listprods.php">Continue</a>
</div>  <!-- end .content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>