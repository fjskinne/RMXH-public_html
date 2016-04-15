<?php
	session_start();
	$_REQUEST['pageTitle'] = "RMXH Update User";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/CSS/remixhits.css" rel="stylesheet" type="text/css" />
<title>RMXH Update User</title>
</head>
<body>
<div class="container">
<?php include "header.php"; 
echo "<div class=\"content\">";



include "config_vars.php";
include "getsessionvars.php";
if ($_POST["action"] =="update" ){
/*
echo "attempt update <BR>";
echo $firstname . " " , $lastname;
echo "<br> server=" . $servername . " user=" . $username;
echo "<br> passwd=" .  $password . " db=" . $dbname;
echo "<br> current UID=" .  $user_id . "<BR>";
*/
  include "sql_connect.php"; // makes $conn
  //  $id=$_POST['ID'];
  //  $passwd=$_POST['passwd'];
  //  echo "Now Looking for " . $firstname . " " . $Lastname . "<br>"; 
	//echo $who;
	//  $data = "SELECT * FROM `creators` WHERE `email` = ' " . $name . "'";
  //echo  "rhid=" . $_POST[ID] . "<BR>First=" . $_POST["FirstName"] . $_POST["LastName"]. "<BR>A1=" . $_POST["Address1"] . "<BR>A2=" . $_POST["Address2"] . "<BR>" . $_POST["City"] . $_POST["State"].$_POST["Zip"]. "<BR>email:" . $_POST["email"] . "<BR>ID:" . $_POST["ID"] . "<BR>";
  if(	$_POST["ID"]>0){  
	  if( $conn){
		  try {
		 $qs = "UPDATE creators  SET Company=?,FirstName=?,LastName=?,Address1 =?,Address2=?, City=?,State=?,Zip=? , email=? WHERE  ID=?";
	//	 echo $qs . "<BR>";
		 $q=$conn->prepare($qs);
		 $q->execute(array($_POST["Company"],$_POST["FirstName"], $_POST["LastName"], $_POST["Address1"],$_POST["Address2"], $_POST["City"],$_POST["State"],$_POST["Zip"],$_POST["email"],$_POST["ID"]));
		  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//    echo "Query successful<BR>";
	  	}
		catch(PDOException $e){
			echo "Update failed: " . $e->getMessage() . "<BR>";
		}
  	}
  }
  else{ //new RH
	if( $conn){
		try {
		  echo "Try INSERT <BR>";
		 $qs = "INSERT INTO creators  (Company,FirstName,LastName,Address1,Address2, City,State,Zip , email) VALUES (:Company,:FirstName,:LastName, :Address1,:Address2,:City,:State,:Zip,:email)";
	//	 echo $qs . "<BR>";
		$q=$conn->prepare($qs);
		 $q->execute(array(':Company'=>$_POST[Company],':FirstName'=>$_POST[FirstName],':LastName'=>$_POST[LastName],':Address1' =>$_POST[Address1], ':Address2'=>$_POST[Address2], ':City'=>$_POST[City] ,':State'=>$_POST[State],':Zip'=>$_POST[Zip] , ':email'=>$_POST[email]));
		  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  //    echo "Query successful<BR>";
	  }
	  catch(PDOException $e){
		  echo "INSERT failed: " . $e->getMessage() . "<BR>";
	  }
	echo"INSERT successful";
	}
  $conn->connection=null;
  }
  /*else if ($_POST["action"] =="changepasswd" ){
	  echo "change Password";
	  echo "<form action=\"../php/changepassword.php\" method=\"POST\" target=\"_self\" accept-charset=\"UTF-8\"
	enctype=\"application/x-www-form-urlencoded\" autocomplete=\"off\" novalidate> ";
	  echo "</form>";
  }
*/
}
?>


<form action="../../php/list_rh.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="submit" name="continue" value="Click to continue">
</form>
</div>
<?php include "footer.php";?>
</div>  <!-- end .container -->

</body>
</html>