<?php
class connection{
__connection(){
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "webonise";
$mysql_database = "reshma";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password);
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");
return $bd;
}
}
?>
