<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Stems in song:";
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
$act=$_GET[ACT];//echo $_GET['prod_id'] . "   T=" . $_GET['title'] . "<BR>";
echo "ACT=" . $act . "<BR>";
if (isset($_GET['pid']) && is_numeric($_GET['pid']) )
{
 // get id value
	$prod_id = $_GET['pid'];
	$Title=$_GET['title'];
echo "PID=" . $prod_id . " Title=" . $Title . " ACT=" . $act ."<br>";
	if($prod_id>0){
		if($act=='A'){ // Then add it
			$stemname=$_POST[stemname];
			$royalty=$_POST[royalty];
			echo "Add STEM for:" . $Title . "<BR>";
//echo "STEM Name=" . $stemname . "<br>";
//echo "Royalty %" . $royalty . " <br>";
			include "sql_connect.php"; // makes $conn
			$sql = "INSERT INTO stems (stem_name,prod_id,royalty) VALUES(:stem_name, :prod_id,:royalty)";
//echo "NEW SQL=" . $sql . "<BR>";  
			try{
			  $q=$conn->prepare($sql);
				if (!$q) {
					echo "\n Prepare Error PDO::errorInfo():\n";
					print_r($conn->errorInfo());
				}
				else{
//echo "new Prepare OK<BR>";  
	  // use exec() because no results are returned
					$q->execute(array(':stem_name'=>$stemname,':prod_id'=>$prod_id,':royalty'=>$royalty));
					$arr = $q->errorInfo();
					if($arr[0]>0){
						echo "\nExecute Error PDOStatement::errorInfo():\n";
						print_r($arr);
					}
					else{
//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						echo "New STEM  added successfully";
					}
				}
			}// end try
			catch(PDOException $e){
				echo "Insert Failed: " . $e->getMessage();
			}
			$conn=null;
		}//endif stemname
		if($act == "D"){ // Then delete it
			$stem_id = $_GET['stem_id'];
			include "sql_connect.php"; // makes $conn
			$sql = "DELETE FROM stems  WHERE Stem_ID = :stem_id ";
	//echo "DELETE FROM STEMS<BR>";  
			try{
				$q=$conn->prepare($sql);
				if (!$q) {
					echo "\n Prepare DELETE Error PDO::errorInfo():\n";
					print_r($conn->errorInfo());
				}
				else{
	//	  echo "Prepare Update OK<BR>";  
				}
				$q->execute(array(':stem_id'=>$stem_id));
				$arr = $q->errorInfo();
				if($arr[0]>0){
					echo "\nExecute DELETE Error PDOStatement::errorInfo():\n";
					print_r($arr);
				}
				else{
	//	  $q->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					echo "STEM DELETED successfully";
				}
			}// end try
			catch(PDOException $e){
				echo "DELETE Failed: " . $e->getMessage();
			}
			$conn=null;
		}//endif delete
		include "sql_connect.php"; // makes $conn
		try{
//		$stmt = $conn->prepare("SELECT * FROM song_to_stem WHERE prod_id='".$prod_id ."'");
			$stmt = $conn->prepare("SELECT stems.Stem_ID, stems.stem_name, products.prod_name FROM stems, products WHERE products.prod_id='". $prod_id ."' AND stems.prod_id = products.prod_id" );//
			if(!$stmt->execute()){
				echo "Execute Error";
			}
// set the resulting array to associative
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			echo "<h2>STEM List for:" . $prod_id . " - " . $Title . " <BR></h2>";
			echo "<table style='border: solid 1px black;'>";
			echo "<tr><th width=\"120px\"> Stem ID#</th> <th width=\"220px\">STEM Name</th><th></th></tr>";
			$tot_perc=0;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$tot_perc=$tot_perc+$row["Percent_of_Song"];
				echo "<tr><td>" . $row[Stem_ID] . "</td><td>" . $row[stem_name] . "</td><td><a href=\"prod_stems.php?ACT=D&amp;stem_id=" . $row[Stem_ID] . "&amp;pid=" .$prod_id . "\">&nbsp;Delete</a></td>";
				echo "</tr>";
			}
			echo "</table><BR>Add STEM<br>";
			echo "<form action=\"prod_stems.php?ACT=A&amp;pid=" . $prod_id . "&amp;title='" . $Title .  "'\" method=\"post\" enctype=\"multipart/form-data\">";
			echo "<input type=\"hidden\" name=\"title\" value=" . $Title . " >";
			echo "STEM Name<input type=\"text\" name=\"stemname\" >";
			echo "Royalty %<input type=\"number\" name=\"royalty\" ><br>";
			echo "<input type=\"submit\" value=\"Add\" name=\"Add\">";
			echo "</form>";
			echo "<a href=\"newproduct.php?pid=" . $prod_id . "\">Return to Product Page</a>";
//  echo "Connected successfully";
		}
		catch(PDOException $e){
			echo "Query failed: " . $e->getMessage();
		}
		$conn->connection=null;
		}// pid>0
}//<!-- end good song ID   -->
else{
	 $prod_id=0;
	echo "<h3>Product must be saved before adding STEMS<BR /></h3><BR>";
	echo "<a href=\"newproduct.php?pid=" . $prod_id . "\">Continue</a>";
}
?>
</div>

<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>
