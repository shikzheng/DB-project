<?php
session_start();
if (version_compare(PHP_VERSION, '5.3.7', '<')){
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
}else if (version_compare(PHP_VERSION, '5.5.0', '<')){
    require_once("libraries/password_compatibility_library.php");
}
require_once("config/db.php");
?>
<html>
<head>
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
</style>
<body>
<div class="container" style = "width:400px;">
<form class="form-signin" method="post" action="loginProcessing.php" name="loginform">
    <h2 class="form-signin-heading">Sign in</h2>
    <label class="sr-only" for="Username">Username</label>
    <input class="form-control" style = "height:45px;" placeholder="Username" id="Username" class="login_input" type="text" name="user_name" required autofocus autocomplete="off"/>
    <label class="sr-only" for="Password">Password</label>
    <input class="form-control" style = "height:45px;" placeholder="Password" id="Password" class="login_input" type="password" name="user_password" autocomplete="off" required autofocus autocomplete="off"/>
    <div class="checkbox">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Log in</button>
</form>
<a href="register.php">Register new account</a>
<br>
<br>
<div id = "message">
  <?php
    if(isset($_SESSION['loginErrorMsg'])){
      echo $_SESSION['loginErrorMsg'];
      session_unset();
    }
  ?>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){

  });
</script>
</html>
</body>
