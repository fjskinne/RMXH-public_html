<?php
session_start();
include "getsessionvars.php";
include "rmxh_functions.php";
//	echo "UID=" . $user_id , "<br>";
 
echo "<div class=\"menu-wrap\">";
echo "<nav class=\"menu\">";
echo "<ul class=\"clearfix\">";
echo  "<li><a href=\"/index.php\" >Home</a></li>";
echo "<li><a href=\"../php/rmxhnews.php\" >News</a></li>";
echo "<li><a href=\"../php/displayprods.php\" >Products</a></li>";
echo "<li><a href=\"../php/specials.php\" >Specials</a></li>";
echo "<li><a href=\"../php/techsupport.php\" >Tech Support</a></li>";
echo "<li><a href=\"../php/contact_us.php\">Contact Us</a></li>";
if($user_id>0){
	echo  "<li><a href=\"../php/rmxhmain.php\" >User Info</a></li>";
	$cart_id=get_cart_id($user_id);
}if($_SESSION["User_level"]>3){ // admin priveleges
	echo "<li><a href=\"../php/admin.php\" >Admin</a>";
		echo "<ul class=\"sub-menu\">";
		echo "<li><a href=\"../php/listprods.php\" >Products</a></li>";
		echo "<li><a href=\"../php/list_rh.php\" >Rights</a></li>";
		echo "<li><a href=\"../php/managesongs.php\" >Songs</a></li>";
		echo "<li><a href=\"../php/admin_list_users.php\" >Users</a></li>";
	echo"</ul></li>";
}
if($cart_id>0){
		echo '<li><a href="checkout.php?cart_id=' . $cart_id . '">Shopping Cart</a></li>';
}
echo"</ul></nav></div>";// end menu div
?>