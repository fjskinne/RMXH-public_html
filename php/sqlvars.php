<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
//Variables for connecting to your database.
//These variable values come from your hosting account.
$hostname = "localhost";
$username = "rmxhsql";
$dbname = "rmxhsql_rmxh2";

//These variable values need to be changed by you before deploying
$password = "your password";
$usertable = "your_tablename";
$yourfield = "your_field";

//Connecting to your database
mysql_connect($hostname, $username, $password) OR DIE ("Unable to
connect to database! Please try again later.");
mysql_select_db($dbname);

//
<body>
</body>
</html>