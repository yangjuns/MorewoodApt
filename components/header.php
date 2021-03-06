<?php
$login = null;
if (!empty($_SESSION["username"])) {
    $login = <<<HTML
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="username"}>{$_SESSION["firstname"]}<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="/user.php">About Me</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/php/logout.php">Logout</a></li>
        </ul>
    </li>
HTML;
} else {
    $login = <<<HTML
        <li><a href="/login.php">Login</a></li>
HTML;
}

$currentPage = (!empty($_SESSION["currentPage"])) ? $_SESSION["currentPage"] : "";
$homeClass = ($currentPage == "HOME") ? "active" : "";
$fileClass = ($currentPage == "FILE") ? "active" : "";
$callClass = ($currentPage == "CALL") ? "active" : "";
echo <<<HTML
<nav class="navbar navbar-inverse"  style="border-radius: 0px;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="color: white;">Morewoodie</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class={$homeClass}><a href="/index.php">Home<span class="sr-only">(current)</span></a></li>
                <li class={$fileClass}><a href="/file.php">File<span class="sr-only">(current)</span></a></li>
                <li class={$callClass}><a href="/call.php">Call<span class="sr-only">(current)</span></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {$login}
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
HTML;

?>
