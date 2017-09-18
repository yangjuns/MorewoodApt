<?php

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

$mail = new PHPMailer\PHPMailer\PHPMailer;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// arguments
$userId = $_SESSION["userid"];
$userName = $_SESSION["username"];
$msg = $_POST["msg"];
$emails = $_POST["emails"];

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
$stmt = $conn->prepare("INSERT INTO comments (userid, comments) VALUES (?, ?)");
$stmt->bind_param("is", $userId, $msg);
// set parameters and execute
$stmt->execute();
$conn->close();

if (sizeof($emails) > 0) {
    $mail->IsSMTP();
    $mail->SMTPDebug = 1;
    $mail->Host = "smtp.1and1.com";
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true;;
    $mail->Username = "notification@morewood.life";
    $mail->Password = "sleepearly2000";
    for ($i = 0; $i < sizeof($emails); $i++) {
        $mail->SetFrom("notification@morewood.life", "Morewood Life");
        $mail->AddAddress($emails[$i]);
        $mail->Subject = $userName . " mentioned you about morewoodlife";
        $mail->Body = $msg;
        $mail->Send();
    }
}

?>
