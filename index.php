<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<?php
    include "head.php";
?>

<body>
    <!--    include header file-->
    <?php
        $_SESSION["currentPage"] = "HOME";
        include "header.php"
    ?>

    <!--    comments-->
    <div id="content-container">
        <?php include "php/getMsg.php"; ?>
    </div>

    <!--    Send Message-->
    <?php include "screenComponents/inputBox.php" ?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>

</body>
</html>
