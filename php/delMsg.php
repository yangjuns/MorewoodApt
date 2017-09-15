<?php

$id = $_POST["commentid"];

$dbname = "morewoodapt";
//$dbname = "morewoodapt_test";

$conn = mysqli_connect("yangjuns.info", "root", "qweasdzxc", $dbname);
mysqli_query($conn, "SET NAMES utf8;");
$query = "UPDATE comments SET active = 0 WHERE commentid = $id";
$result = mysqli_query($conn, $query);
mysqli_close($conn);
?>
