<?php

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
<form class="form-signin" method="post" action="register.php" name="registerform">
    <h2 class="form-signin-heading">Create an account</h2>
    <label class="sr-only" for="login_input_Firstname">First Name</label>
    <input class="form-control" style = "height:45px;" placeholder="First Name" id="login_input_Firstname" class="login_input" type="text" value = "<?php if(isset($_POST["user_firstname"])){ echo $_POST["user_firstname"]; } ?>" name="user_firstname" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_Lastname">Last Name</label>
    <input class="form-control" style = "height:45px;" placeholder="Last Name" id="login_input_Lastname" class="login_input" type="text" value = "<?php if(isset($_POST["user_firstname"])){ echo $_POST["user_lastname"]; } ?>" name="user_lastname" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_email">User's email</label>
    <input class="form-control" style = "height:45px;" placeholder="Email" id="login_input_email" class="login_input" type="email" value = "<?php if(isset($_POST["user_firstname"])){ echo $_POST["user_email"]; } ?>" name="user_email" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_Zipcode">Zip Code</label>
    <input class="form-control" style = "height:45px;" placeholder="Zip code" id="login_input_Zipcode" class="login_input" type="text" value = "<?php if(isset($_POST["user_firstname"])){ echo $_POST["user_zipcode"]; } ?>" name="user_zipcode" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_username">Username</label>
    <input class="form-control" style = "height:45px;" placeholder="Username" id="login_input_username" class="login_input" type="text" value = "<?php if(isset($_POST["user_firstname"])){ echo $_POST["user_name"]; } ?>" name="user_name" autocomplete="off" autofocus required />
    <br>
    <label class="sr-only" for="login_input_password_new">Password</label>
    <input class="form-control" style = "height:45px;" placeholder="Password" id="login_input_password_new" class="login_input" type="password" value = "<?php if(isset($_POST["user_firstname"])){ echo $_POST["user_password_new"]; } ?>" name="user_password_new"  required autofocus autocomplete="off" />
    <br>
    <label class="sr-only" for="login_input_password_repeat">Repeat password</label>
    <input class="form-control" style = "height:45px;" placeholder="Repeat Password" id="login_input_password_repeat" class="login_input" type="password" value = "<?php if(isset($_POST["user_firstname"])){ echo $_POST["user_password_repeat"]; } ?>" name="user_password_repeat" required autofocus autocomplete="off" />
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button>
</form>
<a href="index.php">Back to Login Page</a>
<br>
<br>
<div id = "message">
  <?php
  if (isset($registration)){
      if ($registration->messages){
              echo $registration->messages;
      }
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
