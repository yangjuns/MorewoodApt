<?php
// arguments
$id = $_POST["commentid"];

// db parameters
$db_server="127.0.0.1";
$db_user="root";
$db_password="qweasdzxc";
$dbname = "morewoodapt";
//$dbname = "morewoodapt_test";

$conn = new mysqli($db_server, $db_user, $db_password, $dbname);
if($conn->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
$conn->query("SET NAMES utf8;");

$query = "UPDATE comments SET active = 0 WHERE commentid = $id";
$conn->query($query);
$conn->close();
?>
