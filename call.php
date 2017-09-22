<?php
    include $_SERVER["DOCUMENT_ROOT"] . "/php/sessionStart.php";
?>

<!DOCTYPE html>
<html>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/components/head.php" ?>
<style>
    video {
        background: black;
        border: 1px solid gray;
    }

    .call-page {
        position: relative;
        display: block;
        margin: 0 auto;
        width: 500px;
        height: 500px;
    }

    #localVideo {
        width: 150px;
        height: 150px;
        position: absolute;
        top: 15px;
        right: 15px;
    }

    #remoteVideo {
        width: 500px;
        height: 500px;
    }

</style>

<body>
<?php
    $_SESSION["currentPage"] = "CALL";
    include $_SERVER["DOCUMENT_ROOT"] . "/components/header.php";
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<?php
    if(empty($_SESSION["username"])){
        echo <<<HTML
    <div class="alert alert-danger" role="alert"><strong>Sorry!</strong> You need to log in to use this service.</div>
HTML;
    } else{
        echo <<<HTML
    <div class="container">
    <div class="row">
            <div id="onlineUsers" class="list-group col-md-2">
            </div>
            <div class = "col-md-10">
             <div id = "callPage" class = "call-page ">
                <video id = "localVideo" autoplay></video>
                <video id = "remoteVideo" autoplay></video>
            
                <div class = "row text-center">
                    <div class = "col-md-12">
                        <input id = "callToUsernameInput" type = "text"
                               placeholder = "username to call" />
                        <button id = "callBtn" class = "btn-success btn">Call</button>
                        <button id = "hangUpBtn" class = "btn-danger btn" style="display: none;">Hang Up</button>
                    </div>
                </div>
    
            </div>
            </div>
    </div>
    </div>
    
    <script src = "/js/call.js"></script>
HTML;
    }
?>





</body>

</html>
