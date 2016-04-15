<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Add Product";
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
/*echo "Product ID:" . $_POST["prod_id"] . "<br>";
echo "Product Name:" . $_POST["productname"] . "<br>";
echo "Price:" . $_POST["price"] . "<br>";
echo "Title_text=". $_POST["Title_text"] . "<BR>";
echo "Desc_main=" . $_POST["Desc_main"] . "<BR>";
echo "Desc1="  . $_POST["Desc1"] . "<BR>";
echo "Desc2="  . $_POST["Desc2"] . "<BR>";
echo "Desc3="  . $_POST["Desc3"] . "<BR>";
name=\"UorC\" 
echo "U=" . $_POST["UorC"];
echo "<br>s=" . $_POST["submit"];
*/
if( $_POST["UorC"]=="Update"){
include "sql_connect.php"; // makes $conn
if($_POST["prod_id"]==0){
		  $sql = "INSERT INTO products (prod_name,Title_text,desc_main,desc_1,desc_2,desc_3,price) VALUES(:productname, :Title_text,:desc_main,:desc_1,:desc_2,:desc_3,:price)";
echo $sql . "<BR>";  
try{
		  $q=$conn->prepare($sql);
	  if (!$q) {
		  echo "\n Prepare Error PDO::errorInfo():\n";
		  print_r($conn->errorInfo());
	  }
	  else{
echo "Prepare OK<BR>";  
	  }
	  // use exec() because no results are returned
	  $q->execute(array(':productname'=>$_POST[productname],':Title_text'=>$_POST[Title_text],':desc_main'=>$_POST[Desc_main],':desc_1'=>$_POST[Desc1],':desc_2'=>$_POST[Desc2],':desc_3'=>$_POST[Desc3],':price'=>$_POST[price]));
	  $arr = $q->errorInfo();
	  if($arr[0]>0){
		  echo "\nExecute Error PDOStatement::errorInfo():\n";
		  print_r($arr);
	  }
	  else{
//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "New Product  added successfully";
	  }
  }// end try
  catch(PDOException $e)
	  {
	  echo "Insert Failed: " . $e->getMessage();
  }
}
else{// update existing product
	$sql = "UPDATE products  SET  prod_name = ?, Title_text =?, desc_main =?, desc_1 =?, desc_2 =?, desc_3 = ?, price =?  WHERE prod_id =?";
	try{
		$q=$conn->prepare($sql);
		if (!$q) {
		  echo "\n Prepare Error PDO::errorInfo():\n";
		  print_r($conn->errorInfo());
		}
		else{
//			echo "Prepare Update OK<BR>";  
	  // use exec() because no results are returned
			$q->execute(array($_POST[productname],$_POST[Title_text],$_POST[Desc_main],$_POST[Desc1],$_POST[Desc2],$_POST[Desc3],$_POST[price],$_POST[prod_id]));
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}// end try
	catch(PDOException $e){
		echo "Execute Update Failed: " . $e->getMessage();
	}
}

$conn->connection=null;  
}// endif
else {
			echo "Product  update Cancelled";
}
 // add user successful, return to product details

	echo '<br><a href="newproduct.php?pid=' . $_POST["prod_id"] . '">Continue</a>';

?>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>