<?php

interface vehicle 
{     
	public function run(); 
}

class Test implements vehicle {
    public  function run() {
        echo "Run*****";
    }
}
$vehicle = new Test();
$vehicle->run();
?>
