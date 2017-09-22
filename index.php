<?php include $_SERVER["DOCUMENT_ROOT"] . "/php/sessionStart.php"; ?>

<!DOCTYPE html>
<html lang="en">

<?php include $_SERVER["DOCUMENT_ROOT"] . "/head.php"; ?>

<body>
    <!--    include header file-->
    <?php
        $_SESSION["currentPage"] = "HOME";
        include $_SERVER["DOCUMENT_ROOT"] . "/screenComponents/header.php";
    ?>

    <!--    comments-->
    <div id="content-container"></div>

    <!--    Send Message-->
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/screenComponents/inputBox.php" ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>

</body>
</html>
