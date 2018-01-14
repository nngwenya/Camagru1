
<?php

$username = 'root';
$dsn = 'mysql:host=localhost;dbname=camagru;port=8080';
$password = "12345qwert";
error_reporting(0);

try{
    //create an instance of the PDO class with the required parameters.
    $conn = new PDO($dsn, $username, $password);
    //set pdo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $ex){
    //display success message
    echo "Connection failed".$ex->getMessage();
}
?>