<?php
class sample{
public $dbh;
function connecttodb(){
    $hostname = 'localhost';
    $username = 'root';
    $password = 'webonise';
    
    try {
    $this->dbh = new PDO("mysql:host=$hostname;dbname=reshma", $username, $password);
    // echo a message saying we have connected
    $db=$this->dbh;
  
  	return $db;
    }
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }
}
function insert_data(){
echo "insert_data";echo "<br>";
	$object=new sample();
$dbh=$object->connecttodb();

    // INSERT data
    $count = $dbh->exec("INSERT INTO admin(username, passcode) VALUES ('john1', 'jhon1234')");

    // echo the number of affected rows
    echo $count;
    
}
public function select_data()
{
echo "select_data";echo "<br>";
  	$object=new sample();
	$dbh=$object->connecttodb();

    // The SQL SELECT statement
    $sql = "SELECT * FROM admin";
    foreach ($dbh->query($sql) as $row)
        {
        print $row['username'] .' - '. $row['passcode'] . '<br />';
        }

   
}
public function update_data()
{
 echo "update_data"; echo "<br>";
    $count = $dbh->exec("UPDATE admin SET username='jeny' WHERE passcode='troy123'");

    // echo the number of affected rows
    echo $count;
}
public function fetchassoc_data()
{
echo "fetchassoc";echo "<br>";

    // The SQL SELECT statement
    $sql = "SELECT * FROM animals";

    // fetch into an PDOStatement object
    $stmt = $dbh->query($sql);

    // echo number of columns
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // loop over the object directly
    foreach($result as $key=>$val)
    {
    echo $key.' - '.$val.'<br />';
    }

    
}
public function fetchnum_data()
{
echo "fetchnum";echo "<br>";
    
    // The SQL SELECT statement
    $sql = "SELECT * FROM animals";

    // fetch into an PDOStatement object
    $stmt = $dbh->query($sql);

    // echo number of columns
    $result = $stmt->fetch(PDO::FETCH_NUM);

    // loop over the object directly
    foreach($result as $key=>$val)
    {http://assignment.webonise.com/spike3/
    echo $key.' - '.$val.'<br />';
    }

    
}
	
}


$obj=new sample();

//$obj->connecttodb();
//echo "<br>";
$obj->insert_data();
echo "<br>";
$obj->select_data();
echo "<br>";
$obj->update_data();
echo "<br>";
$obj->fetchassoc_data();
echo "<br>";
$obj->fetchnum_data();

?>
