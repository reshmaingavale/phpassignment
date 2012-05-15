<?php
class examplepdo
{
 echo "fgrrtgrfg"; 
function insert()
{
echo "ereres";
   /* $hostname = 'localhost';
    $username = 'root';
    $password = 'webonise';
    
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=animals", $username, $password);
    // echo a message saying we have connected
    echo 'Connected to database<br />';

    // INSERT data
    $count = $dbh->exec("INSERT INTO animals(animal_type, animal_name) VALUES ('kiwi', 'troy')");

    // echo the number of affected rows
    echo $count;

    // close the database connection
    $dbh = null;
    }
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }*/
}

/*
public function select()
{
    $hostname = 'localhost';
    $username = 'root';
    $password = '123456';
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=animals", $username, $password);
    // echo a message saying we have connected
    echo 'C$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "webonise";
$mysql_database = "reshma";onnected to database<br />';

    // The SQL SELECT statement
    $sql = "SELECT * FROM animals";
    foreach ($dbh->query($sql) as $row)
        {
        print $row['animal_type'] .' - '. $row['animal_name'] . '<br />';
        }

    //close the database connection
    $dbh = null;
    }
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }
}



public function update()
{
    $hostname = 'localhost';
    $username = 'root';
    $password = '123456';
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=animals", $username, $password);
    // echo a message saying we have connected
    echo 'Connected to database<br />';

    // INSERT data
    $count = $dbh->exec("UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'");

    // echo the number of affected rows
    echo $count;

    // close the database connection
    $dbh = null;
    }
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }
}


public function fetchassoc()
{

    $hostname = 'localhost';
    $username = 'root';
    $password = '123456';
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=animals", $username, $password);
    // echo a message saying we have connected
    echo 'Connected to database<br />';

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

    // close the database connection
    $dbh = null;
    }
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }
}


public function fetchnum()
{
    $hostname = 'localhost';
    $username = 'root';
    $password = '123456';

    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=animals", $username, $password);
    //  echo a message saying we have connected
    echo 'Connected to database<br />';

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

    // close the database connection
    $dbh = null;
    }
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }
}*/
}




    $p=new examplepdo();
echo "rfefeds";
    $p->insert();
   /* $p->select();
    $p->update();
    $p->fetchassoc();
    $p->fetchnum();*/
 
       
?>
