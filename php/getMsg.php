<?php
// arguments
$msgLimit = $_POST["limit"];

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

$query = "SELECT commentid, time, firstname, comments FROM users AS u, comments AS c WHERE u.userid = c.userid AND c.active = 1 ORDER BY time DESC LIMIT $msgLimit";
$result = $conn->query($query);
$msgs = array();
date_default_timezone_set("US/Eastern");
while ($row = $result->fetch_assoc()) {
    $fetchedTime = $row["time"];
    $timeStr = date("l dS F Y h:i:s A", strtotime($fetchedTime));
    $row["time"] = $timeStr;
    array_push($msgs, $row);
}
echo json_encode($msgs);

$conn->close();
?>
