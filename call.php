<?php
    include $_SERVER["DOCUMENT_ROOT"] . "/php/sessionStart.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>333 Morewood Apt 5</title>

    <!-- Bootstrap -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/inputBox.css">
</head>
<style>
    .full-video-container{
        position: absolute;
        z-index: -2;
        top: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;

    }
    .small-video-container{
        position: absolute;
        z-index: -1;
        top: 2%;
        right: 0;
        width: 25%;
        height: 30%;
        border:2px solid #989da0;
        overflow: hidden;
    }
    .full-video {
        /* Make video to at least 100% wide and tall */
        min-width: 100%;
        min-height: 100%;

        /* Setting width & height to auto prevents the browser from stretching or squishing the video */
        width: auto;
        height: auto;

        /* Center the video */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
    }
    .small-video{
        /* Make video to at least 100% wide and tall */
        min-width: 100%;
        min-height: 100%;

        /* Setting width & height to auto prevents the browser from stretching or squishing the video */
        width: auto;
        height: auto;

        /* Center the video */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
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
        include $_SERVER["DOCUMENT_ROOT"] . "/components/inputBox.php";
        echo <<<HTML
    <div class="full-video-container">
        <video class="full-video" id = "localVideo" autoplay></video>
    </div>
    <div class="small-video-container" style="display: none;">
        <video class="small-video" id = "remoteVideo"  autoplay></video>
    </div>
    <img id = "hangUpBtn" src="/imgs/hangup.png" alt="" style="width:5%;height:5%; display: none;">
    


    <!--<video id = "remoteVideo" autoplay></video>-->
    <!--<div class="container">-->
    <!--<div class="row">-->
            <!--<div id="onlineUsers" class="list-group col-md-2">-->
            <!--</div>-->
            <!--<div class = "col-md-10">-->
             <!--<div id = "callPage" class = "call-page ">-->
                <!---->
            <!---->
                <!--<div class = "row text-center">-->
                    <!--<div class = "col-md-12">-->
                        <!--<input id = "callToUsernameInput" type = "text"-->
                               <!--placeholder = "username to call" />-->
                        <!--<button id = "callBtn" class = "btn-success btn">Call</button>-->
                        <!--<button id = "hangUpBtn" class = "btn-danger btn" style="display: none;">Hang Up</button>-->
                    <!--</div>-->
                <!--</div>-->
    <!---->
            <!--</div>-->
            <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    
    <script src = "/js/call.js"></script>
HTML;
    }

?>





</body>

</html>
