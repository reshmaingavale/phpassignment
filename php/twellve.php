<?php
$str="My name is Reshma";
$len=strlen($str);

$parts=round($len/4);

$for($i=1;$i<=$parts;$i++){

	echo substr($str,0,$parts);
}

?>
