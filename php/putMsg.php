<?php

$userId = $_POST["person"];
$msg = $_POST["msg"];
$dbname = "morewoodapt";
//$dbname = "morewoodapt_test";

$conn = mysqli_connect("yangjuns.info", "root", "qweasdzxc", $dbname);
mysqli_query($conn, "SET NAMES utf8;");
$query = "INSERT INTO comments (userid, comments, active, time) VALUES ($userId, '$msg' , 1, NOW())";
mysqli_query($conn, $query);

mysqli_close($conn);

?>
