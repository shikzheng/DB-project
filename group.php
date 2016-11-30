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
      <div style="margin:auto;width:450px;height:415px;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#f5f5f5;">
      <form class="form-signin" method="post" action="createGroupProcessing.php" name="" style="width:90%;margin-left:auto;margin-right:auto;">
          <h2 class="form-signin-heading">Create a Group</h2>
          <label class="sr-only" for="creategroup_GroupName">Group Name</label>
          <input class="form-control"  value = "<?php if((isset($_SESSION["creategroup_GroupName"]) && (isset($_SESSION["createGroupErrorMsg"])) && ($_SESSION['createGroupErrorMsg'] != "Success! The group has been created."))){ echo $_SESSION["creategroup_GroupName"];} ?>"
          style = "height:45px;" placeholder="Group Name" id="creategroup_GroupName" class="login_input" type="text" name="creategroup_GroupName" autocomplete="off" autofocus required />
          <br>
          <label class="sr-only" for="creategroup_Description">Description</label>
          <input class="form-control" value = "<?php if((isset($_SESSION["creategroup_Description"]) && (isset($_SESSION["createGroupErrorMsg"])) && ($_SESSION['createGroupErrorMsg'] != "Success! The group has been created."))){ echo $_SESSION["creategroup_Description"];} ?>"
           style = "height:45px;" placeholder="Description" id="creategroup_Description" class="login_input" type="text" name="creategroup_Description" autocomplete="off" autofocus required />
          <br>
          <label class="sr-only" for="creategroup_Category">Category</label>
          <input class="form-control" value = "<?php if((isset($_SESSION["creategroup_Category"]) && (isset($_SESSION["createGroupErrorMsg"])) && ($_SESSION['createGroupErrorMsg'] != "Success! The group has been created."))){ echo $_SESSION["creategroup_Category"];} ?>"
           style = "height:45px;" placeholder="Category" id="creategroup_Category" class="login_input" type="text" name="creategroup_Category" autocomplete="off" autofocus required />
          <br>
          <label class="sr-only" for="creategroup_Keywords">Keywords</label>
          <input class="form-control" value = "<?php if((isset($_SESSION["creategroup_Keywords"])&& (isset($_SESSION["createGroupErrorMsg"]))  && ($_SESSION['createGroupErrorMsg'] != "Success! The group has been created."))){ echo $_SESSION["creategroup_Keywords"];} ?>"
           style = "height:45px;" placeholder="Keywords (Please separate each keyword with a comma)" id="creategroup_Keywords" class="login_input" type="text" name="creategroup_Keywords" autocomplete="off" autofocus required />
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
      <br>
    </div>


    <br>
    <br>
    <br>
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
      <div style="width:1200px;height:auto;border:1px solid #e3e3e3;border-radius:4px;text-align:center;background-color:#FFFFFF;">
      <div class="container">
        <h2 class="form-signin-heading">Search for a group</h2>
          <div class="row">
              <div class="col-lg-4 col-lg-offset-4">
                  <input type="search" id="search" value="" class="form-control" placeholder="Search using group name, category, or keywords">
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12">
                  <table class="table" id="table">
                      <thead>
                          <tr>
                              <th>Group Name</th>
                              <th>Category</th>
                              <th>Keywords</th>
                          </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
                  <hr>
              </div>
          </div>
    </div>
  </div>

  </div>
<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(function () {
    $( '#table' ).searchable({
        striped: true,
        oddRow: { 'background-color': '#f5f5f5' },
        evenRow: { 'background-color': '#fff' },
        searchType: 'fuzzy'
    });

    $( '#searchable-container' ).searchable({
        searchField: '#container-search',
        selector: '.row',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    })
});

  var tableRef = document.getElementById('table').getElementsByTagName('tbody')[0];
  var groupName = [];
  var category = [];
  var keywords = [];
  <?php
      require_once("config/db.php");
      $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $groupName = array();
      $category = array();
      $keywords = array();
      if (!$connection->connect_errno) {
        $sql = "SELECT category,keyword,group_name FROM about NATURAL JOIN a_group;";
        $query= $connection->query($sql);
        while($row = $query->fetch_assoc()){
          array_push($category, $row['category']);
          array_push($keywords, $row['keyword']);
          array_push($groupName, $row['group_name']);
        }
      }
   ?>
  groupName = <?php echo json_encode($groupName) ?>;
  category = <?php echo json_encode($category) ?>;
  keywords = <?php echo json_encode($keywords) ?>;

  for(var i = 0; i < groupName.length; i++){
    var newRow   = tableRef.insertRow(tableRef.rows.length);
    var newCell1  = newRow.insertCell(0);
    var newCell2  = newRow.insertCell(1);
    var newCell3  = newRow.insertCell(2);
    var newText1  = document.createTextNode(groupName[i]);
    var newText2  = document.createTextNode(category[i]);
    var newText3  = document.createTextNode(keywords[i]);
    newCell1.appendChild(newText1);
    newCell2.appendChild(newText2);
    newCell3.appendChild(newText3);
  }



});
</script>
</body>
</html>
