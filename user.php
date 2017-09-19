<?php
include $_SERVER["DOCUMENT_ROOT"] . "/util/sessionStart.php";
$firstname = "";
$lastname = "";
$password = "";
$email = "";
$userid = $_SESSION['userid'];

$db_server ="morewood.life";
$db_user = 'root';
$db_password = 'qweasdzxc';
$db = new mysqli($db_server, $db_user, $db_password, 'morewoodapt');
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
$sql = "SELECT firstname, lastname, password, email FROM users WHERE userid = \"$userid\"";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
};

if($result->num_rows == 0){
    $msg = 'Wrong username or password';
}else{
    $row = $result->fetch_assoc();
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $password = $row["password"];
    $email = $row["email"];
}
$db->close();
?>

    <!DOCTYPE html>
    <html lang="en">

    <?php
    $_SESSION["title"] = "333 Morewood Apt 5 - Login";
    include "head.php";
    ?>

    <body>
    <?php include "header.php" ?>

    <ul class="list-group">
        <li class="list-group-item list-group-item-success">Firstname: <?php echo $firstname?></li>
        <li class="list-group-item list-group-item-info">Lastname: <?php echo $lastname?></li>
        <li class="list-group-item list-group-item-warning">Password: <?php echo $password?> </li>
        <li class="list-group-item list-group-item-danger">Email: <?php echo $email?> </li>
    </ul>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    </body>
    </html>
<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 9/18/17
 * Time: 11:39 PM
 */