<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Add to User's Products";
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
if (isset($_GET['cart_id']) && is_numeric($_GET['cart_id']))
 {
 // get id value
 	$cart_id = $_GET['cart_id'];
 }
 else{
	 $cart_id=0;
 }
echo "Cart ID=" . $cart_id . "<BR>";
if($cart_id){
	include "sql_connect.php"; // makes $conn
	try{// get cart items
	    $stmt = $conn->prepare("SELECT * FROM cart_items  WHERE sc_id ='".$cart_id ."'");
		if(!$stmt->execute()){
			echo "Execute Error";
			$cart_err=1;
		}
//    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		else{
			$carterr=0;
			$cartcontents= $stmt->fetchALL(PDO::FETCH_ASSOC);
		}
	}
	catch(PDOException $e){
	    echo "Query failed: " . $e->getMessage();
	}
	if(!cart_err){
		try{// get cart owner id
		    $stmt = $conn->prepare("SELECT * FROM shoppingcarts  WHERE sc_id = ='".$cart_id ."'");
			if(!$stmt->execute()){
				echo "Execute Error";
				$cart_err=2;
			}
		    else{
				$result = $stmt->Fetch(PDO::FETCH_ASSOC);
				$carterr=0;
				$user_id= $result["user_id"];
echo "Cart owner ID+" . $user_id . "<BR>";
			}
		}
		catch(PDOException $e){
		    echo "Query failed: " . $e->getMessage();
		}
	}
	if(!$cart_err){
		foreach ($cartcontents as $cartitem) {
			try{
				$sql = "INSERT INTO userpurchases (user_id, prod_id, ser_num, p_date) VALUES(:user_id, :prod_id, :ser_num, :p_date)";
				$q=$conn->prepare($sql);
				if (!$q) {
					echo "\n Prepare Error PDO::errorInfo():\n";
					print_r($conn->errorInfo());
				}
				else{		//		, :prod_id, 
					$pid=$cartitem[sc_prod_id];
					$idate=$cartitem[item_date];
					$sernum="234ADF324";
echo "UID=" . $user_id . " PID=" . $pid. " SN=" . $sernum. " Date=" . $idate. "<BR>";
					$q->execute(array(':user_id'=>$user_id,':prod_id'=>$pid,':ser_num'=>$sernum,':p_date'=>$idate));	
					if(!$stmt->execute()){
						echo "Insert purchase Execute Error";
						$cart_err=3;
					}
				}
			}
			catch(PDOException $e){
			    echo "Query failed: " . $e->getMessage();
			}
		}//fend
	}
	$conn->connection=null;
}
else{
	if($cart_err==1)echo "Cart ID Error<br>";
	if($cart_err==2)echo "Cart Owner ID Error<br>";
	if($cart_err==3)echo "Bad Cart Item Error<br>";
}
echo "<a href=\"../index.php\">Return to User Page </a>";
?>
<BR>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>
