<?php
    $msg = '';
    include $_SERVER["DOCUMENT_ROOT"] . "/util/sessionStart.php";

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

<?php
    $_SESSION["title"] = "333 Morewood Apt 5 - Login";
    include $_SERVER["DOCUMENT_ROOT"] . "/head.php";
?>

<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/header.php" ?>

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
