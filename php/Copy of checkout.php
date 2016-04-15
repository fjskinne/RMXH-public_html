<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Check Out";
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
include "rmxh_functions.php"; 

include "header.php"; 
echo "<div class=\"content\">";
include "config_vars.php";
include "getsessionvars.php";
//include "show_s_vars.php";

$cart_id =0;
if (isset($_POST['cart_id']))//if posted, delete orpdate
{
//echo "POSTED<br>";
	$cart_id = $_POST['cart_id'];
	$prod_id=$_POST['prod_id'];
	if($_POST['cart_act']=="DEL"){
//echo "DEL<br>";
		del_cart_item($cart_id,$prod_id);
	}
	elseif($_POST['cart_act']=="ADD")
	{
//echo "ADD<br>";
		add_cart_item($cart_id,$prod_id);
	 }
}
else{
	if (isset($_GET['cart_id']) && is_numeric($_GET['cart_id']))
	{
 // get id value
		$cart_id = $_GET['cart_id'];
	}
	else{
		$cart_id=0;
	}
}

if($cart_id==0){
	echo "No cart to check out<br>";
  echo "<form action=\"../php/displayprods.php\" method=\"GET\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
  echo "   <input type=\"submit\" name=\"No\" value=\"Product\" >";
  echo "</form>";
}
else{
	echo "<br><div class=\"chkoutuserinfo\">";
echo "Cart ID:" . $cart_id . "<br>";
	echo "     UID=" . $user_id . "<br>";	
	echo "   Name :" .$firstname . " " . $lastname . "<br>";
	echo "Addr. 1 :" . $address1 . "<br>";
	echo "Addr. 2 :" . $address2 . "<br>";
	echo " C,S & Z:" . $City . ", " . $State . " " . $Zip . "<br>";
	echo " E-Mail :" . $email . "<br>";
	echo "</div>";
//$UP_Name=$_SESSION["UP_Name"];
   include "sql_connect.php"; // makes $conn
  try{
    $stmt = $conn->prepare("SELECT cart_items.SC_id, products.prod_id,products.prod_name,products.price FROM products, cart_items WHERE  sc_id='" . $cart_id . "'  AND sc_prod_id= prod_id"); 
	if(!$stmt->execute()){
		echo "Execute Error";
	}
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	echo "<h2>Products in Cart</h2><br>";
//Set up table to display search results
echo "Item Count=" .     $stmt->rowcount();
	$sub_total=0;
	echo "<table class=\"prodtable\">";//
	echo "<tr><th width=\"30px\"></th><th width=\"250px\">Item Name</th><th width=\"100px\">Price</th></tr>";
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo "<tr><td><form action=\"../php/checkout.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
echo "<input type=\"hidden\" name=\"cart_id\" value= \"" . $cart_id . "\">";
echo "<input type=\"hidden\" name=\"prod_id\" value= \"" . $row["prod_id"] . "\">";
echo "<input type=\"hidden\" name=\"cart_act\" value= \"DEL\">";
echo "<input type=\"submit\" name=\"DELETE\" value=\"Delete\" >";
echo "</form></td>";
		
		echo "<a href=\"showproduct.php?pid=" . $row["prod_id"] . "\">";
		echo "<td><h2>" . $row["prod_name"] . "</h2></td>";
		echo "<td><h2>$".  number_format($row["price"],2) . "</h2></td>";
		echo "</a>";
		echo "</tr>";// end product row
			$sub_total=$sub_total+$row["price"];
	}//Wend
	echo "<tr><td>--------------</td><td><h2>       Sub_total:</h2></td>";
	echo "<td><h2>".  number_format($sub_total,2) . "</h2></td></tr>";
	echo "</table>";// end product row
}
catch(PDOException $e){
    echo "Querry failed: " . $e->getMessage();
}
$conn->connection=null;
echo "<a href=\"../php/displayprods.php\"> Continue Shopping </a >";

echo "<form action=\"../php/checkout.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
echo "<input type=\"hidden\" name=\"cart_id\" value= \"" . $cart_id . "\"><BR>";
echo "   <input type=\"submit\" name=\"Check Out Now\" value=\"Done\" >";
echo "</form>";
}
echo "</div>"; // end content
include "footer.php";

echo "</div></body></html>";  //- end .container -->

?>