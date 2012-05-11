<?php
//Print current date
echo "1] Print current date"."<br>";
echo date("Y/m/d")."<br>"."<br>";

//print 12th Jan 2012
echo "2] print 12th Jan 2012"."<br>";
echo date("jS M Y")."<br>"."<br>";

// add 7 days in current date
echo "3] add 7 days in current date"."<br>";
$date = date("y-m-d");
$date=Date('y-m-d', strtotime("+7 days"));
echo $date;
?> 
