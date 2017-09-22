<?php
    include $_SERVER["DOCUMENT_ROOT"] . "/util/sessionStart.php";
 ?>

<!DOCTYPE html>
<html>

<?php include "head.php"?>
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
<?php include "header.php"?>

<div id = "callPage" class = "call-page">
    <video id = "localVideo" autoplay></video>
    <video id = "remoteVideo" autoplay></video>

    <div class = "row text-center">
        <div class = "col-md-12">
            <input id = "callToUsernameInput" type = "text"
                   placeholder = "username to call" />
            <button id = "callBtn" class = "btn-success btn">Call</button>
            <button id = "hangUpBtn" class = "btn-danger btn">Hang Up</button>
        </div>
    </div>

</div>

<script src = "/js/call.js"></script>

</body>

</html>
