<?php
$date=date('Y-M-d');
$array_date=explode("-",$date);
$ages = array("year"=>$array_date[0], "month"=>$array_date[1], "date"=>$array_date[2]);
print_r($ages);
?>
