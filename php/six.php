<html>
<body>
<?php
if(isset($_POST['find'])){

$mystring = strtoupper($_POST['string1']);
echo "In Capital Letters :- ".$mystring;

}
?>
<form name="findme" method="post">
String1<input type="text" name="string1">

<input type="submit" name="find" value="Capitalise">
</form>
</body>
</html>
