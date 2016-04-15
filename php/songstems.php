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
//echo $_GET['song_id'] . "   T=" . $_GET['title'] . "<BR>";
if (isset($_GET['song_id']) && is_numeric($_GET['song_id']))
 {
 // get id value
  $song_id = $_GET['song_id'];
  $Title=$_GET['title'];
  
  include "sql_connect.php"; // makes $conn
  try{
//		$stmt = $conn->prepare("SELECT * FROM song_to_stem WHERE Song_ID='".$song_id ."'");
		$stmt = $conn->prepare("SELECT song_to_stem.Stem_ID, song_to_stem.Percent_of_Song, products.prod_name FROM song_to_stem, products WHERE Song_ID='".$song_id ."' AND song_to_stem.Stem_ID = products.prod_id" );//
		if(!$stmt->execute()){
			echo "Execute Error";
		}
  
	  // set the resulting array to associative
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		echo "<h2>STEM List for:" . $song_id . " - " . $Title . " <BR></h2>";
		echo "<table style='border: solid 1px black;'>";
		echo "<tr><th width=\"120px\"> Stem ID#</th> <th width=\"120px\">Percent</th><th width=\"200px\">Product Name</th></tr>";
		$tot_perc=0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$tot_perc=$tot_perc+$row["Percent_of_Song"];
			echo "<tr><td>" . $row["Stem_ID"] . "</td><td>" . $row["Percent_of_Song"] ."</td><td>" . $row["prod_name"] . "</td>";
			echo '<td><a href="editstem2song.php?title=' . $Title . '&amp;stem_id='.$row['Stem_ID'].' ">Edit </a></td>';
			echo "</tr>";
		}
	echo "<tr><td>Creator % =</td><td>" . $tot_perc . "</td><td>************</td></tr>";
	echo '<tr><td><a href="addstem2song.php?title=' . $Title . '&amp;song_id='.$song_id .' ">Add STEM</a></td>';
	echo "<td></td><td><a href=\"managesongs.php\">Return to Song List</a></td></tr>";
		echo "</table>";
  //  echo "Connected successfully";
	}
	catch(PDOException $e){
		echo "Query failed: " . $e->getMessage();
	}
	$conn->connection=null;
}//<!-- end good song ID   -->
else{
	 $song_id=0;
	echo "<h3>Song Not Found<BR /></h3><BR>";
	echo "<a href=\"managesongs.php\">Continue</a>";
}
?>
</div>

<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>
