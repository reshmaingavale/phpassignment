<?php
abstract class AbstractClass
{
    
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    public function printOut() {
        print $this->getValue() . "\n";
    }
}

class getClass1 extends AbstractClass
{
    protected function getValue() {
        return "getClass1";
    }

    public function prefixValue($prefix) {
        return "{$prefix}getClass1";
    }
}



$class1 = new getClass1;
$class1->printOut();
echo "<br>";
echo $class1->prefixValue('take_') ."\n";

?>
