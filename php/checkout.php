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

if (isset($_POST['cart_id']))//if posted, delete or uppdate
{
	$cart_id = $_POST['cart_id'];
	if($cart_id==0){
		$cart_id=create_cart($_POST['user_id']);
	}
//echo "POSTED<br>";
	$prod_id=$_POST['prod_id'];
	if($_POST['cart_act']=="DEL"){
//echo "DEL<br>";
		del_cart_item($cart_id,$prod_id);
	}
	elseif($_POST['cart_act']=="ADD")
	{
echo "ADD<br>";
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
echo "<a href=\"../php/displayprods.php\"> Continue Shopping </a ><BR>";
echo "<a href=\"../php/add2userprods.php?cart_id=" . $cart_id . "\"> TEST add2purchases </a ><BR>";
//Paypal stuff

echo "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">";
echo "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\"";
echo "<input type=\"hidden\" name=\"business\" value=\"jkres@bayland.net\">";
echo "<input type=\"hidden\" name=\"lc\" value=\"US\">";
echo "<input type=\"hidden\" name=\"item_name\" value=\"purchase\">";
echo "<input type=\"hidden\" name=\"item_number\" value=\"" . $cart_id . "\">";
echo "<input type=\"hidden\" name=\"amount\" value=\"" . $sub_total . "\">";
echo "<input type=\"hidden\" name=\"currency_code\" value=\"USD\">";
echo "<input type=\"hidden\" name=\"button_subtype\" value=\"services\">";
echo "<input type=\"hidden\" name=\"no_note\" value=\"0\">";
echo "<input type=\"hidden\" name=\"tax_rate\" value=\"5.000\">";
echo "<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest\">";
echo "<input type=\"image\" src=\"https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\">";
echo "<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\">";
echo "</form>";
/*
HTML version
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="jkres@bayland.net">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="purchase">
<input type="hidden" name="item_number" value="ord#">
<input type="hidden" name="amount" value="1.00">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="tax_rate" value="5.000">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

// end paypal stuff
 * 
 */
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