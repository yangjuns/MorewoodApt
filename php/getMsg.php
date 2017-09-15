<?php
$msgLimit = $_POST["limit"];

$dbname = "morewoodapt";
//$dbname = "morewoodapt_test";

$conn = mysqli_connect("yangjuns.info", "root", "qweasdzxc", $dbname);
mysqli_query($conn, "SET NAMES utf8;");
$query = "SELECT commentid, time, firstname, comments FROM users AS u, comments AS c WHERE u.userid = c.userid AND active = 1 ORDER BY time DESC LIMIT $msgLimit";
$result = mysqli_query($conn, $query);
$msgs = array();
date_default_timezone_set("US/Eastern");
while ($row = mysqli_fetch_assoc($result)) {
    $fetchedTime = $row["time"];
    $timeStr = date("l dS F Y h:i:s A", strtotime($fetchedTime));
    $row["time"] = $timeStr;
    array_push($msgs, $row);
}
echo json_encode($msgs);

mysqli_close($conn);

?>
