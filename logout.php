<?php

include $_SERVER["DOCUMENT_ROOT"] . "/util/sessionStart.php";

unset($_SESSION["username"]);
unset($_SESSION["userid"]);

header("Location: /index.php");
?>
