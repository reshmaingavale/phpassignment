<?php
	$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "webonise";
$mysql_database = "reshma";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password);
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");
$name="reshma";	
	$sql='delete * from admin where username=$name';
echo $sql;
echo "<br>";
$str=eval("\$sql = \"$sql\";");
echo $sql;

?>
