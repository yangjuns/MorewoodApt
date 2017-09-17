<?php

include "/util/sessionStart.php";
// arguments
$msgLimit = 20;

// db parameters
$db_server="morewood.life";
$db_user="root";
$db_password="qweasdzxc";
$dbname = "morewoodapt";
//$dbname = "morewoodapt_test";

$conn = new mysqli($db_server, $db_user, $db_password, $dbname);
if($conn->connect_errno > 0){
    die('Unable to connect to database [' . $conn->connect_error . ']');
}
$conn->query("SET NAMES utf8;");

$query = "SELECT commentid, time, firstname, comments FROM users AS u, comments AS c WHERE u.userid = c.userid AND c.active = 1 ORDER BY time DESC LIMIT $msgLimit";
$result = $conn->query($query) or die($conn->error);
$msgs = array();
date_default_timezone_set("US/Eastern");
while ($row = ($result->fetch_assoc())) {
    $fetchedTime = $row["time"];
    $timeStr = date("m/d/y D H:i:s", strtotime($fetchedTime));
    $row["time"] = $timeStr;
    array_push($msgs, $row);
}
$conn->close();

function blockHTML($msgs){

    foreach($msgs as $row){

        switch ($row["firstname"]){
            case "Yangjun":
                $color = "alert-success";
                break;
            case "Luyao":
                $color = "alert-info";
                break;
            case "LYB":
                $color = "alert-warning";
                break;
            default:
                $color = "alert-danger";
                break;
        }
        echo <<<HTML
    <div class="alert {$color} alert-dismissible" role="alert">
HTML;
        if(!empty($_SESSION["username"]) && ($_SESSION["username"] == $row["firstname"])){
            echo <<<HTML
            <button onclick="delMsg({$row['commentid']});" type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>
HTML;
        }
        echo <<<HTML
        <button class="close" style="font-size: 10px; margin-right: 10px; padding-top: 7px;">{$row["time"]}</button>
        <strong>{$row["firstname"]}: </strong>
        {$row["comments"]}
    </div>
HTML;
    }
}

echo blockHTML($msgs);
?>
