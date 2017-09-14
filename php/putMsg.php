<?php

$userId = $_POST["person"];
$msg = $_POST["msg"];

$conn = mysqli_connect("yangjuns.info", "root", "qweasdzxc", "morewoodapt");
$query = "INSERT INTO comments (userid, comments, active, time) VALUES ($userId, '$msg' , 1, NOW())";
mysqli_query($conn, $query);

mysqli_close($conn);

?>
