<html>
<body>
<?php
if(isset($_POST['find'])){

$mystring = $_POST['string1'];
$findme   = $_POST['findme'];
$pos = strpos($mystring, $findme);


if ($pos == true) {
   
 echo $findme;
    
} else {
    echo "The string '$findme' was not found in the string '$mystring'";
}
}
?>
<form name="findme" method="post">
String1<input type="text" name="string1">
Find me<input type="text" name="findme">
<input type="submit" name="find" value="find">
</form>
</body>
</html>
