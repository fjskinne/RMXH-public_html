<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sick jQuery Slidehow: Demo</title>
<style type="text/css">
<!--
/** 
 * Slideshow style rules.
 */
#slideshow {
	margin:0 auto;
	width:640px;
	height:263px;
	background:transparent url(../img/bg_slideshow.jpg) no-repeat 0 0;
	position:relative;
}
#slideshow #slidesContainer {
  margin:0 auto;
  width:560px;
  height:263px;
  overflow:auto; /* allow scrollbar */
  position:relative;
}
#slideshow #slidesContainer .slide {
  margin:0 auto;
  width:540px; /* reduce by 20 pixels of #slidesContainer to avoid horizontal scroll */
  height:263px;
}

/** 
 * Slideshow controls style rules.
 */
.control {
  display:block;
  width:39px;
  height:263px;
  text-indent:-10000px;
  position:absolute;
  cursor: pointer;
}
#leftControl {
  top:0;
  left:0;
  background:transparent url(../img/control_left.jpg) no-repeat 0 0;
}
#rightControl {
  top:0;
  right:0;
  background:transparent url(../img/control_right.jpg) no-repeat 0 0;
}

/** 
 * Style rules for Demo page
 */
* {
  margin:0;
  padding:0;
  font:normal 11px Verdana, Geneva, sans-serif;
  color:#ccc;
}
a {
  color: #fff;
  font-weight:bold;
  text-decoration:none;
}
a:hover {
  text-decoration:underline;
}
body {
  background:#393737 url(../img/bg_body.jpg) repeat-x top left;
}
#pageContainer {
  margin:0 auto;
  width:960px;
}
#pageContainer h1 {
  display:block;
  width:960px;
  height:114px;
  background:transparent url(../img/bg_pagecontainer_h1.jpg) no-repeat top left;
  text-indent: -10000px;
}
.slide h2, .slide p {
  margin:15px;
}
.slide h2 {
  font:italic 24px Georgia, "Times New Roman", Times, serif;
  color:#ccc;
  letter-spacing:-1px;
}
.slide img {
  float:right;
  margin:0 15px;
}
#footer {
  height:100px;
}
#footer p {
  margin:30px auto 0 auto;
  display:block;
  width:560px;
  height:40px;
}
-->
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var currentPosition = 0;
  var slideWidth = 560;
  var slides = $('.slide');
  var numberOfSlides = slides.length;

  // Remove scrollbar in JS
  $('#slidesContainer').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides
    .wrapAll('<div id="slideInner"></div>')
    // Float left to display horizontally, readjust .slides width
	.css({
      'float' : 'left',
      'width' : slideWidth
    });

  // Set #slideInner width equal to total width of all slides
  $('#slideInner').css('width', slideWidth * numberOfSlides);

  // Insert controls in the DOM
  $('#slideshow')
    .prepend('<span class="control" id="leftControl">Clicking moves left</span>')
    .append('<span class="control" id="rightControl">Clicking moves right</span>');

  // Hide left arrow control on first load
  manageControls(currentPosition);

  // Create event listeners for .controls clicks
  $('.control')
    .bind('click', function(){
    // Determine new position
	currentPosition = ($(this).attr('id')=='rightControl') ? currentPosition+1 : currentPosition-1;
    
	// Hide / show controls
    manageControls(currentPosition);
    // Move slideInner using margin-left
    $('#slideInner').animate({
      'marginLeft' : slideWidth*(-currentPosition)
    });
  });

  // manageControls: Hides and Shows controls depending on currentPosition
  function manageControls(position){
    // Hide left arrow if position is first slide
	if(position==0){ $('#leftControl').hide() } else{ $('#leftControl').show() }
	// Hide right arrow if position is last slide
    if(position==numberOfSlides-1){ $('#rightControl').hide() } else{ $('#rightControl').show() }
  }	
});
</script>
</head>
<body>
<div id="pageContainer">
  <h1><a href="http://sixrevisions.com/tutorials/javascript_tutorial/create-a-slick-and-accessible-slideshow-using-jquery/">Slick Slideshow using jQuery</a></h1>
  <!-- Slideshow HTML -->
  <div id="slideshow">
    <div id="slidesContainer">
 
<?php
include "sql_connect.php"; // makes $conn
try{
    $stmt = $conn->prepare("SELECT products.prod_id,products.prod_name,products.Title_text, prod_photos.Name FROM products, prod_photos WHERE  prod_photos.in_main_gallery=1 AND products.prod_id = prod_photos.prod_id ");
	if(!$stmt->execute()){
		echo "Execute Error";
	}
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//echo "rows=" .     $stmt->rowcount();
	$go=1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<div class=\"slide\">";
      echo "<a href=\"showproduct.php?pid=" . $row["prod_id"] . "\"><h2>" .  $row["prod_name"] . "<p></h2><img src=\"" . $prod_pic_dir ."/" . $row["Name"] . "\" alt=\"".  $row["prod_name"]. "\" width=\"200\" height=\"200\" />" . $row["products.Title_text"] .  "</p></a></div>";
	}//Wend
//	$_SESSION['imgarr'] = $this->files_arr;
}
catch(PDOException $e){
    echo "Querry failed: " . $e->getMessage();
}
$conn->connection=null;
?>
 <!--     <div class="slide">
        <h2>Web Development Tutorial</h2>
        <p><a href="http://sixrevisions.com/tutorials/web-development-tutorials/using-xampp-for-local-wordpress-theme-development/"><img src="img/img_slide_01.jpg" alt="An image that says Install X A M P P for wordpress." width="215" height="145" /></a>If you're into developing web apps, you should check out the tutorial called "<a href="http://sixrevisions.com/tutorials/web-development-tutorials/using-xampp-for-local-wordpress-theme-development/">Using XAMPP for Local WordPress Theme Development</a>" which shows you how to set up a local testing server for developing PHP/Perl based applications locally on your computer. The example also shows you how to set up WordPress locally!</p>
      </div>
      -->
    </div>
  </div>
  <!-- Slideshow HTML -->
  <div id="footer">
    <p><a href="#">Create a Slick and Accessible Slideshow Using  jQuery by Jacob Gube</a> (<a href="http://sixrevisions.com/">Six Revisions</a>)</p>
  </div>
</div>
</body>
</html>
