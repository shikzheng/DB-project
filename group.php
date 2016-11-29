<?php
session_start();
if(!isset($_SESSION['user_login_status'])){
  header("Location: index.php");
}
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
.glyphicon {
    font-size: 20px;
}
.navbar{
  font-size:20px;
}
.nav>li>a:hover {
    text-decoration: none;
    background-color: blue;
}
</style>
<body>
  <nav class="navbar" style="background-color:#00BFFF;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a style="color:white;font-weight:bold;font-size:20px;background-color:#00BFFF;" class="navbar-brand">Welcome, <?php echo $_SESSION['user_firstname']; ?></a>
      </div>
      <ul class="nav navbar-nav">
        <li><a style="color:white;background-color:#00BFFF;" href="main.php">Home</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="#">Friends</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="#">Interests</a></li>
        <li><a style="color:yellow;background-color:#00BFFF;" href="#">Groups</a></li>
        <li><a style="color:white;background-color:#00BFFF;" href="#">Events</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--same as"index.php?logout=true" -->
        <li><a style="color:white;margin-top:-4px;background-color:#00BFFF;" href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
      </ul>
    </div>
  </nav>
  <div class="row" style="width:100%;">
    <div class="col-md-4">
      <div style="margin:auto;width:450px;height:290px;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#f5f5f5;">
      <form class="form-signin" method="post" action="createGroupProcessing.php" name="" style="width:80%;margin-left:auto;margin-right:auto;">
          <h2 class="form-signin-heading">Create a Group</h2>
          <label class="sr-only" for="creategroup_GroupName">Group Name</label>
          <input class="form-control" style = "height:45px;" placeholder="Group Name" id="creategroup_GroupName" class="login_input" type="text" name="creategroup_GroupName" autocomplete="off" autofocus required />
          <br>
          <label class="sr-only" for="creategroup_Description">Description</label>
          <input class="form-control" style = "height:45px;" placeholder="Description" id="creategroup_Description" class="login_input" type="text" name="creategroup_Description" autocomplete="off" autofocus required />
          <br>
          <br>
          <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Create Group</button>
      </form>
      <br>
      <br>
      <div>
        <?php
          if(isset($_SESSION['createGroupErrorMsg'])){
            echo $_SESSION['createGroupErrorMsg'];
            unset($_SESSION['createGroupErrorMsg']);

          }
        ?>
      </div>
    </div>
    </div>
    <div class="col-md-4">
      <div style="margin:auto;width:450px;height:230px;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#f5f5f5;">
      <form class="form-signin" method="post" action="JoinGroupProcessing.php" name="" style="width:80%;margin-left:auto;margin-right:auto;">
          <h2 class="form-signin-heading">Join a Group</h2>
          <label class="sr-only" for="creategroup_GroupName">Group Name</label>
          <input class="form-control" style = "height:45px;" placeholder="Group Name" id="creategroup_GroupName" class="login_input" type="text" name="joingroup_GroupName" autocomplete="off" autofocus required />
          <br>
          <br>
          <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login">Join Group</button>
      </form>
      <br>
      <br>
      <div>
        <?php
          if(isset($_SESSION['JoinGroupErrorMsg'])){
            echo $_SESSION['JoinGroupErrorMsg'];
            unset($_SESSION['JoinGroupErrorMsg']);
          }
        ?>
      </div>
    </div>

    </div>




    <div class="col-md-4">
      <div style="margin:auto;width:450px;height:auto;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#f5f5f5;">
        <div class="list-group"  style="width:80%;margin-left:auto;margin-right:auto;">
          <h2 class="form-signin-heading">View All Groups</h2>
          <a href="#" class="list-group-item active">
            <h4 class="list-group-item-heading">Group 1</h4>
            <p class="list-group-item-text">Description</p>
          </a>
          <br>
          <a href="#" class="list-group-item active">
            <h4 class="list-group-item-heading">Group 2</h4>
            <p class="list-group-item-text">Description</p>
          </a>
          <br>
          <a href="#" class="list-group-item active">
            <h4 class="list-group-item-heading">Group 3</h4>
            <p class="list-group-item-text">Description</p>
          </a>
        </div>
      </div>
    </div>


  </div>


<script type="text/javascript">
$(document).ready(function(){

});
</script>
</body>
</html>
