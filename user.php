<?php
include $_SERVER["DOCUMENT_ROOT"] . "/php/sessionStart.php";
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
$sql = "SELECT username, firstname, lastname, password, email FROM users WHERE userid = \"$userid\"";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
};

if($result->num_rows == 0){
    $msg = 'Wrong username or password';
}else{
    $row = $result->fetch_assoc();
    $username = $row["username"];
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
include include $_SERVER["DOCUMENT_ROOT"] . "/components/head.php";
?>

<body>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/components/header.php"; ?>

<ul class="list-group">
    <li class="list-group-item list-group-item-success">
        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        <span class="field">Username</span>: <span><?php echo $username?></span>
    </li>
    <li class="list-group-item list-group-item-success">
        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        <span class="field">Firstname</span>: <span><?php echo $firstname?></span>
    </li>
    <li class="list-group-item list-group-item-info">
        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        <span class="field">Lastname</span>: <span><?php echo $lastname?></span>
    </li>
    <li class="list-group-item list-group-item-warning">
        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        <span class="field">Password</span>: <span><?php echo $password?></span>
    </li>
    <li class="list-group-item list-group-item-danger">
        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        <span class="field">Email</span>: <span><?php echo $email?></span>
    </li>
</ul>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="/js/user.js"></script>
</body>
</html>
