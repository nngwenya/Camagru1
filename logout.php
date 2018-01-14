<?php   
include_once 'config/session.php';
include_once 'config/database.php'; //to ensure you are using same session

$_SESSION["username"] = NULL;
$_SESSION["password"] = $hash_pass;
session_destroy();
header("location: index.php"); //to redirect back to "index.php" after logging out
?>
