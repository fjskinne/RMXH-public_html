<html>
<head>
<title> RMXH Test</title></head>
<body>
<?php

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Title</th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

$servername = "rmxhsql.db.8987649.hostedresource.com";
$username = "rmxhsql";
$password = "Rmxh2015!";
$dbname = "rmxhsql";
$userid = $_POST["ID"];
//echo "ID=" . $userid . "<BR>";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT Title FROM songs WHERE Creator='".$userid ."'");
	$stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
//    echo "Connected successfully";
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

$conn->connection=null;
echo "<h1>This system is for testing purposes ONLY!</h1>";

 ?>
<BR>
<form action="../RMXH/rmxhmain.php" method="POST" target="_self" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
<input type="hidden" name="ID" value="<?php echo $userid; ?>"/>
<input type="submit" value="Done">
</form>

</body>
</html>
