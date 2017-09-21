<?php
    include $_SERVER["DOCUMENT_ROOT"] . "/util/sessionStart.php";
 ?>

<!DOCTYPE html>
<html lang="en">

<?php
    $_SESSION["title"] = "333 Morewood Apt 5 - Call";
    include $_SERVER["DOCUMENT_ROOT"] . "/head.php";
?>

<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/header.php" ?>

    <div id="call-container">
        <iframe width="100%" height="1500" id="call-frame" src="https://yangjuns.info:8443" frameborder="0" scrolling="no">
        </iframe>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/call.js"></script>

</body>
</html>
