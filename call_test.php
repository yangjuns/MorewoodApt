
<!DOCTYPE html>
<html id="home" lang="en">
<?php
    $_SESSION["title"] = "333 Morewood Apt 5 - Login";
    include $_SERVER["DOCUMENT_ROOT"] . "/head.php";
?>

<body>
<?php include "header.php"?>
<script>
    if(!location.hash.replace('#', '').length) {
        location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
        location.reload();
    }
</script>
<article>
    <table class="visible">
        <tr>
            <td style="text-align: right;">
                <input type="text" id="conference-name" placeholder="Broadcast Name">
            </td>
            <td>
                <button id="start-conferencing">New Broadcast</button>
            </td>
        </tr>
    </table>
    <table id="rooms-list" class="visible"></table>

    <table class="visible">
        <tr>
            <td style="text-align: center;">
                <h2>
                    <strong>Private Broadcast</strong> ?? <a href="" target="_blank" title="Open this link in new tab. Then your broadcasting room will be private!"><code><strong id="unique-token">#123456789</strong></code></a>
                </h2>
            </td>
        </tr>
    </table>

    <div id="participants"></div>

    <script src="https://cdn.webrtc-experiment.com/socket.io.js"> </script>
    <script src="https://cdn.webrtc-experiment.com/RTCPeerConnection-v1.5.js"> </script>
    <script src="https://cdn.webrtc-experiment.com/broadcast/broadcast.js"> </script>
    <script src="https://cdn.webrtc-experiment.com/broadcast/broadcast-ui.js"> </script>
</article>

<!-- commits.js is useless for you! -->
<script src="https://cdn.webrtc-experiment.com/commits.js" async> </script>
</body>
</html>
