<?php
// Start the session
session_start();
$_REQUEST['pageTitle'] = "RMXH Demo Home";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="CSS/flexslider.css" type="text/css" media="screen" />
<?php	echo "<title>" . $_REQUEST['pageTitle'] . "</title>"; ?>
<!-- Modernizr -->
  <script src="js/modernizr.js"></script>

</head>

<body class="loading">
 <!-- -->
<div id="container" class="cf">
<?php 
//	Check for logout
if (isset($_GET['logout']) && is_numeric($_GET['logout'])){
	if($_GET['logout']=1){
//	Poof! You're a bag of shit
	 	$_SESSION["user_id"] = 0;	
		$_SESSION["firstname"] = "";
		$_SESSION["lastname"] = "";
		$_SESSION["address1"] = "";
		$_SESSION["address2"] = "";
		$_SESSION["City"] = "";
		$_SESSION["State"] = "";
		$_SESSION["Zip"] = "";
		$_SESSION["EmailVerified"] = "";
		$_SESSION["email"] = "";
		$_SESSION["UP_Name"] = "";
		$_SESSION["User_level"] = "";
	}
 }
 include "php/header.php"; 
?>
<div class="content">
<div class="center_it">

 
<?php
include "php/sql_connect.php"; // makes $conn
try{
    $stmt = $conn->prepare("SELECT products.in_main_gallery,products.prod_id,products.prod_name,products.Title_text, prod_photos.Name, prod_photos.position FROM products, prod_photos WHERE  products.prod_id = prod_photos.prod_id AND products.in_main_gallery='1' AND prod_photos.position='0'");
	if(!$stmt->execute()){
		echo "Execute Error";
	}
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
echo "<h1>Welcome to the exciting new world of LEGAL Remixes!</h1>
<h2>Here are " . $stmt->rowcount()  .  " of our exciting new products</h2>" ;
echo "<div class=\"slider\"><div class=\"flexslider carousel\"><ul class=\"slides\">";
	$go=1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<li>";
      echo "<h2>" .  $row["prod_name"] . "</h2><a href=\"php/showproduct.php?pid=" . $row["prod_id"] . "\">";
      echo "<img src=\"" . $prod_pic_dir ."/" . $row["Name"] . "\" alt=\"".  $row["prod_name"]. "\">";
	  echo "<p class=\"flex-caption\">" . $row["Title_text"] . "</p></a>"; // , width=50% \" width=\"250\" height=\"250\"
	  echo "</li>"; 
	}//Wend   /
}
catch(PDOException $e){
    echo "Querry failed: " . $e->getMessage();
}
$conn->connection=null;
?>

 </ul></div></div></div></div> <!--  end list, slidesContainer, center_it and content -->
<BR>
<?php include "php/footer.php";?>
</div>  <!-- end .container -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<!--  
jQuery -->
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>
  <!-- FlexSlider -->
  <script defer src="js/jquery.flexslider.js"></script>
  <script type="text/javascript">
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: true,
        itemWidth: 450,
        itemMargin: 2,
        pausePlay: true,
        slideshowSpeed:3500,
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
</body>
</html>
