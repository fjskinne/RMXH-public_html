<?php
session_start();
$_REQUEST['pageTitle'] = "RMXH add or edit product";
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

if (isset($_GET['pid']) && is_numeric($_GET['pid'])){
 // get id value
	$prod_id = $_GET['pid'];
}
if( $_POST["UorC"]=="Update"){
//	echo "update PID=" . $prod_id . "UorC=" . $_POST["UorC"] . "<BR>";
	if($prod_id==0){ //Add a new product
		include "sql_connect.php"; // makes $conn
		$sql = "INSERT INTO products (prod_name,Title_text,desc_main,desc_1,desc_2,desc_3,price) VALUES(:productname, :Title_text,:desc_main,:desc_1,:desc_2,:desc_3,:price)";
//echo "NEW SQL=" . $sql . "<BR>";  
		try{
			$q=$conn->prepare($sql);
			if (!$q) {
				echo "\n Prepare Error PDO::errorInfo():\n";
				print_r($conn->errorInfo());
			}
			else{
//echo "new Prepare OK<BR>";  
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
			}
		}// end try
		catch(PDOException $e){
			echo "Insert Failed: " . $e->getMessage();
		}
		$conn=Null;
// Get new prod_id		
		include "sql_connect.php"; // makes $conn
		try{
			$qs = "SELECT * FROM products WHERE  prod_name='".$_POST[productname] ."'" ;
//   echo $qs . "<br>";
			$result=$conn->query($qs);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$prod_data=$result->fetch();
			$prod_id=$prod_data[prod_id];
//echo "New PID=" . $prod_id  . "<BR>";
		}
		catch(PDOException $e){
			echo "Query failed: " . $e->getMessage() . "<BR>";
		}
		$conn=null;
	}// end insert
	else{// update existing product
		include "sql_connect.php"; // makes $conn
		$sql = "UPDATE products  SET  prod_name = ?, Title_text =?, desc_main =?, desc_1 =?, desc_2 =?, desc_3 = ?, price =? ,in_main_gallery=? WHERE prod_id =?";
		try{
			$q=$conn->prepare($sql);
			if (!$q) {
				echo "\n Prepare Error PDO::errorInfo():\n";
				print_r($conn->errorInfo());
			}
			else{
//	echo "Prepare Update OK<BR>";  
				$q->execute(array($_POST[productname],$_POST[Title_text],$_POST[Desc_main],$_POST[Desc1],$_POST[Desc2],$_POST[Desc3],$_POST[price],$_POST[gallery],$_POST[prod_id]));
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		}// end try
		catch(PDOException $e){
			echo "Execute Update Failed: " . $e->getMessage();
		}
		$conn->connection=null;  
	}// endif update
}// End UorC
// now get current data
//echo "PID=" . $prod_id . "UorC=" . $_POST["UorC"] . "<BR>";
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
//echo $_POST[gallery] . "=gallery B4<br>";
$productname= $prod_data[prod_name];
$price = $prod_data[price];
$Title_text = $prod_data[Title_text];
$Desc_main= $prod_data[desc_main];
$Desc1 = $prod_data[desc_1];
$Desc2 = $prod_data[desc_2];
$Desc3 = $prod_data[desc_3];
$gallery=$prod_data[in_main_gallery];
try{	// Now get photos
	$qs = $conn->prepare("SELECT * From prod_photos WHERE prod_id=? ");
//echo "Photo Prepare OK<BR>";
	$qs->execute(array($prod_id));
//  echo "Execute OK<BR>";
	$result = $qs->setFetchMode(PDO::FETCH_ASSOC);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$rowcnt=0;
	while($row = $qs->fetch(PDO::FETCH_ASSOC)) {
//echo $row["position"] . "   " . $row["Name"] . "<BR>";
		$prod_photos[$rowcnt]=$row["Name"];
//	  		echo $prod_photos[$rowcnt] . "PP<BR>";
		$rowcnt++;
	}
}
catch(PDOException $e){
	echo "Query failed: " . $e->getMessage() . "<BR>";
}
$conn->connection=null;
// Now you can edit product
// main photo
//echo $prod_pic_dir . "/" . $prod_photos[0] . "   <BR>";

echo "<div class=\"mainproddata\">";
echo "Product Id=" . $prod_id . "<BR>";
echo "<form action=\"../php/newproduct.php?pid=" . $prod_id . "\" id=\"newproduct\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
echo "<input type=\"hidden\" name=\"prod_id\" value= \"" . $prod_id . "\"><BR>";
echo "Product Name: <input type=\"text\" name=\"productname\" value= \"" . $productname . "\"><BR>";
echo "Price $ <input type=\"number\" step=\".01\" name=\"price\" value=" . $price . "><br>";
echo "Title Text:<br><textarea name=\"Title_text\" form=\"newproduct\">" . $Title_text . "</textarea>";
echo "Gallery: <input type=\"text\" name=\"gallery\" value= \"" . $gallery . "\" ><BR>";
echo "<BR><button name=\"UorC\" type=\"submit\" value=\"Update\"> Update Product</button> ";
echo "</form>";
if($prod_id>0){
	echo "<a href=\"prod_stems.php?ACT=L&amp;pid=" . $prod_id . "&amp;title='" . $productname .  "'\">Edit Product STEMS</a><br>";
}
else {
	echo "Save product to add STEMS<br>";
}
echo "<a href=\"listprods.php\">Product List</a><BR>";
echo "</div>";
	
echo "<div class=\"mainprodphoto\">";
echo "Main Photo<img src=\"" . $prod_pic_dir . "/" . $prod_photos[0] . "\" alt=\"". $prod_photos[0] . "\" >";

if($prod_id>0){
	echo "<form action=\"upload_prod_photo.php?pid=". $prod_id . "&picpos=0\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" required = \"required\">";
	echo "<input type=\"submit\" value=\"Upload Image\" name=\"submit\">";
	echo "</form>";
	echo "<form action=\"existing_prod_photo.php?pid=". $prod_id . "&picpos=0\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"submit\" value=\"Existing Image\" name=\"submit\"></form>";
}
else {
	echo "<BR>Save product to add photo<br>";
}
echo "Main Description<br><textarea name=\"Desc_main\" form=\"newproduct\">" . $Desc_main . "</textarea>";
echo "</div>";
echo "</div>";	//  end uppercontent

echo "<div class=\"lowercontent\">";
// Desc 1 and photo	
echo "<BR><div class=\"prodphoto\">";
echo "<textarea name=\"Desc1\" form=\"newproduct\">" . $Desc1 . "</textarea>";
echo "<img src=\"" . $prod_pic_dir . "/" . $prod_photos[1] . "\" alt=\"". $prod_photos[1] . "\" >";
echo "<BR><div>";
if($prod_id>0){
	echo "<form action=\"upload_prod_photo.php?pid=". $prod_id . "&picpos=1\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" required = \"required\">";
	echo "<input type=\"submit\" value=\"Upload Image\" name=\"submit\">";
	echo "</form>";
	echo "<form action=\"existing_prod_photo.php?pid=". $prod_id . "&picpos=1\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"submit\" value=\"Existing Image\" name=\"submit\"></form>";
}
else {
	echo "Save product to add photo";
}
echo "</div></div>";
	
// Desc 2 and photo	
echo "<div class=\"prodphoto\"><textarea name=\"Desc2\" form=\"newproduct\">" . $Desc2 . "</textarea>";
echo "<img src=\"" . $prod_pic_dir . "/" . $prod_photos[2] . "\" alt=\"". $prod_photos[2] . "\" >";
echo "<form action=\"upload_prod_photo.php?pid=". $prod_id . "&picpos=2\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" required = \"required\">";
echo "    <input type=\"submit\" value=\"Upload Image\" name=\"submit\">";
echo "</form>";
echo "<form action=\"existing_prod_photo.php?pid=". $prod_id . "&picpos=2\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=\"submit\" value=\"Existing Image\" name=\"submit\">";
echo "</form></div>";

// Desc 3 and photo	
echo "<div class=\"prodphoto\"><textarea name=\"Desc3\" form=\"newproduct\">" . $Desc3 . "</textarea>";
echo "<img src=\"" . $prod_pic_dir . "/" . $prod_photos[3] . "\" alt=\"". $prod_photos[3] . "\" >";
echo "<form action=\"upload_prod_photo.php?pid=". $prod_id . "&picpos=3\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" required = \"required\">";
echo "    <input type=\"submit\" value=\"Upload Image\" name=\"submit\">";
echo "</form>";
echo "<form action=\"existing_prod_photo.php?pid=". $prod_id . "&picpos=3\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=\"submit\" value=\"Existing Image\" name=\"submit\">";
echo "</form></div>";
echo "</div>";	//end lowercontent
echo "</div>";	//end content
include "footer.php";
 ?>
</div>  <!-- end .container -->
</body>
</html>