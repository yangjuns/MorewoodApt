<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// arguments
$userId = $_SESSION["userid"];
$val = $_POST["value"];
$field = $_POST["field"];

// db parameters
$db_server="morewood.life";
$db_user="root";
$db_password="qweasdzxc";
$dbname = "morewoodapt";
//$dbname = "morewoodapt_test";

$conn = new mysqli($db_server, $db_user, $db_password, $dbname);
if($conn->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
$conn->query("SET NAMES utf8;");
// prepare and bind
$stmt = $conn->prepare("UPDATE users SET ".$field." = ? WHERE userid = ?");
$stmt->bind_param("si", $val, $userId);
// set parameters and execute
if($stmt->execute()){
    echo 1;
}
$stmt->close();
$conn->close();

?>
