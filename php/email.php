<?php

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

$mail = new PHPMailer\PHPMailer\PHPMailer;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// arguments
$userName = $_SESSION["username"];
$msg = $_POST["msg"];
$receivers = $_POST["receivers"];

// db parameters
$db_server="morewood.life";
$db_user="root";
$db_password="qweasdzxc";
$dbname = "morewoodapt";
//$dbname = "morewoodapt_test";

// setup email
$mail->IsSMTP();
$mail->SMTPDebug = 1;
$mail->Host = "smtp.1and1.com";
$mail->Port = 465;
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth = true;;
$mailUserName = "notification@morewood";
$mailUserName = $mailUserName . ".life";
$mail->Username = $mailUserName;
$mail->Password = "sleepearly2000";

for ($i = 0; $i < sizeof($receivers); $i++) {
    $conn = new mysqli($db_server, $db_user, $db_password, $dbname);
    if($conn->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    $conn->query("SET NAMES utf8;");
    // prepare and bind
    $stmt = $conn->prepare("SELECT email FROM users WHERE firstname = ?");
    $stmt->bind_param("s", $receivers[$i]);
    // set parameters and execute
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();

    $stmt->close();
    $conn->close();

    $mail->SetFrom($mailUserName, "Morewood Life");
    $mail->AddAddress($result);
    $mail->Subject = $userName . " mentioned you about morewoodlife";
    $mail->Body = $msg;
    $mail->Send();
}

?>
