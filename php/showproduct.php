<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH Product Details";
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
echo "<div class=\"uppercontent\">";

include "config_vars.php";
include "getsessionvars.php";

if (isset($_GET['pid']) && is_numeric($_GET['pid']))
 {
 // get id value
 $prod_id = $_GET['pid'];
 }
 else{
	 $prod_id=0;
 }
//echo "PID=" . $prod_id . "<BR>";
if($prod_id==0){
	$productname= "Product Name";
	$price= 0;
	$Title_text="Title" ;
	$Desc_main= "Main Description";
	$Desc1= "Description 1";
	$Desc2= "Description 2";
	$Desc3= "Description 3";
}
else{ // look for existing product
  include "sql_connect.php"; // makes $conn
  try{
	 $qs = "SELECT * FROM products WHERE  prod_id='".$prod_id ."'" ;
//       echo $qs . "<br>";
	$result=$conn->query($qs);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $prod_data=$result->fetch();
//   echo "Query successful Name=" . $prod_data->rowCount .$prod_data[prod_name] . "<BR>";
  }
  catch(PDOException $e){
	  echo "Query failed: " . $e->getMessage() . "<BR>";
  }
  include "default_photos.php"; // set defaults in case nophotos found
//  if($prod_data->rowCount>0){ // found product
//  echo"found product<BR>";
	  $productname= $prod_data[prod_name];
	  $price = $prod_data[price];
	  $Title_text = $prod_data[Title_text];
	  $Desc_main= $prod_data[desc_main];
	  $Desc1 = $prod_data[desc_1];
	  $Desc2 = $prod_data[desc_2];
	  $Desc3 = $prod_data[desc_3];
  
  try{	// Now get photos
	  $qs = $conn->prepare("SELECT * From prod_photos WHERE prod_id=? ");
//	  echo "Photo Prepare OK<BR>";
		  $qs->execute(array($prod_id));
//  echo "Execute OK<BR>";
	    $result = $qs->setFetchMode(PDO::FETCH_ASSOC);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$rowcnt=0;
		while($row = $qs->fetch(PDO::FETCH_ASSOC)) {
//	  		echo $row["position"] . "   " . $row["Name"] . "<BR>";
			$prod_photos[$rowcnt]=$row["Name"];
//	  		echo $prod_photos[$rowcnt] . "PP<BR>";
			$rowcnt++;

   		}
  }
  catch(PDOException $e){
	  echo "Query failed: " . $e->getMessage() . "<BR>";
  }
//  }
  $conn->connection=null;

}// end else
// main photo
	echo "<H1>" . $productname . "</H1>";
	echo "<div class=\"displayprodmainphoto\">";
	echo "<img src=\"" . $prod_pic_dir . "/" . $prod_photos[0] . "\" alt=\"". $prod_photos[0] . "\" >";
	echo "<p>" . $Desc_main . "</p>";
	echo "<BR>" . $Title_text . "<BR>";
	echo "Price $" . $price . "<BR>";
	echo "<form action=\"../php/checkout.php\" id=\"newproduct\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
  enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
	echo "<input type=\"hidden\" name=\"prod_id\" value= \"" . $prod_id . "\">";
	echo "<input type=\"hidden\" name=\"user_id\" value= \"" . $user_id . "\">";
	echo "<input type=\"hidden\" name=\"cart_id\" value= \"" . $cart_id . "\">";
	echo "<input type=\"hidden\" name=\"cart_act\" value= \"ADD\">";
	echo "<BR><input type=\"submit\" value=\"Add to Cart\"> ";
	echo "</form></div>";	
echo "</div>";	//  end uppercontent
echo "<div class=\"lowercontent\">";
// Desc 1 and photo	
	echo "<div class=\"dispprodphoto\">";
	echo "<img src=\"" . $prod_pic_dir . "/" . $prod_photos[1] . "\" alt=\"". $prod_photos[1] . "\" >";
 	echo  "<p>" . $Desc1 . "</p></div>";
	
// Desc 2 and photo	
	echo "<div class=\"dispprodphoto\">";
	echo "<img src=\"" . $prod_pic_dir . "/" . $prod_photos[2] . "\" alt=\"". $prod_photos[2] . "\" >";
 	echo  "<p>" . $Desc2 . "</p></div>";

// Desc 3 and photo	
	echo "<div class=\"dispprodphoto\">";
	echo "<img src=\"" . $prod_pic_dir . "/" . $prod_photos[3] . "\" alt=\"". $prod_photos[3] . "\" >";
 	echo  "<p>" . $Desc3 . "</p></div>";
?>
</div> <!-- end lower content -->
</div> <!-- end content -->
<?php include "footer.php";?>
</div>  <!-- end .container -->
</body>
</html>