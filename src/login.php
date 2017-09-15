<?php
  // session_start();
  // //echo $$_POST['username'];
  // //echo $_POST['password'];
  // if (isset($_POST['username']) && isset($_POST['password'])){
    // $db_server = 'yangjuns.info';
    // $db_user = 'root';
    // $db_password = 'qweasdzxc';
    // $username = $_POST['username'];
    // $password = $_POST['password'];
  //   $db = new mysqli($db_server, $db_user, $db_password, 'morewoodapt');
  //   if($db->connect_errno > 0){
  //       die('Unable to connect to database [' . $db->connect_error . ']');
  //   }
  //   $sql = "SELECT * FROM users WHERE firstname = \"$username\" AND password = \"$password\"";
  //
  //   if(!$result = $db->query($sql)){
  //       die('There was an error running the query [' . $db->error . ']');
  //   };
  //
  //   if($result->num_rows == 0){
  //     header("Location: login.php");
  //   }else{
  //     $_SESSION['logged_in'] = true;
  //     $_SESSION['username'] = $_POST['username'];
  //     header("Location: index.html");
  //   }
  // }
?>

<?php
    $msg = '';
    session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_POST['username'];
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
      $sql = "SELECT * FROM users WHERE firstname = \"$username\" AND password = \"$password\"";

      if(!$result = $db->query($sql)){
          die('There was an error running the query [' . $db->error . ']');
      };

      if($result->num_rows == 0){
        $msg = 'Wrong username or password';
      }else{
        header("Location: index.html");
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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      function myFunction(){
        window.location.href = "index.html";
      }
    </script>
</head>
<body>
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
                    <li class="active" onClick = "myFunction();"><a>Home <span class="sr-only">(current)</span></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

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
    <div >
      <?php echo $msg ?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
