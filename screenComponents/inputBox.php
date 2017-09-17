<?php
include "util/sessionStart.php";

if(!empty($_SESSION["username"])){
    echo <<<HTML
    <div id="input-panel">
        <form method="post" id="input-form">
            <input type="text" class="msg-input" placeholder="Send a comment" />
            <button type="submit" class="send-msg-btn">Send</button>
        </form>
    </div>
HTML;
}
?>
