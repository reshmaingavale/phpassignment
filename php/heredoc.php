<html>
<body>
<?php
if(isset($_POST['find'])){

$string1 = $_POST['string1'];
$string2   = $_POST['string2'];
$str = <<< DEMO
$string1 $string2
DEMO;
echo $str;
}
?>
<form name="findme" action="#" method="post">
String1<input type="text" name="string1">
String2<input type="text" name="string2">
<input type="submit" name="find" value="find">
</form>
</body>
</html>
