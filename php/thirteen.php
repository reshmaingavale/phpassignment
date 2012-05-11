<?php
$string1="My name is Reshma. Now i am a weboniser";
$result=explode(".",$string1);
$str1=explode(" ",$result[0]);
$str2=explode(" ",$result[1]);

$count_str1=count($str1);

$count_str2=count($str2);

for($i=$count_str1;$i>=0;$i--){
	echo $str1[$i]." ";
}
echo "<br>";
for($i=$count_str2;$i>=0;$i--){
	echo $str2[$i]." ";
}


?>
