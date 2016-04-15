<?php
include "config_vars.php";
include "getsessionvars.php";
//echo "Header here?<BR>"; 
echo "<div class=\"header\">";
echo "<img src=\"/images/rmxhlogo.png\" alt=\"Smiley face\" >";
echo "<div class=\"ht_position\" >" . @$_REQUEST['pageTitle'] . "</div>";
echo "<div class=\"userinfo\"> ";
//echo "UIDx=" . $user_id . "<BR>";
if ($user_id == 0){
	echo "<a href=\"../../php/login.php\">Login</a><BR />";
	echo "<a href=\"../../php/newuser.php\">New User</a>";
}
else {
		echo "<div class=\"userphoto\">";
		if(!is_null($UP_Name)){
			echo "<img src=\"" . $user_photodir . "/". $UP_Name . "\" alt=\"User Photo\" >";
		}
		echo"</div>";
	//echo"got S Vars fuck<BR>PD" . $firstname . $user_photodir;
		echo "<div class=\"userdata\">";
		echo "Welcome " . $firstname ;
	echo "<BR><a href=\"../index.php?logout=1\">Logout</a>";
		echo"</div>"; //end user data
}
echo"</div>";// end user info
	include "topnavbar.php"; 
echo"</div>" // end header
?>