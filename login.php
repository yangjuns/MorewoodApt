<?php
    $msg = '';
    session_start();

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $db_server = 'yangjuns.info';
      $db_user = 'root';
      $db_password = 'qweasdzxc';
      $db = new mysqli($db_server, $db_user, $db_password, 'morewoodapt');
      if($db->connect_errno > 0){
          die('Unable to connect to database [' . $db->connect_error . ']');
      }
      $sql = "SELECT userid FROM users WHERE firstname = \"$username\" AND password = \"$password\"";

      if(!$result = $db->query($sql)){
          die('There was an error running the query [' . $db->error . ']');
      };

      if($result->num_rows == 0){
        $msg = 'Wrong username or password';
      }else{
        $userid = $result->fetch_assoc()["userid"];
        $_SESSION['userid'] = $userid;
        $_SESSION['username'] = $_POST['username'];
        header("Location: index.php");
      }
      $db->close();
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>333 Morewood Apt 5</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php include "header.php" ?>

    <div id="content-container">
      <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
              ?>" method="post" style="text-align:center;">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">username</span>
          <input type="text" name="username" class="form-control" aria-describedby="basic-addon1">
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">Password</span>
          <input type="password" name="password" class="form-control" aria-describedby="basic-addon1">
        </div>
        <br>
        <button type="submit" class="btn btn-success">Login</button>
      </form>
    </div>
    <div >
      <?php echo $msg ?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
