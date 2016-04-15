<?php
session_start();
	$_REQUEST['pageTitle'] = "RMXH Rights to song:";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />
<title> RMXH Rights to Song 2 PHP</title>
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
		$stmt = $conn->prepare("SELECT song_to_stem.Stem_ID, song_to_stem.Percent_of_Song, products.prod_name, products.prod_id FROM song_to_stem, products WHERE Song_ID='".$song_id ."' AND song_to_stem.Stem_ID = products.prod_id" );//
		if(!$stmt->execute()){
			echo "Execute Error";
		}
  		$pid_rows = $stmt->fetchAll();
	  // set the resulting array to associative
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		echo "<h2>Rights List for:" . $song_id . " - " . $Title . " <BR></h2>";
		echo "<table style='border: solid 1px black;'>";
// table header row
		echo "<tr><th width=\"120px\">Stem_ID</th> <th width=\"120px\">Percent</th><th width=\"200px\">Product Name</th><th width=\"200px\">Company</th><th width=\"200px\">First</th><th width=\"200px\">Last</th><th width=\"35px\">RHID</th></tr>";

		$tot_perc=0;
		foreach($pid_rows as $prod_row){
			echo "<tr><th width=\"120px\">" . $prod_row["Stem_ID"] . "</th> <th width=\"120px\">" . $prod_row["Percent_of_Song"] . "</th><th width=\"200px\">" . $prod_row["prod_name"] ."</th>";

			$stmt2 = $conn->prepare("SELECT rights_to_stems.RHolder_ID, rights_to_stems.Percent_of_Right, creators.Company, creators.firstname, creators.lastname FROM rights_to_stems, creators WHERE RHolder_ID='".$prod_row[RHolder_ID] ."' AND rights_to_stems.RHolder_ID = creators.ID" );//
			if(!$stmt2->execute()){
				echo "Execute Error";
			}
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {			
				$tot_perc=$tot_perc+$row["Percent_of_Song"];
				echo "<td>" . $row["Company"] . "</td><td>" . $row["firstname"] ."</td><td>" . $row["lastname"] . "</td><td>" . $row["Percent_of_Right"] . "</td>";
				echo '<td><a href="editstem2song.php?title=' . $Title . '&amp;stem_id='.$row['Stem_ID'].' ">Edit </a></td>';
				echo "</tr>";
			}
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
