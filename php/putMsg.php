<?php
session_start();
// arguments
$userId = $_SESSION["userid"];
$msg = $_POST["msg"];
$emails = $_POST["emails"];

// db parameters
$db_server="yangjuns.info";
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
$stmt = $conn->prepare("INSERT INTO comments (userid, comments) VALUES (?, ?)");
$stmt->bind_param("is", $userId, $msg);

// set parameters and execute
$stmt->execute();
$conn->close();

?>
