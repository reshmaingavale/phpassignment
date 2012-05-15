<?php 
// example for sql injection
$include=include('config.php');

	$sql="select * from admin where id=".$_GET['id'];
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
echo "<pre>";	
print_r($row);
}
//$_GET['id']

?>
<a href="xss1.php?id=1">display</a>

<!--if you want to display result of perticular user and for that you fire select query with getting (id, username etc.) from url. here hacker can hack with putting any number of id, he can get all information of that user. so we should not use url parameters directly in query -->
