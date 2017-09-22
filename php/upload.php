<?php
include $_SERVER["DOCUMENT_ROOT"] . "/php/sessionStart.php";
$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";

$target_file = $target_dir . ($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 100*1024*1024) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // db parameters
        $db_server="morewood.life";
        $db_user="root";
        $db_password="qweasdzxc";
        $dbname = "morewoodapt";
        //$dbname = "morewoodapt_test";
        $userId = $_SESSION["userid"];
        $filename = $_FILES["fileToUpload"]["name"];
        $ip = $_SERVER["REMOTE_ADDR"];
        $conn = new mysqli($db_server, $db_user, $db_password, $dbname);
        if($conn->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $conn->query("SET NAMES utf8;");
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO files (userid, filename, ip) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $filename, $ip);
        var_dump($userId);
        var_dump($filename);
        var_dump($ip);
        // set parameters and execute
        $stmt->execute();
        $conn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
