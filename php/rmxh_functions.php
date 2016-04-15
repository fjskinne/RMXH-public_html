<?php
function add_cart_item($cart_id , $prod_id){ // add item to cart
//echo "Adding to cart#" . $cart_id . " PID=" . $prod_id . " , "  . date("Y-m-d H:i:s") . "<br>";
if($cart_id>0){
		include "sql_connect.php"; // makes $conn
		try{
			$sql = "INSERT INTO cart_items (sc_id,sc_prod_id,item_date) VALUES('"  . $cart_id . "','" . $prod_id. "','" . date("Y-m-d H:i:s") . "')";
//echo $sql . "<br>";
			if(	  $conn->query($sql)===TRUE){
				echo $prod_id ." added to yo cart " . $cart_id . "<BR>";
			}
		}// end try
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		$conn->connection=null;  
	}
else{
	echo "Cart ID Error in ADD2CART<BR>";
}
}

function del_cart_item($cart,$item) {
	include "sql_connect.php"; // makes $conn
//echo "Item=" . $item . "' AND sc_id='" .  $cart . "'<BR>";  
		$sql = "DELETE FROM cart_items  WHERE sc_prod_id ='" . $item . "' AND sc_id='" .  $cart . "'";
//echo $sql . " DELETE FROM cart<BR>";  
	try{
		if ($conn->query($sql)){
//			echo "Product DELETED successfully";
		}
	}// end try
	catch(PDOException $e){
		echo "DELETE Failed: " . $e->getMessage();
	}
	$conn->connection=null;  
}

function get_cart_id( $uid){
  include "sql_connect.php"; // makes $conn
  try{
	$qs = $conn->prepare("SELECT * FROM shoppingcarts WHERE  owner_id=? ");
	 	$qs->execute(array($user_id));
	}
	catch(PDOException $e){
		  echo "Query failed: " . $e->getMessage() . "<BR>";
	}
	if($qs->rowCount()>0){ //exists, update it
		$cart_data=$qs->fetch(PDO::FETCH_ASSOC);
		$ret=$cart_data["sc_id"];
	}
	else {
//echo "No cart found <BR>";
		$ret= o;
	}
$conn=null;
return $ret;
}

function create_cart()
{
include "sql_connect.php"; // makes $conn
	try{
		$sql = "INSERT INTO shoppingcarts (owner_id,sc_date) VALUES('"  . $user_id . "','"  . date("Y-m-d H:i:s") . "')";
		if(	  $conn->query($sql)===TRUE){
			echo "cart created OK<BR>";
		}
	}// end try
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}
	$conn=null;
//		echo "Cart created successfully <br>";
	$cart_id=get_cart_id($user_id);// should be valid  now
return $cart_id;
}
?>