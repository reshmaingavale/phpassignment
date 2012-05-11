<?php 
//Compare two dates. (12-4-2010 & 12-5-2011). Calculate the days between these two dates.
$start = strtotime('12-4-2010');
$end = strtotime('12-5-2011');

$days_between = ceil(abs($end - $start) / 86400);
echo $days_between;

?>
