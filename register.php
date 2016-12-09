<?php
session_start();
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
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
  <div style="margin-left:auto;margin-right:auto;text-align:center;margin-top:20px;">
    <img src="images/logo.png" style="width:300px;" alt="Avatar" class="Avatar">
  </div>
<div class="container" style = "width:400px;margin-top:20px;">
<form class="form-signin" method="post" action="registerProcessing.php" name="registerform">
    <h2 class="form-signin-heading">Create an account</h2>
    <label class="sr-only" for="login_input_Firstname">First Name</label>
    <input class="form-control" style = "height:45px;" placeholder="First Name" id="login_input_Firstname" class="login_input" type="text" value = "<?php if((isset($_SESSION["registration_user_firstname"]) && (isset($_SESSION["registerErrorMsg"])) && ($_SESSION['registerErrorMsg'] != "Your account has been created successfully. You can now log in."))){ echo $_SESSION["registration_user_firstname"];
 } ?>" name="user_firstname" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_Lastname">Last Name</label>
    <input class="form-control" style = "height:45px;" placeholder="Last Name" id="login_input_Lastname" class="login_input" type="text" value = "<?php if((isset($_SESSION["registration_user_lastname"]) && (isset($_SESSION["registerErrorMsg"])) && ($_SESSION['registerErrorMsg'] != "Your account has been created successfully. You can now log in."))){ echo $_SESSION["registration_user_lastname"];
 } ?>" name="user_lastname" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_email">User's email</label>
    <input class="form-control" style = "height:45px;" placeholder="Email" id="login_input_email" class="login_input" type="email" value = "<?php if((isset($_SESSION["registration_user_email"]) && (isset($_SESSION["registerErrorMsg"])) && ($_SESSION['registerErrorMsg'] != "Your account has been created successfully. You can now log in."))){ echo $_SESSION["registration_user_email"];
 } ?>" name="user_email" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_Zipcode">Zip Code</label>
    <input class="form-control" style = "height:45px;" placeholder="Zip code" id="login_input_Zipcode" class="login_input" type="text" value = "<?php if((isset($_SESSION["registration_user_zipcode"]) && (isset($_SESSION["registerErrorMsg"])) && ($_SESSION['registerErrorMsg'] != "Your account has been created successfully. You can now log in."))){ echo $_SESSION["registration_user_zipcode"];
 } ?>" name="user_zipcode" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_username">Username</label>
    <input class="form-control" style = "height:45px;" placeholder="Username" id="login_input_username" class="login_input" type="text" value = "<?php if((isset($_SESSION["registration_user_name"]) && (isset($_SESSION["registerErrorMsg"])) && ($_SESSION['registerErrorMsg'] != "Your account has been created successfully. You can now log in."))){ echo $_SESSION["registration_user_name"];
 } ?>" name="user_name" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_password_new">Password</label>
    <input class="form-control" style = "height:45px;" placeholder="Password" id="login_input_password_new" class="login_input" type="password" value = "" name="user_password_new"  required autofocus autocomplete="off" />
    <br>
    <label class="sr-only" for="login_input_password_repeat">Repeat password</label>
    <input class="form-control" style = "height:45px;" placeholder="Repeat Password" id="login_input_password_repeat" class="login_input" type="password" value = "" name="user_password_repeat" required autofocus autocomplete="off" />
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button>
</form>
<a href="index.php">Back to Login Page</a>
<br>
<br>
<div id = "message">
  <?php
    if(isset($_SESSION['registerErrorMsg'])){
      echo $_SESSION['registerErrorMsg'];
      unset($_SESSION['registerErrorMsg']);
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
