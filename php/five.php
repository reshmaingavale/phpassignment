<?php
$string1="My name is reshma";
$string_array=explode(" ",$string1);


$count1=count($string_array);
$i=0;

wwwarray($i,$count1,$string_array);	

function wwwarray($i,$count1,$string_array){

if($i<$count1)
{
	echo $string_array[$i]." ";
	
	wwwarray($i+1,$count1,$string_array);
}	
else
return;

}

?>

