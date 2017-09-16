<?php

    if(!empty($_SESSION["username"])){
        echo <<<HTML
        <div id="input-panel">
            <div class="container input-subpanel">
                <form id="input-form" class="row" method="post">
                        <input type="text" id="message" class="col-xs-10" placeholder="Send a comment" autofocus>
                        <div class="submit-btn-container col-xs-2">
                            <button type="submit" id="sendMsg"}>Send</button>
                        </div>
                </form>
            </div>
        </div>
HTML;
    }
?>
