<?php
    session_start();
    if(!empty($_SESSION["username"])){
        echo <<<HTML
        <div id="input-bar">
            <form id="input-form" method="post">
                <div class="input-group">
                        <input type="text" id="message" class="form-control" aria-label="...">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit" id="sendMsg"}>Send</button>
                        </div>
                </div>
            </form>
        </div>
HTML;
    }
?>
